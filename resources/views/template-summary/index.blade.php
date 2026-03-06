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
                        <p class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wide">Pilih
                            Jenis Template</p>

                        <a href="{{ route('template-summary.sirup') }}"
                            class="flex items-center justify-between p-4 rounded-lg border border-slate-200 dark:border-slate-600 hover:border-slate-300 dark:hover:border-slate-700 hover:bg-slate-100 dark:hover:bg-slate-900/10 transition-all group">
                            <div class="flex items-center gap-3">
                                <div
                                    class="flex items-center justify-center w-10 h-10 rounded-lg bg-amber-50 dark:bg-amber-900/20 text-amber-600">
                                    <span class="material-symbols-outlined text-[20px]">water_drop</span>
                                </div>
                                <div>
                                    <p class="font-semibold text-slate-900 dark:text-white">Sirup</p>
                                    <p class="text-xs text-slate-500 dark:text-slate-400">Template untuk produk sirup</p>
                                </div>
                            </div>
                            <span
                                class="material-symbols-outlined text-slate-400 group-hover:text-slate-600 transition-colors">arrow_forward</span>
                        </a>

                        <a href="{{ route('template-summary.tablet') }}"
                            class="flex items-center justify-between p-4 rounded-lg border border-slate-200 dark:border-slate-600 hover:border-slate-300 dark:hover:border-slate-700 hover:bg-slate-100 dark:hover:bg-slate-900/10 transition-all group">
                            <div class="flex items-center gap-3">
                                <div
                                    class="flex items-center justify-center w-10 h-10 rounded-lg bg-blue-50 dark:bg-blue-900/20 text-blue-600">
                                    <span class="material-symbols-outlined text-[20px]">medication</span>
                                </div>
                                <div>
                                    <p class="font-semibold text-slate-900 dark:text-white">Tablet</p>
                                    <p class="text-xs text-slate-500 dark:text-slate-400">Template untuk produk tablet</p>
                                </div>
                            </div>
                            <span
                                class="material-symbols-outlined text-slate-400 group-hover:text-slate-600 transition-colors">arrow_forward</span>
                        </a>

                        <a href="{{ route('template-summary.kapsul') }}"
                            class="flex items-center justify-between p-4 rounded-lg border border-slate-200 dark:border-slate-600 hover:border-slate-300 dark:hover:border-slate-700 hover:bg-slate-100 dark:hover:bg-slate-900/10 transition-all group">
                            <div class="flex items-center gap-3">
                                <div
                                    class="flex items-center justify-center w-10 h-10 rounded-lg bg-green-50 dark:bg-green-900/20 text-green-600">
                                    <span class="material-symbols-outlined text-[20px]">blender</span>
                                </div>
                                <div>
                                    <p class="font-semibold text-slate-900 dark:text-white">Kapsul</p>
                                    <p class="text-xs text-slate-500 dark:text-slate-400">Template untuk produk kapsul</p>
                                </div>
                            </div>
                            <span
                                class="material-symbols-outlined text-slate-400 group-hover:text-slate-600 transition-colors">arrow_forward</span>
<<<<<<< HEAD
                        </a>                        
=======
                        </a>
>>>>>>> 6125087b80bb040888bf644f5721b881639f562e
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

                    @if (!empty($sirupDrafts) && $sirupDrafts->count() > 0)
                        <div class="space-y-2 max-h-72 overflow-y-auto pr-1">
                            @foreach ($sirupDrafts as $draft)
                                <a href="{{ route('template-summary.sirup', ['draft' => $draft->id]) }}"
                                    class="flex items-center justify-between p-3 rounded-lg border border-slate-200 dark:border-slate-600 hover:border-blue-300 dark:hover:border-blue-700 hover:bg-slate-50 dark:hover:bg-slate-900/20 transition-colors">
                                    <div class="min-w-0">
                                        <p class="text-sm font-semibold text-slate-900 dark:text-white truncate">
                                            {{ $draft->title ?: 'Draft Sirup' }}
                                        </p>
                                        <p class="text-xs text-slate-500 dark:text-slate-400">
                                            Disimpan: {{ optional($draft->last_saved_at ?? $draft->updated_at)->format('d M Y H:i') }}
                                        </p>
                                    </div>
                                    <span
                                        class="material-symbols-outlined text-slate-400 group-hover:text-slate-600 transition-colors">arrow_forward</span>
                                </a>
                            @endforeach
                    @else
                        <div
                            class="flex flex-col items-center justify-center py-8 border border-dashed border-slate-300 dark:border-slate-600 rounded-lg bg-slate-50 dark:bg-slate-900/30">
                            <span
                                class="material-symbols-outlined text-4xl text-slate-300 dark:text-slate-600 mb-2">inventory_2</span>
                            <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Belum ada draft summary</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection