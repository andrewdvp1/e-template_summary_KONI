<?php

namespace App\Http\Controllers;

use App\Models\TemplateSummaryDraft;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class TemplateSummaryController extends Controller
{
    /**
     * Show template report landing page
     */
    public function index()
    {
        // Master production grouping — mirrors PRODUCTION_DATA in the JS modal
        $productionGroups = [
            'pharma1a' => [
                'label' => 'Production Pharmaceutical I A',
                'types' => ['nutracare', 'kapsul', 'sirup'],
            ],
            'pharma1b' => [
                'label' => 'Production Pharmaceutical I B',
                'types' => ['tablet', 'kapsul'],
            ],
            'pharma2' => [
                'label' => 'Production Pharmaceutical II',
                'types' => ['sirup', 'siladex', 'konvermex', 'heltiskin'],
            ],
            'natural' => [
                'label' => 'Natural Product & Extraction',
                'types' => ['sirup'],
            ],
        ];

        $draftsByGroup = [];
        foreach ($productionGroups as $groupKey => $group) {
            $drafts = TemplateSummaryDraft::query()
                ->whereIn('draft_type', $group['types'])
                ->latest('updated_at')
                ->limit(2)
                ->get();

            if ($drafts->isNotEmpty()) {
                $draftsByGroup[$groupKey] = [
                    'label'  => $group['label'],
                    'types'  => $group['types'],
                    'drafts' => $drafts,
                ];
            }
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
        $drafts = TemplateSummaryDraft::query()
            ->where('draft_type', 'sirup')
            ->orWhere('draft_type', 'tablet')
            ->orWhere('draft_type', 'kapsul')
            ->orWhere('draft_type', 'heltiskin')
            ->orwhere('draft_type', 'konvermex')
            ->orwhere('draft_type', 'nutracare')
            ->orwhere('draft_type', 'siladex')
            ->latest('updated_at')
            ->get();

        return view('template-summary.drafts', [
            'breadcrumb' => [
                'Summary' => null,
                'Draft Summary' => route('template-summary.drafts'),
            ],
            'drafts' => $drafts,
        ]);
    }

    /**
     * Delete a draft summary (sirup)
     */
    public function deleteDraft(TemplateSummaryDraft $draft): JsonResponse
    {
        if ($draft->draft_type !== 'sirup' && 
        $draft->draft_type !== 'tablet' && 
        $draft->draft_type !== 'kapsul' && 
        $draft->draft_type !== 'heltiskin' &&
        $draft->draft_type !== 'konvermex' &&
        $draft->draft_type !== 'nutracare' &&
        $draft->draft_type !== 'siladex') {
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
     * Fungsi Continue Draft untuk mengarahkan ke editor yang sesuai berdasarkan tipe draft (sirup/tablet/kapsul)
     */
    public function continueDraft(TemplateSummaryDraft $draft)
    {
        if ($draft->draft_type === 'sirup') {
            return redirect()->route('template-summary.sirup', ['draft' => $draft->id]);
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
        } elseif ($draft->draft_type === 'siladex') {
            return redirect()->route('template-summary.siladex', ['draft' => $draft->id]);
        }

        abort(404, 'Draft tidak ditemukan.');
    }

    /**
     * Show Sirup template editor
     */
    public function sirupEditor(Request $request)
    {
        $draft = null;
        $from = 'new';
        if ($request->filled('draft')) {
            $draft = TemplateSummaryDraft::query()
                ->where('draft_type', 'sirup')
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
        $breadcrumb['Sirup'] = null;

        return view('template-summary.sirup.editor', [
            'title' => 'Template Sirup',
            'breadcrumb' => $breadcrumb,
            'draft' => $draft,
            'initialDraftState' => $draft?->payload,
        ]);
    }

    /**
     * Export Sirup template to Word
     */
    public function exportSirup(Request $request)
    {
        // Will be implemented later with SirupExportService
        $exportService = new \App\Services\Export\SirupExportService();
        return $exportService->export($request->all());
    }

    public function saveSirupDraft(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'draft_id' => ['nullable', 'integer'],
            'draft_title' => ['nullable', 'string', 'max:255'],
            'draft_state' => ['required', 'string'],
        ]);

        $decodedState = json_decode($validated['draft_state'], true);
        if (!is_array($decodedState)) {
            return response()->json([
                'success' => false,
                'message' => 'Format draft_state tidak valid.',
            ], 422);
        }

        $draft = null;
        if (!empty($validated['draft_id'])) {
            $draft = TemplateSummaryDraft::query()
                ->where('draft_type', 'sirup')
                ->find($validated['draft_id']);
        }

        if (!$draft) {
            $draft = TemplateSummaryDraft::create([
                'draft_type' => 'sirup',
                'title' => $this->resolveDraftTitle($decodedState),
                'payload' => [],
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
            'redirect_url' => route('template-summary.sirup', ['draft' => $draft->id]),
            'stored_files' => $decodedState['stored_files'],
            'saved_at' => now()->format('Y-m-d H:i:s'),
        ]);
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
            'draft_id' => ['nullable', 'integer'],
            'draft_title' => ['nullable', 'string', 'max:255'],
            'draft_state' => ['required', 'string'],
        ]);

        $decodedState = json_decode($validated['draft_state'], true);
        if (!is_array($decodedState)) {
            return response()->json([
                'success' => false,
                'message' => 'Format draft_state tidak valid.',
            ], 422);
        }

        $draft = null;
        if (!empty($validated['draft_id'])) {
            $draft = TemplateSummaryDraft::query()
                ->where('draft_type', 'tablet')
                ->find($validated['draft_id']);
        }

        if (!$draft) {
            $draft = TemplateSummaryDraft::create([
                'draft_type' => 'tablet',
                'title' => $this->resolveDraftTitle($decodedState),
                'payload' => [],
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
            'draft_id' => ['nullable', 'integer'],
            'draft_title' => ['nullable', 'string', 'max:255'],
            'draft_state' => ['required', 'string'],
        ]);

        $decodedState = json_decode($validated['draft_state'], true);
        if (!is_array($decodedState)) {
            return response()->json([
                'success' => false,
                'message' => 'Format draft_state tidak valid.',
            ], 422);
        }

        $draft = null;
        if (!empty($validated['draft_id'])) {
            $draft = TemplateSummaryDraft::query()
                ->where('draft_type', 'kapsul')
                ->find($validated['draft_id']);
        }

        if (!$draft) {
            $draft = TemplateSummaryDraft::create([
                'draft_type' => 'kapsul',
                'title' => $this->resolveDraftTitle($decodedState),
                'payload' => [],
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
            'draft_id' => ['nullable', 'integer'],
            'draft_title' => ['nullable', 'string', 'max:255'],
            'draft_state' => ['required', 'string'],
        ]);

        $decodedState = json_decode($validated['draft_state'], true);
        if (!is_array($decodedState)) {
            return response()->json([
                'success' => false,
                'message' => 'Format draft_state tidak valid.',
            ], 422);
        }

        $draft = null;
        if (!empty($validated['draft_id'])) {
            $draft = TemplateSummaryDraft::query()
                ->where('draft_type', 'heltiskin')
                ->find($validated['draft_id']);
        }

        if (!$draft) {
            $draft = TemplateSummaryDraft::create([
                'draft_type' => 'heltiskin',
                'title' => $this->resolveDraftTitle($decodedState),
                'payload' => [],
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
            'draft_id' => ['nullable', 'integer'],
            'draft_title' => ['nullable', 'string', 'max:255'],
            'draft_state' => ['required', 'string'],
        ]);

        $decodedState = json_decode($validated['draft_state'], true);
        if (!is_array($decodedState)) {
            return response()->json([
                'success' => false,
                'message' => 'Format draft_state tidak valid.',
            ], 422);
        }

        $draft = null;
        if (!empty($validated['draft_id'])) {
            $draft = TemplateSummaryDraft::query()
                ->where('draft_type', 'konvermex')
                ->find($validated['draft_id']);
        }

        if (!$draft) {
            $draft = TemplateSummaryDraft::create([
                'draft_type' => 'konvermex',
                'title' => $this->resolveDraftTitle($decodedState),
                'payload' => [],
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
            'draft_id' => ['nullable', 'integer'],
            'draft_title' => ['nullable', 'string', 'max:255'],
            'draft_state' => ['required', 'string'],
        ]);

        $decodedState = json_decode($validated['draft_state'], true);
        if (!is_array($decodedState)) {
            return response()->json([
                'success' => false,
                'message' => 'Format draft_state tidak valid.',
            ], 422);
        }

        $draft = null;
        if (!empty($validated['draft_id'])) {
            $draft = TemplateSummaryDraft::query()
                ->where('draft_type', 'nutracare')
                ->find($validated['draft_id']);
        }

        if (!$draft) {
            $draft = TemplateSummaryDraft::create([
                'draft_type' => 'nutracare',
                'title' => $this->resolveDraftTitle($decodedState),
                'payload' => [],
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
            'draft_id' => ['nullable', 'integer'],
            'draft_title' => ['nullable', 'string', 'max:255'],
            'draft_state' => ['required', 'string'],
        ]);

        $decodedState = json_decode($validated['draft_state'], true);
        if (!is_array($decodedState)) {
            return response()->json([
                'success' => false,
                'message' => 'Format draft_state tidak valid.',
            ], 422);
        }

        $draft = null;
        if (!empty($validated['draft_id'])) {
            $draft = TemplateSummaryDraft::query()
                ->where('draft_type', 'siladex')
                ->find($validated['draft_id']);
        }

        if (!$draft) {
            $draft = TemplateSummaryDraft::create([
                'draft_type' => 'siladex',
                'title' => $this->resolveDraftTitle($decodedState),
                'payload' => [],
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
}