<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>E-Template Konimex</title>
    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700&amp;display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    {{-- Theme and Settings Initialization (runs before render to prevent flash) --}}
    <script>
        (function() {
            const SETTINGS_KEY = 'eTemplateSettings';
            const stored = localStorage.getItem(SETTINGS_KEY);
            const settings = stored ? JSON.parse(stored) : { theme: 'light', sidebarCollapsed: false };
            
            // Apply theme immediately
            if (settings.theme === 'dark') {
                document.documentElement.classList.remove('light');
                document.documentElement.classList.add('dark');
            }
        })();
    </script>
    
    {{-- Sidebar Collapse Styles --}}
    <style>
        .sidebar-container {
            transition: width 0.3s ease;
        }
        
        .sidebar-container.sidebar-collapsed {
            width: 4.5rem !important;
        }
        
        .sidebar-container.sidebar-collapsed .sidebar-text {
            display: none !important;
        }
        
        .sidebar-container.sidebar-collapsed .sidebar-submenu {
            display: none !important;
        }
        
        .sidebar-container.sidebar-collapsed .sidebar-collapse-btn .collapse-icon {
            transform: rotate(180deg);
        }
        
        .sidebar-container.sidebar-collapsed details[open] {
            /* Close details when collapsed */
        }
        
        .sidebar-container.sidebar-collapsed details > summary > .flex {
            justify-content: center;
        }
        
        .sidebar-container.sidebar-collapsed a,
        .sidebar-container.sidebar-collapsed summary {
            justify-content: center;
        }
        
        .sidebar-container.sidebar-collapsed .p-4 {
            padding-left: 0.5rem;
            padding-right: 0.5rem;
        }
        
        .collapse-icon {
            transition: transform 0.3s ease;
        }
    </style>
</head>
<body class="bg-background-light dark:bg-background-dark text-[#0d121b] dark:text-white font-display overflow-hidden">
    <div class="flex h-screen w-full">
        <x-sidebar />
        <main class="flex-1 flex flex-col min-w-0 bg-background-light dark:bg-background-dark overflow-hidden">
            <x-header :breadcrumb="$breadcrumb ?? null" :title="$title ?? null" />
            <div class="flex-1 overflow-y-auto p-8">
                @yield('content')
            </div>
        </main>
    </div>
    
    {{-- Global Settings Handler --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const SETTINGS_KEY = 'eTemplateSettings';
            
            function getSettings() {
                const stored = localStorage.getItem(SETTINGS_KEY);
                return stored ? JSON.parse(stored) : {
                    theme: 'light',
                    sidebarCollapsed: false,
                    defaultJenisSediaan: ''
                };
            }
            
            function saveSettings(settings) {
                localStorage.setItem(SETTINGS_KEY, JSON.stringify(settings));
            }
            
            // Apply sidebar collapsed state
            const settings = getSettings();
            const sidebar = document.querySelector('.sidebar-container');
            
            if (sidebar && settings.sidebarCollapsed) {
                sidebar.classList.add('sidebar-collapsed');
            }
            
            // Sidebar collapse toggle button handler
            const collapseBtn = document.getElementById('sidebarCollapseBtn');
            if (collapseBtn) {
                collapseBtn.addEventListener('click', function() {
                    const currentSettings = getSettings();
                    currentSettings.sidebarCollapsed = !currentSettings.sidebarCollapsed;
                    saveSettings(currentSettings);
                    
                    if (currentSettings.sidebarCollapsed) {
                        sidebar.classList.add('sidebar-collapsed');
                    } else {
                        sidebar.classList.remove('sidebar-collapsed');
                    }
                });
            }
        });
    </script>
    
    @stack('scripts')

    {{-- SweetAlert2 for beautiful popups --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>