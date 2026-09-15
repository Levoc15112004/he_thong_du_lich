@extends('admin.master')
@section('content')
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden">

        <!-- Header Topbar -->
        <header class="h-20 bg-surface border-b border-gray-100 flex items-center justify-between px-6 lg:px-10 z-10">
            <!-- Left: Mobile menu button & Search -->
            <div class="flex items-center flex-1">
                <button class="md:hidden text-gray-500 hover:text-primary mr-4 focus:outline-none">
                    <i class="fa-solid fa-bars text-xl"></i>
                </button>

                <!-- Search Bar -->
                <div
                    class="hidden sm:flex items-center bg-gray-50 rounded-full px-4 py-2 w-full max-w-md border border-gray-100 focus-within:border-primary focus-within:bg-white transition-all focus-within:shadow-sm">
                    <i class="fa-solid fa-magnifying-glass text-gray-400"></i>
                    <input type="text" placeholder="Tìm kiếm mã đơn, tên khách hàng..."
                        class="bg-transparent border-none focus:outline-none ml-3 w-full text-sm text-dark placeholder-gray-400">
                </div>
            </div>

            <!-- Right: Actions & Notifications -->
            <div class="flex items-center space-x-4">
                <button
                    class="w-10 h-10 rounded-full bg-gray-50 text-gray-500 flex items-center justify-center hover:bg-gray-100 hover:text-primary transition-colors relative">
                    <i class="fa-regular fa-bell"></i>
                    <span class="absolute top-2 right-2.5 w-2 h-2 bg-red-500 rounded-full border border-white"></span>
                </button>
                <div class="h-8 w-px bg-gray-200 hidden sm:block"></div>
                <button
                    class="hidden sm:flex bg-dark text-white text-sm font-medium px-4 py-2 rounded-xl hover:bg-gray-800 transition-colors shadow-soft items-center">
                    <i class="fa-solid fa-plus mr-2"></i> Thêm Tour Mới
                </button>
            </div>
        </header>

        <!-- Main Scrollable Area -->
        <main class="flex-1 overflow-x-hidden overflow-y-auto p-6 lg:p-10">

            <!-- Page Title & Date Range -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-8">
                <div>
                    <h1 class="text-2xl lg:text-3xl font-bold text-dark tracking-tight">Thống kê tổng quan</h1>
                    <p class="text-gray-500 text-sm mt-1">Theo dõi hoạt động kinh doanh của Wanderlust.</p>
                </div>

                <div class="mt-4 sm:mt-0 flex items-center bg-white border border-gray-200 rounded-xl p-1 shadow-sm">
                    <button class="px-4 py-1.5 text-sm font-medium bg-gray-100 text-dark rounded-lg">7 Ngày</button>
                    <button
                        class="px-4 py-1.5 text-sm font-medium text-gray-500 hover:text-dark hover:bg-gray-50 rounded-lg transition-colors">30
                        Ngày</button>
                    <button
                        class="px-4 py-1.5 text-sm font-medium text-gray-500 hover:text-dark hover:bg-gray-50 rounded-lg transition-colors">Năm
                        nay</button>
                </div>
            </div>

            <!-- 1. KPI Stats Cards Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

                <!-- Card 1: Doanh Thu -->
                <div
                    class="bg-white p-6 rounded-2xl border border-gray-100 shadow-card hover:shadow-soft transition-shadow relative overflow-hidden group">
                    <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                        <i class="fa-solid fa-wallet text-6xl text-primary transform rotate-12"></i>
                    </div>
                    <div class="flex justify-between items-start mb-4">
                        <div class="w-12 h-12 rounded-xl bg-sky-50 text-primary flex items-center justify-center text-xl">
                            <i class="fa-solid fa-money-bill-trend-up"></i>
                        </div>
                        <span
                            class="flex items-center text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-1 rounded-md">
                            <i class="fa-solid fa-arrow-trend-up mr-1"></i> +12.5%
                        </span>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 mb-1">Tổng Doanh Thu</p>
                        <h3 class="text-2xl font-bold text-dark">{{ number_format($totalRevenue, 0, ',', '.') }}đ</h3>
                    </div>
                </div>

                <!-- Card 2: Tổng Đơn Đặt -->
                <div
                    class="bg-white p-6 rounded-2xl border border-gray-100 shadow-card hover:shadow-soft transition-shadow relative overflow-hidden group">
                    <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                        <i class="fa-solid fa-ticket text-6xl text-emerald-500 transform -rotate-12"></i>
                    </div>
                    <div class="flex justify-between items-start mb-4">
                        <div
                            class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl">
                            <i class="fa-solid fa-cart-flatbed-suitcase"></i>
                        </div>
                        <span
                            class="flex items-center text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-1 rounded-md">
                            <i class="fa-solid fa-arrow-trend-up mr-1"></i> +8.2%
                        </span>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 mb-1">Tổng Đơn Đặt (Bookings)</p>
                        <h3 class="text-2xl font-bold text-dark">{{ number_format($totalOrders, 0, ',', '.') }}</h3>
                    </div>
                </div>

                <!-- Card 3: Khách hàng mới -->
                <div
                    class="bg-white p-6 rounded-2xl border border-gray-100 shadow-card hover:shadow-soft transition-shadow relative overflow-hidden group">
                    <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                        <i class="fa-solid fa-users text-6xl text-purple-500 transform rotate-12"></i>
                    </div>
                    <div class="flex justify-between items-start mb-4">
                        <div
                            class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-xl">
                            <i class="fa-solid fa-user-plus"></i>
                        </div>
                        <span class="flex items-center text-xs font-bold text-emerald-500 bg-emerald-50 px-2 py-1 rounded-md">
                            <i class="fa-solid fa-arrow-trend-up mr-1"></i> Mới
                        </span>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 mb-1">Tổng Khách Hàng</p>
                        <h3 class="text-2xl font-bold text-dark">{{ number_format($totalUsers, 0, ',', '.') }}</h3>
                    </div>
                </div>

                <!-- Card 4: Tour Đang Hoạt Động -->
                <div
                    class="bg-white p-6 rounded-2xl border border-gray-100 shadow-card hover:shadow-soft transition-shadow relative overflow-hidden group">
                    <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                        <i class="fa-solid fa-earth-americas text-6xl text-amber-500 transform -rotate-12"></i>
                    </div>
                    <div class="flex justify-between items-start mb-4">
                        <div
                            class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl">
                            <i class="fa-solid fa-map-location-dot"></i>
                        </div>
                        <span class="flex items-center text-xs font-bold text-gray-500 bg-gray-100 px-2 py-1 rounded-md">
                            Cố định
                        </span>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 mb-1">Tour Đang Hoạt Động</p>
                        <h3 class="text-2xl font-bold text-dark">{{ number_format($totalTours, 0, ',', '.') }}</h3>
                    </div>
                </div>

            </div>

            <!-- 2. Charts Section -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">

                <!-- Line Chart: Biểu đồ doanh thu (Chiếm 2/3 không gian) -->
                <div class="lg:col-span-2 bg-white p-6 rounded-2xl border border-gray-100 shadow-card">
                    <div class="flex justify-between items-center mb-4">
                        <div>
                            <h2 class="text-lg font-bold text-dark">Biểu Đồ Doanh Thu & Lượt Đặt</h2>
                            <p class="text-xs text-gray-500">Dữ liệu 8 tháng gần nhất (2026)</p>
                        </div>
                        <button class="text-gray-400 hover:text-primary transition-colors"><i
                                class="fa-solid fa-ellipsis-vertical"></i></button>
                    </div>
                    <div class="chart-container">
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>

                <!-- Doughnut Chart: Trạng thái đơn đặt (Chiếm 1/3 không gian) -->
                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-card flex flex-col">
                    <div class="flex justify-between items-center mb-4">
                        <div>
                            <h2 class="text-lg font-bold text-dark">Trạng Thái Đơn Đặt</h2>
                            <p class="text-xs text-gray-500">Tỷ trọng tình trạng giao dịch</p>
                        </div>
                        <button class="text-gray-400 hover:text-primary transition-colors"><i
                                class="fa-solid fa-ellipsis-vertical"></i></button>
                    </div>
                    <div class="doughnut-container flex-grow relative">
                        <!-- Label in the center of doughnut -->
                        <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none mt-2">
                            <span class="text-3xl font-bold text-dark">{{ number_format($totalOrders, 0, ',', '.') }}</span>
                            <span class="text-[10px] uppercase text-gray-400 font-bold tracking-wider">Bookings</span>
                        </div>
                        <canvas id="categoryChart"></canvas>
                    </div>

                    <!-- Custom Legend -->
                    <div class="mt-4 grid grid-cols-2 gap-2 text-xs">
                        <div class="flex items-center"><span class="w-3 h-3 rounded-full bg-[#10b981] mr-2"></span>Đã xác nhận</div>
                        <div class="flex items-center"><span class="w-3 h-3 rounded-full bg-[#f59e0b] mr-2"></span>Chờ xử lý</div>
                        <div class="flex items-center"><span class="w-3 h-3 rounded-full bg-[#0ea5e9] mr-2"></span>Đã hoàn thành</div>
                        <div class="flex items-center"><span class="w-3 h-3 rounded-full bg-[#ef4444] mr-2"></span>Đã hủy</div>
                    </div>
                </div>

            </div>

            <!-- 3. Tables Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                <!-- Table 1: Tour Xem & Đặt Nhiều Nhất -->
                <div class="bg-white rounded-2xl border border-gray-100 shadow-card overflow-hidden flex flex-col">
                    <div class="p-6 border-b border-gray-50 flex justify-between items-center">
                        <h2 class="text-lg font-bold text-dark">Top Tour Nổi Bật</h2>
                        <a href="#" class="text-sm font-medium text-primary hover:underline">Xem tất cả</a>
                    </div>
                    <div class="overflow-x-auto flex-grow">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50/50 text-xs uppercase text-gray-400 border-b border-gray-100">
                                    <th class="py-3 px-6 font-medium">Tên Tour</th>
                                    <th class="py-3 px-6 font-medium text-center">Lượt Xem</th>
                                    <th class="py-3 px-6 font-medium text-center">Đã Bán</th>
                                    <th class="py-3 px-6 font-medium text-right">Xu hướng</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm divide-y divide-gray-50">
                                @forelse($topTours as $tour)
                                <tr class="hover:bg-sky-50/30 transition-colors group">
                                    <td class="py-3 px-6">
                                        <div class="flex items-center">
                                            <img src="{{ Str::startsWith($tour->image, 'http') ? $tour->image : asset($tour->image) }}"
                                                alt="Tour" class="w-10 h-10 rounded-lg object-cover mr-3 shadow-sm">
                                            <div>
                                                <a href="{{ route('admin.tours.edit', $tour->id) }}" class="font-bold text-dark line-clamp-1 group-hover:text-primary transition-colors cursor-pointer">
                                                    {{ $tour->name }}
                                                </a>
                                                <p class="text-xs text-gray-500">{{ $tour->category->name ?? 'Không phân loại' }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3 px-6 text-center font-medium">{{ number_format($tour->views_sum_view ?? 0, 0, ',', '.') }}</td>
                                    <td class="py-3 px-6 text-center font-bold text-dark">{{ number_format($tour->orders_count, 0, ',', '.') }}</td>
                                    <td class="py-3 px-6 text-right">
                                        <i class="fa-solid fa-arrow-trend-up text-emerald-500"></i>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="py-8 text-center text-gray-500">
                                        Chưa có dữ liệu tour nào nổi bật.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Table 2: Giao dịch / Đặt Tour Gần Đây -->
                <div class="bg-white rounded-2xl border border-gray-100 shadow-card overflow-hidden flex flex-col">
                    <div class="p-6 border-b border-gray-50 flex justify-between items-center">
                        <h2 class="text-lg font-bold text-dark">Giao Dịch Mới Nhất</h2>
                        <a href="#" class="text-sm font-medium text-primary hover:underline">Chi tiết</a>
                    </div>
                    <div class="overflow-x-auto flex-grow">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50/50 text-xs uppercase text-gray-400 border-b border-gray-100">
                                    <th class="py-3 px-6 font-medium">Khách Hàng</th>
                                    <th class="py-3 px-6 font-medium">Số Tiền</th>
                                    <th class="py-3 px-6 font-medium text-center">Trạng Thái</th>
                                    <th class="py-3 px-6 font-medium text-right">Thời Gian</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm divide-y divide-gray-50">
                                @forelse($recentOrders as $order)
                                <tr class="hover:bg-gray-50/50 transition-colors cursor-pointer" onclick="window.location.href='{{ route('admin.orders.show', $order->id) }}'">
                                    <td class="py-3 px-6">
                                        <p class="font-bold text-dark">{{ $order->user ? $order->user->name : $order->name }}</p>
                                        <p class="text-xs text-gray-500">WL-{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</p>
                                    </td>
                                    <td class="py-3 px-6 font-medium text-dark">{{ number_format($order->total_price, 0, ',', '.') }}đ</td>
                                    <td class="py-3 px-6 text-center">
                                        @if($order->status == 1)
                                        <span class="bg-emerald-100 text-emerald-600 text-[10px] font-bold px-2 py-1 rounded-md uppercase">Thành công</span>
                                        @elseif($order->status == 0)
                                        <span class="bg-amber-100 text-amber-600 text-[10px] font-bold px-2 py-1 rounded-md uppercase">Chờ xử lý</span>
                                        @elseif($order->status == 2)
                                        <span class="bg-red-100 text-red-500 text-[10px] font-bold px-2 py-1 rounded-md uppercase">Đã Hủy</span>
                                        @else
                                        <span class="bg-gray-100 text-gray-500 text-[10px] font-bold px-2 py-1 rounded-md uppercase">Khác</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-6 text-right text-gray-500 text-xs">{{ \Carbon\Carbon::parse($order->created_at)->diffForHumans() }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="py-8 text-center text-gray-500">
                                        Chưa có giao dịch nào.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

        </main>
    </div>

    <!-- Scripts for Charts & Interactivity -->
    <script>
        // Setup shared options for aesthetics
        Chart.defaults.font.family = "'Plus Jakarta Sans', sans-serif";
        Chart.defaults.color = '#94a3b8';

        // 1. Line Chart: Revenue & Bookings
        const ctxLine = document.getElementById('revenueChart').getContext('2d');

        // Create a soft gradient for the fill area under the line
        let gradientFill = ctxLine.createLinearGradient(0, 0, 0, 300);
        gradientFill.addColorStop(0, 'rgba(14, 165, 233, 0.4)'); // Primary color with opacity
        gradientFill.addColorStop(1, 'rgba(14, 165, 233, 0)'); // Fades to transparent

        new Chart(ctxLine, {
            type: 'line',
            data: {
                labels: ['Th 1', 'Th 2', 'Th 3', 'Th 4', 'Th 5', 'Th 6', 'Th 7', 'Th 8'],
                datasets: [{
                        label: 'Doanh Thu (Triệu VNĐ)',
                        data: [350, 420, 380, 510, 480, 650, 720, 850],
                        borderColor: '#0ea5e9', // Sky blue primary
                        backgroundColor: gradientFill,
                        borderWidth: 3,
                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: '#0ea5e9',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        fill: true, // Enable gradient fill
                        tension: 0.4, // Makes the line smooth/curvy
                        yAxisID: 'y'
                    },
                    {
                        label: 'Lượt Đặt (Bookings)',
                        data: [150, 180, 160, 220, 210, 290, 310, 360],
                        borderColor: '#10b981', // Emerald secondary
                        borderDash: [5, 5], // Dashed line to differentiate
                        borderWidth: 2,
                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: '#10b981',
                        pointRadius: 3,
                        fill: false,
                        tension: 0.4,
                        yAxisID: 'y1'
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                plugins: {
                    legend: {
                        position: 'top',
                        align: 'end',
                        labels: {
                            usePointStyle: true,
                            boxWidth: 8,
                            padding: 20
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(15, 23, 42, 0.9)', // Dark background for tooltip
                        titleFont: {
                            size: 13,
                            weight: 'bold'
                        },
                        bodyFont: {
                            size: 13
                        },
                        padding: 12,
                        cornerRadius: 8,
                        displayColors: true,
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false,
                            drawBorder: false
                        }
                    },
                    y: {
                        type: 'linear',
                        display: true,
                        position: 'left',
                        grid: {
                            borderDash: [4, 4],
                            color: '#f1f5f9',
                            drawBorder: false
                        },
                        ticks: {
                            callback: function(value) {
                                return value + ' Tr';
                            }
                        }
                    },
                    y1: {
                        type: 'linear',
                        display: true,
                        position: 'right',
                        grid: {
                            display: false,
                            drawBorder: false
                        },
                    }
                }
            }
        });

        // 2. Doughnut Chart: Đơn Hàng Distribution
        const ctxPie = document.getElementById('categoryChart').getContext('2d');
        new Chart(ctxPie, {
            type: 'doughnut',
            data: {
                labels: ['Đã xác nhận', 'Chờ xử lý', 'Đã hoàn thành', 'Đã hủy'],
                datasets: [{
                    data: [{{ $orderConfirmed }}, {{ $orderPending }}, {{ $orderCompleted }}, {{ $orderCancelled }}],
                    backgroundColor: [
                        '#10b981', // Emerald green
                        '#f59e0b', // Amber
                        '#0ea5e9', // Sky blue
                        '#ef4444'  // Red
                    ],
                    borderWidth: 0,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '75%', // Makes the ring thinner/thicker
                plugins: {
                    legend: {
                        display: false // We use custom HTML legend instead
                    },
                    tooltip: {
                        backgroundColor: 'rgba(15, 23, 42, 0.9)',
                        padding: 12,
                        cornerRadius: 8,
                        callbacks: {
                            label: function(context) {
                                return ' ' + context.label + ': ' + context.parsed + ' Đơn';
                            }
                        }
                    }
                }
            }
        });
    </script>
@endsection
