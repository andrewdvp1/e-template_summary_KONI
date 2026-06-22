<?php

namespace App\Http\Controllers;

use App\Models\TemplateSummaryDraft;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

// (kept)
use Illuminate\View\View;

class TemplateSummaryController extends Controller
{
    /**
     * Show template report landing page
     */
    public function index()
    {
        // Master production grouping — mirrors PRODUCTION_DATA in the JS modal
        // line_types: mapping line name => draft_types yang termasuk di line itu
        $productionGroups = [
            'pharma1a' => [
                'label' => 'Production Pharmaceutical I A',
                'icon'  => 'factory',
                'lines' => [
                    'Line Soft Capsule' => ['nutracare', 'kapsul'],
                    'Line Paramex'      => ['sirup'],
                    'Line Steril'       => ['sirup'],
                ],
            ],
            'pharma1b' => [
                'label' => 'Production Pharmaceutical I B',
                'icon'  => 'factory',
                'lines' => [
                    'Line Tablet'                     => ['tablet'],
                    'Line Tablet Kapsul Kapsul Keras' => ['kapsul'],
                ],
            ],
            'pharma2' => [
                'label' => 'Production Pharmaceutical II',
                'icon'  => 'precision_manufacturing',
                'lines' => [
                    'Line 1' => ['anakonidin60'],
                    'Line 2' => ['anakonidin30'],
                    'Line 3' => ['siladex'],
                    'Line 4' => ['konvermex'],
                    'Line 5' => ['konidinobh'],
                    'Line 6' => ['heltiskin'],
                ],
            ],
            'natural' => [
                'label' => 'Natural Product & Extraction',
                'icon'  => 'eco',
                'lines' => [
                    'Line Obat Dalam' => ['nutracaregrape', 'qfomil'],
                    'Line Obat Luar'  => ['sirup'],
                    'Line Ekstraksi'  => ['zingiberis'],
                ],
            ],
        ];

        // Collect all types per group, fetch all drafts (no limit — JS handles display)
        $draftsByGroup = [];
        foreach ($productionGroups as $groupKey => $group) {
            $allTypes = collect($group['lines'])->flatten()->unique()->values()->all();

            $drafts = TemplateSummaryDraft::query()
                ->whereIn('draft_type', $allTypes)
                ->latest('updated_at')
                ->get();

            $draftsByGroup[$groupKey] = [
                'label'  => $group['label'],
                'icon'   => $group['icon'],
                'lines'  => $group['lines'],   // all lines — shown in dropdown always
                'drafts' => $drafts,
            ];
        }

        return view('template-summary.index', [
            'breadcrumb' => [
                'Summary' => null,
                'Buat Baru' => route('template-summary.index'),
            ],
            'draftsByGroup' => $draftsByGroup,
        ]);
    }

    /**
     * Show Draft Summary list for template-summary
     */
    public function drafts()
    {
        $allDrafts = TemplateSummaryDraft::query()
            ->where('draft_type', 'anakonidin30')
            ->orWhere('draft_type', 'sirup')  // Legacy support
            ->orWhere('draft_type', 'tablet')
            ->orWhere('draft_type', 'kapsul')
            ->orWhere('draft_type', 'heltiskin')
            ->orwhere('draft_type', 'konvermex')
            ->orwhere('draft_type', 'nutracare')
            ->orwhere('draft_type', 'nutracaregrape')
            ->orwhere('draft_type', 'siladex')
            ->orwhere('draft_type', 'konidinobh')
            ->orwhere('draft_type', 'anakonidin60')
            ->orwhere('draft_type', 'qfomil')
            ->orwhere('draft_type', 'zingiberis')
            ->latest('updated_at')
            ->get();

        // Group drafts by production segment based on bagian field
        $draftsBySegment = [
            'pharma1a' => ['label' => 'Production Pharmaceutical I A', 'drafts' => collect()],
            'pharma1b' => ['label' => 'Production Pharmaceutical I B', 'drafts' => collect()],
            'pharma2'  => ['label' => 'Production Pharmaceutical II', 'drafts' => collect()],
            'natural'  => ['label' => 'Natural Product & Extraction', 'drafts' => collect()],
            'other'    => ['label' => 'Lainnya', 'drafts' => collect()],
        ];

        foreach ($allDrafts as $draft) {
            $formValues = $draft->payload['form_values'] ?? [];
            $bagian = strtolower(trim($formValues['judul_bagian'] ?? ($formValues['tujuan_bagian'] ?? '')));

            // Draft type yang sudah pasti segmennya — tidak boleh dioverride oleh kata kunci bagian
            $typeSegmentFixed = [
                'siladex'        => 'pharma2',
                'konvermex'      => 'pharma2',
                'heltiskin'      => 'pharma2',
                'anakonidin60'   => 'pharma2',
                'anakonidin30'   => 'pharma2',
                'sirup'          => 'pharma2',
                'kapsul'         => 'pharma1a',
                'nutracare'      => 'pharma1a',
                'tablet'         => 'pharma1b',
                'konidinobh'     => 'pharma2',
                'nutracaregrape' => 'natural',
                'qfomil'         => 'natural',
                'zingiberis'     => 'natural',
            ];

            if (isset($typeSegmentFixed[$draft->draft_type])) {
                $segment = $typeSegmentFixed[$draft->draft_type];
                $draftsBySegment[$segment]['drafts']->push($draft);
                continue;
            }

            // Determine segment dari bagian — untuk tipe yang tidak ada di fixed map
            $segment = 'other';
            if (str_contains($bagian, 'pharmaceutical ii') || str_contains($bagian, 'pharma ii') || str_contains($bagian, 'pharma 2')) {
                $segment = 'pharma2';
            } elseif (
                str_contains($bagian, 'pharmaceutical i b') ||
                str_contains($bagian, 'pharma i b') ||
                str_contains($bagian, 'pharma ib') ||
                str_contains($bagian, 'farmasi i b') ||
                str_contains($bagian, 'farmasi ib') ||
                (str_contains($bagian, 'farmasi i') && str_contains($bagian, 'gedung b')) ||
                (str_contains($bagian, 'farmasi i') && str_contains($bagian, 'tablet'))
            ) {
                $segment = 'pharma1b';
            } elseif (
                str_contains($bagian, 'pharmaceutical i a') ||
                str_contains($bagian, 'pharma i a') ||
                str_contains($bagian, 'pharma ia') ||
                str_contains($bagian, 'pharmaceutical i ') ||
                str_contains($bagian, 'farmasi i')
            ) {
                $segment = 'pharma1a';
            } elseif (str_contains($bagian, 'natural') || str_contains($bagian, 'extraction') || str_contains($bagian, 'natpro')) {
                $segment = 'natural';
            }

            // Fallback berdasarkan draft_type jika bagian kosong atau tidak dikenali
            if ($segment === 'other') {
                $segment = 'other'; // tetap other jika tidak dikenali
            }

            $draftsBySegment[$segment]['drafts']->push($draft);
        }

        // Remove empty segments
        $draftsBySegment = array_filter($draftsBySegment, fn($seg) => $seg['drafts']->isNotEmpty());

        return view('template-summary.drafts', [
            'breadcrumb' => [
                'Summary' => null,
                'Draft Summary' => route('template-summary.drafts'),
            ],
            'draftsBySegment' => $draftsBySegment,
        ]);
    }

    /**
     * Delete a draft summary (sirup)
     */
    public function deleteDraft(TemplateSummaryDraft $draft): JsonResponse
    {
        if ($draft->draft_type !== 'anakonidin30' && 
        $draft->draft_type !== 'tablet' && 
        $draft->draft_type !== 'kapsul' && 
        $draft->draft_type !== 'heltiskin' &&
        $draft->draft_type !== 'konvermex' &&
        $draft->draft_type !== 'nutracare' &&
        $draft->draft_type !== 'nutracaregrape' &&
        $draft->draft_type !== 'siladex' &&
        $draft->draft_type !== 'konidinobh'&&
        $draft->draft_type !== 'anakonidin60'&&
        $draft->draft_type !== 'qfomil' &&
        $draft->draft_type !== 'zingiberis')
        {
            return response()->json([
                'success' => false,
                'message' => 'Draft tidak ditemukan.',
            ], 404);
        }

        $this->deleteDraftStorageDirectory($draft->id);
        $draft->delete();

        return response()->json([
            'success' => true,
            'message' => 'Draft berhasil dihapus.',
        ]);

    }
    /**
     * Fungsi Continue Draft untuk mengarahkan ke editor yang sesuai berdasarkan tipe draft
     */
    public function continueDraft(TemplateSummaryDraft $draft)
    {
        if ($draft->draft_type === 'anakonidin30') {
            return redirect()->route('template-summary.anakonidin30', ['draft' => $draft->id]);
        } elseif ($draft->draft_type === 'sirup') {
            // Legacy support - redirect sirup to anakonidin30
            return redirect()->route('template-summary.anakonidin30', ['draft' => $draft->id]);
        } elseif ($draft->draft_type === 'tablet') {
            return redirect()->route('template-summary.tablet', ['draft' => $draft->id]);
        } elseif ($draft->draft_type === 'kapsul') {
            return redirect()->route('template-summary.kapsul', ['draft' => $draft->id]);
        } elseif ($draft->draft_type === 'heltiskin') {
            return redirect()->route('template-summary.heltiskin', ['draft' => $draft->id]);
        } elseif ($draft->draft_type === 'konvermex') {
            return redirect()->route('template-summary.konvermex', ['draft' => $draft->id]);
        } elseif ($draft->draft_type === 'nutracare') {
            return redirect()->route('template-summary.nutracare', ['draft' => $draft->id]);
        } elseif ($draft->draft_type === 'nutracaregrape') {
            return redirect()->route('template-summary.nutracaregrape', ['draft' => $draft->id]);
        } elseif ($draft->draft_type === 'siladex') {
            return redirect()->route('template-summary.siladex', ['draft' => $draft->id]);
        } elseif ($draft->draft_type === 'konidinobh') {
            return redirect()->route('template-summary.konidinobh', ['draft' => $draft->id]);
        } elseif ($draft->draft_type === 'anakonidin60') {
            return redirect()->route('template-summary.anakonidin60', ['draft' => $draft->id]);
        } elseif ($draft->draft_type === 'qfomil') {
            return redirect()->route('template-summary.qfomil', ['draft' => $draft->id]);
        } elseif ($draft->draft_type === 'zingiberis') {
            return redirect()->route('template-summary.zingiberis', ['draft' => $draft->id]);
        }

        abort(404, 'Draft tidak ditemukan.');
    }

   public function tabletEditor(Request $request)
    {
        $draft = null;
        $from = 'new';
        if ($request->filled('draft')) {
            $draft = TemplateSummaryDraft::query()
                ->where('draft_type', 'tablet')
                ->findOrFail($request->string('draft')->toString());
            $payload = $draft->payload;
            if (is_array($payload)) {
                $draft->payload = $this->normalizeStoredFilesUrl($payload, $draft->id);
            }
            $from = 'draft';
        }

        $breadcrumb = [
            'Summary' => route('template-summary.index'),
        ];
        if ($from === 'draft') {
            $breadcrumb['Draft Summary'] = route('template-summary.drafts');
        } else {
            $breadcrumb['Buat Baru'] = route('template-summary.index');
        }
        $breadcrumb['Tablet'] = null;

        return view('template-summary.tablet.editor', [
            'title' => 'Template Tablet',
            'breadcrumb' => $breadcrumb,
            'draft' => $draft,
            'initialDraftState' => $draft?->payload,
            'draftLine' => $draft?->draft_line ?? $request->string('line')->toString() ?: null,
        ]);
    }

    /**
     * Export Tablet template to Word
     */
    public function exportTablet(Request $request)
    {
        // Will be implemented later with TabletExportService
        $exportService = new \App\Services\Export\TabletExportService();
        return $exportService->export($request->all());
    }

    public function saveTabletDraft(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'draft_id'    => ['nullable', 'integer'],
            'draft_title' => ['nullable', 'string', 'max:255'],
            'draft_line'  => ['nullable', 'string', 'max:100'],
            'draft_state' => ['required', 'string'],
        ]);

        $decodedState = json_decode($validated['draft_state'], true);
        if (!is_array($decodedState)) {
            return response()->json(['success' => false, 'message' => 'Format draft_state tidak valid.'], 422);
        }

        $draft = null;
        if (!empty($validated['draft_id'])) {
            $draft = TemplateSummaryDraft::query()->where('draft_type', 'tablet')->find($validated['draft_id']);
        }

        if (!$draft) {
            $draft = TemplateSummaryDraft::create([
                'draft_type'  => 'tablet',
                'draft_line'  => $validated['draft_line'] ?? null,
                'title'       => $this->resolveDraftTitle($decodedState),
                'payload'     => [],
                'last_saved_at' => now(),
            ]);
        }
        $previousState = is_array($draft->payload) ? $draft->payload : [];

        $storedFiles = $decodedState['stored_files'] ?? [];
        if (!is_array($storedFiles)) {
            $storedFiles = [];
        }

        $storedFiles['mixing_image_file'] = $this->storeDraftFileGroup(
            $request,
            $draft->id,
            'mixing_image_file',
            'images'
        );
        $storedFiles['mixing_excel_file'] = $this->storeDraftFileGroup(
            $request,
            $draft->id,
            'mixing_excel_file',
            'excel'
        );

        $mergedStoredImages = $decodedState['stored_files']['mixing_image_file'] ?? [];
        if (!is_array($mergedStoredImages)) {
            $mergedStoredImages = [];
        }
        $mergedStoredImages = array_merge($mergedStoredImages, $storedFiles['mixing_image_file']);

        $mergedStoredExcel = $decodedState['stored_files']['mixing_excel_file'] ?? [];
        if (!is_array($mergedStoredExcel)) {
            $mergedStoredExcel = [];
        }
        $mergedStoredExcel = array_merge($mergedStoredExcel, $storedFiles['mixing_excel_file']);

        $decodedState['stored_files']['mixing_image_file'] = $mergedStoredImages;
        $decodedState['stored_files']['mixing_excel_file'] = $mergedStoredExcel;
        $decodedState = $this->normalizeStoredFilesUrl($decodedState, $draft->id);
        $this->cleanupRemovedDraftFiles($previousState, $decodedState);

        $formValues = $decodedState['form_values'] ?? [];
        if (!is_array($formValues)) {
            $formValues = [];
        }
        foreach ($mergedStoredImages as $tableUid => $imageMeta) {
            if (is_array($imageMeta) && !empty($imageMeta['path'])) {
                $formValues["existing_mixing_image_file[{$tableUid}]"] = (string) $imageMeta['path'];
            }
        }
        $decodedState['form_values'] = $formValues;

        $draft->update([
            'title' => $this->resolveDraftTitle($decodedState),
            'payload' => $decodedState,
            'last_saved_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'draft_id' => $draft->id,
            'message' => 'Draft berhasil disimpan.',
            'redirect_url' => route('template-summary.tablet', ['draft' => $draft->id]),
            'stored_files' => $decodedState['stored_files'],
            'saved_at' => now()->format('Y-m-d H:i:s'),
        ]);
    }

    // ── Anakonidin 30ml (Sirup) ─────────────────────────────────────────────────

    public function sirupEditor(Request $request)
    {
        $draft = null;
        $from = 'new';
        if ($request->filled('draft')) {
            $draft = TemplateSummaryDraft::query()
                ->where('draft_type', 'anakonidin30')
                ->findOrFail($request->string('draft')->toString());
            $payload = $draft->payload;
            if (is_array($payload)) {
                $draft->payload = $this->normalizeStoredFilesUrl($payload, $draft->id);
            }
            $from = 'draft';
        }

        $breadcrumb = [
            'Summary' => route('template-summary.index'),
        ];
        if ($from === 'draft') {
            $breadcrumb['Draft Summary'] = route('template-summary.drafts');
        } else {
            $breadcrumb['Buat Baru'] = route('template-summary.index');
        }
        $breadcrumb['Anakonidin 30ml'] = null;

        return view('template-summary.anakonidin30.editor', [
            'title' => 'Template Anakonidin 30ml',
            'breadcrumb' => $breadcrumb,
            'draft' => $draft,
            'initialDraftState' => $draft?->payload,
            'draftLine' => $draft?->draft_line ?? $request->string('line')->toString() ?: null,
        ]);
    }

    public function exportAnakonidin30(Request $request)
    {
        $exportService = new \App\Services\Export\Anakonidin30ExportService();
        return $exportService->export($request->all());
    }

    public function saveAnakonidin30Draft(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'draft_id' => ['nullable', 'integer'],
            'draft_title' => ['nullable', 'string', 'max:255'],
            'draft_line' => ['nullable', 'string', 'max:100'],
            'draft_state' => ['required', 'string'],
        ]);

        $decodedState = json_decode($validated['draft_state'], true);
        if (!is_array($decodedState)) {
            return response()->json(['success' => false, 'message' => 'Format draft_state tidak valid.'], 422);
        }

        $draft = null;
        if (!empty($validated['draft_id'])) {
            $draft = TemplateSummaryDraft::query()->where('draft_type', 'anakonidin30')->find($validated['draft_id']);
        }

        if (!$draft) {
            $draft = TemplateSummaryDraft::create([
                'draft_type' => 'anakonidin30',
                'title' => $validated['draft_title'] ?? 'Draft Anakonidin 30ml',
                'draft_line' => $validated['draft_line'] ?? null,
                'payload' => $decodedState,
                'last_saved_at' => now(),
            ]);
        } else {
            $draft->update([
                'title' => $validated['draft_title'] ?? $draft->title,
                'draft_line' => $validated['draft_line'] ?? $draft->draft_line,
                'payload' => $decodedState,
                'last_saved_at' => now(),
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Draft berhasil disimpan.',
            'draft_id' => $draft->id,
            'redirect_url' => route('template-summary.anakonidin30', ['draft' => $draft->id]),
            'stored_files' => $decodedState['stored_files'],
            'saved_at' => now()->format('Y-m-d H:i:s'),
        ]);
    }

    // ── Kapsul ───────────────────────────────────────────────────────────────────

    public function kapsulEditor(Request $request)
    {
        $draft = null;
        $from = 'new';
        if ($request->filled('draft')) {
            $draft = TemplateSummaryDraft::query()
                ->where('draft_type', 'kapsul')
                ->findOrFail($request->string('draft')->toString());
            $payload = $draft->payload;
            if (is_array($payload)) {
                $draft->payload = $this->normalizeStoredFilesUrl($payload, $draft->id);
            }
            $from = 'draft';
        }

        $breadcrumb = [
            'Summary' => route('template-summary.index'),
        ];
        if ($from === 'draft') {
            $breadcrumb['Draft Summary'] = route('template-summary.drafts');
        } else {
            $breadcrumb['Buat Baru'] = route('template-summary.index');
        }
        $breadcrumb['Kapsul'] = null;

        return view('template-summary.kapsul.editor', [
            'title' => 'Template Kapsul',
            'breadcrumb' => $breadcrumb,
            'draft' => $draft,
            'initialDraftState' => $draft?->payload,
            'draftLine' => $draft?->draft_line ?? $request->string('line')->toString() ?: null,
        ]);
    }

    /**
     * Export Kapsul template to Word
     */
    public function exportKapsul(Request $request)
    {
        // Will be implemented later with KapsulExportService
        $exportService = new \App\Services\Export\KapsulExportService();
        return $exportService->export($request->all());
    }

    public function saveKapsulDraft(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'draft_id'    => ['nullable', 'integer'],
            'draft_title' => ['nullable', 'string', 'max:255'],
            'draft_line'  => ['nullable', 'string', 'max:100'],
            'draft_state' => ['required', 'string'],
        ]);

        $decodedState = json_decode($validated['draft_state'], true);
        if (!is_array($decodedState)) {
            return response()->json(['success' => false, 'message' => 'Format draft_state tidak valid.'], 422);
        }

        $draft = null;
        if (!empty($validated['draft_id'])) {
            $draft = TemplateSummaryDraft::query()->where('draft_type', 'kapsul')->find($validated['draft_id']);
        }

        if (!$draft) {
            $draft = TemplateSummaryDraft::create([
                'draft_type'  => 'kapsul',
                'draft_line'  => $validated['draft_line'] ?? null,
                'title'       => $this->resolveDraftTitle($decodedState),
                'payload'     => [],
                'last_saved_at' => now(),
            ]);
        }
        $previousState = is_array($draft->payload) ? $draft->payload : [];

        $storedFiles = $decodedState['stored_files'] ?? [];
        if (!is_array($storedFiles)) {
            $storedFiles = [];
        }

        $storedFiles['mixing_image_file'] = $this->storeDraftFileGroup(
            $request,
            $draft->id,
            'mixing_image_file',
            'images'
        );
        $storedFiles['mixing_excel_file'] = $this->storeDraftFileGroup(
            $request,
            $draft->id,
            'mixing_excel_file',
            'excel'
        );

        $mergedStoredImages = $decodedState['stored_files']['mixing_image_file'] ?? [];
        if (!is_array($mergedStoredImages)) {
            $mergedStoredImages = [];
        }
        $mergedStoredImages = array_merge($mergedStoredImages, $storedFiles['mixing_image_file']);

        $mergedStoredExcel = $decodedState['stored_files']['mixing_excel_file'] ?? [];
        if (!is_array($mergedStoredExcel)) {
            $mergedStoredExcel = [];
        }
        $mergedStoredExcel = array_merge($mergedStoredExcel, $storedFiles['mixing_excel_file']);

        $decodedState['stored_files']['mixing_image_file'] = $mergedStoredImages;
        $decodedState['stored_files']['mixing_excel_file'] = $mergedStoredExcel;
        $decodedState = $this->normalizeStoredFilesUrl($decodedState, $draft->id);
        $this->cleanupRemovedDraftFiles($previousState, $decodedState);

        $formValues = $decodedState['form_values'] ?? [];
        if (!is_array($formValues)) {
            $formValues = [];
        }
        foreach ($mergedStoredImages as $tableUid => $imageMeta) {
            if (is_array($imageMeta) && !empty($imageMeta['path'])) {
                $formValues["existing_mixing_image_file[{$tableUid}]"] = (string) $imageMeta['path'];
            }
        }
        $decodedState['form_values'] = $formValues;

        $draft->update([
            'title' => $this->resolveDraftTitle($decodedState),
            'payload' => $decodedState,
            'last_saved_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'draft_id' => $draft->id,
            'message' => 'Draft berhasil disimpan.',
            'redirect_url' => route('template-summary.kapsul', ['draft' => $draft->id]),
            'stored_files' => $decodedState['stored_files'],
            'saved_at' => now()->format('Y-m-d H:i:s'),
        ]);
    }

    public function heltiskinEditor(Request $request)
    {
        $draft = null;
        $from = 'new';
        if ($request->filled('draft')) {
            $draft = TemplateSummaryDraft::query()
                ->where('draft_type', 'heltiskin')
                ->findOrFail($request->string('draft')->toString());
            $payload = $draft->payload;
            if (is_array($payload)) {
                $draft->payload = $this->normalizeStoredFilesUrl($payload, $draft->id);
            }
            $from = 'draft';
        }

        $breadcrumb = [
            'Summary' => route('template-summary.index'),
        ];
        if ($from === 'draft') {
            $breadcrumb['Draft Summary'] = route('template-summary.drafts');
        } else {
            $breadcrumb['Buat Baru'] = route('template-summary.index');
        }
        $breadcrumb['Heltiskin'] = null;

        return view('template-summary.heltiskin.editor', [
            'title' => 'Template Heltiskin',
            'breadcrumb' => $breadcrumb,
            'draft' => $draft,
            'initialDraftState' => $draft?->payload,
            'draftLine' => $draft?->draft_line ?? $request->string('line')->toString() ?: null,
        ]);
    }

    /**
     * Export Kapsul template to Word
     */
    public function exportHeltiskin(Request $request)
    {
        // Will be implemented later with KapsulExportService
        $exportService = new \App\Services\Export\HeltiskinExportService();
        return $exportService->export($request->all());
    }

    public function saveHeltiskinDraft(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'draft_id'    => ['nullable', 'integer'],
            'draft_title' => ['nullable', 'string', 'max:255'],
            'draft_line'  => ['nullable', 'string', 'max:100'],
            'draft_state' => ['required', 'string'],
        ]);

        $decodedState = json_decode($validated['draft_state'], true);
        if (!is_array($decodedState)) {
            return response()->json(['success' => false, 'message' => 'Format draft_state tidak valid.'], 422);
        }

        $draft = null;
        if (!empty($validated['draft_id'])) {
            $draft = TemplateSummaryDraft::query()->where('draft_type', 'heltiskin')->find($validated['draft_id']);
        }

        if (!$draft) {
            $draft = TemplateSummaryDraft::create([
                'draft_type'  => 'heltiskin',
                'draft_line'  => $validated['draft_line'] ?? null,
                'title'       => $this->resolveDraftTitle($decodedState),
                'payload'     => [],
                'last_saved_at' => now(),
            ]);
        }
        $previousState = is_array($draft->payload) ? $draft->payload : [];

        $storedFiles = $decodedState['stored_files'] ?? [];
        if (!is_array($storedFiles)) {
            $storedFiles = [];
        }

        $storedFiles['mixing_image_file'] = $this->storeDraftFileGroup(
            $request,
            $draft->id,
            'mixing_image_file',
            'images'
        );
        $storedFiles['mixing_excel_file'] = $this->storeDraftFileGroup(
            $request,
            $draft->id,
            'mixing_excel_file',
            'excel'
        );

        $mergedStoredImages = $decodedState['stored_files']['mixing_image_file'] ?? [];
        if (!is_array($mergedStoredImages)) {
            $mergedStoredImages = [];
        }
        $mergedStoredImages = array_merge($mergedStoredImages, $storedFiles['mixing_image_file']);

        $mergedStoredExcel = $decodedState['stored_files']['mixing_excel_file'] ?? [];
        if (!is_array($mergedStoredExcel)) {
            $mergedStoredExcel = [];
        }
        $mergedStoredExcel = array_merge($mergedStoredExcel, $storedFiles['mixing_excel_file']);

        $decodedState['stored_files']['mixing_image_file'] = $mergedStoredImages;
        $decodedState['stored_files']['mixing_excel_file'] = $mergedStoredExcel;
        $decodedState = $this->normalizeStoredFilesUrl($decodedState, $draft->id);
        $this->cleanupRemovedDraftFiles($previousState, $decodedState);

        $formValues = $decodedState['form_values'] ?? [];
        if (!is_array($formValues)) {
            $formValues = [];
        }
        foreach ($mergedStoredImages as $tableUid => $imageMeta) {
            if (is_array($imageMeta) && !empty($imageMeta['path'])) {
                $formValues["existing_mixing_image_file[{$tableUid}]"] = (string) $imageMeta['path'];
            }
        }
        $decodedState['form_values'] = $formValues;

        $draft->update([
            'title' => $this->resolveDraftTitle($decodedState),
            'payload' => $decodedState,
            'last_saved_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'draft_id' => $draft->id,
            'message' => 'Draft berhasil disimpan.',
            'redirect_url' => route('template-summary.heltiskin', ['draft' => $draft->id]),
            'stored_files' => $decodedState['stored_files'],
            'saved_at' => now()->format('Y-m-d H:i:s'),
        ]);
    }

    //Konvermex Editor
    public function konvermexEditor(Request $request)
    {
        $draft = null;
        $from = 'new';
        if ($request->filled('draft')) {
            $draft = TemplateSummaryDraft::query()
                ->where('draft_type', 'konvermex')
                ->findOrFail($request->string('draft')->toString());
            $payload = $draft->payload;
            if (is_array($payload)) {
                $draft->payload = $this->normalizeStoredFilesUrl($payload, $draft->id);
            }
            $from = 'draft';
        }

        $breadcrumb = [
            'Summary' => route('template-summary.index'),
        ];
        if ($from === 'draft') {
            $breadcrumb['Draft Summary'] = route('template-summary.drafts');
        } else {
            $breadcrumb['Buat Baru'] = route('template-summary.index');
        }
        $breadcrumb['Konvermex'] = null;

        return view('template-summary.konvermex.editor', [
            'title' => 'Template Konvermex',
            'breadcrumb' => $breadcrumb,
            'draft' => $draft,
            'initialDraftState' => $draft?->payload,
            'draftLine' => $draft?->draft_line ?? $request->string('line')->toString() ?: null,
        ]);
    }

    /**
     * Export Konvermex template to Word
     */
    public function exportKonvermex(Request $request)
    {
        // Will be implemented later with KonvermexExportService
        $exportService = new \App\Services\Export\KonvermexExportService();
        return $exportService->export($request->all());
    }

    public function saveKonvermexDraft(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'draft_id'    => ['nullable', 'integer'],
            'draft_title' => ['nullable', 'string', 'max:255'],
            'draft_line'  => ['nullable', 'string', 'max:100'],
            'draft_state' => ['required', 'string'],
        ]);

        $decodedState = json_decode($validated['draft_state'], true);
        if (!is_array($decodedState)) {
            return response()->json(['success' => false, 'message' => 'Format draft_state tidak valid.'], 422);
        }

        $draft = null;
        if (!empty($validated['draft_id'])) {
            $draft = TemplateSummaryDraft::query()->where('draft_type', 'konvermex')->find($validated['draft_id']);
        }

        if (!$draft) {
            $draft = TemplateSummaryDraft::create([
                'draft_type'  => 'konvermex',
                'draft_line'  => $validated['draft_line'] ?? null,
                'title'       => $this->resolveDraftTitle($decodedState),
                'payload'     => [],
                'last_saved_at' => now(),
            ]);
        }
        $previousState = is_array($draft->payload) ? $draft->payload : [];

        $storedFiles = $decodedState['stored_files'] ?? [];
        if (!is_array($storedFiles)) {
            $storedFiles = [];
        }

        $storedFiles['mixing_image_file'] = $this->storeDraftFileGroup(
            $request,
            $draft->id,
            'mixing_image_file',
            'images'
        );
        $storedFiles['mixing_excel_file'] = $this->storeDraftFileGroup(
            $request,
            $draft->id,
            'mixing_excel_file',
            'excel'
        );

        $mergedStoredImages = $decodedState['stored_files']['mixing_image_file'] ?? [];
        if (!is_array($mergedStoredImages)) {
            $mergedStoredImages = [];
        }
        $mergedStoredImages = array_merge($mergedStoredImages, $storedFiles['mixing_image_file']);

        $mergedStoredExcel = $decodedState['stored_files']['mixing_excel_file'] ?? [];
        if (!is_array($mergedStoredExcel)) {
            $mergedStoredExcel = [];
        }
        $mergedStoredExcel = array_merge($mergedStoredExcel, $storedFiles['mixing_excel_file']);

        $decodedState['stored_files']['mixing_image_file'] = $mergedStoredImages;
        $decodedState['stored_files']['mixing_excel_file'] = $mergedStoredExcel;
        $decodedState = $this->normalizeStoredFilesUrl($decodedState, $draft->id);
        $this->cleanupRemovedDraftFiles($previousState, $decodedState);

        $formValues = $decodedState['form_values'] ?? [];
        if (!is_array($formValues)) {
            $formValues = [];
        }
        foreach ($mergedStoredImages as $tableUid => $imageMeta) {
            if (is_array($imageMeta) && !empty($imageMeta['path'])) {
                $formValues["existing_mixing_image_file[{$tableUid}]"] = (string) $imageMeta['path'];
            }
        }
        $decodedState['form_values'] = $formValues;

        $draft->update([
            'title' => $this->resolveDraftTitle($decodedState),
            'payload' => $decodedState,
            'last_saved_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'draft_id' => $draft->id,
            'message' => 'Draft berhasil disimpan.',
            'redirect_url' => route('template-summary.konvermex', ['draft' => $draft->id]),
            'stored_files' => $decodedState['stored_files'],
            'saved_at' => now()->format('Y-m-d H:i:s'),
        ]);
    }

    //Nutracare Editor
    public function nutracareEditor(Request $request)
    {
        $draft = null;
        $from = 'new';
        if ($request->filled('draft')) {
            $draft = TemplateSummaryDraft::query()
                ->where('draft_type', 'nutracare')
                ->findOrFail($request->string('draft')->toString());
            $payload = $draft->payload;
            if (is_array($payload)) {
                $draft->payload = $this->normalizeStoredFilesUrl($payload, $draft->id);
            }
            $from = 'draft';
        }

        $breadcrumb = [
            'Summary' => route('template-summary.index'),
        ];
        if ($from === 'draft') {
            $breadcrumb['Draft Summary'] = route('template-summary.drafts');
        } else {
            $breadcrumb['Buat Baru'] = route('template-summary.index');
        }
        $breadcrumb['Nutracare'] = null;

        return view('template-summary.nutracare.editor', [
            'title' => 'Template Nutracare',
            'breadcrumb' => $breadcrumb,
            'draft' => $draft,
            'initialDraftState' => $draft?->payload,
            'draftLine' => $draft?->draft_line ?? $request->string('line')->toString() ?: null,
        ]);
    }

    /**
     * Export Nutracare template to Word
     */
    public function exportNutracare(Request $request)
    {
        // Will be implemented later with NutracareExportService
        $exportService = new \App\Services\Export\NutracareExportService();
        return $exportService->export($request->all());
    }

    public function saveNutracareDraft(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'draft_id'    => ['nullable', 'integer'],
            'draft_title' => ['nullable', 'string', 'max:255'],
            'draft_line'  => ['nullable', 'string', 'max:100'],
            'draft_state' => ['required', 'string'],
        ]);

        $decodedState = json_decode($validated['draft_state'], true);
        if (!is_array($decodedState)) {
            return response()->json(['success' => false, 'message' => 'Format draft_state tidak valid.'], 422);
        }

        $draft = null;
        if (!empty($validated['draft_id'])) {
            $draft = TemplateSummaryDraft::query()->where('draft_type', 'nutracare')->find($validated['draft_id']);
        }

        if (!$draft) {
            $draft = TemplateSummaryDraft::create([
                'draft_type'  => 'nutracare',
                'draft_line'  => $validated['draft_line'] ?? null,
                'title'       => $this->resolveDraftTitle($decodedState),
                'payload'     => [],
                'last_saved_at' => now(),
            ]);
        }
        $previousState = is_array($draft->payload) ? $draft->payload : [];

        $storedFiles = $decodedState['stored_files'] ?? [];
        if (!is_array($storedFiles)) {
            $storedFiles = [];
        }

        $storedFiles['mixing_image_file'] = $this->storeDraftFileGroup(
            $request,
            $draft->id,
            'mixing_image_file',
            'images'
        );
        $storedFiles['mixing_excel_file'] = $this->storeDraftFileGroup(
            $request,
            $draft->id,
            'mixing_excel_file',
            'excel'
        );

        $mergedStoredImages = $decodedState['stored_files']['mixing_image_file'] ?? [];
        if (!is_array($mergedStoredImages)) {
            $mergedStoredImages = [];
        }
        $mergedStoredImages = array_merge($mergedStoredImages, $storedFiles['mixing_image_file']);

        $mergedStoredExcel = $decodedState['stored_files']['mixing_excel_file'] ?? [];
        if (!is_array($mergedStoredExcel)) {
            $mergedStoredExcel = [];
        }
        $mergedStoredExcel = array_merge($mergedStoredExcel, $storedFiles['mixing_excel_file']);

        $decodedState['stored_files']['mixing_image_file'] = $mergedStoredImages;
        $decodedState['stored_files']['mixing_excel_file'] = $mergedStoredExcel;
        $decodedState = $this->normalizeStoredFilesUrl($decodedState, $draft->id);
        $this->cleanupRemovedDraftFiles($previousState, $decodedState);

        $formValues = $decodedState['form_values'] ?? [];
        if (!is_array($formValues)) {
            $formValues = [];
        }
        foreach ($mergedStoredImages as $tableUid => $imageMeta) {
            if (is_array($imageMeta) && !empty($imageMeta['path'])) {
                $formValues["existing_mixing_image_file[{$tableUid}]"] = (string) $imageMeta['path'];
            }
        }
        $decodedState['form_values'] = $formValues;

        $draft->update([
            'title' => $this->resolveDraftTitle($decodedState),
            'payload' => $decodedState,
            'last_saved_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'draft_id' => $draft->id,
            'message' => 'Draft berhasil disimpan.',
            'redirect_url' => route('template-summary.nutracare', ['draft' => $draft->id]),
            'stored_files' => $decodedState['stored_files'],
            'saved_at' => now()->format('Y-m-d H:i:s'),
        ]);
    }

    //Siladex Editor
    public function siladexEditor(Request $request)
    {
        $draft = null;
        $from = 'new';
        if ($request->filled('draft')) {
            $draft = TemplateSummaryDraft::query()
                ->where('draft_type', 'siladex')
                ->findOrFail($request->string('draft')->toString());
            $payload = $draft->payload;
            if (is_array($payload)) {
                $draft->payload = $this->normalizeStoredFilesUrl($payload, $draft->id);
            }
            $from = 'draft';
        }

        $breadcrumb = [
            'Summary' => route('template-summary.index'),
        ];
        if ($from === 'draft') {
            $breadcrumb['Draft Summary'] = route('template-summary.drafts');
        } else {
            $breadcrumb['Buat Baru'] = route('template-summary.index');
        }
        $breadcrumb['Siladex'] = null;

        return view('template-summary.siladex.editor', [
            'title' => 'Template Siladex',
            'breadcrumb' => $breadcrumb,
            'draft' => $draft,
            'initialDraftState' => $draft?->payload,
            'draftLine' => $draft?->draft_line ?? $request->string('line')->toString() ?: null,
        ]);
    }

    /**
     * Export Siladex template to Word
     */
    public function exportSiladex(Request $request)
    {
        // Will be implemented later with SiladexExportService
        $exportService = new \App\Services\Export\SiladexExportService();
        return $exportService->export($request->all());
    }

    public function saveSiladexDraft(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'draft_id'    => ['nullable', 'integer'],
            'draft_title' => ['nullable', 'string', 'max:255'],
            'draft_line'  => ['nullable', 'string', 'max:100'],
            'draft_state' => ['required', 'string'],
        ]);

        $decodedState = json_decode($validated['draft_state'], true);
        if (!is_array($decodedState)) {
            return response()->json(['success' => false, 'message' => 'Format draft_state tidak valid.'], 422);
        }

        $draft = null;
        if (!empty($validated['draft_id'])) {
            $draft = TemplateSummaryDraft::query()->where('draft_type', 'siladex')->find($validated['draft_id']);
        }

        if (!$draft) {
            $draft = TemplateSummaryDraft::create([
                'draft_type'  => 'siladex',
                'draft_line'  => $validated['draft_line'] ?? null,
                'title'       => $this->resolveDraftTitle($decodedState),
                'payload'     => [],
                'last_saved_at' => now(),
            ]);
        }
        $previousState = is_array($draft->payload) ? $draft->payload : [];

        $storedFiles = $decodedState['stored_files'] ?? [];
        if (!is_array($storedFiles)) {
            $storedFiles = [];
        }

        $storedFiles['mixing_image_file'] = $this->storeDraftFileGroup(
            $request,
            $draft->id,
            'mixing_image_file',
            'images'
        );
        $storedFiles['mixing_excel_file'] = $this->storeDraftFileGroup(
            $request,
            $draft->id,
            'mixing_excel_file',
            'excel'
        );

        $mergedStoredImages = $decodedState['stored_files']['mixing_image_file'] ?? [];
        if (!is_array($mergedStoredImages)) {
            $mergedStoredImages = [];
        }
        $mergedStoredImages = array_merge($mergedStoredImages, $storedFiles['mixing_image_file']);

        $mergedStoredExcel = $decodedState['stored_files']['mixing_excel_file'] ?? [];
        if (!is_array($mergedStoredExcel)) {
            $mergedStoredExcel = [];
        }
        $mergedStoredExcel = array_merge($mergedStoredExcel, $storedFiles['mixing_excel_file']);

        $decodedState['stored_files']['mixing_image_file'] = $mergedStoredImages;
        $decodedState['stored_files']['mixing_excel_file'] = $mergedStoredExcel;
        $decodedState = $this->normalizeStoredFilesUrl($decodedState, $draft->id);
        $this->cleanupRemovedDraftFiles($previousState, $decodedState);

        $formValues = $decodedState['form_values'] ?? [];
        if (!is_array($formValues)) {
            $formValues = [];
        }
        foreach ($mergedStoredImages as $tableUid => $imageMeta) {
            if (is_array($imageMeta) && !empty($imageMeta['path'])) {
                $formValues["existing_mixing_image_file[{$tableUid}]"] = (string) $imageMeta['path'];
            }
        }
        $decodedState['form_values'] = $formValues;

        $draft->update([
            'title' => $this->resolveDraftTitle($decodedState),
            'payload' => $decodedState,
            'last_saved_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'draft_id' => $draft->id,
            'message' => 'Draft berhasil disimpan.',
            'redirect_url' => route('template-summary.siladex', ['draft' => $draft->id]),
            'stored_files' => $decodedState['stored_files'],
            'saved_at' => now()->format('Y-m-d H:i:s'),
        ]);
    }

    /**
     * Show Anakonidin 60 mL template editor
     */
    public function Anakonidin60Editor(Request $request)
    {
        $draft = null;
        $from = 'new';
        if ($request->filled('draft')) {
            $draft = TemplateSummaryDraft::query()
                ->where('draft_type', 'anakonidin60')
                ->findOrFail($request->string('draft')->toString());
            $payload = $draft->payload;
            if (is_array($payload)) {
                $draft->payload = $this->normalizeStoredFilesUrl($payload, $draft->id);
            }
            $from = 'draft';
        }

        $breadcrumb = [
            'Summary' => route('template-summary.index'),
        ];
        if ($from === 'draft') {
            $breadcrumb['Draft Summary'] = route('template-summary.drafts');
        } else {
            $breadcrumb['Buat Baru'] = route('template-summary.index');
        }
        $breadcrumb['Anakonidin 60ml'] = null;

        return view('template-summary.anakonidin60.editor', [
            'title' => 'Template Anakonidin 60ml',
            'breadcrumb' => $breadcrumb,
            'draft' => $draft,
            'initialDraftState' => $draft?->payload,
            'draftLine' => $draft?->draft_line ?? $request->string('line')->toString() ?: null,
        ]);
    }

    /**
     * Export Anakonidin 60 mL template to Word
     */
    public function exportAnakonidin60(Request $request)
    {
        // Will be implemented later with SirupExportService
        $exportService = new \App\Services\Export\Anakonidin60ExportService();
        return $exportService->export($request->all());
    }

    public function saveAnakonidin60Draft(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'draft_id'    => ['nullable', 'integer'],
            'draft_title' => ['nullable', 'string', 'max:255'],
            'draft_line'  => ['nullable', 'string', 'max:100'],
            'draft_state' => ['required', 'string'],
        ]);

        $decodedState = json_decode($validated['draft_state'], true);
        if (!is_array($decodedState)) {
            return response()->json(['success' => false, 'message' => 'Format draft_state tidak valid.'], 422);
        }

        $draft = null;
        if (!empty($validated['draft_id'])) {
            $draft = TemplateSummaryDraft::query()->where('draft_type', 'anakonidin60')->find($validated['draft_id']);
        }

        if (!$draft) {
            $draft = TemplateSummaryDraft::create([
                'draft_type'  => 'anakonidin60',
                'draft_line'  => $validated['draft_line'] ?? null,
                'title'       => $this->resolveDraftTitle($decodedState),
                'payload'     => [],
                'last_saved_at' => now(),
            ]);
        }
        $previousState = is_array($draft->payload) ? $draft->payload : [];

        $storedFiles = $decodedState['stored_files'] ?? [];
        if (!is_array($storedFiles)) {
            $storedFiles = [];
        }

        $storedFiles['mixing_image_file'] = $this->storeDraftFileGroup(
            $request,
            $draft->id,
            'mixing_image_file',
            'images'
        );
        $storedFiles['mixing_excel_file'] = $this->storeDraftFileGroup(
            $request,
            $draft->id,
            'mixing_excel_file',
            'excel'
        );

        $mergedStoredImages = $decodedState['stored_files']['mixing_image_file'] ?? [];
        if (!is_array($mergedStoredImages)) {
            $mergedStoredImages = [];
        }
        $mergedStoredImages = array_merge($mergedStoredImages, $storedFiles['mixing_image_file']);

        $mergedStoredExcel = $decodedState['stored_files']['mixing_excel_file'] ?? [];
        if (!is_array($mergedStoredExcel)) {
            $mergedStoredExcel = [];
        }
        $mergedStoredExcel = array_merge($mergedStoredExcel, $storedFiles['mixing_excel_file']);

        $decodedState['stored_files']['mixing_image_file'] = $mergedStoredImages;
        $decodedState['stored_files']['mixing_excel_file'] = $mergedStoredExcel;
        $decodedState = $this->normalizeStoredFilesUrl($decodedState, $draft->id);
        $this->cleanupRemovedDraftFiles($previousState, $decodedState);

        $formValues = $decodedState['form_values'] ?? [];
        if (!is_array($formValues)) {
            $formValues = [];
        }
        foreach ($mergedStoredImages as $tableUid => $imageMeta) {
            if (is_array($imageMeta) && !empty($imageMeta['path'])) {
                $formValues["existing_mixing_image_file[{$tableUid}]"] = (string) $imageMeta['path'];
            }
        }
        $decodedState['form_values'] = $formValues;

        $draft->update([
            'title' => $this->resolveDraftTitle($decodedState),
            'payload' => $decodedState,
            'last_saved_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'draft_id' => $draft->id,
            'message' => 'Draft berhasil disimpan.',
            'redirect_url' => route('template-summary.anakonidin60', ['draft' => $draft->id]),
            'stored_files' => $decodedState['stored_files'],
            'saved_at' => now()->format('Y-m-d H:i:s'),
        ]);
    }

    public function parseExcel(Request $request)
    {
        //     $request->validate([
        //         'file' => 'required|file|mimes:xlsx,xls,ods|max:10240', // Max 10MB
        //     ]);

        //     try {
        //         $file = $request->file('file');
        //         $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file->getPathname());
        //         $worksheet = $spreadsheet->getActiveSheet();

        //         $data = [];
        //         $mergedCells = $worksheet->getMergeCells();
        //         $mergedCellMap = [];

        //         // Build merged cell map
        //         foreach ($mergedCells as $mergeRange) {
        //             $rangeData = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::rangeBoundaries($mergeRange);
        //             $startCol = $rangeData[0][0];
        //             $startRow = $rangeData[0][1];
        //             $endCol = $rangeData[1][0];
        //             $endRow = $rangeData[1][1];

        //             // Get the value from the top-left cell
        //             $value = $worksheet->getCellByColumnAndRow($startCol, $startRow)->getValue();

        //             // Mark all cells in this merge range
        //             for ($row = $startRow; $row <= $endRow; $row++) {
        //                 for ($col = $startCol; $col <= $endCol; $col++) {
        //                     $mergedCellMap[$row][$col] = [
        //                         'value' => $value,
        //                         'colspan' => $endCol - $startCol + 1,
        //                         'rowspan' => $endRow - $startRow + 1,
        //                         'isFirst' => ($row === $startRow && $col === $startCol),
        //                         'isHidden' => !($row === $startRow && $col === $startCol),
        //                     ];
        //                 }
        //             }
        //         }

        //         // Get highest row and column
        //         $highestRow = $worksheet->getHighestRow();
        //         $highestColumn = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($worksheet->getHighestColumn());

        //         // Build data array
        //         for ($row = 1; $row <= $highestRow; $row++) {
        //             $rowData = [];
        //             for ($col = 1; $col <= $highestColumn; $col++) {
        //                 $cellData = [
        //                     'value' => '',
        //                     'colspan' => 1,
        //                     'rowspan' => 1,
        //                     'isHidden' => false,
        //                 ];

        //                 if (isset($mergedCellMap[$row][$col])) {
        //                     $merge = $mergedCellMap[$row][$col];
        //                     $cellData['value'] = $merge['value'] ?? '';
        //                     $cellData['colspan'] = $merge['colspan'];
        //                     $cellData['rowspan'] = $merge['rowspan'];
        //                     $cellData['isHidden'] = $merge['isHidden'];
        //                 } else {
        //                     $cellData['value'] = $worksheet->getCellByColumnAndRow($col, $row)->getValue() ?? '';
        //                 }

        //                 $rowData[] = $cellData;
        //             }
        //             $data[] = $rowData;
        //         }

        //         return response()->json([
        //             'success' => true,
        //             'data' => $data,
        //             'rows' => $highestRow,
        //             'cols' => $highestColumn,
        //         ]);

        //     } catch (\Exception $e) {
        //         return response()->json([
        //             'success' => false,
        //             'message' => 'Gagal membaca file Excel: ' . $e->getMessage(),
        //         ], 500);
        //     }
    }

    /**
     * @return array<string, array{path:string,url:string,name:string}>
     */
    private function storeDraftFileGroup(Request $request, int $draftId, string $field, string $folder): array
    {
        $files = $request->file($field, []);
        if (!is_array($files)) {
            return [];
        }

        $stored = [];
        foreach ($files as $tableUid => $file) {
            if (!$file || !$file->isValid()) {
                continue;
            }

            $path = $file->store("template-summary/drafts/{$draftId}/{$folder}", 'public');
            $stored[(string) $tableUid] = [
                'path' => $path,
                'url' => $this->publicStorageUrl($path),
                'name' => $file->getClientOriginalName(),
            ];
        }

        return $stored;
    }

    private function resolveDraftTitle(array $state): string
    {
        $fields = $state['form_values'] ?? [];
        if (!is_array($fields)) {
            return 'Draft Sirup';
        } 

        $product = trim((string) ($fields['judul_nama_produk'] ?? ''));
        $formula = trim((string) ($fields['judul_formula'] ?? ''));
        $line = trim((string) ($fields['judul_line'] ?? ''));
        $bagian = trim((string) ($fields['judul_bagian'] ?? ($fields['tujuan_bagian'] ?? '')));

        $product = $product !== '' ? $product : '';
        $line = $line !== '' ? $line : '2';
        $bagian = $bagian !== '' ? $bagian : 'Production (Pharmaceutical II) Gedung B';

        $title = "SUMMARY LAPORAN VALIDASI PROSES PEMBUATAN PRODUK {$product}";
        if ($formula !== '') {
            $title .= " ({$formula})";
        }
        $title .= " DI LINE {$line} BAGIAN " . strtoupper($bagian);

        return $title;
    }

    // ── Konidin OBH ──────────────────────────────────────────────────────────────

    public function konidinobhEditor(Request $request)
    {
        $draft = null;
        $from  = 'new';
        if ($request->filled('draft')) {
            $draft = TemplateSummaryDraft::query()
                ->where('draft_type', 'konidinobh')
                ->findOrFail($request->string('draft')->toString());
            $payload = $draft->payload;
            if (is_array($payload)) {
                $draft->payload = $this->normalizeStoredFilesUrl($payload, $draft->id);
            }
            $from = 'draft';
        }

        $breadcrumb = ['Summary' => route('template-summary.index')];
        if ($from === 'draft') {
            $breadcrumb['Draft Summary'] = route('template-summary.drafts');
        } else {
            $breadcrumb['Buat Baru'] = route('template-summary.index');
        }
        $breadcrumb['Konidin OBH'] = null;

        return view('template-summary.konidinobh.editor', [
            'title'             => 'Template Konidin OBH',
            'breadcrumb'        => $breadcrumb,
            'draft'             => $draft,
            'initialDraftState' => $draft?->payload,
            'draftLine'         => $draft?->draft_line ?? $request->string('line')->toString() ?: null,
        ]);
    }

    public function exportKonidinOBH(Request $request)
    {
        $exportService = new \App\Services\Export\KonidinOBHExportService();
        return $exportService->export($request->all());
    }

    public function saveKonidinOBHDraft(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'draft_id'    => ['nullable', 'integer'],
            'draft_title' => ['nullable', 'string', 'max:255'],
            'draft_line'  => ['nullable', 'string', 'max:100'],
            'draft_state' => ['required', 'string'],
        ]);

        $decodedState = json_decode($validated['draft_state'], true);
        if (!is_array($decodedState)) {
            return response()->json(['success' => false, 'message' => 'Format draft_state tidak valid.'], 422);
        }

        $draft = null;
        if (!empty($validated['draft_id'])) {
            $draft = TemplateSummaryDraft::query()->where('draft_type', 'konidinobh')->find($validated['draft_id']);
        }

        if (!$draft) {
            $draft = TemplateSummaryDraft::create([
                'draft_type'    => 'konidinobh',
                'draft_line'    => $validated['draft_line'] ?? null,
                'title'         => $this->resolveDraftTitle($decodedState),
                'payload'       => [],
                'last_saved_at' => now(),
            ]);
        }
        $previousState = is_array($draft->payload) ? $draft->payload : [];

        $storedFiles = $decodedState['stored_files'] ?? [];
        if (!is_array($storedFiles)) $storedFiles = [];

        $storedFiles['mixing_image_file'] = $this->storeDraftFileGroup($request, $draft->id, 'mixing_image_file', 'images');
        $storedFiles['mixing_excel_file'] = $this->storeDraftFileGroup($request, $draft->id, 'mixing_excel_file', 'excel');

        $mergedStoredImages = array_merge(
            is_array($decodedState['stored_files']['mixing_image_file'] ?? null) ? $decodedState['stored_files']['mixing_image_file'] : [],
            $storedFiles['mixing_image_file']
        );
        $mergedStoredExcel = array_merge(
            is_array($decodedState['stored_files']['mixing_excel_file'] ?? null) ? $decodedState['stored_files']['mixing_excel_file'] : [],
            $storedFiles['mixing_excel_file']
        );

        $decodedState['stored_files']['mixing_image_file'] = $mergedStoredImages;
        $decodedState['stored_files']['mixing_excel_file'] = $mergedStoredExcel;
        $decodedState = $this->normalizeStoredFilesUrl($decodedState, $draft->id);
        $this->cleanupRemovedDraftFiles($previousState, $decodedState);

        $formValues = is_array($decodedState['form_values'] ?? null) ? $decodedState['form_values'] : [];
        foreach ($mergedStoredImages as $tableUid => $imageMeta) {
            if (is_array($imageMeta) && !empty($imageMeta['path'])) {
                $formValues["existing_mixing_image_file[{$tableUid}]"] = (string) $imageMeta['path'];
            }
        }
        $decodedState['form_values'] = $formValues;

        $draft->update([
            'title'         => $this->resolveDraftTitle($decodedState),
            'payload'       => $decodedState,
            'last_saved_at' => now(),
        ]);

        return response()->json([
            'success'      => true,
            'draft_id'     => $draft->id,
            'message'      => 'Draft berhasil disimpan.',
            'redirect_url' => route('template-summary.konidinobh', ['draft' => $draft->id]),
            'stored_files' => $decodedState['stored_files'],
            'saved_at'     => now()->format('Y-m-d H:i:s'),
        ]);
    }

    private function deleteDraftStorageDirectory(int $draftId): void
    {
        $basePath = "template-summary/drafts/{$draftId}";
        if (Storage::disk('public')->exists($basePath)) {
            Storage::disk('public')->deleteDirectory($basePath);
        }
    }

    private function publicStorageUrl(string $path): string
    {
        $normalizedPath = ltrim(str_replace('\\', '/', $path), '/');
        return asset('storage/' . $normalizedPath);
    }

    private function cleanupRemovedDraftFiles(array $oldState, array $newState): void
    {
        $oldPaths = $this->extractStoredFilePaths($oldState);
        $newPaths = $this->extractStoredFilePaths($newState);

        $pathsToDelete = array_diff($oldPaths, $newPaths);
        foreach ($pathsToDelete as $path) {
            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
        }
    }

    /**
     * @return array<int, string>
     */
    private function extractStoredFilePaths(array $state): array
    {
        $storedFiles = $state['stored_files'] ?? [];
        if (!is_array($storedFiles)) {
            return [];
        }

        $paths = [];
        foreach (['mixing_image_file', 'mixing_excel_file'] as $group) {
            $items = $storedFiles[$group] ?? [];
            if (!is_array($items)) {
                continue;
            }

            foreach ($items as $meta) {
                if (!is_array($meta)) {
                    continue;
                }

                $path = isset($meta['path']) ? trim((string) $meta['path']) : '';
                if ($path !== '') {
                    $paths[] = str_replace('\\', '/', $path);
                }
            }
        }

        return array_values(array_unique($paths));
    }

    private function normalizeStoredFilesUrl(array $state, ?int $draftId = null): array
    {
        $storedFiles = $state['stored_files'] ?? [];
        if (!is_array($storedFiles)) {
            return $state;
        }

        $imageMap = $storedFiles['mixing_image_file'] ?? [];
        if (is_array($imageMap)) {
            $imageMap = $this->normalizeStoredFileGroup($imageMap, $draftId, 'images');
        }

        $excelMap = $storedFiles['mixing_excel_file'] ?? [];
        if (is_array($excelMap)) {
            $excelMap = $this->normalizeStoredFileGroup($excelMap, $draftId, 'excel');
        }

        $state['stored_files']['mixing_image_file'] = $imageMap;
        $state['stored_files']['mixing_excel_file'] = $excelMap;

        return $state;
    }

    /**
     * @param array<string, mixed> $group
     * @return array<string, mixed>
     */
    private function normalizeStoredFileGroup(array $group, ?int $draftId, string $folder): array
    {
        foreach ($group as $tableUid => $meta) {
            if (!is_array($meta)) {
                continue;
            }

            $path = $this->normalizeStoredFilePath($meta, $draftId, $folder);
            if ($path === '') {
                continue;
            }

            $group[$tableUid]['path'] = $path;
            $group[$tableUid]['url'] = $this->publicStorageUrl($path);
        }

        return $group;
    }

    /**
     * Normalize legacy path formats:
     * - absolute /storage/... URL path
     * - raw "storage/..." path
     * - filename-only value from older drafts
     */
    private function normalizeStoredFilePath(array $meta, ?int $draftId, string $folder): string
    {
        $path = trim((string) ($meta['path'] ?? ''));
        $url = trim((string) ($meta['url'] ?? ''));

        if ($path === '' && $url !== '') {
            $parsedUrlPath = (string) (parse_url($url, PHP_URL_PATH) ?? '');
            if ($parsedUrlPath !== '') {
                $path = $parsedUrlPath;
            }
        }

        if ($path === '') {
            return '';
        }

        $path = str_replace('\\', '/', $path);
        $path = preg_replace('#^https?://[^/]+/#i', '', $path) ?? $path;
        $path = ltrim($path, '/');
        $path = preg_replace('#^storage/#i', '', $path) ?? $path;

        if ($draftId !== null) {
            if (!str_contains($path, '/')) {
                $path = "template-summary/drafts/{$draftId}/{$folder}/{$path}";
            } elseif (preg_match("#^drafts/{$draftId}/#", $path)) {
                $path = 'template-summary/' . $path;
            }
        }

        return ltrim($path, '/');
    }

    // ── Nutracare Grape Seed ─────────────────────────────────────────────────

    public function nutracareGrapeEditor(Request $request)
    {
        $draft = null;
        $from  = 'new';

        if ($request->filled('draft')) {
            $draft = TemplateSummaryDraft::query()
                ->where('draft_type', 'nutracaregrape')
                ->findOrFail($request->string('draft')->toString());
            $payload = $draft->payload;
            if (is_array($payload)) {
                $draft->payload = $this->normalizeStoredFilesUrl($payload, $draft->id);
            }
            $from = 'draft';
        }

        $breadcrumb = ['Summary' => route('template-summary.index')];
        if ($from === 'draft') {
            $breadcrumb['Draft Summary'] = route('template-summary.drafts');
        } else {
            $breadcrumb['Buat Baru'] = route('template-summary.index');
        }
        $breadcrumb['Nutracare Grape Seed'] = null;

        return view('template-summary.nutracaregrape.editor', [
            'title'             => 'Template Nutracare Grape Seed',
            'breadcrumb'        => $breadcrumb,
            'draft'             => $draft,
            'initialDraftState' => $draft?->payload,
            'draftLine'         => $draft?->draft_line ?? $request->string('line')->toString() ?: null,
        ]);
    }

    public function exportNutracareGrape(Request $request)
    {
        $exportService = new \App\Services\Export\NutracareGrapeExportService();
        return $exportService->export($request->all());
    }

    public function saveNutracareGrapeDraft(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'draft_id'    => ['nullable', 'integer'],
            'draft_title' => ['nullable', 'string', 'max:255'],
            'draft_line'  => ['nullable', 'string', 'max:100'],
            'draft_state' => ['required', 'string'],
        ]);

        $decodedState = json_decode($validated['draft_state'], true);
        if (!is_array($decodedState)) {
            return response()->json(['success' => false, 'message' => 'Format draft_state tidak valid.'], 422);
        }

        $draft = null;
        if (!empty($validated['draft_id'])) {
            $draft = TemplateSummaryDraft::query()
                ->where('draft_type', 'nutracaregrape')
                ->find($validated['draft_id']);
        }

        if (!$draft) {
            $draft = TemplateSummaryDraft::create([
                'draft_type'    => 'nutracaregrape',
                'draft_line'    => $validated['draft_line'] ?? null,
                'title'         => $this->resolveDraftTitle($decodedState),
                'payload'       => [],
                'last_saved_at' => now(),
            ]);
        }

        $previousState = is_array($draft->payload) ? $draft->payload : [];

        $storedFiles = $decodedState['stored_files'] ?? [];
        if (!is_array($storedFiles)) {
            $storedFiles = [];
        }

        $storedFiles['mixing_image_file'] = $this->storeDraftFileGroup(
            $request, $draft->id, 'mixing_image_file', 'images'
        );
        $storedFiles['mixing_excel_file'] = $this->storeDraftFileGroup(
            $request, $draft->id, 'mixing_excel_file', 'excel'
        );

        $mergedStoredImages = $decodedState['stored_files']['mixing_image_file'] ?? [];
        if (!is_array($mergedStoredImages)) $mergedStoredImages = [];
        $mergedStoredImages = array_merge($mergedStoredImages, $storedFiles['mixing_image_file']);

        $mergedStoredExcel = $decodedState['stored_files']['mixing_excel_file'] ?? [];
        if (!is_array($mergedStoredExcel)) $mergedStoredExcel = [];
        $mergedStoredExcel = array_merge($mergedStoredExcel, $storedFiles['mixing_excel_file']);

        $decodedState['stored_files']['mixing_image_file'] = $mergedStoredImages;
        $decodedState['stored_files']['mixing_excel_file'] = $mergedStoredExcel;
        $decodedState = $this->normalizeStoredFilesUrl($decodedState, $draft->id);
        $this->cleanupRemovedDraftFiles($previousState, $decodedState);

        $formValues = $decodedState['form_values'] ?? [];
        if (!is_array($formValues)) $formValues = [];
        foreach ($mergedStoredImages as $tableUid => $imageMeta) {
            if (is_array($imageMeta) && !empty($imageMeta['path'])) {
                $formValues["existing_mixing_image_file[{$tableUid}]"] = (string) $imageMeta['path'];
            }
        }
        $decodedState['form_values'] = $formValues;

        $draft->update([
            'title'         => $this->resolveDraftTitle($decodedState),
            'payload'       => $decodedState,
            'last_saved_at' => now(),
        ]);

        return response()->json([
            'success'      => true,
            'draft_id'     => $draft->id,
            'message'      => 'Draft berhasil disimpan.',
            'redirect_url' => route('template-summary.nutracaregrape', ['draft' => $draft->id]),
            'stored_files' => $decodedState['stored_files'],
            'saved_at'     => now()->format('Y-m-d H:i:s'),
        ]);
    }

    // ── Q-Fomil ──────────────────────────────────────────────────────────────

    public function QFomilEditor(Request $request)
    {
        $draft = null;
        $from  = 'new';

        if ($request->filled('draft')) {
            $draft = TemplateSummaryDraft::query()
                ->where('draft_type', 'qfomil')
                ->findOrFail($request->string('draft')->toString());
            $payload = $draft->payload;
            if (is_array($payload)) {
                $draft->payload = $this->normalizeStoredFilesUrl($payload, $draft->id);
            }
            $from = 'draft';
        }

        $breadcrumb = ['Summary' => route('template-summary.index')];
        if ($from === 'draft') {
            $breadcrumb['Draft Summary'] = route('template-summary.drafts');
        } else {
            $breadcrumb['Buat Baru'] = route('template-summary.index');
        }
        $breadcrumb['Q-Fomil'] = null;

        return view('template-summary.qfomil.editor', [
            'title'             => 'Template Q-Fomil',
            'breadcrumb'        => $breadcrumb,
            'draft'             => $draft,
            'initialDraftState' => $draft?->payload,
            'draftLine'         => $draft?->draft_line ?? $request->string('line')->toString() ?: null,
        ]);
    }

    public function exportQFomil(Request $request)
    {
        $exportService = new \App\Services\Export\QFomilExportService();
        return $exportService->export($request->all());
    }

    public function saveQFomilDraft(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'draft_id'    => ['nullable', 'integer'],
            'draft_title' => ['nullable', 'string', 'max:255'],
            'draft_line'  => ['nullable', 'string', 'max:100'],
            'draft_state' => ['required', 'string'],
        ]);

        $decodedState = json_decode($validated['draft_state'], true);
        if (!is_array($decodedState)) {
            return response()->json(['success' => false, 'message' => 'Format draft_state tidak valid.'], 422);
        }

        $draft = null;
        if (!empty($validated['draft_id'])) {
            $draft = TemplateSummaryDraft::query()
                ->where('draft_type', 'qfomil')
                ->find($validated['draft_id']);
        }

        if (!$draft) {
            $draft = TemplateSummaryDraft::create([
                'draft_type'    => 'qfomil',
                'draft_line'    => $validated['draft_line'] ?? null,
                'title'         => $this->resolveDraftTitle($decodedState),
                'payload'       => [],
                'last_saved_at' => now(),
            ]);
        }

        $previousState = is_array($draft->payload) ? $draft->payload : [];

        $storedFiles = $decodedState['stored_files'] ?? [];
        if (!is_array($storedFiles)) $storedFiles = [];

        $storedFiles['mixing_image_file'] = $this->storeDraftFileGroup(
            $request, $draft->id, 'mixing_image_file', 'images'
        );
        $storedFiles['mixing_excel_file'] = $this->storeDraftFileGroup(
            $request, $draft->id, 'mixing_excel_file', 'excel'
        );

        $mergedStoredImages = $decodedState['stored_files']['mixing_image_file'] ?? [];
        if (!is_array($mergedStoredImages)) $mergedStoredImages = [];
        $mergedStoredImages = array_merge($mergedStoredImages, $storedFiles['mixing_image_file']);

        $mergedStoredExcel = $decodedState['stored_files']['mixing_excel_file'] ?? [];
        if (!is_array($mergedStoredExcel)) $mergedStoredExcel = [];
        $mergedStoredExcel = array_merge($mergedStoredExcel, $storedFiles['mixing_excel_file']);

        $decodedState['stored_files']['mixing_image_file'] = $mergedStoredImages;
        $decodedState['stored_files']['mixing_excel_file'] = $mergedStoredExcel;
        $decodedState = $this->normalizeStoredFilesUrl($decodedState, $draft->id);
        $this->cleanupRemovedDraftFiles($previousState, $decodedState);

        $formValues = $decodedState['form_values'] ?? [];
        if (!is_array($formValues)) $formValues = [];
        foreach ($mergedStoredImages as $tableUid => $imageMeta) {
            if (is_array($imageMeta) && !empty($imageMeta['path'])) {
                $formValues["existing_mixing_image_file[{$tableUid}]"] = (string) $imageMeta['path'];
            }
        }
        $decodedState['form_values'] = $formValues;

        $draft->update([
            'title'         => $this->resolveDraftTitle($decodedState),
            'payload'       => $decodedState,
            'last_saved_at' => now(),
        ]);

        return response()->json([
            'success'      => true,
            'draft_id'     => $draft->id,
            'message'      => 'Draft berhasil disimpan.',
            'redirect_url' => route('template-summary.qfomil', ['draft' => $draft->id]),
            'stored_files' => $decodedState['stored_files'],
            'saved_at'     => now()->format('Y-m-d H:i:s'),
        ]);
    }

    // ── Zingiberis Officinalis Powder Extract ─────────────────────────────────

    public function ZingiberisEditor(Request $request)
    {
        $draft = null;
        $from  = 'new';

        if ($request->filled('draft')) {
            $draft = TemplateSummaryDraft::query()
                ->where('draft_type', 'zingiberis')
                ->findOrFail($request->string('draft')->toString());
            $payload = $draft->payload;
            if (is_array($payload)) {
                $draft->payload = $this->normalizeStoredFilesUrl($payload, $draft->id);
            }
            $from = 'draft';
        }

        $breadcrumb = ['Summary' => route('template-summary.index')];
        if ($from === 'draft') {
            $breadcrumb['Draft Summary'] = route('template-summary.drafts');
        } else {
            $breadcrumb['Buat Baru'] = route('template-summary.index');
        }
        $breadcrumb['Zingiberis'] = null;

        // Load stages with machines for machine dropdowns
        $stages = \App\Models\Stage::query()
            ->orderBy('sort_order')
            ->with(['machines' => fn($q) => $q->orderBy('sort_order')])
            ->get();

        return view('template-summary.zingiberis.editor', [
            'title'             => 'Template Zingiberis',
            'breadcrumb'        => $breadcrumb,
            'draft'             => $draft,
            'initialDraftState' => $draft?->payload,
            'draftLine'         => $draft?->draft_line ?? $request->string('line')->toString() ?: null,
            'stages'            => $stages,
        ]);
    }

    public function exportZingiberis(Request $request)
    {
        // TEMP DEBUG: log semua data yang diterima
        $all = $request->except(['_token', 'export_token']);
        \Illuminate\Support\Facades\Log::info('ZINGIBERIS EXPORT DATA', $all);

        $exportService = new \App\Services\Export\ZingiberisExportService();
        return $exportService->export($all);
    }

    public function saveZingiberisDraft(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'draft_id'    => ['nullable', 'integer'],
            'draft_title' => ['nullable', 'string', 'max:255'],
            'draft_line'  => ['nullable', 'string', 'max:100'],
            'draft_state' => ['required', 'string'],
        ]);

        $decodedState = json_decode($validated['draft_state'], true);
        if (!is_array($decodedState)) {
            return response()->json(['success' => false, 'message' => 'Format draft_state tidak valid.'], 422);
        }

        $draft = null;
        if (!empty($validated['draft_id'])) {
            $draft = TemplateSummaryDraft::query()
                ->where('draft_type', 'zingiberis')
                ->find($validated['draft_id']);
        }

        if (!$draft) {
            $draft = TemplateSummaryDraft::create([
                'draft_type'    => 'zingiberis',
                'draft_line'    => $validated['draft_line'] ?? null,
                'title'         => $this->resolveDraftTitle($decodedState),
                'payload'       => [],
                'last_saved_at' => now(),
            ]);
        }

        $previousState = is_array($draft->payload) ? $draft->payload : [];

        $storedFiles = $decodedState['stored_files'] ?? [];
        if (!is_array($storedFiles)) $storedFiles = [];

        $storedFiles['mixing_image_file'] = $this->storeDraftFileGroup(
            $request, $draft->id, 'mixing_image_file', 'images'
        );
        $storedFiles['mixing_excel_file'] = $this->storeDraftFileGroup(
            $request, $draft->id, 'mixing_excel_file', 'excel'
        );

        $mergedStoredImages = $decodedState['stored_files']['mixing_image_file'] ?? [];
        if (!is_array($mergedStoredImages)) $mergedStoredImages = [];
        $mergedStoredImages = array_merge($mergedStoredImages, $storedFiles['mixing_image_file']);

        $mergedStoredExcel = $decodedState['stored_files']['mixing_excel_file'] ?? [];
        if (!is_array($mergedStoredExcel)) $mergedStoredExcel = [];
        $mergedStoredExcel = array_merge($mergedStoredExcel, $storedFiles['mixing_excel_file']);

        $decodedState['stored_files']['mixing_image_file'] = $mergedStoredImages;
        $decodedState['stored_files']['mixing_excel_file'] = $mergedStoredExcel;
        $decodedState = $this->normalizeStoredFilesUrl($decodedState, $draft->id);
        $this->cleanupRemovedDraftFiles($previousState, $decodedState);

        $formValues = $decodedState['form_values'] ?? [];
        if (!is_array($formValues)) $formValues = [];
        foreach ($mergedStoredImages as $tableUid => $imageMeta) {
            if (is_array($imageMeta) && !empty($imageMeta['path'])) {
                $formValues["existing_mixing_image_file[{$tableUid}]"] = (string) $imageMeta['path'];
            }
        }
        $decodedState['form_values'] = $formValues;

        $draft->update([
            'title'         => $this->resolveDraftTitle($decodedState),
            'payload'       => $decodedState,
            'last_saved_at' => now(),
        ]);

        return response()->json([
            'success'      => true,
            'draft_id'     => $draft->id,
            'message'      => 'Draft berhasil disimpan.',
            'redirect_url' => route('template-summary.zingiberis', ['draft' => $draft->id]),
            'stored_files' => $decodedState['stored_files'],
            'saved_at'     => now()->format('Y-m-d H:i:s'),
        ]);
    }
}