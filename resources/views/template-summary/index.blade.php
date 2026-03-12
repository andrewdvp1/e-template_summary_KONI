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

                        {{-- Native HTML Accordion --}}
                        <details class="group bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm hover:shadow-md transition-shadow overflow-hidden">
                            {{-- Tombol Utama (Summary) --}}
                            <summary class="flex items-center justify-between p-4 cursor-pointer list-none hover:bg-slate-50 dark:hover:bg-slate-900/20 transition-all border-l-4 border-transparent group-open:border-red-500 hover:border-red-300 dark:hover:border-red-800">
                                <div class="flex items-center gap-4">
                                    <div class="flex items-center justify-center w-12 h-12 rounded-xl bg-red-50 dark:bg-red-900/20 text-red-600">
                                        <span class="material-symbols-outlined text-[28px]">factory</span>
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-slate-900 dark:text-white group-hover:text-red-600 transition-colors">Production I A</h3>
                                        <p class="text-xs text-slate-500 dark:text-slate-400">Klik untuk melihat daftar sediaan</p>
                                    </div>
                                </div>
                                {{-- Icon Panah Otomatis Berputar --}}
                                <div class="flex items-center justify-center w-8 h-8 rounded-full bg-slate-50 dark:bg-slate-800 group-hover:bg-red-50 dark:group-hover:bg-red-900/30 transition-colors">
                                    <span class="material-symbols-outlined text-slate-400 group-hover:text-red-500 transition-transform duration-300 group-open:rotate-180">
                                        expand_more
                                    </span>
                                </div>
                            </summary>

                            {{-- Isi Menu (Sub-menu) --}}
                            <div class="p-4 pt-0 flex flex-col gap-2 bg-slate-50/50 dark:bg-slate-900/10">
                                <div class="pl-4 border-l-2 border-red-100 dark:border-red-900/30 flex flex-col gap-3 mt-4">
                                    
                                    {{-- Item: Sirup --}}
                                    <a href="{{ route('template-summary.sirup') }}"
                                        class="group/item flex items-center justify-between p-3.5 rounded-xl bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700 shadow-sm hover:bg-amber-50 dark:hover:bg-amber-900/10 hover:border-amber-200 dark:hover:border-amber-800 transition-all hover:-translate-y-0.5 hover:shadow-md">
                                        <div class="flex items-center gap-4">
                                            <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-amber-50 dark:bg-amber-900/20 text-amber-600 group-hover/item:scale-110 transition-transform">
                                                <span class="material-symbols-outlined text-[22px]">water_drop</span>
                                            </div>
                                            <div>
                                                <p class="font-bold text-slate-800 dark:text-slate-200 group-hover/item:text-amber-700 dark:group-hover/item:text-amber-400 transition-colors">Sirup</p>
                                                <p class="text-xs text-slate-500 dark:text-slate-400">Template summary sirup</p>
                                            </div>
                                        </div>
                                        <span class="material-symbols-outlined text-slate-300 group-hover/item:text-amber-500 transform group-hover/item:translate-x-1 transition-all">arrow_forward</span>
                                    </a>

                                    {{-- Item: Kapsul --}}
                                    <a href="{{ route('template-summary.kapsul') }}"
                                        class="group/item flex items-center justify-between p-3.5 rounded-xl bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700 shadow-sm hover:bg-green-50 dark:hover:bg-green-900/10 hover:border-green-200 dark:hover:border-green-800 transition-all hover:-translate-y-0.5 hover:shadow-md">
                                        <div class="flex items-center gap-4">
                                            <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-green-50 dark:bg-green-900/20 text-green-600 group-hover/item:scale-110 transition-transform">
                                                <span class="material-symbols-outlined text-[22px]">blender</span>
                                            </div>
                                            <div>
                                                <p class="font-bold text-slate-800 dark:text-slate-200 group-hover/item:text-green-700 dark:group-hover/item:text-green-400 transition-colors">Line Soft Capsule</p>
                                                <p class="text-xs text-slate-500 dark:text-slate-400">Template summary soft capsule</p>
                                            </div>
                                        </div>
                                        <span class="material-symbols-outlined text-slate-300 group-hover/item:text-green-500 transform group-hover/item:translate-x-1 transition-all">arrow_forward</span>
                                    </a>
                                </div>
                            </div>
                        </details>
                    </div>
                    
                    <div class="flex flex-col gap-3">
                        {{-- Native HTML Accordion --}}
                        <details class="group bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm hover:shadow-md transition-shadow overflow-hidden">
                            {{-- Tombol Utama (Summary) --}}
                            <summary class="flex items-center justify-between p-4 cursor-pointer list-none hover:bg-slate-50 dark:hover:bg-slate-900/20 transition-all border-l-4 border-transparent group-open:border-blue-500 hover:border-blue-300 dark:hover:border-blue-800">
                                <div class="flex items-center gap-4">
                                    <div class="flex items-center justify-center w-12 h-12 rounded-xl bg-blue-50 dark:bg-blue-900/20 text-blue-600">
                                        <span class="material-symbols-outlined text-[28px]">factory</span>
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-slate-900 dark:text-white group-hover:text-blue-600 transition-colors">Production I B</h3>
                                        <p class="text-xs text-slate-500 dark:text-slate-400">Klik untuk melihat daftar sediaan</p>
                                    </div>
                                </div>
                                {{-- Icon Panah Otomatis Berputar --}}
                                <div class="flex items-center justify-center w-8 h-8 rounded-full bg-slate-50 dark:bg-slate-800 group-hover:bg-blue-50 dark:group-hover:bg-blue-900/30 transition-colors">
                                    <span class="material-symbols-outlined text-slate-400 group-hover:text-blue-500 transition-transform duration-300 group-open:rotate-180">
                                        expand_more
                                    </span>
                                </div>
                            </summary>

                            {{-- Isi Menu (Sub-menu) --}}
                            <div class="p-4 pt-0 flex flex-col gap-2 bg-slate-50/50 dark:bg-slate-900/10">
                                <div class="pl-4 border-l-2 border-blue-100 dark:border-blue-900/30 flex flex-col gap-3 mt-4">

                                    {{-- Item: Tablet --}}
                                    <a href="{{ route('template-summary.tablet') }}"
                                        class="group/item flex items-center justify-between p-3.5 rounded-xl bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700 shadow-sm hover:bg-blue-50 dark:hover:bg-blue-900/10 hover:border-blue-200 dark:hover:border-blue-800 transition-all hover:-translate-y-0.5 hover:shadow-md">
                                        <div class="flex items-center gap-4">
                                            <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-blue-50 dark:bg-blue-900/20 text-blue-600 group-hover/item:scale-110 transition-transform">
                                                <span class="material-symbols-outlined text-[22px]">medication</span>
                                            </div>
                                            <div>
                                                <p class="font-bold text-slate-800 dark:text-slate-200 group-hover/item:text-blue-700 dark:group-hover/item:text-blue-400 transition-colors">Line Tablet</p>
                                                <p class="text-xs text-slate-500 dark:text-slate-400">Template summary tablet</p>
                                            </div>
                                        </div>
                                        <span class="material-symbols-outlined text-slate-300 group-hover/item:text-blue-500 transform group-hover/item:translate-x-1 transition-all">arrow_forward</span>
                                    </a>
                                </div>
                            </div>
                        </details>
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
                                        $bgColor = 'bg-amber-50 dark:bg-amber-900/10';
                                        $borderColor = 'border-amber-200 dark:border-amber-900/30';
                                    } elseif($draft->draft_type === 'tablet') {
                                        $icon = 'medication';
                                        $bgColor = 'bg-blue-50 dark:bg-blue-900/10';
                                        $borderColor = 'border-blue-200 dark:border-blue-900/30';
                                    } elseif($draft->draft_type === 'kapsul') {
                                        $icon = 'blender';
                                        $bgColor = 'bg-green-50 dark:bg-green-900/10';
                                        $borderColor = 'border-green-200 dark:border-green-900/30';
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
@endsection