import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: "class",
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    safelist: [
        // Safelist untuk warna dinamis di drafts.blade.php
        'bg-red-50', 'bg-red-600', 'bg-red-900/20',
        'bg-blue-50', 'bg-blue-600', 'bg-blue-900/20',
        'bg-emerald-50', 'bg-emerald-600', 'bg-emerald-900/20',
        'bg-purple-50', 'bg-purple-600', 'bg-purple-900/20',
        'bg-amber-50', 'bg-amber-500', 'bg-amber-900/20',
        'bg-slate-100', 'bg-slate-500', 'bg-slate-700',
        'text-red-400', 'text-red-500', 'text-red-600',
        'text-blue-400', 'text-blue-500', 'text-blue-600',
        'text-emerald-600',
        'text-purple-600',
        'text-amber-600',
        'text-slate-600',
        'border-red-200', 'border-red-800/40',
        'border-blue-200', 'border-blue-800/40',
        'border-emerald-200', 'border-emerald-800/40',
        'border-purple-200', 'border-purple-800/40',
        'border-amber-200', 'border-amber-800/40',
        'border-slate-200', 'border-slate-600',
        'ring-red-500/20',
        'ring-blue-500/20',
        'ring-emerald-500/20',
        'ring-purple-500/20',
        'ring-amber-500/20',
        'ring-slate-500/20',
    ],
    theme: {
        extend: {
            colors: {
                "primary": "#ef4444",
                "background-light": "#f6f6f8",
                "background-dark": "#101622",
            },
            fontFamily: {
                "display": ["Manrope", "sans-serif"],
                sans: ['Manrope', ...defaultTheme.fontFamily.sans],
            },
            borderRadius: {
                "DEFAULT": "0.25rem",
                "lg": "0.5rem",
                "xl": "0.75rem",
                "full": "9999px"
            },
        },
    },
    plugins: [],
};
