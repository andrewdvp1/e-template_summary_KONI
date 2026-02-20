<aside
    class="sidebar-container w-58 bg-white dark:bg-[#1a2233] border-r border-[#e7ebf3] dark:border-gray-800 flex flex-col h-full shrink-0 transition-all duration-300">
    <div class="p-4 pb-2">
        <div class="flex items-center justify-between mb-8">
            <div class="flex items-center gap-2">
                <img src="{{ asset('images/k_logo.png') }}" alt="Logo" class="ms-2 size-9 rounded-lg object-contain" />
                <div class="flex flex-col sidebar-text">
                    <h1 class="text-xl font-bold leading-tight tracking-[-0.015em] text-red-600">E-Template</h1>
                </div>
            </div>
            <button type="button" id="sidebarCollapseBtn"
                class="flex items-center sidebar-collapse-btn p-1.5 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 dark:hover:bg-slate-700 dark:hover:text-slate-300 transition-colors"
                title="Toggle Sidebar">
                <span class="material-symbols-outlined text-[18px] collapse-icon">chevron_left</span>
            </button>
        </div>
        <div class="flex flex-col gap-1">
            <a class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ request()->is('/') ? 'bg-red-50 text-red-600 font-medium' : 'text-[#64748b] hover:bg-gray-50 hover:text-[#0f172a]' }}"
                href="/" title="Dashboard">
                <span
                    class="material-symbols-outlined text-[20px] {{ request()->is('/') ? 'material-symbols-filled' : '' }}">dashboard</span>
                <p class="text-sm sidebar-text {{ request()->is('/') ? 'font-medium' : '' }}">Dashboard</p>
            </a>

            <details class="group" {{ request()->routeIs('template-summary.*') ? 'open' : '' }}>
                <summary
                    class="list-none w-full flex items-center justify-between gap-3 px-3 py-2 rounded-lg transition-colors cursor-pointer {{ request()->routeIs('template-summary.*') ? 'bg-red-50 text-red-600' : 'text-[#64748b] hover:bg-gray-50 hover:text-[#0f172a]' }}"
                    title="Laporan">
                    <div class="flex items-center gap-3">
                        <span
                            class="material-symbols-outlined text-[20px] {{ request()->routeIs('template-summary.*') ? 'material-symbols-filled' : '' }}">description</span>
                        <p class="text-sm font-medium sidebar-text">Summary</p>
                    </div>
                    <span
                        class="material-symbols-outlined text-[18px] transition-transform duration-200 group-open:rotate-180 sidebar-text">expand_more</span>
                </summary>
                <div
                    class="pl-4 flex flex-col gap-1 mt-1 border-l-2 border-slate-100 dark:border-slate-800 ml-5 sidebar-submenu">
                    @php
                        $isTemplateIndex = request()->routeIs('template-summary.index');
                        $isTemplateDrafts = request()->routeIs('template-summary.drafts');
                        $isTemplateEditor = request()->routeIs('template-summary.*') && !$isTemplateIndex && !$isTemplateDrafts;
                        $isDraftEditor = $isTemplateEditor && request()->filled('draft');
                        $isNewEditor = $isTemplateEditor && !request()->filled('draft');
                    @endphp
                    <a class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ ($isTemplateIndex || $isNewEditor) ? 'text-red-600 bg-red-50' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50' }}"
                        href="{{ route('template-summary.index') }}">
                        <span
                            class="w-1.5 h-1.5 rounded-full {{ ($isTemplateIndex || $isNewEditor) ? 'bg-red-600' : 'bg-slate-300' }}"></span>
                        <span class="sidebar-text">Buat Baru</span>
                    </a>
                    <a class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ ($isTemplateDrafts || $isDraftEditor) ? 'text-red-600 bg-red-50' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50' }}"
                        href="{{ route('template-summary.drafts') }}">
                        <span
                            class="w-1.5 h-1.5 rounded-full {{ ($isTemplateDrafts || $isDraftEditor) ? 'bg-red-600' : 'bg-slate-300' }}"></span>
                        <span class="sidebar-text">Draft Summary</span>
                    </a>
                </div>
            </details>

            <a class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('settings.*') ? 'bg-red-50 text-red-600 font-medium' : 'text-[#64748b] hover:bg-gray-50 hover:text-[#0f172a]' }}"
                href="{{ route('settings.index') }}" title="Settings">
                <span
                    class="material-symbols-outlined text-[20px] {{ request()->routeIs('settings.*') ? 'material-symbols-filled' : '' }}">settings</span>
                <p class="text-sm font-medium sidebar-text">Settings</p>
            </a>
        </div>
    </div>
    <div class="mt-auto p-4 border-t border-[#e7ebf3] dark:border-gray-800">
        <div class="flex items-center justify-between gap-2 px-1 pt-1">
            <div class="flex items-center gap-3 min-w-0 sidebar-text">
                <div class="size-9 rounded-full bg-cover bg-center border-2 border-white shadow-sm ring-1 ring-gray-100 shrink-0"
                    style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuAvj7R6Yg4ZjOmjzG7rM6PBFuwqkNLfIvyLKc5QbHf5Ubm0gh_MUhCgNoAIdGYJlw4ou50Ix6BDxjZRkkR2pbrBbuI_2uqvphJbiGvp23yhfEZ5CLzMhNpnoJIs7nCyuodK5h7xI889siS-j0pvF06iuFdAkYxcowfTMap2CsKfEy5pWwKnAv1M2czNYZfvgwnslsznw9Nkx4bnX4BEYKrlUfbmSf0GmDjjJXPJ0XgowsEVaAIm_n4f9VNnw2juMYmsZzkp4B9nil4');">
                </div>
                <div class="flex flex-col min-w-0">
                    <p class="text-sm font-bold text-[#0f172a] dark:text-white leading-none truncate">Admin</p>
                    <p class="text-xs text-gray-500 mt-1 leading-none truncate">Validation Officer</p>
                </div>
            </div>
            <button
                class="flex items-center justify-center text-gray-400 hover:text-red-600 cursor-pointer dark:text-gray-500 dark:hover:text-red-400 p-2 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors shrink-0"
                title="Log Out" style="cursor: pointer;">
                <span class="material-symbols-outlined text-[20px]">logout</span>
            </button>
        </div>
    </div>
</aside>
