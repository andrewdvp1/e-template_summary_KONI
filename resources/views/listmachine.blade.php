@extends('layouts.app')

@section('content')
    @php
        /*
         * Safelist classes (jangan dihapus komentar ini — Tailwind purge perlu melihat class ini):
         * bg-blue-600 bg-cyan-600 bg-emerald-600 bg-red-600 bg-orange-500 bg-purple-600 bg-slate-600
         * bg-blue-50 bg-cyan-50 bg-emerald-50 bg-red-50 bg-orange-100
         * dark:bg-blue-900/20 dark:bg-cyan-900/20 dark:bg-emerald-900/20 dark:bg-red-900/20 dark:bg-orange-700
         * text-blue-500 text-cyan-500 text-emerald-600 text-red-600 text-orange-600
         * dark:text-blue-400 dark:text-cyan-400
         * border-blue-200 border-cyan-200 border-emerald-200 border-red-200 border-orange-200
         * dark:border-blue-800/40 dark:border-cyan-800/40 dark:border-emerald-800/40 dark:border-red-800/40 dark:border-orange-600
         * ring-blue-500/20 ring-cyan-500/20 ring-emerald-500/20 ring-red-500/20 ring-orange-500/20
         */
        $segmentConfig = [
            'Ekstraksi'              => ['icon' => 'science',          'color' => 'blue',    'accent' => 'bg-blue-600',    'light' => 'bg-blue-50 dark:bg-blue-900/20',         'text' => 'text-blue-500 dark:text-blue-400',   'border' => 'border-blue-200 dark:border-blue-800/40',    'ring' => 'ring-blue-500/20'],
            'Evaporasi'              => ['icon' => 'humidity_low',     'color' => 'cyan',    'accent' => 'bg-cyan-600',    'light' => 'bg-cyan-50 dark:bg-cyan-900/20',         'text' => 'text-cyan-500 dark:text-cyan-400',   'border' => 'border-cyan-200 dark:border-cyan-800/40',    'ring' => 'ring-cyan-500/20'],
            'Granulasi'              => ['icon' => 'grain',            'color' => 'emerald', 'accent' => 'bg-emerald-600', 'light' => 'bg-emerald-50 dark:bg-emerald-900/20',   'text' => 'text-emerald-600',                   'border' => 'border-emerald-200 dark:border-emerald-800/40','ring' => 'ring-emerald-500/20'],
            'Sterilisasi'            => ['icon' => 'health_and_safety','color' => 'red',     'accent' => 'bg-red-600',     'light' => 'bg-red-50 dark:bg-red-900/20',           'text' => 'text-red-600',                       'border' => 'border-red-200 dark:border-red-800/40',      'ring' => 'ring-red-500/20'],
            'Pengecilan Ukuran Granul' => ['icon' => 'compress',       'color' => 'orange',  'accent' => 'bg-orange-500',  'light' => 'bg-orange-100 dark:bg-orange-700',       'text' => 'text-orange-600',                    'border' => 'border-orange-200 dark:border-orange-600',   'ring' => 'ring-orange-500/20'],
            'Mixing'                 => ['icon' => 'blender',          'color' => 'green',   'accent' => 'bg-green-600',   'light' => 'bg-green-50 dark:bg-green-900/20',       'text' => 'text-green-600',                     'border' => 'border-green-200 dark:border-green-800/40',  'ring' => 'ring-green-500/20'],
        ];

        /* Inline style fallback untuk segment yang warnanya bisa di-purge */
        $segmentStyle = [
            'Evaporasi'               => ['header' => 'background-color:#0891b2;', 'pill' => 'background-color:#0891b2;'],
            'Pengecilan Ukuran Granul'=> ['header' => 'background-color:#f97316;', 'pill' => 'background-color:#f97316;'],
        ];
    @endphp

    <div class="flex flex-col gap-6">

        {{-- Page Header --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900 dark:text-white">List Machine</h1>
            </div>
            <button type="button" onclick="openCreateStageModal()"
                class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-800 hover:bg-slate-50 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 font-medium transition-all text-sm self-start md:self-auto">
                <span class="material-symbols-outlined text-[18px]">add</span>
                Tambah Tahapan Pengolahan
            </button>
        </div>

        {{-- Search Tahapan --}}
        <div class="relative">
            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 material-symbols-outlined text-[20px]">search</span>
            <input type="text" id="stageSearch" placeholder="Cari tahapan... (contoh: Ekstraksi)"
                class="w-full pl-10 pr-10 py-2.5 rounded-xl border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition-all text-sm shadow-sm">
            <button type="button" id="stageClearBtn" onclick="clearStageSearch()"
                class="hidden absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 material-symbols-outlined text-[18px]">close</button>
        </div>

        {{-- Filter Tahapan --}}
        <div class="flex flex-wrap items-center gap-3">
            <span class="text-sm font-semibold text-slate-500 dark:text-slate-400 shrink-0">Pilih Tahapan:</span>
            @foreach ($stages as $stage)
                @php
                    $segLabel = $stage->name;
                    $sc = $segmentConfig[$segLabel] ?? ['icon' => 'category', 'color' => 'purple', 'accent' => 'bg-purple-600', 'light' => 'bg-purple-50 dark:bg-purple-900/20', 'text' => 'text-purple-600', 'border' => 'border-purple-200 dark:border-purple-800/40', 'ring' => 'ring-purple-500/20'];
                    $segKey = $stage->id;
                    $inlineStyle = $segmentStyle[$segLabel]['pill'] ?? '';
                @endphp
                <button type="button"
                    onclick="scrollToSegment('{{ $segKey }}')"
                    style="{{ $inlineStyle }}"
                    data-stage-name="{{ strtolower($segLabel) }}"
                    class="seg-nav-pill inline-flex items-center gap-2 px-4 py-2 rounded-full transition-all text-sm font-bold text-white {{ $sc['accent'] }} hover:opacity-90 shadow-sm cursor-pointer">
                    <span class="material-symbols-outlined text-[16px]">{{ $sc['icon'] }}</span>
                    {{ $segLabel }}
                    <span class="seg-nav-count inline-flex items-center justify-center w-5 h-5 rounded-full bg-white/25 text-white text-[11px] font-bold shrink-0">
                        {{ $stage->machines->count() }}
                    </span>
                </button>
            @endforeach
        </div>

        <div class="flex flex-col gap-6">
            @foreach ($stages as $stage)
                @php
                    $segLabel = $stage->name;
                    $sc = $segmentConfig[$segLabel] ?? ['icon' => 'category', 'color' => 'purple', 'accent' => 'bg-purple-600', 'light' => 'bg-purple-50 dark:bg-purple-900/20', 'text' => 'text-purple-600', 'border' => 'border-purple-200 dark:border-purple-800/40', 'ring' => 'ring-purple-500/20'];
                    $segKey = $stage->id;
                @endphp

                    <div id="seg-{{ $segKey }}" class="segment-block rounded-2xl overflow-hidden scroll-mt-6 shadow-lg"
                        data-stage-name="{{ strtolower($segLabel) }}">
                    {{-- Segment Header (klik untuk expand/collapse) --}}
                    @php $headerStyle = $segmentStyle[$segLabel]['header'] ?? ''; @endphp
                    <div class="{{ $sc['accent'] }} px-5 py-3 flex items-center justify-between gap-3 select-none segment-header cursor-pointer"
                        style="{{ $headerStyle }}"
                        onclick="scrollToSegment('{{ $segKey }}')"
                        data-segment="{{ $segKey }}">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-white text-[20px]">{{ $sc['icon'] }}</span>
                            <span class="font-bold text-white text-sm tracking-wide">{{ $segLabel }}</span>
                            <span class="px-2.5 py-0.5 rounded-md bg-white/25 text-white text-[11px] font-bold segment-total-count">{{ $stage->machines->count() }} mesin</span>
                        </div>

                        {{-- Collapse toggle --}}
                        <div class="flex items-center gap-1">
                            {{-- Edit Stage --}}
                            <button type="button"
                                onclick="event.stopPropagation(); openEditStageModal('{{ $stage->id }}', '{{ e($segLabel) }}')"
                                class="flex items-center justify-center w-7 h-7 rounded-full bg-white/15 hover:bg-white/30 transition-all shrink-0" title="Edit Tahap">
                                <span class="material-symbols-outlined text-white text-[16px]">edit</span>
                            </button>
                            {{-- Hapus Stage --}}
                            <button type="button"
                                onclick="event.stopPropagation(); openDeleteStageModal('{{ $stage->id }}', '{{ e($segLabel) }}', {{ $stage->machines->count() }})"
                                class="flex items-center justify-center w-7 h-7 rounded-full bg-white/15 hover:bg-red-500/60 transition-all shrink-0" title="Hapus Tahap">
                                <span class="material-symbols-outlined text-white text-[16px]">delete</span>
                            </button>
                            {{-- Expand/Collapse --}}
                            <button type="button" onclick="event.stopPropagation(); toggleSegment('{{ $segKey }}')"
                                class="seg-toggle-btn flex items-center justify-center w-7 h-7 rounded-full bg-white/15 hover:bg-white/25 transition-all shrink-0" title="Tampilkan/Sembunyikan">
                                <span class="material-symbols-outlined text-white text-[18px] seg-toggle-icon transition-transform duration-300">expand_more</span>
                            </button>
                        </div>
                    </div>

                    {{-- Segment Body --}}
                    <div class="segment-body hidden" data-segment-body="{{ $segKey }}">


                        <div class="px-5 py-4 bg-white dark:bg-slate-800/60 border-t border-slate-100 dark:border-slate-700">
                            <div class="flex items-center justify-between gap-3 mb-3">
                                <div class="text-sm font-semibold text-slate-900 dark:text-white">Daftar Mesin</div>
                                <button type="button"
                                    class="inline-flex items-center gap-2 px-3 py-2 rounded-lg bg-red-600 hover:bg-red-700 text-white text-sm font-medium"
                                    onclick="openCreateModal('{{ $segKey }}', '{{ e($segLabel) }}')">
                                    <span class="material-symbols-outlined text-[18px]">add</span>
                                    Tambah
                                </button>
                            </div>

                            <div class="overflow-x-auto">
                                <table class="min-w-full text-sm">
                                    <thead class="text-left">
                                        <tr class="text-slate-500 dark:text-slate-300">
                                            <th class="py-2 pr-3">Nama</th>
                                            <th class="py-2"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($stage->machines as $machine)
                                            <tr class="draft-item" data-search="{{ strtolower($machine->name) }}" data-line="all">
                                                <td class="py-2 pr-3 text-slate-900 dark:text-white font-medium">{{ $machine->name }}</td>
                                                <td class="py-2">
                                                    <div class="flex gap-2">
                                                        <button type="button" class="px-3 py-1.5 rounded-lg border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 hover:bg-slate-50 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-200"
                                                            onclick="openEditModal('{{ $segKey }}', '{{ $machine->id }}', '{{ e($machine->name) }}')">
                                                            Edit
                                                        </button>

                                                        <form method="POST" action="{{ route('listmachine.machines.destroy', ['stage' => $stage->id, 'machine' => $machine->id]) }}"
                                                            id="delete-machine-form-{{ $machine->id }}"
                                                            onsubmit="return false;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button"
                                                                onclick="confirmDeleteMachine('{{ $machine->id }}')"
                                                                class="px-3 py-1.5 rounded-lg bg-red-600 hover:bg-red-700 text-white">Hapus</button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="2" class="py-3 text-slate-500">Belum ada mesin di tahap ini.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>

@endsection

@push('scripts')
<script>
(function () {
    // jalankan setelah DOM siap, pakai window.onload sebagai fallback
    function init() {
        const stageSearch   = document.getElementById('stageSearch');
        const stageClearBtn = document.getElementById('stageClearBtn');

        if (!stageSearch) return;

        function filterStages(query) {
            const q = (query || '').toLowerCase().trim();

            // filter segment blocks
            document.querySelectorAll('.segment-block').forEach(function (block) {
                const name = (block.getAttribute('data-stage-name') || '').toLowerCase();
                block.style.display = (!q || name.includes(q)) ? '' : 'none';
            });

            // filter pill buttons
            document.querySelectorAll('.seg-nav-pill').forEach(function (pill) {
                const name = (pill.getAttribute('data-stage-name') || '').toLowerCase();
                pill.style.display = (!q || name.includes(q)) ? '' : 'none';
            });

            // toggle clear button
            if (stageClearBtn) {
                stageClearBtn.classList.toggle('hidden', !q);
            }
        }

        stageSearch.addEventListener('input', function () {
            filterStages(this.value);
        });

        stageSearch.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                this.value = '';
                filterStages('');
            }
        });

        window.clearStageSearch = function () {
            stageSearch.value = '';
            filterStages('');
            stageSearch.focus();
        };
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();

document.addEventListener('DOMContentLoaded', function () {

    window.toggleSegment = function(segKey) {
        const block = document.getElementById('seg-' + segKey);
        if (!block) return;
        const body = block.querySelector('.segment-body');
        const icon = block.querySelector('.seg-toggle-icon');
        const isHidden = body.classList.contains('hidden');
        body.classList.toggle('hidden', !isHidden);
        if (icon) icon.style.transform = isHidden ? 'rotate(180deg)' : '';
    };

    window.scrollToSegment = function(segKey) {
        const target = document.getElementById('seg-' + segKey);
        if (!target) return;
        const body = target.querySelector('.segment-body');
        const icon = target.querySelector('.seg-toggle-icon');
        const isHidden = body && body.classList.contains('hidden');

        if (isHidden) {
            body.classList.remove('hidden');
            if (icon) icon.style.transform = 'rotate(180deg)';
            target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        } else {
            body.classList.add('hidden');
            if (icon) icon.style.transform = '';
        }
    };
});

// ─── Stage CRUD ────────────────────────────────────────────────────────────

function openCreateStageModal() {
    Swal.fire({
        title: 'Tambah Tahap Pengolahan',
        input: 'text',
        inputLabel: 'Nama Tahap',
        inputPlaceholder: 'Contoh: Granulasi, Mixing, Pengeringan...',
        showCancelButton: true,
        cancelButtonText: 'Batal',
        confirmButtonText: 'Simpan',
        confirmButtonColor: '#dc2626',
        preConfirm: (value) => {
            const name = (value || '').trim();
            if (!name) {
                Swal.showValidationMessage('Nama tahap wajib diisi');
                return false;
            }
            return name;
        }
    }).then((result) => {
        if (!result.isConfirmed) return;

        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '/list-machine/stages';

        const csrf = document.querySelector('meta[name="csrf-token"]')?.content;
        if (csrf) {
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = csrf;
            form.appendChild(csrfInput);
        }

        const nameInput = document.createElement('input');
        nameInput.type = 'hidden';
        nameInput.name = 'name';
        nameInput.value = result.value;
        form.appendChild(nameInput);

        document.body.appendChild(form);
        form.submit();
    });
}

function openEditStageModal(stageId, currentName) {
    Swal.fire({
        title: 'Edit Tahap Pengolahan',
        input: 'text',
        inputValue: currentName,
        inputLabel: 'Nama Tahap',
        showCancelButton: true,
        cancelButtonText: 'Batal',
        confirmButtonText: 'Simpan Perubahan',
        confirmButtonColor: '#dc2626',
        preConfirm: (value) => {
            const name = (value || '').trim();
            if (!name) {
                Swal.showValidationMessage('Nama tahap wajib diisi');
                return false;
            }
            return name;
        }
    }).then((result) => {
        if (!result.isConfirmed) return;

        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '/list-machine/stages/' + stageId;

        const csrf = document.querySelector('meta[name="csrf-token"]')?.content;
        if (csrf) {
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = csrf;
            form.appendChild(csrfInput);
        }

        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'PUT';
        form.appendChild(methodInput);

        const nameInput = document.createElement('input');
        nameInput.type = 'hidden';
        nameInput.name = 'name';
        nameInput.value = result.value;
        form.appendChild(nameInput);

        document.body.appendChild(form);
        form.submit();
    });
}

function openDeleteStageModal(stageId, stageName, machineCount) {
    const warningText = machineCount > 0
        ? `<p class="mt-1 text-sm text-red-500">Tahap ini memiliki <strong>${machineCount} mesin</strong> yang akan ikut terhapus.</p>`
        : '';

    Swal.fire({
        title: 'Hapus Tahap Pengolahan?',
        html: `<p>Apakah Anda yakin ingin menghapus tahap <strong>"${stageName}"</strong>?</p>${warningText}`,
        icon: 'warning',
        showCancelButton: true,
        cancelButtonText: 'Batal',
        confirmButtonText: 'Ya, Hapus',
        confirmButtonColor: '#dc2626',
    }).then((result) => {
        if (!result.isConfirmed) return;

        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '/list-machine/stages/' + stageId;

        const csrf = document.querySelector('meta[name="csrf-token"]')?.content;
        if (csrf) {
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = csrf;
            form.appendChild(csrfInput);
        }

        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'DELETE';
        form.appendChild(methodInput);

        document.body.appendChild(form);
        form.submit();
    });
}

// ─── Machine CRUD ───────────────────────────────────────────────────────────

function confirmDeleteMachine(machineId) {
    Swal.fire({
        title: 'Hapus Mesin?',
        text: 'Yakin ingin menghapus mesin ini?',
        icon: 'warning',
        showCancelButton: true,
        cancelButtonText: 'Cancel',
        confirmButtonText: 'Hapus',
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#6b7280',
        reverseButtons: true,
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.getElementById('delete-machine-form-' + machineId);
            if (form) {
                form.onsubmit = null;
                form.submit();
            }
        }
    });
}

function openCreateModal(stageId, stageLabel) {
    Swal.fire({
        title: 'Tambah Mesin - ' + stageLabel,
        input: 'text',
        inputLabel: 'Nama Mesin',
        inputPlaceholder: 'Masukkan nama mesin',
        showCancelButton: true,
        confirmButtonText: 'Simpan',
        preConfirm: (value) => {
            const name = (value || '').trim();
            if (!name) {
                Swal.showValidationMessage('Nama mesin wajib diisi');
                return false;
            }
            return name;
        }
    }).then((result) => {
        if (!result.isConfirmed) return;

        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '/list-machine/stages/' + stageId + '/machines';

        const csrf = document.querySelector('meta[name="csrf-token"]')?.content;
        if (csrf) {
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = csrf;
            form.appendChild(csrfInput);
        }

        const nameInput = document.createElement('input');
        nameInput.type = 'hidden';
        nameInput.name = 'name';
        nameInput.value = result.value;
        form.appendChild(nameInput);

        document.body.appendChild(form);
        form.submit();
    });
}

function openEditModal(stageId, machineId, currentName) {
    Swal.fire({
        title: 'Edit Mesin',
        input: 'text',
        inputValue: currentName,
        inputLabel: 'Nama Mesin',
        showCancelButton: true,
        confirmButtonText: 'Simpan Perubahan',
        preConfirm: (value) => {
            const name = (value || '').trim();
            if (!name) {
                Swal.showValidationMessage('Nama mesin wajib diisi');
                return false;
            }
            return name;
        }
    }).then((result) => {
        if (!result.isConfirmed) return;

        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '/list-machine/stages/' + stageId + '/machines/' + machineId;

        const csrf = document.querySelector('meta[name="csrf-token"]')?.content;
        if (csrf) {
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = csrf;
            form.appendChild(csrfInput);
        }

        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'PUT';
        form.appendChild(methodInput);

        const nameInput = document.createElement('input');
        nameInput.type = 'hidden';
        nameInput.name = 'name';
        nameInput.value = result.value;
        form.appendChild(nameInput);

        document.body.appendChild(form);
        form.submit();
    });
}
</script>
@endpush
