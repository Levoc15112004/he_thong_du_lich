<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travel Go</title>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/feather-icons"></script>

    <!-- Icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assest/css/main.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    <!-- ChartJS -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="icon" type="image/png" sizes="64x64" href="{{ asset('assest/img/logo_title.svg') }}">

</head>

<body class="bg-slate-50">

    @include('admins.layout.header')
    <div class="flex">

        <!-- SIDEBAR -->
        <div id="sidebar"
            class="fixed top-0 left-0 w-64 h-screen bg-white shadow-2xl z-40
        -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out">

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
</script>

</html>
