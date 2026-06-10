@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto space-y-5">
        {{-- Welcome Header --}}
        <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm p-5 relative overflow-hidden">
            <div class="relative z-10">
                <h1 class="text-xl font-bold text-slate-900 dark:text-white mb-1">Selamat Datang, Pengguna!</h1>
                <p class="text-xs text-slate-500 dark:text-slate-400 max-w-2xl">
                    Di E-Template Konimex, Anda dapat membuat, melanjutkan, dan mengelola semua draft laporan validasi proses pembuatan produk dengan mudah.
                </p>
                <div class="mt-4 flex flex-wrap gap-2">
                    <a href="{{ route('template-summary.index') }}" class="inline-flex items-center justify-center gap-1.5 px-4 py-2 rounded-lg bg-red-600 hover:bg-red-700 text-white font-medium transition-all shadow-sm shadow-red-500/20 text-sm">
                        <span class="material-symbols-outlined text-[18px]">add</span>
                        Buat Laporan Baru
                    </a>
                </div>
            </div>
            {{-- Decorative Background Elements --}}
            <div class="absolute right-0 top-0 w-48 h-full hidden md:block opacity-10 pointer-events-none">
                <span class="material-symbols-outlined text-[150px] text-red-600 absolute -right-8 -top-6">description</span>
            </div>
        </div>

        {{-- Statistics overview --}}
        <div class="mb-6">

            <h2 class="text-sm font-bold text-slate-900 dark:text-white mb-3">Statistik Draft Laporan Anda ({{ $draftCounts['total'] }} Total)</h2>
            <div class="flex flex-wrap gap-3">

                {{-- Pharma I A --}}
                <a href="{{ route('template-summary.index') }}"
                    class="group relative bg-white dark:bg-slate-800 rounded-xl p-3 flex flex-col justify-between transition-all duration-300 hover:-translate-y-0.5 w-44 h-44 shadow-[0_2px_12px_-2px_rgba(0,0,0,0.05)] hover:shadow-[0_6px_20px_-4px_rgba(220,38,38,0.15)] border border-slate-100 hover:border-red-200 dark:border-slate-700 dark:hover:border-red-800/50 overflow-hidden">
                    <div class="absolute top-0 right-0 w-20 h-20 bg-red-500/10 rounded-full blur-2xl -mr-10 -mt-10 opacity-50 group-hover:opacity-100 transition-opacity"></div>
                    <div class="flex items-start justify-between relative z-10 mb-3">
                        <div>
                            <p class="text-[10px] font-bold text-slate-500 dark:text-slate-400 mb-0.5 uppercase tracking-wider">Pharma I A</p>
                            <h3 class="text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">{{ $draftCounts['pharma1a'] }}</h3>
                        </div>
                        <div class="flex items-center justify-center w-9 h-9 rounded-lg bg-red-50 dark:bg-red-900/20 text-red-600 group-hover:scale-110 transition-transform duration-300">
                            <span class="material-symbols-outlined text-[20px]">factory</span>
                        </div>
                    </div>
                    <div class="relative z-10">
                        <p class="text-[10px] text-slate-400 dark:text-slate-500 mb-1.5">Line Soft Capsule, Paramex, Steril</p>
                        <div class="flex items-center justify-between pt-2 border-t border-slate-100 dark:border-slate-700/50 text-xs font-semibold text-slate-600 dark:text-slate-300 group-hover:text-red-600 dark:group-hover:text-red-400 transition-colors">
                            <span>Kelola Draft</span>
                            <span class="material-symbols-outlined text-[15px] transform group-hover:translate-x-1 transition-transform">arrow_forward</span>
                        </div>
                    </div>
                </a>

                {{-- Pharma I B --}}
                <a href="{{ route('template-summary.index') }}"
                    class="group relative bg-white dark:bg-slate-800 rounded-xl p-3 flex flex-col justify-between transition-all duration-300 hover:-translate-y-0.5 w-44 h-44 shadow-[0_2px_12px_-2px_rgba(0,0,0,0.05)] hover:shadow-[0_6px_20px_-4px_rgba(37,99,235,0.15)] border border-slate-100 hover:border-blue-200 dark:border-slate-700 dark:hover:border-blue-800/50 overflow-hidden">
                    <div class="absolute top-0 right-0 w-20 h-20 bg-blue-500/10 rounded-full blur-2xl -mr-10 -mt-10 opacity-50 group-hover:opacity-100 transition-opacity"></div>
                    <div class="flex items-start justify-between relative z-10 mb-3">
                        <div>
                            <p class="text-[10px] font-bold text-slate-500 dark:text-slate-400 mb-0.5 uppercase tracking-wider">Pharma I B</p>
                            <h3 class="text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">{{ $draftCounts['pharma1b'] }}</h3>
                        </div>
                        <div class="flex items-center justify-center w-9 h-9 rounded-lg bg-blue-50 dark:bg-blue-900/20 text-blue-600 group-hover:scale-110 transition-transform duration-300">
                            <span class="material-symbols-outlined text-[20px]">factory</span>
                        </div>
                    </div>
                    <div class="relative z-10">
                        <p class="text-[10px] text-slate-400 dark:text-slate-500 mb-1.5">Line Tablet, Kapsul Keras</p>
                        <div class="flex items-center justify-between pt-2 border-t border-slate-100 dark:border-slate-700/50 text-xs font-semibold text-slate-600 dark:text-slate-300 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                            <span>Kelola Draft</span>
                            <span class="material-symbols-outlined text-[15px] transform group-hover:translate-x-1 transition-transform">arrow_forward</span>
                        </div>
                    </div>
                </a>

                {{-- Pharma II --}}
                <a href="{{ route('template-summary.index') }}"
                    class="group relative bg-white dark:bg-slate-800 rounded-xl p-3 flex flex-col justify-between transition-all duration-300 hover:-translate-y-0.5 w-44 h-44 shadow-[0_2px_12px_-2px_rgba(0,0,0,0.05)] hover:shadow-[0_6px_20px_-4px_rgba(16,185,129,0.15)] border border-slate-100 hover:border-emerald-200 dark:border-slate-700 dark:hover:border-emerald-800/50 overflow-hidden">
                    <div class="absolute top-0 right-0 w-20 h-20 bg-emerald-500/10 rounded-full blur-2xl -mr-10 -mt-10 opacity-50 group-hover:opacity-100 transition-opacity"></div>
                    <div class="flex items-start justify-between relative z-10 mb-3">
                        <div>
                            <p class="text-[10px] font-bold text-slate-500 dark:text-slate-400 mb-0.5 uppercase tracking-wider">Pharma II</p>
                            <h3 class="text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">{{ $draftCounts['pharma2'] }}</h3>
                        </div>
                        <div class="flex items-center justify-center w-9 h-9 rounded-lg bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 group-hover:scale-110 transition-transform duration-300">
                            <span class="material-symbols-outlined text-[20px]">precision_manufacturing</span>
                        </div>
                    </div>
                    <div class="relative z-10">
                        <p class="text-[10px] text-slate-400 dark:text-slate-500 mb-1.5">Line 1 â€“ 6</p>
                        <div class="flex items-center justify-between pt-2 border-t border-slate-100 dark:border-slate-700/50 text-xs font-semibold text-slate-600 dark:text-slate-300 group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors">
                            <span>Kelola Draft</span>
                            <span class="material-symbols-outlined text-[15px] transform group-hover:translate-x-1 transition-transform">arrow_forward</span>
                        </div>
                    </div>
                </a>

                {{-- Natural Product --}}
                <a href="{{ route('template-summary.index') }}"
                    class="group relative bg-white dark:bg-slate-800 rounded-xl p-3 flex flex-col justify-between transition-all duration-300 hover:-translate-y-0.5 w-44 h-44 shadow-[0_2px_12px_-2px_rgba(0,0,0,0.05)] hover:shadow-[0_6px_20px_-4px_rgba(245,158,11,0.15)] border border-slate-100 hover:border-amber-200 dark:border-slate-700 dark:hover:border-amber-800/50 overflow-hidden">
                    <div class="absolute top-0 right-0 w-20 h-20 bg-amber-500/10 rounded-full blur-2xl -mr-10 -mt-10 opacity-50 group-hover:opacity-100 transition-opacity"></div>
                    <div class="flex items-start justify-between relative z-10 mb-3">
                        <div>
                            <p class="text-[10px] font-bold text-slate-500 dark:text-slate-400 mb-0.5 uppercase tracking-wider">Natural</p>
                            <h3 class="text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">{{ $draftCounts['natural'] }}</h3>
                        </div>
                        <div class="flex items-center justify-center w-9 h-9 rounded-lg bg-amber-50 dark:bg-amber-900/20 text-amber-600 group-hover:scale-110 transition-transform duration-300">
                            <span class="material-symbols-outlined text-[20px]">eco</span>
                        </div>
                    </div>
                    <div class="relative z-10">
                        <p class="text-[10px] text-slate-400 dark:text-slate-500 mb-1.5">Nutracare Grape Seed, Q-Fomil</p>
                        <div class="flex items-center justify-between pt-2 border-t border-slate-100 dark:border-slate-700/50 text-xs font-semibold text-slate-600 dark:text-slate-300 group-hover:text-amber-600 dark:group-hover:text-amber-400 transition-colors">
                            <span>Kelola Draft</span>
                            <span class="material-symbols-outlined text-[15px] transform group-hover:translate-x-1 transition-transform">arrow_forward</span>
                        </div>
                    </div>
                </a>

            </div>
        </div>

            {{-- Recent Drafts Section --}}
            <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
                <div class="px-5 py-3.5 border-b border-slate-100 dark:border-slate-700 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div class="flex items-center gap-2.5">
                        <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-red-50 dark:bg-red-900/20 text-red-600">
                            <span class="material-symbols-outlined text-[18px]">history</span>
                        </div>
                        <div>
                            <h2 class="text-sm font-bold text-slate-900 dark:text-white leading-tight">Aktivitas Terakhir</h2>
                            <p class="text-[10px] text-slate-500 dark:text-slate-400 mt-0.5">Draft yang baru saja Anda kerjakan</p>
                        </div>
                    </div>
                    <a href="{{ route('template-summary.drafts') }}" class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-xs font-medium text-slate-700 dark:text-slate-300 hover:bg-slate-100 hover:text-red-700 dark:hover:bg-slate-700 dark:hover:text-red-400 transition-colors">
                        Lihat Semua
                        <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
                    </a>
                </div>

                {{-- List Machine (di bawah Draft Summary header) --}}
                <div class="px-5 py-3 border-b border-slate-100 dark:border-slate-700">
                    <a href="{{ route('listmachine.index') }}"
                       class="inline-flex items-center gap-2 px-3 py-2 rounded-lg bg-red-600 hover:bg-red-700 text-white text-xs font-medium transition-all">
                        <span class="material-symbols-outlined text-[16px]">inventory_2</span>
                        List Machine
                    </a>
                </div>

                <div class="p-0">

                @if($recentDrafts->count() > 0)
                    <div class="divide-y divide-slate-100 dark:divide-slate-700">
                        @foreach($recentDrafts as $draft)
                            @php
                                $icon = 'description';
                                $iconColor = 'text-slate-400';

                                if($draft->draft_type === 'anakonidin30' || $draft->draft_type === 'sirup') {
                                    $icon = 'water_drop';
                                    $iconColor = 'text-amber-500';
                                } elseif($draft->draft_type === 'tablet') {
                                    $icon = 'medication';
                                    $iconColor = 'text-blue-500';
                                } elseif($draft->draft_type === 'kapsul') {
                                    $icon = 'blender';
                                    $iconColor = 'text-green-500';
                                } elseif($draft->draft_type === 'heltiskin') {
                                    $icon = 'spa';
                                    $iconColor = 'text-pink-500';
                                } elseif($draft->draft_type === 'konvermex') {
                                    $icon = 'science';
                                    $iconColor = 'text-purple-500';
                                } elseif($draft->draft_type === 'nutracare') {
                                    $icon = 'health_and_safety';
                                    $iconColor = 'text-red-500';
                                } elseif($draft->draft_type === 'siladex') {
                                    $icon = 'local_pharmacy';
                                    $iconColor = 'text-violet-500';
                                } elseif($draft->draft_type === 'konidinobh') {
                                    $icon = 'inventory_2';
                                    $iconColor = 'text-purple-500';
                                } elseif($draft->draft_type === 'anakonidin60') {
                                    $icon = 'water_drop';
                                    $iconColor = 'text-emerald-500';
                                }
                            @endphp
                            <div class="group flex flex-col sm:flex-row sm:items-center justify-between gap-3 px-4 py-3 hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                                <div class="flex items-center gap-3">
                                    <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-slate-100 dark:bg-slate-800 shrink-0 border border-slate-200 dark:border-slate-700">
                                        <span class="material-symbols-outlined {{ $iconColor }} text-[17px]">{{ $icon }}</span>
                                    </div>
                                    <div class="flex flex-col">
                                        <h3 class="text-xs font-bold text-slate-900 dark:text-white group-hover:text-red-600 dark:group-hover:text-red-400 transition-colors">
                                            {{ $draft->title ?: 'Draft Laporan ' . ucfirst($draft->draft_type) }}
                                        </h3>
                                        <div class="flex items-center gap-2 text-[10px] text-slate-500 dark:text-slate-400 mt-0.5">
                                            <span class="font-medium text-slate-600 dark:text-slate-300">
                                                {{ ucfirst($draft->draft_type) }}
                                            </span>
                                            <span class="w-1 h-1 rounded-full bg-slate-300 dark:bg-slate-600"></span>
                                            <span class="flex items-center gap-0.5">
                                                <span class="material-symbols-outlined text-[11px]">schedule</span>
                                                {{ optional($draft->last_saved_at ?? $draft->updated_at)->diffForHumans() }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="sm:shrink-0 ml-11 sm:ml-0 opacity-100 sm:opacity-0 sm:group-hover:opacity-100 transition-opacity duration-200">
                                    <a href="{{ route('template-summary.continue', ['draft' => $draft->id]) }}" class="inline-flex items-center justify-center gap-1.5 px-3 py-1.5 rounded-lg bg-red-50 text-red-700 hover:bg-red-600 hover:text-white dark:bg-red-900/30 dark:text-red-400 dark:hover:bg-red-600 dark:hover:text-white text-xs font-medium transition-colors border border-red-100 dark:border-red-900/50 w-full sm:w-auto shadow-sm">
                                        Lanjutkan
                                        <span class="material-symbols-outlined text-[14px]">draw</span>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="p-10 flex flex-col items-center justify-center text-center">
                        <div class="w-12 h-12 rounded-xl bg-slate-50 dark:bg-slate-800/50 text-slate-400 dark:text-slate-500 flex items-center justify-center mb-3">
                            <span class="material-symbols-outlined text-[26px]">inventory_2</span>
                        </div>
                        <h3 class="text-sm font-semibold text-slate-900 dark:text-white mb-1">Belum ada aktivitas</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400 max-w-sm mb-4">
                            Anda belum memiliki draft laporan. Mulai buat laporan baru untuk melihatnya di sini.
                        </p>
                        <a href="{{ route('template-summary.index') }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg bg-red-600 hover:bg-red-700 text-white font-medium transition-all shadow-sm shadow-red-500/20 text-sm">
                            <span class="material-symbols-outlined text-[18px]">add</span>
                            Buat Laporan
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

