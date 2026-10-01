<!-- SIDEBAR CONTENT -->
<div class="flex flex-col w-full min-h-screen pt-16 lg:pt-20 bg-white dark:bg-slate-900 pb-6 transition-colors duration-200">

    <!-- USER INFO -->
    <div class="px-6 py-6 border-b border-slate-100 dark:border-slate-800 flex items-center gap-4">
        <div class="relative shrink-0">
            <img src="{{ Auth::user()->avatar_url ?? 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name ?? 'Admin').'&background=10b981&color=fff&bold=true' }}"
                onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'Admin') }}&background=10b981&color=fff&bold=true';"
                class="w-12 h-12 rounded-full border-2 border-emerald-500/20 shadow-sm object-cover"
                alt="Admin Avatar">
            <div class="absolute bottom-0 right-0 w-3.5 h-3.5 bg-green-500 border-2 border-white dark:border-slate-800 rounded-full"></div>
        </div>
        <div class="flex-1 overflow-hidden">
            <p class="font-bold text-slate-800 dark:text-white truncate text-sm">
                {{ Auth::user()->name ?? 'Administrator' }}
            </p>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5 truncate">
                Quản trị viên
            </p>
        </div>
    </div>

    <!-- MENU LIST -->
    <ul class="flex-1 px-4 py-6 space-y-2">

        @php
            $menuItems = [
                [
                    'title' => 'Quản lý tour du lịch',
                    'icon' => 'map',
                    'submenu' => [
                        [
                            'text' => 'Quản lý Tour',
                            'icon' => 'map-pin',
                            'route' => route('admin.tours.index'),
                        ],
                        [
                            'text' => 'Quản lý lịch trình',
                            'icon' => 'calendar',
                            'route' => route('admin.tour_schedules.index'),
                        ],
                        [
                            'text' => 'Quản lý loại hình',
                            'icon' => 'package',
                            'route' => route('admin.attr.index'),
                        ],
                    ],
                ],

                [
                    'title' => 'Quản lý vận hành',
                    'icon' => 'settings',
                    'submenu' => [
                        [
                            'text' => 'Quản lý danh mục',
                            'icon' => 'layers',
                            'route' => route('categories.index'),
                        ],
                        [
                            'text' => 'Quản lý người dùng',
                            'icon' => 'users',
                            'route' => route('admin.users.index'),
                        ],
                        [
                            'text' => 'Quản lý banner',
                            'icon' => 'image',
                            'route' => route('admin.banners.index'),
                        ],
                        [
                            'text' => 'Quản lý bài viết',
                            'icon' => 'file-text',
                            'route' => route('admin.blogs.index'),
                        ],
                        [
                            'text' => 'Quản lý voucher',
                            'icon' => 'tag',
                            'route' => route('admin.vouchers.index'),
                        ],
                        [
                            'text' => 'Sử dụng voucher',
                            'icon' => 'check-circle',
                            'route' => route('admin.user_vouchers.index'),
                        ],
                    ],
                ],

                [
                    'title' => 'Quản lý hỗ trợ',
                    'icon' => 'headphones',
                    'submenu' => [
                        [
                            'text' => 'Hỗ trợ khách hàng',
                            'icon' => 'message-circle',
                            'route' => route('admin.chat.index'),
                        ],
                    ],
                ],

                [
                    'title' => 'Quản lý báo cáo',
                    'icon' => 'pie-chart',
                    'submenu' => [
                        [
                            'text' => 'Quản lý đơn hàng',
                            'icon' => 'shopping-cart',
                            'route' => route('admin.orders.index'),
                        ],
                        [
                            'text' => 'Quản lý thanh toán',
                            'icon' => 'credit-card',
                            'route' => route('admin.payments.index'),
                        ],
                        [
                            'text' => 'Báo cáo tổng hợp',
                            'icon' => 'trending-up',
                            'route' => route('admin.reports'),
                        ],
                    ],
                ],
            ];
            
            $currentUrl = request()->url();
        @endphp


        @foreach ($menuItems as $item)
            @php
                // Check if any submenu item is active
                $isActiveGroup = false;
                foreach ($item['submenu'] as $sub) {
                    if ($currentUrl == $sub['route']) {
                        $isActiveGroup = true;
                        break;
                    }
                }
            @endphp
            <li class="group mb-1">

                <!-- MAIN MENU -->
                <button
                    class="menu-toggle w-full flex items-center justify-between px-3 py-3 rounded-xl transition-all duration-200 ease-in-out border border-transparent
                    {{ $isActiveGroup ? 'bg-emerald-50 text-emerald-700 shadow-sm border-emerald-100' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">

                    <div class="flex items-center space-x-3.5">
                        <i data-feather="{{ $item['icon'] }}" class="w-5 h-5 {{ $isActiveGroup ? 'text-emerald-600' : 'text-slate-500 group-hover:text-slate-700' }}"></i>
                        <span class="font-semibold text-[14px]">
                            {{ $item['title'] }}
                        </span>
                    </div>

                    <i data-feather="chevron-right" class="menu-arrow w-4 h-4 transition-transform duration-300 {{ $isActiveGroup ? 'rotate-90 text-emerald-600' : 'text-slate-400' }}"></i>

                </button>


                <!-- SUBMENU -->
                <ul class="submenu overflow-hidden transition-all duration-300 {{ $isActiveGroup ? 'max-h-[500px] opacity-100 mt-2' : 'max-h-0 opacity-0' }}">
                    <div class="pl-5 pr-2 py-1 space-y-1 relative before:content-[''] before:absolute before:left-[22px] before:top-2 before:bottom-2 before:w-[1.5px] before:bg-slate-200">
                        @foreach ($item['submenu'] as $sub)
                            @php
                                $isActiveItem = ($currentUrl == $sub['route']);
                            @endphp
                            <li class="relative">
                                <!-- Line indicator -->
                                <div class="absolute left-[-11px] top-1/2 -translate-y-1/2 w-3 h-[1.5px] {{ $isActiveItem ? 'bg-emerald-500' : 'bg-transparent' }} transition-colors"></div>
                                
                                <a href="{{ $sub['route'] }}"
                                    class="flex items-center space-x-3 px-4 py-2.5 rounded-lg text-[13.5px] font-medium transition-all duration-200
                                   {{ $isActiveItem ? 'bg-emerald-600 text-white shadow-md shadow-emerald-200' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">

                                    <i data-feather="{{ $sub['icon'] }}"
                                        class="w-4 h-4 {{ $isActiveItem ? 'text-white' : 'text-slate-400' }}">
                                    </i>

                                    <span>
                                        {{ $sub['text'] }}
                                    </span>

                                </a>
                            </li>
                        @endforeach
                    </div>
                </ul>

            </li>
        @endforeach


        <!-- LOGOUT -->
        <li class="pt-6 mt-4 border-t border-slate-100">
            <a href="{{ route('logout.admin') }}"
                class="flex items-center space-x-3.5 px-3 py-3 rounded-xl font-semibold text-[14px] text-red-600 hover:bg-red-50 transition-colors">
                <i data-feather="log-out" class="w-5 h-5 text-red-500"></i>
                <span>Đăng xuất</span>
            </a>
        </li>

    </ul>

</div>

<!-- SCRIPT -->
<script src="https://unpkg.com/feather-icons"></script>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        feather.replace();

        // toggle submenu with smooth animation
        document.querySelectorAll('.menu-toggle').forEach(btn => {
            btn.addEventListener('click', () => {
                const parent = btn.parentElement;
                const submenu = parent.querySelector('.submenu');
                const arrow = parent.querySelector('.menu-arrow');

                // Check if currently collapsed (max-h-0)
                const isCollapsed = submenu.classList.contains('max-h-0');

                if (isCollapsed) {
                    submenu.classList.remove('max-h-0', 'opacity-0');
                    submenu.classList.add('max-h-[500px]', 'opacity-100', 'mt-2');
                    arrow.classList.add('rotate-90');
                } else {
                    submenu.classList.add('max-h-0', 'opacity-0');
                    submenu.classList.remove('max-h-[500px]', 'opacity-100', 'mt-2');
                    arrow.classList.remove('rotate-90');
                }
            });
        });
    });
</script>

