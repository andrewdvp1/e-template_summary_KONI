@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto flex flex-col gap-8">
        {{-- Settings Sections --}}
        <div class="flex flex-col gap-6">

            {{-- Appearance Section --}}
            <div
                class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-700/50">
                    <h2 class="text-lg font-bold text-slate-800 dark:text-white flex items-center gap-2">
                        <span class="material-symbols-outlined text-xl text-slate-500">dark_mode</span>
                        Tampilan
                    </h2>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Atur tema dan tampilan aplikasi</p>
                </div>
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div class="flex flex-col">
                            <span class="text-sm font-semibold text-slate-700 dark:text-slate-300">Mode Gelap</span>
                            <span class="text-xs text-slate-500 dark:text-slate-400">Aktifkan tampilan gelap untuk
                                mengurangi silau</span>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" id="darkModeToggle" class="sr-only peer">
                            <div
                                class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-red-300 dark:peer-focus:ring-red-800 rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-slate-600 peer-checked:bg-red-600">
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            {{-- Layout Section --}}
            <div
                class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-700/50">
                    <h2 class="text-lg font-bold text-slate-800 dark:text-white flex items-center gap-2">
                        <span class="material-symbols-outlined text-xl text-slate-500">view_sidebar</span>
                        Layout
                    </h2>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Atur tata letak dan navigasi</p>
                </div>
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div class="flex flex-col">
                            <span class="text-sm font-semibold text-slate-700 dark:text-slate-300">Sidebar Kompak</span>
                            <span class="text-xs text-slate-500 dark:text-slate-400">Kecilkan sidebar untuk ruang kerja
                                lebih luas</span>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" id="sidebarCollapseToggle" class="sr-only peer">
                            <div
                                class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-red-300 dark:peer-focus:ring-red-800 rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-slate-600 peer-checked:bg-red-600">
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            {{-- Database Info Section --}}
            <div
                class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-700/50">
                    <h2 class="text-lg font-bold text-slate-800 dark:text-white flex items-center gap-2">
                        <span class="material-symbols-outlined text-xl text-slate-500">database</span>
                        Informasi Database
                    </h2>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Status koneksi database</p>
                </div>
                <div class="p-6" id="databaseInfoContainer">
                    <div class="flex items-center gap-3 text-slate-500">
                        <span class="material-symbols-outlined animate-spin">progress_activity</span>
                        <span class="text-sm">Memeriksa koneksi...</span>
                    </div>
                </div>
            </div>

            {{-- About Section --}}
            <div
                class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-700/50">
                    <h2 class="text-lg font-bold text-slate-800 dark:text-white flex items-center gap-2">
                        <span class="material-symbols-outlined text-xl text-slate-500">info</span>
                        Tentang Aplikasi
                    </h2>
                </div>
                <div class="p-6">
                    <div class="flex items-start gap-4">
                        <img src="{{ asset('images/k_logo.png') }}" alt="Logo"
                            class="size-16 rounded-xl object-contain bg-slate-50 dark:bg-slate-700 p-2" />
                        <div class="flex flex-col gap-2">
                            <div>
                                <h3 class="text-lg font-bold text-red-600">E-Template</h3>
                                <p class="text-sm text-slate-500 dark:text-slate-400">Report Generator System</p>
                            </div>
                            <div class="flex flex-col gap-1 text-sm">
                                <div class="flex items-center gap-2">
                                    <span class="text-slate-500 dark:text-slate-400">Versi:</span>
                                    <span class="font-medium text-slate-700 dark:text-slate-300">{{ $appVersion }}</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="text-slate-500 dark:text-slate-400">Dibuat oleh:</span>
                                    <span class="font-medium text-slate-700 dark:text-slate-300">Tim Validasi Konimex</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="text-slate-500 dark:text-slate-400">Tahun:</span>
                                    <span class="font-medium text-slate-700 dark:text-slate-300">2026</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 pt-4 border-t border-slate-100 dark:border-slate-700/50">
                        <p class="text-xs text-slate-400 dark:text-slate-500">
                            © 2026 PT Konimex Pharmaceutical Laboratories. All rights reserved.
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Settings management
        const SETTINGS_KEY = 'eTemplateSettings';

        // Get settings from localStorage
        function getSettings() {
            const stored = localStorage.getItem(SETTINGS_KEY);
            return stored ? JSON.parse(stored) : {
                theme: 'light',
                sidebarCollapsed: false,
            };
        }

        // Save settings to localStorage
        function saveSettings(settings) {
            localStorage.setItem(SETTINGS_KEY, JSON.stringify(settings));
        }

        // Initialize settings on page load
        document.addEventListener('DOMContentLoaded', function() {
            const settings = getSettings();

            // Initialize Dark Mode Toggle
            const darkModeToggle = document.getElementById('darkModeToggle');
            darkModeToggle.checked = settings.theme === 'dark';
            darkModeToggle.addEventListener('change', function() {
                settings.theme = this.checked ? 'dark' : 'light';
                saveSettings(settings);
                applyTheme(settings.theme);
            });

            // Initialize Sidebar Collapse Toggle
            const sidebarCollapseToggle = document.getElementById('sidebarCollapseToggle');
            sidebarCollapseToggle.checked = settings.sidebarCollapsed;
            sidebarCollapseToggle.addEventListener('change', function() {
                settings.sidebarCollapsed = this.checked;
                saveSettings(settings);
                applySidebarState(settings.sidebarCollapsed);
            });

            // Fetch database status
            fetchDatabaseStatus();
        });

        // Apply theme
        function applyTheme(theme) {
            if (theme === 'dark') {
                document.documentElement.classList.remove('light');
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
                document.documentElement.classList.add('light');
            }
        }

        // Apply sidebar state
        function applySidebarState(collapsed) {
            const sidebar = document.querySelector('aside');
            if (sidebar) {
                if (collapsed) {
                    sidebar.classList.add('sidebar-collapsed');
                } else {
                    sidebar.classList.remove('sidebar-collapsed');
                }
            }
        }

        // Fetch database status
        async function fetchDatabaseStatus() {
            const container = document.getElementById('databaseInfoContainer');
            try {
                const response = await fetch('/settings/database-status');
                const data = await response.json();

                if (data.connected) {
                    container.innerHTML = `
                    <div class="flex flex-col gap-3">
                        <div class="flex items-center gap-2">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400">
                                <span class="size-1.5 rounded-full bg-green-500"></span>
                                Terhubung
                            </span>
                        </div>
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div class="flex flex-col">
                                <span class="text-slate-500 dark:text-slate-400">Database</span>
                                <span class="font-medium text-slate-700 dark:text-slate-300">${data.database}</span>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-slate-500 dark:text-slate-400">Host</span>
                                <span class="font-medium text-slate-700 dark:text-slate-300">${data.host}</span>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-slate-500 dark:text-slate-400">Driver</span>
                                <span class="font-medium text-slate-700 dark:text-slate-300">${data.driver}</span>
                            </div>
                        </div>
                    </div>
                `;
                } else {
                    container.innerHTML = `
                    <div class="flex items-center gap-2">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400">
                            <span class="size-1.5 rounded-full bg-red-500"></span>
                            Tidak Terhubung
                        </span>
                        <span class="text-sm text-slate-500">${data.error || 'Gagal terhubung ke database'}</span>
                    </div>
                `;
                }
            } catch (error) {
                container.innerHTML = `
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400">
                        <span class="size-1.5 rounded-full bg-yellow-500"></span>
                        Error
                    </span>
                    <span class="text-sm text-slate-500">Gagal memeriksa status database</span>
                </div>
            `;
            }
        }
    </script>
@endpush