<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travel Go - Quản trị</title>

    <script>
        tailwind = {
            config: {
                darkMode: 'class',
            }
        };
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/feather-icons"></script>

    <!-- Icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">

    <!-- ChartJS -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="icon" type="image/svg+xml" href="{{ asset('assets/img/logo_title.svg') }}">

    <style>
        /* Admin Dark Mode Support */
        html.dark {
            color-scheme: dark;
        }
        html.dark body {
            background-color: #0b1120 !important;
            color: #f1f5f9 !important;
        }
        html.dark .bg-white {
            background-color: #1e293b !important;
            color: #f1f5f9;
        }
        html.dark .bg-slate-50, html.dark .bg-gray-50 {
            background-color: #0f172a !important;
        }
        html.dark .bg-slate-100, html.dark .bg-gray-100 {
            background-color: #334155 !important;
            color: #f1f5f9;
        }
        html.dark .text-slate-900, html.dark .text-slate-800, html.dark .text-gray-900, html.dark .text-gray-800 {
            color: #f8fafc !important;
        }
        html.dark .text-slate-700, html.dark .text-gray-700, html.dark .text-slate-600 {
            color: #cbd5e1 !important;
        }
        html.dark .text-slate-500, html.dark .text-gray-500 {
            color: #94a3b8 !important;
        }
        html.dark .border-slate-100, html.dark .border-slate-200, html.dark .border-gray-200, html.dark .border-gray-100 {
            border-color: #334155 !important;
        }
        html.dark #sidebar {
            background-color: #0f172a !important;
            border-color: #334155 !important;
        }
        html.dark input:not([type="checkbox"]):not([type="radio"]), 
        html.dark select, 
        html.dark textarea {
            background-color: #1e293b !important;
            color: #f8fafc !important;
            border-color: #475569 !important;
        }
        html.dark table thead tr {
            background-color: #1e293b !important;
            color: #e2e8f0 !important;
        }
        html.dark table tbody tr {
            border-color: #334155 !important;
        }
        html.dark table tbody tr:hover {
            background-color: rgba(51, 65, 85, 0.4) !important;
        }
    </style>
</head>

<body class="bg-slate-50 dark:bg-slate-950 text-slate-800 dark:text-slate-100 transition-colors duration-200">

    @include('admins.layout.header')
    <div class="flex">

        <!-- SIDEBAR -->
        <div id="sidebar"
            class="fixed top-0 left-0 w-64 h-screen bg-white dark:bg-slate-900 shadow-2xl z-40
        -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out border-r border-slate-200 dark:border-slate-800">

            <div class="h-full overflow-y-auto sidebar-scroll">
                @include('admins.layout.menu')
            </div>
        </div>

        <!-- Overlay mobile -->
        <div id="overlay" class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden lg:hidden z-30 transition-opacity duration-300"></div>

        <!-- CONTENT -->
        <div class="flex-1 pt-20 lg:pt-24 p-4 sm:p-6 text-[13px] transition-all duration-300
                lg:pl-64">
            <div class="max-w-[1600px] mx-auto">
                @yield('home')
            </div>
        </div>

    </div>

    <!-- Floating Theme Switcher Button -->
    <button type="button" class="theme-toggle-btn fixed bottom-6 right-6 z-50 w-11 h-11 rounded-full bg-white dark:bg-slate-800 text-slate-700 dark:text-amber-400 shadow-xl border border-slate-200 dark:border-slate-700 flex items-center justify-center transition-all duration-300 hover:scale-110 active:scale-95 group focus:outline-none" title="Chuyển đổi giao diện Sáng / Tối" aria-label="Toggle Theme">
        <i class="fa-solid fa-moon text-base dark:hidden group-hover:rotate-12 transition-transform"></i>
        <i class="fa-solid fa-sun text-base hidden dark:inline-block text-amber-400 group-hover:rotate-45 transition-transform"></i>
    </button>

</body>

<script>
    const btn = document.getElementById("openSidebarBtn");
    const sidebar = document.getElementById("sidebar");
    const overlay = document.getElementById("overlay");

    btn?.addEventListener("click", () => {
        sidebar.classList.remove("-translate-x-full");
        overlay.classList.remove("hidden");
    });

    overlay?.addEventListener("click", () => {
        sidebar.classList.add("-translate-x-full");
        overlay.classList.add("hidden");
    });

    // Theme toggle
    function toggleTheme() {
        const isDark = document.documentElement.classList.toggle('dark');
        localStorage.setItem('theme', isDark ? 'dark' : 'light');
    }
    document.querySelectorAll('.theme-toggle-btn').forEach(btn => {
        btn.addEventListener('click', toggleTheme);
    });
</script>

</html>
