
 <aside class="w-64 bg-surface border-r border-gray-100 flex-shrink-0 hidden md:flex flex-col shadow-card z-20 transition-all duration-300 relative">
        <!-- Logo -->
        <div class="h-20 flex items-center px-6 border-b border-gray-50">
            <i class="fa-solid fa-plane-departure text-primary text-2xl mr-2"></i>
            <span class="font-bold text-xl text-dark tracking-tight">Wander<span class="text-primary">Admin</span></span>
        </div>

        <!-- Navigation Menu -->
        <nav class="flex-1 overflow-y-auto py-6 px-4 space-y-1">
            <p class="px-3 text-xs font-bold text-gray-400 uppercase tracking-wider mb-2 mt-4 first:mt-0">Tổng Quan</p>

            <a href="{{ route('admin.home') }}" class="flex items-center px-3 py-2.5 rounded-xl font-medium transition-colors group {{ request()->routeIs('admin.home') ? 'bg-sky-50 text-primary' : 'text-gray-500 hover:bg-gray-50 hover:text-dark' }}">
                <i class="fa-solid fa-chart-pie w-6 text-center mr-2 {{ request()->routeIs('admin.home') ? '' : 'group-hover:text-primary transition-colors' }}"></i>
                Dashboard
            </a>

            <p class="px-3 text-xs font-bold text-gray-400 uppercase tracking-wider mb-2 mt-6">Quản Lý Tours</p>
            
            <a href="{{ route('categories.index') }}" class="flex items-center px-3 py-2.5 rounded-xl font-medium transition-colors group {{ request()->routeIs('categories.*') ? 'bg-sky-50 text-primary' : 'text-gray-500 hover:bg-gray-50 hover:text-dark' }}">
                <i class="fa-solid fa-list w-6 text-center mr-2 {{ request()->routeIs('admin.category.*') ? '' : 'group-hover:text-primary transition-colors' }}"></i>
                Danh mục
            </a>

            <a href="{{ route('admin.tours.index') }}" class="flex items-center px-3 py-2.5 rounded-xl font-medium transition-colors group {{ request()->routeIs('admin.tours.*') ? 'bg-sky-50 text-primary' : 'text-gray-500 hover:bg-gray-50 hover:text-dark' }}">
                <i class="fa-solid fa-map-location-dot w-6 text-center mr-2 {{ request()->routeIs('admin.tour.*') ? '' : 'group-hover:text-primary transition-colors' }}"></i>
                Tour Du lịch
            </a>
            
            <a href="{{ route('admin.tour_schedules.index') }}" class="flex items-center px-3 py-2.5 rounded-xl font-medium transition-colors group {{ request()->routeIs('admin.tour_schedules.*') ? 'bg-sky-50 text-primary' : 'text-gray-500 hover:bg-gray-50 hover:text-dark' }}">
                <i class="fa-solid fa-calendar-days w-6 text-center mr-2 {{ request()->routeIs('admin.tour_detail.*') ? '' : 'group-hover:text-primary transition-colors' }}"></i>
                Lịch trình Tour
            </a>

            <a href="{{ route('admin.attr.index') }}" class="flex items-center px-3 py-2.5 rounded-xl font-medium transition-colors group {{ request()->routeIs('admin.attr.*') ? 'bg-sky-50 text-primary' : 'text-gray-500 hover:bg-gray-50 hover:text-dark' }}">
                <i class="fa-solid fa-tags w-6 text-center mr-2 {{ request()->routeIs('admin.attr.*') ? '' : 'group-hover:text-primary transition-colors' }}"></i>
                Thuộc tính Tour
            </a>

            <p class="px-3 text-xs font-bold text-gray-400 uppercase tracking-wider mb-2 mt-6">Doanh Thu & Dịch Vụ</p>

            <a href="{{ route('admin.orders.index') }}" class="flex items-center px-3 py-2.5 rounded-xl font-medium transition-colors group justify-between {{ request()->routeIs('admin.orders.*') ? 'bg-sky-50 text-primary' : 'text-gray-500 hover:bg-gray-50 hover:text-dark' }}">
                <div class="flex items-center">
                    <i class="fa-solid fa-ticket w-6 text-center mr-2 {{ request()->routeIs('admin.order.*') ? '' : 'group-hover:text-primary transition-colors' }}"></i>
                    Đơn Đặt (Bookings)
                </div>
            </a>
            
            <a href="{{ route('admin.payments.index') }}" class="flex items-center px-3 py-2.5 rounded-xl font-medium transition-colors group {{ request()->routeIs('admin.payments.*') ? 'bg-sky-50 text-primary' : 'text-gray-500 hover:bg-gray-50 hover:text-dark' }}">
                <i class="fa-solid fa-money-bill-wave w-6 text-center mr-2 {{ request()->routeIs('admin.payment.*') ? '' : 'group-hover:text-primary transition-colors' }}"></i>
                Thanh Toán
            </a>
            
            <a href="{{ route('admin.users.index') }}" class="flex items-center px-3 py-2.5 rounded-xl font-medium transition-colors group {{ request()->routeIs('admin.users.*') ? 'bg-sky-50 text-primary' : 'text-gray-500 hover:bg-gray-50 hover:text-dark' }}">
                <i class="fa-solid fa-users w-6 text-center mr-2 {{ request()->routeIs('admin.user.*') ? '' : 'group-hover:text-primary transition-colors' }}"></i>
                Khách hàng
            </a>

            <p class="px-3 text-xs font-bold text-gray-400 uppercase tracking-wider mb-2 mt-6">Quảng Cáo & Marketing</p>
            
            <a href="{{ route('admin.vouchers.index') }}" class="flex items-center px-3 py-2.5 rounded-xl font-medium transition-colors group {{ request()->routeIs('admin.vouchers.*') ? 'bg-sky-50 text-primary' : 'text-gray-500 hover:bg-gray-50 hover:text-dark' }}">
                <i class="fa-solid fa-gift w-6 text-center mr-2 {{ request()->routeIs('admin.voucher.*') ? '' : 'group-hover:text-primary transition-colors' }}"></i>
                Voucher
            </a>

            <a href="{{ route('admin.user_vouchers.index') }}" class="flex items-center px-3 py-2.5 rounded-xl font-medium transition-colors group {{ request()->routeIs('admin.user_vouchers.*') ? 'bg-sky-50 text-primary' : 'text-gray-500 hover:bg-gray-50 hover:text-dark' }}">
                <i class="fa-solid fa-hand-holding-heart w-6 text-center mr-2 {{ request()->routeIs('admin.user_voucher.*') ? '' : 'group-hover:text-primary transition-colors' }}"></i>
                Voucher khách
            </a>

            <a href="{{ route('admin.banners.index') }}" class="flex items-center px-3 py-2.5 rounded-xl font-medium transition-colors group {{ request()->routeIs('admin.banners.*') ? 'bg-sky-50 text-primary' : 'text-gray-500 hover:bg-gray-50 hover:text-dark' }}">
                <i class="fa-solid fa-image w-6 text-center mr-2 {{ request()->routeIs('admin.banner.*') ? '' : 'group-hover:text-primary transition-colors' }}"></i>
                Banner
            </a>

            <p class="px-3 text-xs font-bold text-gray-400 uppercase tracking-wider mb-2 mt-6">Nội Dung & Hỗ Trợ</p>

            <a href="{{ route('admin.blogs.index') }}" class="flex items-center px-3 py-2.5 rounded-xl font-medium transition-colors group {{ request()->routeIs('admin.blogs.*') ? 'bg-sky-50 text-primary' : 'text-gray-500 hover:bg-gray-50 hover:text-dark' }}">
                <i class="fa-solid fa-newspaper w-6 text-center mr-2 {{ request()->routeIs('admin.blog.*') ? '' : 'group-hover:text-primary transition-colors' }}"></i>
                Bài viết / Blog
            </a>

            <a href="{{ route('admin.chat.index') }}" class="flex items-center px-3 py-2.5 rounded-xl font-medium transition-colors group {{ request()->routeIs('admin.chat.*') ? 'bg-sky-50 text-primary' : 'text-gray-500 hover:bg-gray-50 hover:text-dark' }}">
                <i class="fa-regular fa-comment-dots w-6 text-center mr-2 {{ request()->routeIs('admin.chat.*') ? '' : 'group-hover:text-primary transition-colors' }}"></i>
                Hỗ trợ (Chat)
            </a>
        </nav>

        <!-- Admin Profile Mini -->
        <div class="p-4 border-t border-gray-100">
            <div class="relative group cursor-pointer">
                <div class="flex items-center p-3 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors">
                    <img src="https://i.pravatar.cc/150?img=11" alt="Admin" class="w-10 h-10 rounded-full border-2 border-white shadow-sm">
                    <div class="ml-3 overflow-hidden">
                        <p class="text-sm font-bold text-dark leading-tight line-clamp-1">{{ Auth::check() ? Auth::user()->name : 'Admin System' }}</p>
                        <p class="text-xs text-gray-500">Quản trị viên</p>
                    </div>
                </div>
                
                <!-- Logout Dropdown Menu -->
                <div class="absolute bottom-full left-0 mb-2 w-full bg-white border border-gray-100 rounded-xl shadow-[0_-10px_40px_-5px_rgba(0,0,0,0.08)] opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50 overflow-hidden">
                    <a href="{{ route('logout.admin') }}" class="flex items-center w-full px-4 py-3 text-sm text-red-600 hover:bg-red-50 transition-colors font-medium">
                        <i class="fa-solid fa-arrow-right-from-bracket mr-2"></i> Đăng xuất
                    </a>
                </div>
            </div>
        </div>
    </aside>

