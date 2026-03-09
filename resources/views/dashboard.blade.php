@extends('layouts.app')

@section('content')
    <div class="max-w-5xl mx-auto space-y-8">
        {{-- Welcome Header --}}
        <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm p-8 relative overflow-hidden">
            <div class="relative z-10">
                <h1 class="text-3xl font-bold text-slate-900 dark:text-white mb-2">Selamat Datang, Pengguna!</h1>
                <p class="text-slate-500 dark:text-slate-400 max-w-2xl">
                    Di E-Template Konimex, Anda dapat membuat, melanjutkan, dan mengelola semua draft laporan validasi proses pembuatan produk dengan mudah.
                </p>
                <div class="mt-6 flex flex-wrap gap-3">
                    <a href="{{ route('template-summary.index') }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-red-600 hover:bg-red-700 text-white font-medium transition-all shadow-sm shadow-red-500/20">
                        <span class="material-symbols-outlined text-[20px]">add</span>
                        Buat Laporan Baru
                    </a>
                </div>
            </div>
            {{-- Decorative Background Elements --}}
            <div class="absolute right-0 top-0 w-64 h-full hidden md:block opacity-10 pointer-events-none">
                <span class="material-symbols-outlined text-[200px] text-red-600 absolute -right-10 -top-10">description</span>
            </div>
        </div>

        {{-- Statistics overview --}}
        <div>
            <h2 class="text-lg font-bold text-slate-900 dark:text-white mb-4">Statistik Draft Laporan Anda ({{ $draftCounts['total'] }} Total)</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                {{-- Sirup Stats --}}
                <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm p-6 flex items-center gap-5 transition-transform hover:-translate-y-1 duration-300">
                    <div class="flex items-center justify-center w-14 h-14 rounded-2xl bg-amber-50 dark:bg-amber-900/20 text-amber-600 shrink-0">
                        <span class="material-symbols-outlined text-[32px]">water_drop</span>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Draft Sirup</p>
                        <h3 class="text-3xl font-bold text-slate-900 dark:text-white">{{ $draftCounts['sirup'] }}</h3>
                    </div>
                </div>

                {{-- Tablet Stats --}}
                <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm p-6 flex items-center gap-5 transition-transform hover:-translate-y-1 duration-300">
                    <div class="flex items-center justify-center w-14 h-14 rounded-2xl bg-blue-50 dark:bg-blue-900/20 text-blue-600 shrink-0">
                        <span class="material-symbols-outlined text-[32px]">medication</span>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Draft Line Tablet</p>
                        <h3 class="text-3xl font-bold text-slate-900 dark:text-white">{{ $draftCounts['tablet'] }}</h3>
                    </div>
                </div>

                {{-- Kapsul Stats --}}
                <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm p-6 flex items-center gap-5 transition-transform hover:-translate-y-1 duration-300">
                    <div class="flex items-center justify-center w-14 h-14 rounded-2xl bg-green-50 dark:bg-green-900/20 text-green-600 shrink-0">
                        <span class="material-symbols-outlined text-[32px]">blender</span>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Draft Line Soft Capsule</p>
                        <h3 class="text-3xl font-bold text-slate-900 dark:text-white">{{ $draftCounts['kapsul'] }}</h3>
                    </div>
                </div>
            </div>
        </div>

        {{-- Recent Drafts Section --}}
        <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-slate-100 dark:border-slate-700 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-indigo-50 dark:bg-indigo-900/20 text-indigo-600">
                        <span class="material-symbols-outlined text-[22px]">history</span>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-slate-900 dark:text-white">Aktivitas Terakhir</h2>
                        <p class="text-sm text-slate-500 dark:text-slate-400">Draft yang baru saja Anda kerjakan</p>
                    </div>
                </div>
                <a href="{{ route('template-summary.drafts') }}" class="inline-flex items-center gap-1 text-sm font-medium text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300">
                    Lihat Semua Draft
                    <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                </a>
            </div>
            
            <div class="p-0">
                @if($recentDrafts->count() > 0)
                    <div class="divide-y divide-slate-100 dark:divide-slate-700">
                        @foreach($recentDrafts as $draft)
                            @php
                                $icon = 'description';
                                $iconColor = 'text-slate-500';
                                $bgColor = 'bg-slate-50 dark:bg-slate-800/50';
                                
                                if($draft->draft_type === 'sirup') {
                                    $icon = 'water_drop';
                                    $iconColor = 'text-amber-600';
                                    $bgColor = 'bg-amber-50 dark:bg-amber-900/10';
                                } elseif($draft->draft_type === 'tablet') {
                                    $icon = 'medication';
                                    $iconColor = 'text-blue-600';
                                    $bgColor = 'bg-blue-50 dark:bg-blue-900/10';
                                } elseif($draft->draft_type === 'kapsul') {
                                    $icon = 'blender';
                                    $iconColor = 'text-green-600';
                                    $bgColor = 'bg-green-50 dark:bg-green-900/10';
                                }
                            @endphp
                            <div class="p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4 hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                                <div class="flex items-start gap-4">
                                    <div class="flex items-center justify-center w-12 h-12 rounded-xl {{ $bgColor }} shrink-0 mt-0.5">
                                        <span class="material-symbols-outlined {{ $iconColor }}">{{ $icon }}</span>
                                    </div>
                                    <div>
                                        <h3 class="text-base font-semibold text-slate-900 dark:text-white leading-tight mb-1">
                                            {{ $draft->title ?: 'Draft Laporan ' . ucfirst($draft->draft_type) }}
                                        </h3>
                                        <div class="flex items-center gap-3 text-xs text-slate-500 dark:text-slate-400">
                                            <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full bg-slate-100 dark:bg-slate-700 font-medium text-slate-700 dark:text-slate-300">
                                                {{ ucfirst($draft->draft_type) }}
                                            </span>
                                            <span class="flex items-center gap-1">
                                                <span class="material-symbols-outlined text-[14px]">calendar_today</span>
                                                {{ optional($draft->last_saved_at ?? $draft->updated_at)->diffForHumans() }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="sm:shrink-0 ml-16 sm:ml-0">
                                    <a href="{{ route('template-summary.continue', ['draft' => $draft->id]) }}" class="inline-flex items-center justify-center gap-2 px-4 py-2 rounded-lg border border-slate-200 dark:border-slate-600 text-sm font-medium text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 hover:text-slate-900 dark:hover:text-white transition-colors w-full sm:w-auto">
                                        Lanjutkan Draft
                                        <span class="material-symbols-outlined text-[18px]">edit</span>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="p-12 flex flex-col items-center justify-center text-center">
                        <div class="w-16 h-16 rounded-2xl bg-slate-50 dark:bg-slate-800/50 text-slate-400 dark:text-slate-500 flex items-center justify-center mb-4">
                            <span class="material-symbols-outlined text-[32px]">inventory_2</span>
                        </div>
                        <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-2">Belum ada aktivitas</h3>
                        <p class="text-slate-500 dark:text-slate-400 max-w-sm mb-6">
                            Anda belum memiliki draft laporan. Mulai buat laporan baru untuk melihatnya di sini.
                        </p>
                        <a href="{{ route('template-summary.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-red-600 hover:bg-red-700 text-white font-medium transition-all shadow-sm shadow-red-500/20">
                            <span class="material-symbols-outlined text-[20px]">add</span>
                            Buat Laporan
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
