<!-- TOPBAR / HEADER -->
<div
    class="fixed top-0 left-0 right-0 z-50 bg-white dark:bg-slate-900 shadow-md border-b border-slate-200 dark:border-slate-800
            h-16 sm:h-18 lg:h-20
            flex items-center justify-between
            px-3 sm:px-4 lg:px-6 transition-colors duration-200">

    <!-- LEFT: Logo + Mobile Menu -->
    <div class="flex items-center gap-3 sm:gap-4">

        <!-- Mobile Sidebar Button -->
        <button id="openSidebarBtn" class="lg:hidden text-2xl sm:text-3xl text-slate-700 dark:text-slate-200 focus:outline-none">
            <i class="fa-solid fa-bars"></i>
        </button>

        <!-- Logo -->
        <a href="{{ route('admin.home') }}" class="flex items-center gap-2.5 group">
            <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-gradient-to-tr from-emerald-500 to-teal-500 flex items-center justify-center text-white shadow-md shadow-emerald-500/20 group-hover:rotate-6 transition-transform">
                <i class="fa-solid fa-compass text-lg sm:text-xl"></i>
            </div>
            <div class="flex flex-col">
                <span class="text-lg sm:text-xl font-black tracking-tight text-slate-800 dark:text-white leading-tight">
                    Wander<span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-500 to-teal-400">Admin</span>
                </span>
                <span class="text-[9px] uppercase tracking-wider text-slate-400 font-bold -mt-0.5">Control Panel</span>
            </div>
        </a>
    </div>

    <!-- RIGHT: Theme Switcher & User -->
    <div class="flex items-center gap-2 sm:gap-4">

        <!-- Dark / Light Mode Toggle Button -->
        <button type="button" class="theme-toggle-btn w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-amber-400 hover:bg-slate-200 dark:hover:bg-slate-700 flex items-center justify-center transition-all cursor-pointer shadow-sm" title="Chuyển đổi giao diện Sáng / Tối" aria-label="Toggle Dark Mode">
            <i class="fa-solid fa-moon text-base dark:hidden pointer-events-none"></i>
            <i class="fa-solid fa-sun text-base hidden dark:inline-block pointer-events-none text-amber-400"></i>
        </button>

        <!-- User Dropdown Menu -->
        <div class="relative">
            <!-- User Button -->
            <button id="userMenuBtn" class="flex items-center gap-2 sm:gap-3 p-1 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors focus:outline-none">

                <img src="{{ Auth::user()->avatar_url ?? 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name ?? 'Admin').'&background=10b981&color=fff&bold=true' }}" 
                     onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'Admin') }}&background=10b981&color=fff&bold=true';"
                     class="w-9 h-9 sm:w-10 sm:h-10 rounded-full border border-slate-200 dark:border-slate-700 shadow-sm object-cover"
                     alt="Admin Avatar">

                <!-- Ẩn text trên mobile -->
                <span class="hidden sm:block font-bold text-slate-700 dark:text-slate-200 text-sm">
                    {{ Auth::user()->name ?? 'Admin' }}
                </span>
                <i class="fa-solid fa-chevron-down text-xs text-slate-400 hidden sm:block"></i>
            </button>

            <!-- Dropdown -->
            <ul id="userDropdown"
                class="absolute right-0 mt-2 w-48
                       bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700 shadow-xl rounded-2xl py-2
                       opacity-0 invisible
                       transition-all duration-150 z-50">

                <li class="px-4 py-2 border-b border-slate-100 dark:border-slate-700">
                    <p class="text-xs text-slate-400">Đăng nhập với tư cách</p>
                    <p class="text-sm font-bold text-slate-800 dark:text-white truncate">{{ Auth::user()->email ?? 'admin@wandervibe.com' }}</p>
                </li>
                <li>
                    <a href="{{ route('user.home') }}" target="_blank" class="flex items-center gap-2 px-4 py-2.5 text-sm text-slate-700 dark:text-slate-300 hover:bg-emerald-50 dark:hover:bg-slate-700 hover:text-emerald-600 transition-colors">
                        <i class="fa-solid fa-globe text-xs text-slate-400"></i> Xem trang chủ
                    </a>
                </li>
                <li>
                    <a href="{{ route('logout.admin') }}" class="flex items-center gap-2 px-4 py-2.5 text-sm text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-950/30 transition-colors">
                        <i class="fa-solid fa-arrow-right-from-bracket text-xs"></i> Đăng xuất
                    </a>
                </li>
            </ul>
        </div>

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

