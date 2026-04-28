@extends('layouts.app')

@section('content')
    @php
        $defaultNames = [
            'kapsul'    => 'KONILIFE OMEGA 3 SOFT CAPSULE',
            'sirup'     => 'ANAKONIDIN OBH 30 ML',
            'tablet'    => 'INZA 4 KAPLET',
            'siladex'   => 'SILADEX ANTITUSSIVE 60 ML',
            'nutracare' => 'NUTRACARE EPO 500 SOFT CAPSULE',
            'heltiskin' => 'HELTISKIN CREAM',
            'konvermex' => 'KONVERMEX 125 SUSPENSI',
        ];
        $segmentConfig = [
            'pharma1a' => ['icon' => 'factory',                 'color' => 'red',     'accent' => 'bg-red-600',     'light' => 'bg-red-50 dark:bg-red-900/20',      'text' => 'text-red-600',     'border' => 'border-red-200 dark:border-red-800/40',     'ring' => 'ring-red-500/20'],
            'pharma1b' => ['icon' => 'factory',                 'color' => 'blue',    'accent' => 'bg-blue-600',    'light' => 'bg-blue-50 dark:bg-blue-900/20',    'text' => 'text-blue-600',    'border' => 'border-blue-200 dark:border-blue-800/40',   'ring' => 'ring-blue-500/20'],
            'pharma2'  => ['icon' => 'precision_manufacturing', 'color' => 'emerald', 'accent' => 'bg-emerald-600', 'light' => 'bg-emerald-50 dark:bg-emerald-900/20','text' => 'text-emerald-600','border' => 'border-emerald-200 dark:border-emerald-800/40','ring' => 'ring-emerald-500/20'],
            'pharma3'  => ['icon' => 'precision_manufacturing', 'color' => 'violet',  'accent' => 'bg-violet-600',  'light' => 'bg-violet-50 dark:bg-violet-900/20', 'text' => 'text-violet-600',  'border' => 'border-violet-200 dark:border-violet-800/40', 'ring' => 'ring-violet-500/20'],
            'natural'  => ['icon' => 'eco',                     'color' => 'amber',   'accent' => 'bg-amber-500',   'light' => 'bg-amber-50 dark:bg-amber-900/20',   'text' => 'text-amber-600',   'border' => 'border-amber-200 dark:border-amber-800/40',  'ring' => 'ring-amber-500/20'],
            'other'    => ['icon' => 'folder',                  'color' => 'slate',   'accent' => 'bg-slate-500',   'light' => 'bg-slate-100 dark:bg-slate-700',     'text' => 'text-slate-600',   'border' => 'border-slate-200 dark:border-slate-600',     'ring' => 'ring-slate-500/20'],
        ];
        $typeConfig = [
            'sirup'     => ['icon' => 'water_drop',        'label' => 'Sirup'],
            'tablet'    => ['icon' => 'medication',         'label' => 'Tablet'],
            'kapsul'    => ['icon' => 'blender',            'label' => 'Kapsul'],
            'heltiskin' => ['icon' => 'spa',                'label' => 'Heltiskin'],
            'konvermex' => ['icon' => 'science',            'label' => 'Konvermex'],
            'nutracare' => ['icon' => 'health_and_safety',  'label' => 'Nutracare'],
            'siladex'   => ['icon' => 'local_pharmacy',     'label' => 'Siladex'],
        ];
    @endphp

    <div class="flex flex-col gap-6">

        {{-- Page Header --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Draft Summary</h1>
                <p class="text-slate-500 dark:text-slate-400 mt-1">Lanjutkan penyusunan summary yang tersimpan.</p>
            </div>
            <a href="{{ route('template-summary.index') }}"
                class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-800 hover:bg-slate-50 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 font-medium transition-all text-sm self-start md:self-auto">
                <span class="material-symbols-outlined text-[18px]">add</span>
                Buat Summary Baru
            </a>
        </div>

        {{-- Global Search --}}
        <div class="relative">
            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 material-symbols-outlined text-[20px]">search</span>
            <input type="text" id="draftSearch" placeholder="Cari nama produk, nomor dokumen..."
                class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition-all text-sm shadow-sm">
        </div>

        @if (!empty($draftsBySegment))

            {{-- Segment Quick-Nav (Pill Buttons) --}}
            <div class="flex flex-wrap gap-2" id="segmentNav">
                @foreach ($draftsBySegment as $segKey => $segment)
                    @php $sc = $segmentConfig[$segKey] ?? $segmentConfig['other']; @endphp
                    <button type="button"
                        class="seg-nav-pill inline-flex items-center gap-2.5 px-4 py-2.5 rounded-full border-2 transition-all text-sm font-semibold
                            border-{{ $sc['color'] }}-500 {{ $sc['text'] }} bg-transparent hover:bg-{{ $sc['color'] }}-500/10"
                        data-target="{{ $segKey }}"
                        data-color="{{ $sc['color'] }}"
                        onclick="scrollToSegment('{{ $segKey }}')">
                        <span class="material-symbols-outlined text-[18px]">{{ $sc['icon'] }}</span>
                        {{ $segment['label'] }}
                        <span class="seg-nav-count inline-flex items-center justify-center min-w-[24px] h-6 px-2 rounded-full bg-{{ $sc['color'] }}-500/20 {{ $sc['text'] }} text-xs font-bold">
                            {{ $segment['drafts']->count() }}
                        </span>
                    </button>
                @endforeach
            </div>

            {{-- Segment Cards --}}
            @foreach ($draftsBySegment as $segKey => $segment)
                @php
                    $sc = $segmentConfig[$segKey] ?? $segmentConfig['other'];

                    // Collect all unique lines in this segment
                    $segLines = [];
                    foreach ($segment['drafts'] as $d) {
                        $fv     = is_array($d->payload['form_values'] ?? null) ? $d->payload['form_values'] : [];
                        $l      = trim($fv['judul_line'] ?? ($fv['tujuan_line'] ?? ''));
                        $bagian = trim($fv['judul_bagian'] ?? ($fv['tujuan_bagian'] ?? ($fv['batch_bagian_produksi'] ?? '')));
                        
                        $val = '';
                        $label = '';
                        
                        if ($l !== '') {
                            // Ada line eksplisit dari form
                            $val   = strtolower($l); // "4"
                            $label = 'Line ' . $l;   // "Line 4"
                        } elseif (!empty($d->draft_line)) {
                            // Gunakan draft_line dari DB
                            $dbLine = $d->draft_line; // "Line 4" atau "Line Soft Capsule"
                            // Ekstrak angka/nama line dari string
                            if (preg_match('/line\s+(.+)/i', $dbLine, $m)) {
                                $val   = strtolower(trim($m[1])); // "4" atau "soft capsule"
                                $label = $dbLine; // "Line 4"
                            } else {
                                $val   = strtolower($dbLine);
                                $label = $dbLine;
                            }
                        } elseif ($bagian !== '') {
                            // Ekstrak dari bagian
                            if (preg_match('/\b(line\s+\S+(?:\s+\S+){0,3})/i', $bagian, $m)) {
                                $extracted = trim($m[1]); // "Line 4"
                                if (preg_match('/line\s+(.+)/i', $extracted, $m2)) {
                                    $val   = strtolower(trim($m2[1])); // "4"
                                    $label = ucfirst(strtolower($extracted)); // "Line 4"
                                }
                            } elseif (preg_match('/\b(lini\s+\S+(?:\s+\S+){0,2})/i', $bagian, $m)) {
                                $extracted = trim($m[1]); // "Lini 4"
                                if (preg_match('/lini\s+(.+)/i', $extracted, $m2)) {
                                    $val   = strtolower(trim($m2[1])); // "4"
                                    $label = 'Line ' . trim($m2[1]); // "Line 4"
                                }
                            }
                        }
                        
                        if ($val !== '' && !isset($segLines[$val])) {
                            $segLines[$val] = $label;
                        }
                    }
                    uksort($segLines, 'strnatcmp');
                @endphp

                <div id="seg-{{ $segKey }}" class="segment-block rounded-2xl overflow-hidden scroll-mt-6 shadow-lg">

                    {{-- Segment Header --}}
                    <div class="{{ $sc['accent'] }} px-5 py-3 flex items-center justify-between gap-3 select-none segment-header" data-segment="{{ $segKey }}">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-white text-[20px]">{{ $sc['icon'] }}</span>
                            <span class="font-bold text-white text-sm tracking-wide">{{ $segment['label'] }}</span>
                            <span class="px-2.5 py-0.5 rounded-md bg-white/25 text-white text-[11px] font-bold segment-total-count">{{ $segment['drafts']->count() }} draft</span>
                        </div>
                        {{-- Controls --}}
                        <div class="flex items-center gap-2 shrink-0">
                            @if (count($segLines) >= 1)
                                {{-- Line Filter --}}
                                <div class="seg-line-wrapper relative flex items-center gap-1.5 rounded-lg bg-white/15 border border-white/30 px-2.5 py-1.5 cursor-pointer hover:bg-white/20 transition-colors" onclick="event.stopPropagation();">
                                    <span class="shrink-0 material-symbols-outlined text-white text-[14px]">view_column</span>
                                    <select class="seg-line-filter absolute inset-0 w-full h-full opacity-0 cursor-pointer dark-select"
                                        data-segment="{{ $segKey }}">
                                        <option value="" class="text-slate-800 bg-white">Semua Line</option>
                                        @foreach ($segLines as $lVal => $lLabel)
                                            <option value="{{ $lVal }}" class="text-slate-800 bg-white">{{ $lLabel }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-white text-xs font-medium pointer-events-none seg-line-text">Semua Line</span>
                                    <span class="shrink-0 material-symbols-outlined text-white text-[14px]">expand_more</span>
                                </div>
                                {{-- Sort Filter --}}
                                <div class="seg-sort-wrapper relative flex items-center gap-1.5 rounded-lg bg-white/15 border border-white/30 px-2.5 py-1.5 cursor-pointer hover:bg-white/20 transition-colors" onclick="event.stopPropagation();">
                                    <span class="shrink-0 material-symbols-outlined text-white text-[14px]">sort</span>
                                    <select class="seg-sort-filter absolute inset-0 w-full h-full opacity-0 cursor-pointer dark-select"
                                        data-segment="{{ $segKey }}">
                                        <option value="updated_desc" class="text-slate-800 bg-white">Terbaru</option>
                                        <option value="updated_asc"  class="text-slate-800 bg-white">Terlama</option>
                                        <option value="title_asc"    class="text-slate-800 bg-white">A–Z</option>
                                        <option value="title_desc"   class="text-slate-800 bg-white">Z–A</option>
                                    </select>
                                    <span class="text-white text-xs font-medium pointer-events-none seg-sort-text">Terbaru</span>
                                    <span class="shrink-0 material-symbols-outlined text-white text-[14px]">expand_more</span>
                                </div>
                            @endif
                            {{-- Collapse toggle --}}
                            <button type="button" onclick="event.stopPropagation(); toggleSegment('{{ $segKey }}')"
                                class="seg-toggle-btn flex items-center justify-center w-7 h-7 rounded-full bg-white/15 hover:bg-white/25 transition-all shrink-0" title="Tampilkan/Sembunyikan">
                                <span class="material-symbols-outlined text-white text-[18px] seg-toggle-icon transition-transform duration-300">expand_more</span>
                            </button>
                        </div>
                    </div>

                    {{-- Draft List (scrollable, max 3 visible) --}}
                    <div class="segment-body hidden">
                    <div class="segment-items divide-y divide-slate-100 dark:divide-slate-700/50 overflow-y-auto"
                        style="max-height: calc(3 * 100px);">

                        @foreach ($segment['drafts'] as $draft)
                            @php
                                $fv          = is_array($draft->payload['form_values'] ?? null) ? $draft->payload['form_values'] : [];
                                $nomorDok    = $fv['dokumen_no'] ?? '-';
                                $tglDok      = $fv['dokumen_tanggal'] ?? '-';
                                $namaProduk  = strtoupper(trim($fv['judul_nama_produk'] ?? ''));
                                if ($namaProduk === '') $namaProduk = $defaultNames[$draft->draft_type] ?? strtoupper($draft->draft_type);
                                $zatAktif    = trim($fv['judul_formula'] ?? '');
                                $draftBagian = trim($fv['judul_bagian'] ?? ($fv['tujuan_bagian'] ?? ($fv['batch_bagian_produksi'] ?? '')));

                                // Ambil line eksplisit (judul_line / tujuan_line)
                                $draftLine = trim($fv['judul_line'] ?? ($fv['tujuan_line'] ?? ''));

                                // Label line untuk ditampilkan
                                if ($draftLine !== '') {
                                    $lineLabel = 'Line ' . $draftLine;
                                } elseif (!empty($draft->draft_line)) {
                                    // Gunakan draft_line dari DB (disimpan saat membuat draft dari modal)
                                    $lineLabel = $draft->draft_line;
                                } elseif ($draftBagian !== '') {
                                    // Ekstrak segmen "Line ..." dari string bagian
                                    if (preg_match('/\b(line\s+\S+(?:\s+\S+){0,3})/i', $draftBagian, $m)) {
                                        $lineLabel = ucfirst(strtolower($m[1]));
                                    } elseif (preg_match('/\b(lini\s+\S+(?:\s+\S+){0,2})/i', $draftBagian, $m)) {
                                        $lineLabel = ucfirst(strtolower($m[1]));
                                    } else {
                                        $lineLabel = '';
                                    }
                                } else {
                                    $lineLabel = '';
                                }

                                // Nilai untuk filter — harus konsisten dengan key di $segLines
                                // $segLines key: angka/nama line saja (tanpa "Line"), misal "4" atau "soft capsule"
                                if ($draftLine !== '') {
                                    // Ada line eksplisit dari form: "4"
                                    $lineFilterVal = strtolower($draftLine);
                                } elseif (!empty($draft->draft_line)) {
                                    // Gunakan draft_line dari DB: "Line 4" → ekstrak "4"
                                    $dbLine = $draft->draft_line;
                                    if (preg_match('/line\s+(.+)/i', $dbLine, $m)) {
                                        $lineFilterVal = strtolower(trim($m[1])); // "4" atau "soft capsule"
                                    } else {
                                        $lineFilterVal = strtolower($dbLine);
                                    }
                                } elseif ($draftBagian !== '') {
                                    // Ekstrak dari bagian
                                    if (preg_match('/\bline\s+(\S+(?:\s+\S+){0,3})/i', $draftBagian, $mf)) {
                                        $lineFilterVal = strtolower(trim($mf[1])); // "4"
                                    } elseif (preg_match('/\blini\s+(\S+(?:\s+\S+){0,2})/i', $draftBagian, $mf)) {
                                        $lineFilterVal = strtolower(trim($mf[1])); // "4"
                                    } else {
                                        $lineFilterVal = '';
                                    }
                                } else {
                                    $lineFilterVal = '';
                                }

                                $tc         = $typeConfig[$draft->draft_type] ?? ['icon' => 'description', 'label' => ucfirst($draft->draft_type)];
                                $searchText = strtolower($namaProduk . ' ' . $zatAktif . ' ' . $nomorDok . ' ' . $tglDok . ' ' . $draftBagian . ' ' . $lineLabel);
                            @endphp
                            <div class="draft-item group flex items-center gap-3 px-4 py-3 hover:bg-slate-50 dark:hover:bg-slate-700/40 transition-colors"
                                style="min-height:100px;"
                                data-title="{{ strtolower($namaProduk) }}"
                                data-updated="{{ $draft->updated_at->timestamp }}"
                                data-search="{{ $searchText }}"
                                data-line="{{ $lineFilterVal }}"
                                data-segment="{{ $segKey }}">

                                {{-- Type Icon --}}
                                <div class="shrink-0 flex items-center justify-center w-10 h-10 rounded-xl {{ $sc['light'] }}">
                                    <span class="material-symbols-outlined {{ $sc['text'] }} text-[20px]">{{ $tc['icon'] }}</span>
                                </div>

                                {{-- Main Info --}}
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-bold text-slate-900 dark:text-white group-hover:text-red-600 transition-colors leading-snug truncate"
                                        title="{{ $namaProduk }}{{ $zatAktif ? ' ('.$zatAktif.')' : '' }}">
                                        {{ $namaProduk }}@if($zatAktif) <span class="font-normal text-slate-400 dark:text-slate-500 normal-case">({{ $zatAktif }})</span>@endif
                                    </p>
                                    <p class="text-[11px] text-slate-400 dark:text-slate-500 mt-0.5">Summary Laporan Validasi Produk</p>

                                    {{-- Badges row --}}
                                    <div class="flex flex-wrap items-center gap-1.5 mt-1.5">
                                        {{-- Type badge --}}
                                        <span class="inline-flex items-center gap-0.5 px-1.5 py-0.5 rounded {{ $sc['light'] }} {{ $sc['text'] }} text-[10px] font-semibold uppercase tracking-wide">
                                            {{ $tc['label'] }}
                                        </span>
                                        {{-- Line badge --}}
                                        @if ($lineLabel !== '')
                                            <span class="inline-flex items-center gap-0.5 px-1.5 py-0.5 rounded-full bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-300 border border-blue-200 dark:border-blue-700/40 text-[10px] font-semibold">
                                                <span class="material-symbols-outlined text-[10px]">view_column</span>
                                                {{ $lineLabel }}
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-0.5 px-1.5 py-0.5 rounded-full bg-slate-100 dark:bg-slate-700 text-slate-400 dark:text-slate-500 text-[10px]">
                                                <span class="material-symbols-outlined text-[10px]">view_column</span>
                                                Line –
                                            </span>
                                        @endif
                                        {{-- Time --}}
                                        <span class="text-[10px] text-slate-400 dark:text-slate-500 flex items-center gap-0.5 ml-auto">
                                            <span class="material-symbols-outlined text-[10px]">schedule</span>
                                            {{ $draft->updated_at->locale('id')->diffForHumans() }}
                                        </span>
                                    </div>

                                    {{-- Doc info row --}}
                                    <div class="flex items-center gap-3 mt-1.5 text-[10px] text-slate-500 dark:text-slate-400">
                                        <span class="flex items-center gap-0.5">
                                            <span class="material-symbols-outlined text-[10px] text-slate-400">tag</span>
                                            <span class="font-medium text-slate-600 dark:text-slate-300">No.:</span>
                                            {{ $nomorDok !== '-' && $nomorDok !== '' ? $nomorDok : '–' }}
                                        </span>
                                        <span class="flex items-center gap-0.5">
                                            <span class="material-symbols-outlined text-[10px] text-slate-400">calendar_today</span>
                                            <span class="font-medium text-slate-600 dark:text-slate-300">Tgl.:</span>
                                            {{ $tglDok !== '-' && $tglDok !== '' ? $tglDok : '–' }}
                                        </span>
                                    </div>
                                </div>

                                {{-- Actions --}}
                                <div class="shrink-0 flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <button type="button"
                                        onclick="deleteDraft({{ $draft->id }}, '{{ addslashes($namaProduk . ($zatAktif ? ' ('.$zatAktif.')' : '')) }}')"
                                        class="flex items-center p-1.5 rounded-lg text-slate-400 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 transition-all"
                                        title="Hapus">
                                        <span class="material-symbols-outlined text-[18px]">delete</span>
                                    </button>
                                    <a href="{{ route('template-summary.continue', ['draft' => $draft->id]) }}"
                                        class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg {{ $sc['accent'] }} hover:opacity-90 text-white text-xs font-semibold transition-all shadow-sm">
                                        <span class="material-symbols-outlined text-[14px]">edit</span>
                                        Lanjutkan
                                    </a>
                                </div>
                            </div>
                        @endforeach

                    </div>

                    {{-- Segment Footer: empty state per segment --}}
                    <div class="seg-empty hidden px-5 py-6 text-center text-sm text-slate-400 dark:text-slate-500">
                        <span class="material-symbols-outlined text-2xl block mb-1 text-slate-300 dark:text-slate-600">search_off</span>
                        Tidak ada draft yang cocok.
                    </div>

                    </div>{{-- end segment-body --}}

                </div>
            @endforeach

        @else
            <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm p-12 text-center">
                <div class="inline-flex items-center justify-center size-16 bg-slate-100 dark:bg-slate-700 rounded-full mb-4">
                    <span class="material-symbols-outlined text-slate-400 dark:text-slate-500 text-3xl">draft</span>
                </div>
                <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-2">Belum Ada Draft Tersimpan</h3>
                <p class="text-slate-500 dark:text-slate-400 mb-6 max-w-sm mx-auto">Mulai buat summary baru dan simpan sebagai draft untuk melanjutkan nanti.</p>
                <a href="{{ route('template-summary.index') }}"
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-lg bg-red-600 hover:bg-red-700 text-white font-bold transition-all shadow-lg shadow-red-500/20 text-sm">
                    <span class="material-symbols-outlined text-[18px]">add</span>
                    Buat Summary Baru
                </a>
            </div>
        @endif

    </div>

    {{-- Delete Confirmation Modal --}}
    <div id="deleteModal"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm opacity-0 pointer-events-none transition-opacity duration-200"
        onclick="if(event.target===this) closeDeleteModal()">
        <div id="deleteModalContent"
            class="bg-white dark:bg-slate-800 rounded-2xl shadow-2xl w-full max-w-md mx-4 transform scale-95 transition-transform duration-200">
            <div class="p-6">
                <div class="flex items-center justify-center w-14 h-14 rounded-full bg-red-50 dark:bg-red-900/20 mx-auto mb-4">
                    <span class="material-symbols-outlined text-red-600 text-[32px]">delete_forever</span>
                </div>
                <h3 class="text-lg font-bold text-slate-900 dark:text-white text-center mb-2">Hapus Draft?</h3>
                <p class="text-sm text-slate-500 dark:text-slate-400 text-center mb-1">Anda akan menghapus draft:</p>
                <p id="deleteModalTitle" class="text-sm font-semibold text-slate-800 dark:text-slate-200 text-center mb-5 px-4 line-clamp-2"></p>
                <div class="flex items-start gap-2 bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-700/50 rounded-xl px-4 py-3 mb-6">
                    <span class="material-symbols-outlined text-amber-500 text-[20px] shrink-0 mt-0.5">warning</span>
                    <p class="text-xs text-amber-700 dark:text-amber-400 text-left">Semua data pada draft ini akan <span class="font-semibold">dihapus permanen</span> dan tidak dapat dipulihkan kembali.</p>
                </div>
                <div class="flex gap-3">
                    <button type="button" onclick="closeDeleteModal()"
                        class="flex-1 px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-600 text-slate-700 dark:text-slate-300 font-semibold text-sm hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors cursor-pointer">
                        Batal
                    </button>
                    <button type="button" id="deleteConfirmBtn"
                        class="flex-1 px-4 py-2.5 rounded-xl bg-red-600 hover:bg-red-700 text-white font-semibold text-sm shadow-sm transition-colors cursor-pointer">
                        Hapus
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    // ── Global search ────────────────────────────────────────────────
    const searchInput = document.getElementById('draftSearch');
    if (searchInput) {
        searchInput.addEventListener('input', function () {
            const query = this.value.toLowerCase().trim();
            document.querySelectorAll('.segment-block').forEach(block => {
                const items   = Array.from(block.querySelectorAll('.draft-item'));
                let   visible = 0;
                items.forEach(item => {
                    const match = !query || (item.dataset.search || '').includes(query);
                    const lineFilter = block.querySelector('.seg-line-filter');
                    const lineVal    = lineFilter ? lineFilter.value : '';
                    const matchLine  = !lineVal || item.dataset.line === lineVal;
                    const show = match && matchLine;
                    item.style.display = show ? '' : 'none';
                    if (show) visible++;
                });
                block.querySelector('.seg-empty').classList.toggle('hidden', visible > 0);
                const countEl = block.querySelector('.segment-total-count');
                if (countEl) countEl.textContent = visible + ' draft';
                const navCount = document.querySelector(`.seg-nav-btn[data-target="${block.id.replace('seg-','')}"] .seg-nav-count`);
                if (navCount) navCount.textContent = visible;
                // Auto-expand if search has results
                if (query && visible > 0) {
                    const body = block.querySelector('.segment-body');
                    const icon = block.querySelector('.seg-toggle-icon');
                    if (body && body.classList.contains('hidden')) {
                        body.classList.remove('hidden');
                        if (icon) icon.style.transform = 'rotate(180deg)';
                    }
                }
            });
        });
    }

    // ── Per-segment Sort ─────────────────────────────────────────────
    document.querySelectorAll('.seg-sort-filter').forEach(select => {
        select.addEventListener('change', function () {
            const segKey   = this.dataset.segment;
            const sortVal  = this.value;
            const block    = document.getElementById('seg-' + segKey);
            if (!block) return;
            
            // Update visible text
            const wrapper = this.closest('.seg-sort-wrapper');
            const textEl = wrapper ? wrapper.querySelector('.seg-sort-text') : null;
            if (textEl) {
                const selectedOption = this.options[this.selectedIndex];
                textEl.textContent = selectedOption.text;
            }
            
            const container = block.querySelector('.segment-items');
            const items     = Array.from(container.querySelectorAll('.draft-item'));
            items.sort((a, b) => {
                if (sortVal === 'updated_desc') return b.dataset.updated - a.dataset.updated;
                if (sortVal === 'updated_asc')  return a.dataset.updated - b.dataset.updated;
                if (sortVal === 'title_desc')   return b.dataset.title.localeCompare(a.dataset.title);
                return a.dataset.title.localeCompare(b.dataset.title);
            });
            items.forEach(item => container.appendChild(item));
        });
    });

    // ── Per-segment Line filter ──────────────────────────────────────
    document.querySelectorAll('.seg-line-filter').forEach(select => {
        select.addEventListener('change', function () {
            const segKey  = this.dataset.segment;
            const lineVal = this.value;
            const block   = document.getElementById('seg-' + segKey);
            if (!block) return;

            // Update visible text
            const wrapper = this.closest('.seg-line-wrapper');
            const textEl = wrapper ? wrapper.querySelector('.seg-line-text') : null;
            if (textEl) {
                const selectedOption = this.options[this.selectedIndex];
                textEl.textContent = selectedOption.text;
            }

            const query  = searchInput ? searchInput.value.toLowerCase().trim() : '';
            const items  = Array.from(block.querySelectorAll('.draft-item'));
            let   visible = 0;

            items.forEach(item => {
                const matchLine   = !lineVal || item.dataset.line === lineVal;
                const matchSearch = !query   || (item.dataset.search || '').includes(query);
                const show = matchLine && matchSearch;
                item.style.display = show ? '' : 'none';
                if (show) visible++;
            });

            block.querySelector('.seg-empty').classList.toggle('hidden', visible > 0);
            const countEl = block.querySelector('.segment-total-count');
            if (countEl) countEl.textContent = visible + ' draft';
            const navCount = document.querySelector(`.seg-nav-btn[data-target="${segKey}"] .seg-nav-count`);
            if (navCount) navCount.textContent = visible;
        });
    });

    // ── Segment collapse/expand ──────────────────────────────────────
    window.toggleSegment = function(segKey) {
        const block = document.getElementById('seg-' + segKey);
        if (!block) return;
        const body    = block.querySelector('.segment-body');
        const icon    = block.querySelector('.seg-toggle-icon');
        const isHidden = body.classList.contains('hidden');
        body.classList.toggle('hidden', !isHidden);
        if (icon) icon.style.transform = isHidden ? 'rotate(180deg)' : '';
    }

    // Scroll to segment
    window.scrollToSegment = function(segKey) {
        const target = document.getElementById('seg-' + segKey);
        if (target) {
            target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            // Auto-expand if collapsed
            const body = target.querySelector('.segment-body');
            const icon = target.querySelector('.seg-toggle-icon');
            if (body && body.classList.contains('hidden')) {
                body.classList.remove('hidden');
                if (icon) icon.style.transform = 'rotate(180deg)';
            }
        }
    }

    // ── Highlight active segment in nav on scroll ────────────────────
    const segBlocks = Array.from(document.querySelectorAll('.segment-block'));
    const observer  = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const id = entry.target.id.replace('seg-', '');
                document.querySelectorAll('.seg-nav-pill').forEach(b => {
                    const active = b.dataset.target === id;
                    const color = b.dataset.color || 'red';
                    
                    if (active) {
                        // Active state: tambah ring outline saja
                        b.classList.add('ring-4', `ring-${color}-500/30`);
                    } else {
                        // Inactive state: hapus ring
                        b.classList.remove('ring-4', `ring-${color}-500/30`);
                    }
                });
            }
        });
    }, { threshold: 0.3 });
    segBlocks.forEach(b => observer.observe(b));
});

function deleteDraft(draftId, draftTitle) {
    document.getElementById('deleteModalTitle').textContent = draftTitle;
    document.getElementById('deleteConfirmBtn').onclick = function () {
        closeDeleteModal();
        fetch(`/template-summary/drafts/${draftId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) window.location.reload();
            else alert('Gagal menghapus draft: ' + (data.message || 'Unknown error'));
        })
        .catch(() => alert('Terjadi kesalahan saat menghapus draft'));
    };

    const modal = document.getElementById('deleteModal');
    modal.classList.remove('opacity-0', 'pointer-events-none');
    modal.classList.add('opacity-100', 'pointer-events-auto');
    document.getElementById('deleteModalContent').classList.remove('scale-95');
    document.getElementById('deleteModalContent').classList.add('scale-100');
}

function closeDeleteModal() {
    const modal = document.getElementById('deleteModal');
    modal.classList.add('opacity-0', 'pointer-events-none');
    modal.classList.remove('opacity-100', 'pointer-events-auto');
    document.getElementById('deleteModalContent').classList.add('scale-95');
    document.getElementById('deleteModalContent').classList.remove('scale-100');
}
</script>
@endpush
