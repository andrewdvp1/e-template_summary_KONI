@props(['items'])

<div class="flex flex-wrap items-center gap-2 text-sm font-medium">
    @foreach($items as $label => $link)
        @if($loop->last)
            <span class="text-red-600 font-semibold">{{ $label }}</span>
        @elseif($loop->first)
            <span class="text-slate-500">{{ $label }}</span>
            <span class="material-symbols-outlined text-slate-400 text-[18px]">chevron_right</span>
        @else
            <a class="text-slate-500 hover:text-red-600 transition-colors" href="{{ $link }}">{{ $label }}</a>
            <span class="material-symbols-outlined text-slate-400 text-[18px]">chevron_right</span>
        @endif
    @endforeach
</div>
