@extends('layouts.app')

@section('content')
    @php
        
        $segmentConfig = [
            'Ekstraksi' => ['icon' => 'science',                                  'color' => 'blue',     'accent' => 'bg-blue-600',     'light' => 'bg-blue-50 dark:bg-blue-900/20',       'text' => 'text-blue-500 dark:text-blue-400',      'border' => 'border-blue-200 dark:border-blue-800/40',      'ring' => 'ring-blue-500/20'],
            'Evaporasi' => ['icon' => 'humidity_low',                             'color' => 'cyan',    'accent' => 'bg-cyan-600',    'light' => 'bg-cyan-50 dark:bg-cyan-900/20',     'text' => 'text-cyan-500 dark:text-cyan-400',    'border' => 'border-cyan-200 dark:border-cyan-800/40',    'ring' => 'ring-cyan-500/20'],
            'Granulasi'  => ['icon' => 'grain',                                   'color' => 'emerald', 'accent' => 'bg-emerald-600', 'light' => 'bg-emerald-50 dark:bg-emerald-900/20','text' => 'text-emerald-600',                    'border' => 'border-emerald-200 dark:border-emerald-800/40','ring' => 'ring-emerald-500/20'],
            'Sterilisasi'  => ['icon' => 'health_and_safety',                                   'color' => 'red',   'accent' => 'bg-red-600',   'light' => 'bg-red-50 dark:bg-red-900/20',   'text' => 'text-red-600',                      'border' => 'border-red-200 dark:border-red-800/40',  'ring' => 'ring-red-500/20'],
            'Pengecilan Ukuran Granul'    => ['icon' => 'compress',               'color' => 'orange',   'accent' => 'bg-orange-500',   'light' => 'bg-orange-100 dark:bg-orange-700',     'text' => 'text-orange-600',                      'border' => 'border-orange-200 dark:border-orange-600',     'ring' => 'ring-orange-500/20'],
        ];
       
    @endphp

    <div class="flex flex-col gap-6">

        {{-- Page Header --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900 dark:text-white">List Machine</h1>

            </div>
            <a href="{{ route('template-summary.index') }}"
                class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-800 hover:bg-slate-50 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 font-medium transition-all text-sm self-start md:self-auto">
                <span class="material-symbols-outlined text-[18px]">add</span>
                Tambah Tahapan Pengolahan
            </a>
        </div>

        {{-- Global Search --}}
        <div class="relative">
            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 material-symbols-outlined text-[20px]">search</span>
            <input type="text" id="draftSearch" placeholder="Cari nama mesin..."
                class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition-all text-sm shadow-sm">
        </div>

        @if (!empty($draftsBySegment))

            {{-- Segment Quick-Nav (Pill Buttons) --}}
            <div class="flex flex-wrap gap-3" id="segmentNav">
                @foreach ($draftsBySegment as $segKey => $segment)
                    @php $sc = $segmentConfig[$segKey] ?? $segmentConfig['other']; @endphp
                    <button type="button"
                        class="seg-nav-pill inline-flex items-center gap-2.5 px-5 py-2.5 rounded-full transition-all text-sm font-bold text-white {{ $sc['accent'] }} hover:opacity-90 shadow-sm"
                        data-target="{{ $segKey }}"
                        data-color="{{ $sc['color'] }}"
                        onclick="scrollToSegment('{{ $segKey }}')">
                        <span class="material-symbols-outlined text-[18px]">{{ $sc['icon'] }}</span>
                        {{ $segment['label'] }}
                        <span class="seg-nav-count inline-flex items-center justify-center w-6 h-6 rounded-full bg-white/25 text-white text-[11px] font-bold shrink-0">
                            {{ $segment['drafts']->count() }}
                        </span>
                    </button>
                @endforeach
            </div>

            
                <div id="seg-{{ $segKey }}" class="segment-block rounded-2xl overflow-hidden scroll-mt-6 shadow-lg">

                    {{-- Segment Header --}}
                    <div class="{{ $sc['accent'] }} px-5 py-3 flex items-center justify-between gap-3 select-none segment-header" data-segment="{{ $segKey }}">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-white text-[20px]">{{ $sc['icon'] }}</span>
                            <span class="font-bold text-white text-sm tracking-wide">{{ $segment['label'] }}</span>
                            <span class="px-2.5 py-0.5 rounded-md bg-white/25 text-white text-[11px] font-bold segment-total-count">{{ $segment['drafts']->count() }} draft</span>
                        </div>
                           
                            {{-- Collapse toggle --}}
                            <button type="button" onclick="event.stopPropagation(); toggleSegment('{{ $segKey }}')"
                                class="seg-toggle-btn flex items-center justify-center w-7 h-7 rounded-full bg-white/15 hover:bg-white/25 transition-all shrink-0" title="Tampilkan/Sembunyikan">
                                <span class="material-symbols-outlined text-white text-[18px] seg-toggle-icon transition-transform duration-300">expand_more</span>
                            </button>
                        </div>
                    </div>
            @endforeach

       

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

    // Scroll to segment — toggle collapse if already expanded
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
        setActivePill(segKey);
    }

    // ── Highlight active segment in nav on scroll ────────────────────
    const colorMap = {
        'red':     '#dc2626',
        'blue':    '#2563eb',
        'emerald': '#059669',
        'violet':  '#7c3aed',
        'amber':   '#d97706',
        'slate':   '#475569',
    };

    function setActivePill(segKey) {
        document.querySelectorAll('.seg-nav-pill').forEach(b => {
            b.style.boxShadow = '';
            b.style.transform = '';
        });
        const activePill = document.querySelector(`.seg-nav-pill[data-target="${segKey}"]`);
        if (activePill) {
            const hex = colorMap[activePill.dataset.color] || '#dc2626';
            activePill.style.boxShadow = `0 0 0 3px rgba(255,255,255,0.7), 0 0 0 5px ${hex}`;
            activePill.style.transform = 'scale(1.05)';
        }
    }
    // Observer dihapus — active state hanya via klik pill

    // Klik di luar pill → clear semua active state
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.seg-nav-pill')) {
            document.querySelectorAll('.seg-nav-pill').forEach(b => {
                b.style.boxShadow = '';
                b.style.transform = '';
            });
        }
    });
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
