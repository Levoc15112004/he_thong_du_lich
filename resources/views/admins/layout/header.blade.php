<!-- TOPBAR / HEADER -->
<div
    class="fixed top-0 left-0 right-0 z-50 bg-white shadow-md
            h-16 sm:h-18 lg:h-20
            flex items-center justify-between
            px-3 sm:px-4 lg:px-6">

    <!-- LEFT: Logo + Mobile Menu -->
    <div class="flex items-center gap-3 sm:gap-4">

        <!-- Mobile Sidebar Button -->
        <button id="openSidebarBtn" class="lg:hidden text-2xl sm:text-3xl text-slate-700 focus:outline-none">
            <i class="fa-solid fa-bars"></i>
        </button>

        <!-- Logo -->
        <a href="{{ route('admin.home') }}">
            <img src="{{ url('assest/img/logo.png') }}" class="w-24 sm:w-28 lg:w-32 object-contain" alt="Logo">
        </a>
    </div>

    <!-- RIGHT: User -->
    <div class="relative">

        <!-- User Button -->
        <button id="userMenuBtn" class="flex items-center gap-2 sm:gap-3
                       focus:outline-none">

            <img src="{{ url('assest/img/admin.jpg') }}" class="w-9 h-9 sm:w-10 sm:h-10 rounded-full border shadow-sm">

            <!-- Ẩn text trên mobile -->
            <span class="hidden sm:block font-medium text-slate-700">
                Admin
            </span>
        </button>

        <!-- Dropdown -->
        <ul id="userDropdown"
            class="absolute right-0 mt-2 w-40
                   bg-white shadow-lg rounded-lg py-2
                   opacity-0 invisible
                   transition-all duration-150">

            <li>
                <a href="{{ route('logout.admin') }}" class="block px-4 py-2 text-slate-700 hover:bg-slate-50">
                    Đăng xuất
                </a>
            </li>
        </ul>

    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {

        const userBtn = document.getElementById('userMenuBtn');
        const menu = document.getElementById('userDropdown');

        if (userBtn && menu) {
            userBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                menu.classList.toggle('opacity-100');
                menu.classList.toggle('visible');
                menu.classList.toggle('opacity-0');
                menu.classList.toggle('invisible');
            });

            document.addEventListener('click', function() {
                menu.classList.add('opacity-0', 'invisible');
                menu.classList.remove('opacity-100', 'visible');
            });
        }

    });
</script>

