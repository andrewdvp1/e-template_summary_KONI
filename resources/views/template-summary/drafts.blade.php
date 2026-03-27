@extends('layouts.app')

@section('content')
    <div class="flex flex-col gap-6">
        {{-- Header Section --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Draft Summary</h1>
                <p class="text-slate-500 dark:text-slate-400 mt-1">Lanjutkan penyusunan summary yang tersimpan.</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('template-summary.index') }}"
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-800 hover:bg-slate-50 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 font-medium transition-all text-sm">
                    <span class="material-symbols-outlined text-[18px]">add</span>
                    Buat Summary Baru
                </a>
            </div>
        </div>

        {{-- Search & Sort --}}
        <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 p-4 shadow-sm">
            <div class="flex flex-col md:flex-row gap-4">
                <div class="flex-1 relative">
                    <span
                        class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 material-symbols-outlined text-[20px]">search</span>
                    <input type="text" id="draftSearch" placeholder="Cari judul, nomor dokumen, atau tanggal..."
                        class="w-full pl-10 pr-4 py-2 rounded-lg border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-900 focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition-all text-sm">
                </div>
                <div class="md:w-64">
                    <div class="relative">
                        <span
                            class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 material-symbols-outlined text-[20px]">sort</span>
                        <select id="draftSort"
                            class="w-full pl-10 pr-8 py-2 rounded-lg border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-900 focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition-all text-sm appearance-none cursor-pointer">
                            <option value="updated_desc">Terbaru Diupdate</option>
                            <option value="updated_asc">Terlama Diupdate</option>
                            <option value="title_asc">Judul (A-Z)</option>
                            <option value="title_desc">Judul (Z-A)</option>
                        </select>
                        <span
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 material-symbols-outlined text-[20px] pointer-events-none">expand_more</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Drafts List --}}
        @if ($drafts->count() > 0)
            <div id="draftsContainer" class="flex flex-col gap-3">
                @foreach ($drafts as $draft)
                    @php
                        $formValues = $draft->payload['form_values'] ?? [];
                        $nomorDokumen = is_array($formValues) ? $formValues['dokumen_no'] ?? '-' : '-';
                        $tanggalDokumen = is_array($formValues) ? $formValues['dokumen_tanggal'] ?? '-' : '-';
                        $searchText = strtolower(($draft->title ?? '') . ' ' . $nomorDokumen . ' ' . $tanggalDokumen);
                    @endphp
                    <div class="draft-item bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden hover:shadow-md transition-all group"
                        data-title="{{ strtolower($draft->title ?? '') }}"
                        data-updated="{{ $draft->updated_at->timestamp }}" data-search="{{ $searchText }}">
                        <div class="p-4 flex flex-col gap-2">
                            {{-- Top Row: Title & Actions/Date --}}
                            <div class="flex items-start justify-between gap-6">
                                <h3 class="flex-1 pr-4 md:pr-6 dark:border-slate-700 font-bold text-slate-900 dark:text-white group-hover:text-red-600 transition-colors text-lg uppercase"
                                    title="{{ $draft->title }}">
                                    {{ $draft->title ?: 'Draft Summary' }}
                                </h3>
                                <div class="flex flex-col items-end gap-1 min-w-fit pl-1 md:pl-2">
                                    <span class="text-xs text-slate-400 dark:text-slate-500 whitespace-nowrap"
                                        title="{{ $draft->updated_at->format('d M Y H:i') }}">
                                        <span
                                            class="material-symbols-outlined text-[14px] align-middle mr-1">schedule</span>
                                        {{ $draft->updated_at->locale('id')->diffForHumans() }}
                                    </span>
                                </div>
                            </div>

                            {{-- Bottom Row: Details & Action --}}
                            <div
                                class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 pt-2 border-t border-slate-100 dark:border-slate-700/50">
                                <div class="flex flex-col gap-1 text-sm text-slate-500 dark:text-slate-400">
                                    <div class="flex items-center gap-2">
                                        <span class="font-medium text-slate-700 dark:text-slate-300">Nomor Dokumen:</span>
                                        <span class="truncate max-w-md">{{ $nomorDokumen ?: '-' }}</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="font-medium text-slate-700 dark:text-slate-300">Tanggal Dokumen:</span>
                                        <span class="truncate max-w-md">{{ $tanggalDokumen ?: '-' }}</span>
                                    </div>
                                </div>

                                <div class="flex items-center gap-2">
                                    <button type="button"
                                        onclick="deleteDraft({{ $draft->id }}, '{{ addslashes($draft->title ?? 'Draft Summary') }}')"
                                        class="flex items-center p-2 rounded-lg text-slate-400 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 transition-all"
                                        title="Hapus draft">
                                        <span class="material-symbols-outlined text-[20px]">delete</span>
                                    </button>
                                    <a href="{{ route('template-summary.continue', ['draft' => $draft->id]) }}"
                                        class="px-4 py-2 rounded-lg bg-red-600 hover:bg-red-700 text-white ...">
                                        <span class="material-symbols-outlined text-[16px]">edit</span>
                                    Lanjutkan
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            {{-- Empty State --}}
            <div
                class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm p-12 text-center">
                <div
                    class="inline-flex items-center justify-center size-16 bg-slate-100 dark:bg-slate-700 rounded-full mb-4">
                    <span class="material-symbols-outlined text-slate-400 dark:text-slate-500 text-3xl">draft</span>
                </div>
                <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-2">Belum Ada Draft Tersimpan</h3>
                <p class="text-slate-500 dark:text-slate-400 mb-6 max-w-sm mx-auto">Mulai buat summary baru dan simpan
                    sebagai draft untuk melanjutkan nanti.</p>
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
                {{-- Icon --}}
                <div class="flex items-center justify-center w-14 h-14 rounded-full bg-red-50 dark:bg-red-900/20 mx-auto mb-4">
                    <span class="material-symbols-outlined text-red-600 text-[32px]">delete_forever</span>
                </div>
                {{-- Text --}}
                <h3 class="text-lg font-bold text-slate-900 dark:text-white text-center mb-2">Hapus Draft?</h3>
                <p class="text-sm text-slate-500 dark:text-slate-400 text-center mb-1">Anda akan menghapus draft:</p>
                <p id="deleteModalTitle" class="text-sm font-semibold text-slate-800 dark:text-slate-200 text-center mb-5 px-4 line-clamp-2"></p>
                <div class="flex items-start gap-2 bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-700/50 rounded-xl px-4 py-3 mb-6">
                    <span class="material-symbols-outlined text-amber-500 text-[20px] shrink-0 mt-0.5">warning</span>
                    <p class="text-xs text-amber-700 dark:text-amber-400 text-left">Semua data pada draft ini akan <span class="font-semibold">dihapus permanen</span> dan tidak dapat dipulihkan kembali.</p>
                </div>
                {{-- Buttons --}}
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
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('draftSearch');
            const sortSelect = document.getElementById('draftSort');
            const container = document.getElementById('draftsContainer');

            if (searchInput && container) {
                const items = Array.from(container.getElementsByClassName('draft-item'));

                function filterItems() {
                    const query = searchInput.value.toLowerCase();
                    items.forEach(item => {
                        const searchText = item.dataset.search || '';
                        item.style.display = searchText.includes(query) ? 'block' : 'none';
                    });
                }

                function sortItems() {
                    const sortValue = sortSelect.value;

                    const sortedItems = items.sort((a, b) => {
                        if (sortValue === 'updated_desc') {
                            return b.dataset.updated - a.dataset.updated;
                        }
                        if (sortValue === 'updated_asc') {
                            return a.dataset.updated - b.dataset.updated;
                        }
                        if (sortValue === 'title_desc') {
                            return b.dataset.title.localeCompare(a.dataset.title);
                        }
                        return a.dataset.title.localeCompare(b.dataset.title);
                    });

                    sortedItems.forEach(item => container.appendChild(item));
                }

                searchInput.addEventListener('input', filterItems);
                sortSelect.addEventListener('change', sortItems);
            }
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
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            window.location.reload();
                        } else {
                            alert('Gagal menghapus draft: ' + (data.message || 'Unknown error'));
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan saat menghapus draft');
                    });
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