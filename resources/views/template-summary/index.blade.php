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
            <div
                class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
                <div class="p-6">
                    <div class="flex items-center gap-4 mb-4">
                        <div
                            class="flex items-center justify-center w-12 h-12 rounded-xl bg-blue-50 dark:bg-blue-900/20 text-blue-600">
                            <span class="material-symbols-outlined text-[28px]">draft</span>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-slate-900 dark:text-white">Lanjutkan Draft</h3>
                            <p class="text-sm text-slate-500 dark:text-slate-400">Buka laporan yang belum selesai</p>
                        </div>
                    </div>
                    <p class="text-sm text-slate-600 dark:text-slate-300 mb-6">
                        Lanjutkan pengerjaan laporan yang sudah disimpan sebelumnya.
                    </p>

                    @if (!empty($recentDrafts) && $recentDrafts->count() > 0)
                        <div class="space-y-3 max-h-80 overflow-y-auto pr-1 custom-scrollbar">
                            @foreach ($recentDrafts as $draft)
                                @php
                                    $icon = 'description';
                                    $iconColor = 'text-slate-400';
                                    $bgColor = 'bg-slate-50 dark:bg-slate-900/20';
                                    $borderColor = 'border-slate-200 dark:border-slate-700';
                                    $route = route('template-summary.continue', ['draft' => $draft->id]);
                                    
                                    if($draft->draft_type === 'sirup') {
                                        $icon = 'water_drop';
                                        $iconColor = 'text-amber-600';
                                        $bgColor = 'bg-amber-50 dark:bg-amber-900/10';
                                        $borderColor = 'border-amber-200 dark:border-amber-900/30';
                                    } elseif($draft->draft_type === 'tablet') {
                                        $icon = 'medication';
                                        $iconColor = 'text-blue-600';
                                        $bgColor = 'bg-blue-50 dark:bg-blue-900/10';
                                        $borderColor = 'border-blue-200 dark:border-blue-900/30';
                                    } elseif($draft->draft_type === 'kapsul') {
                                        $icon = 'blender';
                                        $iconColor = 'text-green-600';
                                        $bgColor = 'bg-green-50 dark:bg-green-900/10';
                                        $borderColor = 'border-green-200 dark:border-green-900/30';
                                    } elseif($draft->draft_type === 'heltiskin') {
                                        $icon = 'spa';
                                        $iconColor = 'text-pink-600';
                                        $bgColor = 'bg-pink-50 dark:bg-pink-900/10';
                                        $borderColor = 'border-pink-200 dark:border-pink-900/30';
                                    } elseif($draft->draft_type === 'konvermex') {
                                        $icon = 'science';
                                        $iconColor = 'text-red-600';
                                        $bgColor = 'bg-magenta-50 dark:bg-magenta-900/10';
                                        $borderColor = 'border-magenta-200 dark:border-magenta-900/30';
                                    } elseif($draft->draft_type === 'nutracare') {
                                        $icon = 'health_and_safety';
                                        $iconColor = 'text-emerald-600';
                                        $bgColor = 'bg-emerald-50 dark:bg-emerald-900/10';
                                        $borderColor = 'border-emerald-200 dark:border-emerald-900/30';
                                    }
                                @endphp
                                <a href="{{ $route }}"
                                    class="group/draft flex items-start gap-4 p-4 rounded-xl border {{ $borderColor }} hover:border-blue-300 dark:hover:border-blue-700 bg-white dark:bg-slate-800 hover:bg-slate-50 dark:hover:bg-slate-900/40 transition-all shadow-sm hover:shadow-md hover:-translate-y-0.5">
                                    <div class="flex items-center justify-center w-10 h-10 rounded-lg {{ $bgColor }} shrink-0 mt-0.5">
                                        <span class="material-symbols-outlined {{ $iconColor }} text-[20px]">{{ $icon }}</span>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-bold text-slate-900 dark:text-white truncate group-hover/draft:text-blue-600 dark:group-hover/draft:text-blue-400 transition-colors">
                                            {{ $draft->title ?: 'Draft Laporan ' . ucfirst($draft->draft_type) }}
                                        </p>
                                        <div class="flex items-center gap-2 mt-1">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-medium bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 uppercase tracking-wider">
                                                {{ ucfirst($draft->draft_type) }}
                                            </span>
                                            <span class="text-xs text-slate-500 dark:text-slate-400 flex items-center gap-1">
                                                <span class="material-symbols-outlined text-[12px]">schedule</span>
                                                {{ optional($draft->last_saved_at ?? $draft->updated_at)->diffForHumans() }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="flex items-center justify-center w-8 h-8 rounded-full bg-slate-50 dark:bg-slate-900/30 group-hover/draft:bg-blue-50 dark:group-hover/draft:bg-blue-900/30 opacity-0 group-hover/draft:opacity-100 transition-all transform translate-x-2 group-hover/draft:translate-x-0">
                                        <span class="material-symbols-outlined text-[18px] text-slate-400 group-hover/draft:text-blue-600 dark:group-hover/draft:text-blue-400">arrow_forward</span>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <div
                            class="flex flex-col items-center justify-center py-10 border border-dashed border-slate-300 dark:border-slate-600 rounded-xl bg-slate-50 dark:bg-slate-800/50">
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
    (function() {
        // ── Route URLs (from Laravel) ────────────────────────────────
        const ROUTES = {
            sirup:  "{{ route('template-summary.sirup') }}",
            kapsul: "{{ route('template-summary.kapsul') }}",
            tablet: "{{ route('template-summary.tablet') }}",
            heltiskin: "{{ route('template-summary.heltiskin') }}",
            konvermex: "{{ route('template-summary.konvermex') }}",
            nutracare: "{{ route('template-summary.nutracare') }}",
            siladex: "{{ route('template-summary.siladex') }}",
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
                        route: 'sirup',
                        templates: [
                            { label: 'Template 1', route: 'sirup' },
                            { label: 'Template 2', route: 'sirup' },
                            { label: 'Template 3', route: 'sirup' },
                        ]
                    },
                    {
                        name: 'Line 2',
                        route: 'sirup',
                        templates: [
                            { label: 'Template 1', route: 'sirup' },
                            { label: 'Template 2', route: 'sirup' },
                            { label: 'Template 3', route: 'sirup' },
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
                            { label: 'Template 1', route: 'sirup' },
                            { label: 'Template 2', route: 'sirup' },
                            { label: 'Template 3', route: 'sirup' },
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
            natural: {
                title: 'Natural Product & Extraction',
                lines: [
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
        };

        // ── Navigate ─────────────────────────────────────────────────
        window.navigateToSelectedTemplate = function() {
            if (selectedRoute) {
                window.location.href = selectedRoute;
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