@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto">
        {{-- Page Header --}}
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Template Summary</h1>
            <p class="text-slate-500 dark:text-slate-400 mt-1">Pilih template untuk membuat summary baru atau lanjutkan draft
                yang sudah ada.</p>
        </div>

        {{-- Options Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Empty Template Card --}}
            <div
                class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
                <div class="p-6">
                    <div class="flex items-center gap-4 mb-4">
                        <div
                            class="flex items-center justify-center w-12 h-12 rounded-xl bg-red-50 dark:bg-red-900/20 text-red-600">
                            <span class="material-symbols-outlined text-[28px]">note_add</span>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-slate-900 dark:text-white">Template Kosong</h3>
                            <p class="text-sm text-slate-500 dark:text-slate-400">Mulai dari template baru</p>
                        </div>
                    </div>
                    <p class="text-sm text-slate-600 dark:text-slate-300 mb-6">
                        Pilih jenis sediaan untuk membuat summary baru dengan template yang sudah disiapkan.
                    </p>

                    {{-- Template Type Selection --}}
                    <div class="flex flex-col gap-3">
                        <p class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wide">Pilih Jenis Template</p>

                        {{-- Production Pharmaceutical I A --}}
                        <button onclick="openProductionModal('pharma1a')"
                            class="w-full flex items-center justify-between p-4 rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-sm hover:shadow-lg hover:border-red-300 dark:hover:border-red-700 transition-all hover:-translate-y-0.5 group cursor-pointer">
                            <div class="flex items-center gap-4">
                                <div class="flex items-center justify-center w-12 h-12 rounded-xl bg-red-50 dark:bg-red-900/20 text-red-600 group-hover:scale-110 transition-transform">
                                    <span class="material-symbols-outlined text-[28px]">factory</span>
                                </div>
                                <div class="text-left">
                                    <h3 class="font-bold text-slate-900 dark:text-white group-hover:text-red-600 transition-colors">Production Pharmaceutical I A</h3>
                                    <p class="text-xs text-slate-500 dark:text-slate-400">Line Soft Capsule, Paramex, Steril</p>
                                </div>
                            </div>
                            <div class="flex items-center justify-center w-8 h-8 rounded-full bg-slate-50 dark:bg-slate-800 group-hover:bg-red-50 dark:group-hover:bg-red-900/30 transition-colors">
                                <span class="material-symbols-outlined text-slate-400 group-hover:text-red-500 transition-colors">arrow_forward</span>
                            </div>
                        </button>

                        {{-- Production Pharmaceutical I B --}}
                        <button onclick="openProductionModal('pharma1b')"
                            class="w-full flex items-center justify-between p-4 rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-sm hover:shadow-lg hover:border-blue-300 dark:hover:border-blue-700 transition-all hover:-translate-y-0.5 group cursor-pointer">
                            <div class="flex items-center gap-4">
                                <div class="flex items-center justify-center w-12 h-12 rounded-xl bg-blue-50 dark:bg-blue-900/20 text-blue-600 group-hover:scale-110 transition-transform">
                                    <span class="material-symbols-outlined text-[28px]">factory</span>
                                </div>
                                <div class="text-left">
                                    <h3 class="font-bold text-slate-900 dark:text-white group-hover:text-blue-600 transition-colors">Production Pharmaceutical I B</h3>
                                    <p class="text-xs text-slate-500 dark:text-slate-400">Line Tablet, Tablet Kapsul Kapsul Keras</p>
                                </div>
                            </div>
                            <div class="flex items-center justify-center w-8 h-8 rounded-full bg-slate-50 dark:bg-slate-800 group-hover:bg-blue-50 dark:group-hover:bg-blue-900/30 transition-colors">
                                <span class="material-symbols-outlined text-slate-400 group-hover:text-blue-500 transition-colors">arrow_forward</span>
                            </div>
                        </button>

                        {{-- Production Pharmaceutical II --}}
                        <button onclick="openProductionModal('pharma2')"
                            class="w-full flex items-center justify-between p-4 rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-sm hover:shadow-lg hover:border-emerald-300 dark:hover:border-emerald-700 transition-all hover:-translate-y-0.5 group cursor-pointer">
                            <div class="flex items-center gap-4">
                                <div class="flex items-center justify-center w-12 h-12 rounded-xl bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 group-hover:scale-110 transition-transform">
                                    <span class="material-symbols-outlined text-[28px]">precision_manufacturing</span>
                                </div>
                                <div class="text-left">
                                    <h3 class="font-bold text-slate-900 dark:text-white group-hover:text-emerald-600 transition-colors">Production Pharmaceutical II</h3>
                                    <p class="text-xs text-slate-500 dark:text-slate-400">Line 1 – 6</p>
                                </div>
                            </div>
                            <div class="flex items-center justify-center w-8 h-8 rounded-full bg-slate-50 dark:bg-slate-800 group-hover:bg-emerald-50 dark:group-hover:bg-emerald-900/30 transition-colors">
                                <span class="material-symbols-outlined text-slate-400 group-hover:text-emerald-500 transition-colors">arrow_forward</span>
                            </div>
                        </button>

                        {{-- Production Pharmaceutical III --}}
                        <button onclick="openProductionModal('pharma3')"
                            class="w-full flex items-center justify-between p-4 rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-sm hover:shadow-lg hover:border-purple-300 dark:hover:border-purple-700 transition-all hover:-translate-y-0.5 group cursor-pointer">
                            <div class="flex items-center gap-4">
                                <div class="flex items-center justify-center w-12 h-12 rounded-xl bg-purple-50 dark:bg-purple-900/20 text-purple-600 group-hover:scale-110 transition-transform">
                                    <span class="material-symbols-outlined text-[28px]">biotech</span>
                                </div>
                                <div class="text-left">
                                    <h3 class="font-bold text-slate-900 dark:text-white group-hover:text-purple-600 transition-colors">Production Pharmaceutical III</h3>
                                    <p class="text-xs text-slate-500 dark:text-slate-400">Line 5 (Sachet) Gedung B</p>
                                </div>
                            </div>
                            <div class="flex items-center justify-center w-8 h-8 rounded-full bg-slate-50 dark:bg-slate-800 group-hover:bg-purple-50 dark:group-hover:bg-purple-900/30 transition-colors">
                                <span class="material-symbols-outlined text-slate-400 group-hover:text-purple-500 transition-colors">arrow_forward</span>
                            </div>
                        </button>

                        {{-- Natural Product & Extraction --}}
                        <button onclick="openProductionModal('natural')"
                            class="w-full flex items-center justify-between p-4 rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-sm hover:shadow-lg hover:border-amber-300 dark:hover:border-amber-700 transition-all hover:-translate-y-0.5 group cursor-pointer">
                            <div class="flex items-center gap-4">
                                <div class="flex items-center justify-center w-12 h-12 rounded-xl bg-amber-50 dark:bg-amber-900/20 text-amber-600 group-hover:scale-110 transition-transform">
                                    <span class="material-symbols-outlined text-[28px]">eco</span>
                                </div>
                                <div class="text-left">
                                    <h3 class="font-bold text-slate-900 dark:text-white group-hover:text-amber-600 transition-colors">Natural Product & Extraction</h3>
                                    <p class="text-xs text-slate-500 dark:text-slate-400">Line Obat Dalam, Obat Luar, Ekstraksi</p>
                                </div>
                            </div>
                            <div class="flex items-center justify-center w-8 h-8 rounded-full bg-slate-50 dark:bg-slate-800 group-hover:bg-amber-50 dark:group-hover:bg-amber-900/30 transition-colors">
                                <span class="material-symbols-outlined text-slate-400 group-hover:text-amber-500 transition-colors">arrow_forward</span>
                            </div>
                        </button>
                    </div>
                </div>
            </div>

            {{-- Continue Draft Card --}}
            <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
                <div class="p-6">
                    {{-- Card Header --}}
                    <div class="flex items-center gap-4 mb-4">
                        <div class="flex items-center justify-center w-12 h-12 rounded-xl bg-blue-50 dark:bg-blue-900/20 text-blue-600">
                            <span class="material-symbols-outlined text-[28px]">draft</span>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-slate-900 dark:text-white">Lanjutkan Draft</h3>
                            <p class="text-sm text-slate-500 dark:text-slate-400">Buka laporan yang belum selesai</p>
                        </div>
                    </div>

                    @php
                        $hasAnyDraft = collect($draftsByGroup)->contains(fn($g) => $g['drafts']->isNotEmpty());

                        $typeConfig = [
                            'anakonidin30' => ['icon' => 'water_drop',       'color' => 'amber'],
                            'sirup'     => ['icon' => 'water_drop',       'color' => 'amber'],  // Legacy support
                            'tablet'    => ['icon' => 'medication',        'color' => 'blue'],
                            'kapsul'    => ['icon' => 'blender',           'color' => 'green'],
                            'heltiskin' => ['icon' => 'spa',               'color' => 'pink'],
                            'konvermex' => ['icon' => 'science',           'color' => 'red'],
                            'nutracare' => ['icon' => 'health_and_safety', 'color' => 'emerald'],
                            'siladex'   => ['icon' => 'local_pharmacy',    'color' => 'violet'],
                            'konidinobh'=> ['icon' => 'medication_liquid',  'color' => 'teal'],
                        ];
                        $colorMap = [
                            'amber'   => ['icon' => 'text-amber-600',   'bg' => 'bg-amber-50 dark:bg-amber-900/10',    'border' => 'border-amber-200 dark:border-amber-800/40'],
                            'blue'    => ['icon' => 'text-blue-600',    'bg' => 'bg-blue-50 dark:bg-blue-900/10',      'border' => 'border-blue-200 dark:border-blue-800/40'],
                            'green'   => ['icon' => 'text-green-600',   'bg' => 'bg-green-50 dark:bg-green-900/10',    'border' => 'border-green-200 dark:border-green-800/40'],
                            'pink'    => ['icon' => 'text-pink-600',    'bg' => 'bg-pink-50 dark:bg-pink-900/10',      'border' => 'border-pink-200 dark:border-pink-800/40'],
                            'red'     => ['icon' => 'text-red-600',     'bg' => 'bg-red-50 dark:bg-red-900/10',        'border' => 'border-red-200 dark:border-red-800/40'],
                            'emerald' => ['icon' => 'text-emerald-600', 'bg' => 'bg-emerald-50 dark:bg-emerald-900/10','border' => 'border-emerald-200 dark:border-emerald-800/40'],
                            'violet'  => ['icon' => 'text-violet-600',  'bg' => 'bg-violet-50 dark:bg-violet-900/10',  'border' => 'border-violet-200 dark:border-violet-800/40'],
                            'teal'    => ['icon' => 'text-teal-600',    'bg' => 'bg-teal-50 dark:bg-teal-900/10',      'border' => 'border-teal-200 dark:border-teal-800/40'],
                        ];
                        $groupMeta = [
                            'pharma1a' => ['color' => 'text-red-600',    'bg' => 'bg-red-50 dark:bg-red-900/20'],
                            'pharma1b' => ['color' => 'text-blue-600',   'bg' => 'bg-blue-50 dark:bg-blue-900/20'],
                            'pharma2'  => ['color' => 'text-emerald-600','bg' => 'bg-emerald-50 dark:bg-emerald-900/20'],
                            'pharma3'  => ['color' => 'text-purple-600', 'bg' => 'bg-purple-50 dark:bg-purple-900/20'],
                            'natural'  => ['color' => 'text-amber-600',  'bg' => 'bg-amber-50 dark:bg-amber-900/20'],
                        ];
                    @endphp

                    @if ($hasAnyDraft)
                        {{-- ── Controls: Sort + Line Filter ── --}}
                        <div class="flex gap-2 mb-4">
                            {{-- Sort --}}
                            <div class="relative flex-1" id="sortDropdownWrap">
                                <button type="button" id="sortDropdownBtn"
                                    class="w-full flex items-center gap-1.5 rounded-lg border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-800 px-2.5 py-1.5 hover:border-blue-400 transition-colors text-xs text-slate-700 dark:text-slate-300"
                                    onclick="toggleDropdown('sortDropdown')">
                                    <span class="shrink-0 material-symbols-outlined text-slate-400 text-[15px]">sort</span>
                                    <span id="sortDropdownLabel" class="flex-1 text-left">Terbaru</span>
                                    <span class="shrink-0 material-symbols-outlined text-slate-400 text-[14px]">expand_more</span>
                                </button>
                                <div id="sortDropdown" class="hidden absolute z-50 top-full left-0 mt-1 w-full rounded-lg border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-800 shadow-lg overflow-hidden">
                                    @foreach(['newest' => 'Terbaru', 'oldest' => 'Terlama', 'az' => 'A → Z', 'za' => 'Z → A'] as $val => $label)
                                    <button type="button"
                                        class="sort-option w-full text-left px-3 py-2 text-xs text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors"
                                        data-value="{{ $val }}" onclick="selectSort('{{ $val }}', '{{ $label }}')">
                                        {{ $label }}
                                    </button>
                                    @endforeach
                                </div>
                                {{-- Hidden native select for JS compatibility --}}
                                <select id="draftSort" class="hidden">
                                    <option value="newest">Terbaru</option>
                                    <option value="oldest">Terlama</option>
                                    <option value="az">A → Z</option>
                                    <option value="za">Z → A</option>
                                </select>
                            </div>
                            {{-- Line Filter --}}
                            <div class="relative flex-1" id="lineDropdownWrap">
                                <button type="button" id="lineDropdownBtn"
                                    class="w-full flex items-center gap-1.5 rounded-lg border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-800 px-2.5 py-1.5 hover:border-blue-400 transition-colors text-xs text-slate-700 dark:text-slate-300"
                                    onclick="toggleDropdown('lineDropdown')">
                                    <span class="shrink-0 material-symbols-outlined text-slate-400 text-[15px]">filter_list</span>
                                    <span id="lineDropdownLabel" class="flex-1 text-left truncate">Semua Line</span>
                                    <span class="shrink-0 material-symbols-outlined text-slate-400 text-[14px]">expand_more</span>
                                </button>
                                <div id="lineDropdown" class="hidden absolute z-50 top-full left-0 mt-1 w-full max-h-60 rounded-lg border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-800 shadow-lg overflow-y-auto">
                                    <button type="button"
                                        class="line-option w-full text-left px-3 py-2 text-xs text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors"
                                        data-value="all" onclick="selectLine('all', 'Semua Line')">
                                        Semua Line
                                    </button>
                                    @foreach ($draftsByGroup as $groupKey => $group)
                                        <div class="px-3 py-1.5 text-[10px] font-semibold text-slate-400 dark:text-slate-500 uppercase tracking-wide bg-slate-50 dark:bg-slate-900/50">{{ $group['label'] }}</div>
                                        @foreach (array_keys($group['lines']) as $lineName)
                                        <button type="button"
                                            class="line-option w-full text-left px-3 py-2 pl-5 text-xs text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors"
                                            data-value="{{ $groupKey }}::{{ $lineName }}"
                                            onclick="selectLine('{{ $groupKey }}::{{ $lineName }}', '{{ $lineName }}')">
                                            {{ $lineName }}
                                        </button>
                                        @endforeach
                                    @endforeach
                                </div>
                                {{-- Hidden native select for JS compatibility --}}
                                <select id="draftLineFilter" class="hidden">
                                    <option value="all">Semua Line</option>
                                    @foreach ($draftsByGroup as $groupKey => $group)
                                        <optgroup label="{{ $group['label'] }}">
                                        @foreach (array_keys($group['lines']) as $lineName)
                                            <option value="{{ $groupKey }}::{{ $lineName }}">{{ $lineName }}</option>
                                        @endforeach
                                        </optgroup>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- ── Draft List ── --}}
                        <div id="draftListContainer" class="space-y-4 max-h-[380px] overflow-y-auto pr-1 custom-scrollbar">
                            @foreach ($draftsByGroup as $groupKey => $group)
                                @php $gm = $groupMeta[$groupKey] ?? ['color' => 'text-slate-500', 'bg' => 'bg-slate-100']; @endphp

                                <div class="draft-group" data-group="{{ $groupKey }}">
                                    {{-- Group header --}}
                                    <div class="flex items-center gap-2 mb-2">
                                        <div class="flex items-center justify-center w-6 h-6 rounded-md {{ $gm['bg'] }}">
                                            <span class="material-symbols-outlined {{ $gm['color'] }} text-[14px]">{{ $group['icon'] }}</span>
                                        </div>
                                        <span class="text-[11px] font-semibold {{ $gm['color'] }} uppercase tracking-wide leading-none">{{ $group['label'] }}</span>
                                        <div class="flex-1 h-px bg-slate-100 dark:bg-slate-700"></div>
                                    </div>

                                    {{-- Draft items --}}
                                    <div class="space-y-2 draft-items-wrapper">
                                        @foreach ($group['drafts'] as $draftIdx => $draft)
                                            @php
                                                $tc  = $typeConfig[$draft->draft_type] ?? ['icon' => 'description', 'color' => 'blue'];
                                                $clr = $colorMap[$tc['color']] ?? $colorMap['blue'];
                                                // Use stored draft_line directly — exact line where draft was created
                                                $draftLineAttr = $draft->draft_line
                                                    ? $groupKey . '::' . $draft->draft_line
                                                    : '';
                                            @endphp
                                            <a href="{{ route('template-summary.continue', ['draft' => $draft->id]) }}"
                                                class="draft-item group/draft flex items-center gap-3 p-3 rounded-xl border {{ $clr['border'] }} hover:border-blue-300 dark:hover:border-blue-700 bg-white dark:bg-slate-800 hover:bg-slate-50 dark:hover:bg-slate-900/40 transition-all shadow-sm hover:shadow-md hover:-translate-y-0.5"
                                                data-group="{{ $groupKey }}"
                                                data-lines="{{ $draftLineAttr }}"
                                                data-title="{{ strtolower($draft->title ?: 'Draft ' . $draft->draft_type) }}"
                                                data-updated="{{ ($draft->last_saved_at ?? $draft->updated_at)->timestamp }}"
                                                data-index="{{ $draftIdx }}"
                                                @if($draftIdx >= 2) style="display:none" data-collapsed="1" @endif>
                                                <div class="flex items-center justify-center w-9 h-9 rounded-lg {{ $clr['bg'] }} shrink-0">
                                                    <span class="material-symbols-outlined {{ $clr['icon'] }} text-[18px]">{{ $tc['icon'] }}</span>
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <p class="text-sm font-bold text-slate-900 dark:text-white truncate group-hover/draft:text-blue-600 dark:group-hover/draft:text-blue-400 transition-colors">
                                                        {{ $draft->title ?: 'Draft ' . ucfirst($draft->draft_type) }}
                                                    </p>
                                                    <div class="flex items-center gap-2 mt-0.5">
                                                        <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-semibold {{ $clr['bg'] }} {{ $clr['icon'] }} uppercase tracking-wide">
                                                            {{ ucfirst($draft->draft_type) }}
                                                        </span>
                                                        <span class="text-xs text-slate-400 flex items-center gap-0.5">
                                                            <span class="material-symbols-outlined text-[11px]">schedule</span>
                                                            {{ optional($draft->last_saved_at ?? $draft->updated_at)->diffForHumans() }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <span class="material-symbols-outlined text-[18px] text-slate-300 group-hover/draft:text-blue-500 transition-colors shrink-0">arrow_forward</span>
                                            </a>
                                        @endforeach
                                    </div>
                                    {{-- Show more button --}}
                                    @if ($group['drafts']->count() > 2)
                                    <button type="button"
                                        class="show-more-btn mt-1 w-full text-center text-xs text-slate-400 dark:text-slate-500 hover:text-blue-500 dark:hover:text-blue-400 py-1.5 transition-colors"
                                        data-group="{{ $groupKey }}"
                                        data-total="{{ $group['drafts']->count() }}"
                                        onclick="toggleShowMore(this)">
                                        <span class="show-more-label">+ {{ $group['drafts']->count() - 2 }} draft lainnya</span>
                                    </button>
                                    @endif
                                </div>
                            @endforeach

                            {{-- Empty state when filter yields nothing --}}
                            <div id="draftEmptyFilter" class="hidden flex-col items-center justify-center py-8 text-center">
                                <span class="material-symbols-outlined text-3xl text-slate-300 dark:text-slate-600 mb-2">search_off</span>
                                <p class="text-sm text-slate-500 dark:text-slate-400">Tidak ada draft untuk filter ini.</p>
                            </div>
                        </div>
                    @else
                        <div class="flex flex-col items-center justify-center py-10 border border-dashed border-slate-300 dark:border-slate-600 rounded-xl bg-slate-50 dark:bg-slate-800/50">
                            <div class="w-16 h-16 rounded-2xl bg-white dark:bg-slate-800 flex items-center justify-center mb-4 shadow-sm">
                                <span class="material-symbols-outlined text-3xl text-slate-400 dark:text-slate-500">inventory_2</span>
                            </div>
                            <h4 class="text-base font-semibold text-slate-900 dark:text-white mb-1">Belum ada draft</h4>
                            <p class="text-sm text-slate-500 dark:text-slate-400 text-center max-w-[250px]">
                                Anda belum memiliki laporan yang disimpan. Mulai buat template baru.
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- ============================================================ --}}
    {{-- POPUP MODAL: Template Summary Produk                         --}}
    {{-- ============================================================ --}}
    <div id="productionModal"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm opacity-0 pointer-events-none transition-opacity duration-300"
        onclick="if(event.target===this) closeProductionModal()">
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-2xl w-full max-w-4xl mx-4 max-h-[85vh] flex flex-col transform scale-95 transition-transform duration-300"
            id="productionModalContent">

            {{-- Modal Header --}}
            <div class="flex items-center justify-between px-6 py-4 border-b border-slate-200 dark:border-slate-700">
                <div class="flex items-center gap-3">
                    <div class="flex items-center justify-center w-10 h-10 rounded-xl bg-red-50 dark:bg-red-900/20 text-red-600">
                        <span class="material-symbols-outlined text-[24px]">factory</span>
                    </div>
                    <div>
                        <h2 id="modalTitle" class="text-lg font-bold text-slate-900 dark:text-white">Production Pharmaceutical I A</h2>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Pilih line dan template yang diinginkan</p>
                    </div>
                </div>
                <button onclick="closeProductionModal()"
                    class="flex items-center justify-center w-9 h-9 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors cursor-pointer">
                    <span class="material-symbols-outlined text-slate-400 hover:text-slate-600 dark:hover:text-slate-300">close</span>
                </button>
            </div>

            {{-- Modal Body --}}
            <div class="flex flex-1 overflow-hidden">
                {{-- Left Sidebar: Line Buttons --}}
                <div id="modalSidebar" class="w-64 shrink-0 border-r border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900/30 p-4 overflow-y-auto flex flex-col gap-2">
                    {{-- Lines will be injected by JS --}}
                </div>

                {{-- Right Panel: Template Table --}}
                <div class="flex-1 flex flex-col overflow-hidden">
                    {{-- Table Header --}}
                    <div class="bg-red-600 text-white px-5 py-3 flex items-center gap-3">
                        <span class="material-symbols-outlined text-[20px]">table_chart</span>
                        <span class="font-bold text-sm tracking-wide">Template Summary Produk</span>
                    </div>

                    {{-- Table Content --}}
                    <div id="modalTemplateList" class="flex-1 overflow-y-auto">
                        {{-- Template rows will be injected by JS --}}
                    </div>
                </div>
            </div>

            {{-- Modal Footer --}}
            <div class="flex items-center justify-end gap-3 px-6 py-4 border-t border-slate-200 dark:border-slate-700">
                <button onclick="closeProductionModal()"
                    class="px-6 py-2.5 rounded-xl border border-slate-300 dark:border-slate-600 text-slate-700 dark:text-slate-300 font-semibold text-sm hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors cursor-pointer">
                    Batal
                </button>
                <button id="modalBtnBuat" onclick="navigateToSelectedTemplate()"
                    class="px-6 py-2.5 rounded-xl bg-red-600 hover:bg-red-700 text-white font-semibold text-sm shadow-sm hover:shadow-md transition-all cursor-pointer disabled:opacity-40 disabled:cursor-not-allowed"
                    disabled>
                    Buat
                </button>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
    // ── Custom Dropdown helpers ──────────────────────────────────────
    window.toggleShowMore = function(btn) {
        const groupKey = btn.dataset.group;
        const group    = btn.closest('.draft-group');
        const items    = Array.from(group.querySelectorAll('.draft-item[data-collapsed="1"]'));
        const isHidden = items.length > 0 && items[0].style.display === 'none';
        items.forEach(function(item) { item.style.display = isHidden ? '' : 'none'; });
        const total = parseInt(btn.dataset.total);
        btn.querySelector('.show-more-label').textContent = isHidden
            ? 'Sembunyikan'
            : '+ ' + (total - 2) + ' draft lainnya';
    };
    function toggleDropdown(id) {
        const el = document.getElementById(id);
        const isHidden = el.classList.contains('hidden');
        // Close all dropdowns first
        ['sortDropdown', 'lineDropdown'].forEach(function(d) {
            document.getElementById(d)?.classList.add('hidden');
        });
        if (isHidden) el.classList.remove('hidden');
    }
    function selectSort(val, label) {
        document.getElementById('sortDropdownLabel').textContent = label;
        document.getElementById('draftSort').value = val;
        document.getElementById('sortDropdown').classList.add('hidden');
        document.getElementById('draftSort').dispatchEvent(new Event('change'));
    }
    function selectLine(val, label) {
        document.getElementById('lineDropdownLabel').textContent = label;
        document.getElementById('draftLineFilter').value = val;
        document.getElementById('lineDropdown').classList.add('hidden');
        document.getElementById('draftLineFilter').dispatchEvent(new Event('change'));
    }
    // Close dropdowns on outside click
    document.addEventListener('click', function(e) {
        if (!e.target.closest('#sortDropdownWrap') && !e.target.closest('#lineDropdownWrap')) {
            document.getElementById('sortDropdown')?.classList.add('hidden');
            document.getElementById('lineDropdown')?.classList.add('hidden');
        }
    });
    // ── Draft Filter & Sort ──────────────────────────────────────────
    (function () {
        const sortEl   = document.getElementById('draftSort');
        const lineEl   = document.getElementById('draftLineFilter');
        const container = document.getElementById('draftListContainer');
        const emptyMsg  = document.getElementById('draftEmptyFilter');
        if (!sortEl || !lineEl || !container) return;

        function applyFilters() {
            const sort     = sortEl.value;
            const lineVal  = lineEl.value;
            const isFiltered = lineVal !== 'all';

            // Collect all draft-item elements
            const allItems = Array.from(container.querySelectorAll('.draft-item'));

            // Filter by line
            allItems.forEach(item => {
                if (lineVal === 'all') {
                    // Restore collapsed state
                    if (item.dataset.collapsed === '1') item.style.display = 'none';
                    else item.style.display = '';
                } else {
                    const itemLine = (item.dataset.lines || '').trim();
                    item.style.display = (itemLine === lineVal) ? '' : 'none';
                }
            });

            // Show/hide show-more buttons
            container.querySelectorAll('.show-more-btn').forEach(btn => {
                btn.style.display = isFiltered ? 'none' : '';
            });

            // Sort visible items — re-insert into their parent wrappers
            const groups = Array.from(container.querySelectorAll('.draft-group'));
            groups.forEach(group => {
                const wrapper = group.querySelector('.draft-items-wrapper');
                if (!wrapper) return;

                const visibleItems = Array.from(wrapper.querySelectorAll('.draft-item'))
                    .filter(i => i.style.display !== 'none');

                visibleItems.sort((a, b) => {
                    if (sort === 'newest') return b.dataset.updated - a.dataset.updated;
                    if (sort === 'oldest') return a.dataset.updated - b.dataset.updated;
                    if (sort === 'az')     return a.dataset.title.localeCompare(b.dataset.title);
                    if (sort === 'za')     return b.dataset.title.localeCompare(a.dataset.title);
                    return 0;
                });

                visibleItems.forEach(i => wrapper.appendChild(i));

                const anyVisible = Array.from(wrapper.querySelectorAll('.draft-item'))
                    .some(i => i.style.display !== 'none');
                group.style.display = anyVisible ? '' : 'none';
            });

            // Show empty state if everything is hidden
            const anyVisible = allItems.some(i => i.style.display !== 'none');
            emptyMsg.classList.toggle('hidden', anyVisible);
            emptyMsg.classList.toggle('flex', !anyVisible);
        }

        sortEl.addEventListener('change', applyFilters);
        lineEl.addEventListener('change', applyFilters);
    })();
    </script>
    <script>
    (function() {
        // ── Route URLs (from Laravel) ────────────────────────────────
        const ROUTES = {
            anakonidin30: "{{ route('template-summary.anakonidin30') }}",
            sirup:  "{{ route('template-summary.sirup') }}",  // Legacy support
            kapsul: "{{ route('template-summary.kapsul') }}",
            tablet: "{{ route('template-summary.tablet') }}",
            heltiskin: "{{ route('template-summary.heltiskin') }}",
            konvermex: "{{ route('template-summary.konvermex') }}",
            nutracare: "{{ route('template-summary.nutracare') }}",
            siladex: "{{ route('template-summary.siladex') }}",
            konidinobh: "{{ route('template-summary.konidinobh') }}",
            anakonidin60: "{{ route('template-summary.anakonidin60') }}",
        };

        // ── Menu Data Config ─────────────────────────────────────────
        const PRODUCTION_DATA = {
            pharma1a: {
                title: 'Production Pharmaceutical I A',
                lines: [
                    {
                        name: 'Line Soft Capsule',
                        route: 'kapsul, nutracare',
                        templates: [
                            { label: 'Template Nutracare EPO 500 Soft Capsule', route: 'nutracare' },
                            { label: 'Template Konilife Omega 3 Soft Capsule', route: 'kapsul' },
                            { label: 'Template 3', route: 'kapsul' },
                        ]
                    },
                    {
                        name: 'Line Paramex',
                        route: 'sirup',
                        templates: [
                            { label: 'Template 1', route: 'sirup' },
                            { label: 'Template 2', route: 'sirup' },
                            { label: 'Template 3', route: 'sirup' },
                        ]
                    },
                    {
                        name: 'Line Steril',
                        route: 'sirup',
                        templates: [
                            { label: 'Template 1', route: 'sirup' },
                            { label: 'Template 2', route: 'sirup' },
                            { label: 'Template 3', route: 'sirup' },
                        ]
                    },
                ]
            },
            pharma1b: {
                title: 'Production Pharmaceutical I B',
                lines: [
                    {
                        name: 'Line Tablet',
                        route: 'tablet',
                        templates: [
                            { label: 'Template 1', route: 'tablet' },
                            { label: 'Template 2', route: 'tablet' },
                            { label: 'Template 3', route: 'tablet' },
                        ]
                    },
                    {
                        name: 'Line Tablet Kapsul Kapsul Keras',
                        route: 'kapsul',
                        templates: [
                            { label: 'Template 1', route: 'kapsul' },
                            { label: 'Template 2', route: 'kapsul' },
                            { label: 'Template 3', route: 'kapsul' },
                        ]
                    },
                ]
            },
            pharma2: {
                title: 'Production Pharmaceutical II',
                lines: [
                    {
                        name: 'Line 1',
                        route: 'anakonidin60',
                        templates: [
                            { label: 'Template Anakonidin 60 ml', route: 'anakonidin60' },
                            { label: 'Template 2', route: 'anakonidin60' },
                            { label: 'Template 3', route: 'anakonidin60' },
                        ]
                    },
                    {
                        name: 'Line 2',
                        route: 'anakonidin30',
                        templates: [
                            { label: 'Template Anakonidin 30 ml', route: 'anakonidin30' },
                            { label: 'Template 2', route: 'anakonidin30' },
                            { label: 'Template 3', route: 'anakonidin30' },
                        ]
                    },
                    {
                        name: 'Line 3',
                        route: 'sirup',
                        templates: [
                            { label: 'Template Siladex Antitussive 60 ml', route: 'siladex' },
                            { label: 'Template 2', route: 'sirup' },
                            { label: 'Template 3', route: 'sirup' },
                        ]
                    },
                    {
                        name: 'Line 4',
                        route: 'sirup, konvermex',
                        templates: [
                            { label: 'Template Konvermex 125 Suspensi', route: 'konvermex' },
                            { label: 'Template 2', route: 'sirup' },
                            { label: 'Template 3', route: 'sirup' },
                        ]
                    },
                    {
                        name: 'Line 5',
                        route: 'sirup',
                        templates: [
                            { label: 'Template Sirup', route: 'sirup' },
                        ]
                    },
                    {
                        name: 'Line 6',
                        route: 'sirup, heltiskin',
                        templates: [
                            { label: 'Template Heltiskin', route: 'heltiskin' },
                            { label: 'Template Sirup', route: 'sirup' },
                        ]
                    },
                ]
            },
            pharma3: {
                title: 'Production Pharmaceutical III',
                lines: [
                    {
                        name: 'Line 5 (Sachet) Gedung B',
                        route: 'konidinobh',
                        templates: [
                            { label: 'Template Konidin OBH (Sachet)', route: 'konidinobh' },
                            { label: 'Template Sirup', route: 'sirup' },
                        ]
                    },
                ]
            },
            natural: {
                title: 'Natural Product & Extraction',                lines: [
                    {
                        name: 'Line Obat Dalam',
                        route: 'sirup',
                        templates: [
                            { label: 'Template 1', route: 'sirup' },
                            { label: 'Template 2', route: 'sirup' },
                            { label: 'Template 3', route: 'sirup' },
                        ]
                    },
                    {
                        name: 'Line Obat Luar',
                        route: 'sirup',
                        templates: [
                            { label: 'Template 1', route: 'sirup' },
                            { label: 'Template 2', route: 'sirup' },
                            { label: 'Template 3', route: 'sirup' },
                        ]
                    },
                    {
                        name: 'Line Ekstraksi',
                        route: 'sirup',
                        templates: [
                            { label: 'Template 1', route: 'sirup' },
                            { label: 'Template 2', route: 'sirup' },
                            { label: 'Template 3', route: 'sirup' },
                        ]
                    },
                ]
            },
        };

        // ── State ────────────────────────────────────────────────────
        let currentGroup    = null;
        let activeLineIndex = 0;
        let selectedRoute   = null;
        let selectedLine    = null;

        // ── DOM refs ─────────────────────────────────────────────────
        const modal        = document.getElementById('productionModal');
        const modalContent = document.getElementById('productionModalContent');
        const modalTitle   = document.getElementById('modalTitle');
        const sidebar      = document.getElementById('modalSidebar');
        const templateList = document.getElementById('modalTemplateList');
        const btnBuat      = document.getElementById('modalBtnBuat');

        // ── Open Modal ───────────────────────────────────────────────
        window.openProductionModal = function(groupKey) {
            currentGroup    = PRODUCTION_DATA[groupKey];
            activeLineIndex = 0;
            selectedRoute   = null;
            selectedLine    = null;
            if (!currentGroup) return;

            modalTitle.textContent = currentGroup.title;
            btnBuat.disabled = true;

            renderSidebar();
            renderTemplates();

            // Show
            modal.classList.remove('opacity-0', 'pointer-events-none');
            modal.classList.add('opacity-100', 'pointer-events-auto');
            modalContent.classList.remove('scale-95');
            modalContent.classList.add('scale-100');
            document.body.style.overflow = 'hidden';
        };

        // ── Close Modal ──────────────────────────────────────────────
        window.closeProductionModal = function() {
            modal.classList.add('opacity-0', 'pointer-events-none');
            modal.classList.remove('opacity-100', 'pointer-events-auto');
            modalContent.classList.add('scale-95');
            modalContent.classList.remove('scale-100');
            document.body.style.overflow = '';
            selectedRoute = null;
            selectedLine  = null;
        };

        // ── Navigate ─────────────────────────────────────────────────
        window.navigateToSelectedTemplate = function() {
            if (selectedRoute) {
                const url = new URL(selectedRoute, window.location.origin);
                if (selectedLine) url.searchParams.set('line', selectedLine);
                window.location.href = url.toString();
            }
        };

        // ── Render sidebar lines ─────────────────────────────────────
        function renderSidebar() {
            sidebar.innerHTML = '';
            currentGroup.lines.forEach(function(line, idx) {
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.className = buildLineClass(idx === activeLineIndex);
                btn.innerHTML = '<span class="material-symbols-outlined text-[18px]">' +
                    (idx === activeLineIndex ? 'radio_button_checked' : 'radio_button_unchecked') +
                    '</span><span class="text-sm font-semibold truncate">' + escapeHtml(line.name) + '</span>';
                btn.onclick = function() {
                    activeLineIndex = idx;
                    selectedRoute   = null;
                    selectedLine    = null;
                    btnBuat.disabled = true;
                    renderSidebar();
                    renderTemplates();
                };
                sidebar.appendChild(btn);
            });
        }

        function buildLineClass(isActive) {
            const base = 'w-full flex items-center gap-3 px-4 py-3 rounded-xl text-left transition-all cursor-pointer ';
            if (isActive) {
                return base + 'bg-red-600 text-white shadow-md';
            }
            return base + 'bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-300 hover:border-red-300 dark:hover:border-red-700 hover:bg-red-50 dark:hover:bg-red-900/10';
        }

        // ── Render template rows ─────────────────────────────────────
        function renderTemplates() {
            const line = currentGroup.lines[activeLineIndex];
            if (!line) { templateList.innerHTML = ''; return; }

            let html = '';
            line.templates.forEach(function(tpl, tplIdx) {
                const routeUrl = ROUTES[tpl.route] || '#';
                html += '<div class="template-row flex items-center px-5 py-3.5 border-b border-slate-100 dark:border-slate-700 cursor-pointer transition-all hover:bg-red-50 dark:hover:bg-red-900/10" ' +
                    'data-route="' + escapeAttr(routeUrl) + '" onclick="selectTemplate(this)">' +
                    '<div class="flex items-center gap-3 flex-1 min-w-0">' +
                    '<span class="material-symbols-outlined text-[18px] text-slate-300 tmpl-radio">radio_button_unchecked</span>' +
                    '<span class="text-sm font-medium text-slate-700 dark:text-slate-300 truncate">' + escapeHtml(tpl.label) + '</span>' +
                    '</div>' +
                    '<span class="material-symbols-outlined text-[16px] text-slate-300">chevron_right</span>' +
                    '</div>';
            });

            templateList.innerHTML = html;
        }

        // ── Select a template row ────────────────────────────────────
        window.selectTemplate = function(el) {
            // Remove active from all
            templateList.querySelectorAll('.template-row').forEach(function(row) {
                row.classList.remove('bg-red-50', 'dark:bg-red-900/10', 'border-l-4', 'border-l-red-500');
                row.querySelector('.tmpl-radio').textContent = 'radio_button_unchecked';
                row.querySelector('.tmpl-radio').classList.remove('text-red-600');
                row.querySelector('.tmpl-radio').classList.add('text-slate-300');
            });
            // Set active
            el.classList.add('bg-red-50', 'dark:bg-red-900/10', 'border-l-4', 'border-l-red-500');
            el.querySelector('.tmpl-radio').textContent = 'radio_button_checked';
            el.querySelector('.tmpl-radio').classList.add('text-red-600');
            el.querySelector('.tmpl-radio').classList.remove('text-slate-300');

            selectedRoute = el.getAttribute('data-route');
            selectedLine  = currentGroup.lines[activeLineIndex]?.name || null;
            btnBuat.disabled = false;
        };

        // ── Escape helpers ───────────────────────────────────────────
        function escapeHtml(str) {
            var p = document.createElement('p');
            p.appendChild(document.createTextNode(str));
            return p.innerHTML;
        }
        function escapeAttr(str) {
            return str.replace(/"/g, '&quot;').replace(/'/g, '&#39;');
        }

        // ── Keyboard: Escape closes modal ────────────────────────────
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !modal.classList.contains('pointer-events-none')) {
                closeProductionModal();
            }
        });
    })();
    </script>
    @endpush
@endsection