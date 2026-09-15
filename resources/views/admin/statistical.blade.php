@extends('admin.master')

@section('content')
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden bg-gray-50/50">
        
        <!-- Header Topbar -->
        <header class="h-20 bg-surface border-b border-gray-100 flex items-center justify-between px-6 lg:px-10 z-10 flex-shrink-0 bg-white">
            <div class="flex items-center flex-1">
                <button class="md:hidden text-gray-500 hover:text-primary mr-4 focus:outline-none">
                    <i class="fa-solid fa-bars text-xl"></i>
                </button>
                <h2 class="text-xl font-bold text-dark hidden sm:block">Thống Kê Tổng Quan (Analytics)</h2>
            </div>
            
            <div class="flex items-center space-x-4">
                <div class="flex bg-gray-100 p-1 rounded-xl">
                    <button class="px-4 py-1.5 text-sm font-bold rounded-lg bg-white shadow-sm text-dark transition-all">7 Ngày</button>
                    <button class="px-4 py-1.5 text-sm font-medium rounded-lg text-gray-500 hover:text-dark transition-all">Trong Tháng</button>
                    <button class="px-4 py-1.5 text-sm font-medium rounded-lg text-gray-500 hover:text-dark transition-all">Trong Năm</button>
                </div>
                
                <div class="h-8 w-px bg-gray-200 mx-2"></div>

                <button class="w-10 h-10 rounded-full bg-gray-50 text-gray-500 flex items-center justify-center hover:bg-gray-100 hover:text-primary transition-colors relative">
                    <i class="fa-regular fa-bell"></i>
                </button>
                <div class="flex items-center cursor-pointer">
                    <img src="https://i.pravatar.cc/150?img=11" alt="Admin" class="w-9 h-9 rounded-full border-2 border-white shadow-sm">
                </div>
            </div>
        </header>

        <!-- Main Scrollable Area -->
        <main class="flex-1 overflow-x-hidden overflow-y-auto p-6 lg:p-10 relative">
            <div class="block pb-10">
                
                <!-- 1. CỤM THẺ THỐNG KÊ (STAT CARDS) -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    
                    <!-- Card 1: Doanh thu -->
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden group hover:shadow-md transition-shadow">
                        <div class="absolute -right-6 -top-6 text-sky-50 opacity-50 group-hover:scale-110 transition-transform duration-500">
                            <i class="fa-solid fa-wallet text-9xl"></i>
                        </div>
                        <div class="relative z-10">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-sm font-medium text-gray-500">Tổng Doanh Thu</h3>
                                <span class="flex items-center text-xs font-bold text-emerald-500 bg-emerald-50 px-2.5 py-1 rounded-full"><i class="fa-solid fa-arrow-trend-up mr-1"></i> +12.5%</span>
                            </div>
                            <h2 class="text-3xl font-black text-dark mb-1">452.5M <span class="text-base font-bold text-gray-400">VNĐ</span></h2>
                            <p class="text-xs text-gray-400">So với kỳ thống kê trước</p>
                        </div>
                    </div>

                    <!-- Card 2: Lượt đặt Tour -->
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden group hover:shadow-md transition-shadow">
                        <div class="absolute -right-6 -top-6 text-indigo-50 opacity-50 group-hover:scale-110 transition-transform duration-500">
                            <i class="fa-solid fa-plane-departure text-9xl"></i>
                        </div>
                        <div class="relative z-10">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-sm font-medium text-gray-500">Số Đơn Hàng (Orders)</h3>
                                <span class="flex items-center text-xs font-bold text-emerald-500 bg-emerald-50 px-2.5 py-1 rounded-full"><i class="fa-solid fa-arrow-trend-up mr-1"></i> +8.2%</span>
                            </div>
                            <h2 class="text-3xl font-black text-dark mb-1">1,248 <span class="text-base font-bold text-gray-400">Đơn</span></h2>
                            <p class="text-xs text-gray-400">Tỷ lệ thành công đạt 92%</p>
                        </div>
                    </div>

                    <!-- Card 3: Khách hàng mới -->
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden group hover:shadow-md transition-shadow">
                        <div class="absolute -right-6 -top-6 text-orange-50 opacity-50 group-hover:scale-110 transition-transform duration-500">
                            <i class="fa-solid fa-users text-9xl"></i>
                        </div>
                        <div class="relative z-10">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-sm font-medium text-gray-500">Người Dùng Mới</h3>
                                <span class="flex items-center text-xs font-bold text-red-500 bg-red-50 px-2.5 py-1 rounded-full"><i class="fa-solid fa-arrow-trend-down mr-1"></i> -2.4%</span>
                            </div>
                            <h2 class="text-3xl font-black text-dark mb-1">356 <span class="text-base font-bold text-gray-400">User</span></h2>
                            <p class="text-xs text-gray-400">Đăng ký mới trong kỳ</p>
                        </div>
                    </div>

                    <!-- Card 4: Lượt truy cập web -->
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden group hover:shadow-md transition-shadow">
                        <div class="absolute -right-4 -top-6 text-emerald-50 opacity-50 group-hover:scale-110 transition-transform duration-500">
                            <i class="fa-solid fa-earth-asia text-9xl"></i>
                        </div>
                        <div class="relative z-10">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-sm font-medium text-gray-500">Lượt Truy Cập (Views)</h3>
                                <span class="flex items-center text-xs font-bold text-emerald-500 bg-emerald-50 px-2.5 py-1 rounded-full"><i class="fa-solid fa-arrow-trend-up mr-1"></i> +24.8%</span>
                            </div>
                            <h2 class="text-3xl font-black text-dark mb-1">12.5K <span class="text-base font-bold text-gray-400">Lượt</span></h2>
                            <p class="text-xs text-gray-400">Peak hour: 19:00 - 21:00</p>
                        </div>
                    </div>

                </div>

                <!-- 2. BIỂU ĐỒ CHÍNH (DOANH THU & ĐƠN HÀNG) -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
                    
                    <!-- Line Chart: Phân tích Doanh thu (Full Width trên Mobile, 2/3 trên Desktop) -->
                    <div class="lg:col-span-2 bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-gray-100">
                        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-6">
                            <div>
                                <h3 class="text-lg font-bold text-dark">Biểu Đồ Doanh Thu & Truy Cập</h3>
                                <p class="text-sm text-gray-500">Biến động dòng tiền theo các tháng trong năm</p>
                            </div>
                            <button class="text-gray-400 hover:text-primary transition-colors flex items-center mt-3 sm:mt-0 text-sm font-medium border border-gray-200 px-3 py-1.5 rounded-lg">
                                <i class="fa-solid fa-download mr-2"></i> Xuất Báo Cáo
                            </button>
                        </div>
                        
                        <!-- Vẽ biểu đồ bằng ApexCharts -->
                        <div id="revenueChart" class="w-full h-80"></div>
                    </div>

                    <!-- Donut Chart: Phân bổ tỷ trọng loại Tour (1/3 trên Desktop) -->
                    <div class="bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-gray-100">
                        <div class="mb-6">
                            <h3 class="text-lg font-bold text-dark">Tỷ Trọng Doanh Số Bán Hàng</h3>
                            <p class="text-sm text-gray-500">Lượt đặt vé chia theo loại hình Tour</p>
                        </div>
                        
                        <!-- Biểu đồ Donut ApexCharts -->
                        <div class="flex justify-center items-center h-64">
                            <div id="categoryChart" class="w-full h-full flex justify-center"></div>
                        </div>

                        <!-- Legend/Chú thích custom (Optional) -->
                        <div class="mt-4 space-y-3">
                            <div class="flex justify-between items-center text-sm">
                                <span class="flex items-center text-gray-600 font-medium"><span class="w-3 h-3 rounded-full bg-[#0ea5e9] mr-2"></span> Tour Trong Nước</span>
                                <span class="font-bold text-dark">55%</span>
                            </div>
                            <div class="flex justify-between items-center text-sm">
                                <span class="flex items-center text-gray-600 font-medium"><span class="w-3 h-3 rounded-full bg-[#10b981] mr-2"></span> Tour Quốc Tế</span>
                                <span class="font-bold text-dark">30%</span>
                            </div>
                            <div class="flex justify-between items-center text-sm">
                                <span class="flex items-center text-gray-600 font-medium"><span class="w-3 h-3 rounded-full bg-[#f59e0b] mr-2"></span> Voucher Đặc Biệt</span>
                                <span class="font-bold text-dark">15%</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 3. BẢNG TOP TOUR BÁN CHẠY (BAR CHART HOẶC LISTING DỮ LIỆU) -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    
                    <!-- Biểu đồ Cột: Top 5 Tỉnh/Thành được ghé thăm -->
                    <div class="bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-gray-100">
                        <div class="mb-6 flex justify-between items-center">
                            <div>
                                <h3 class="text-lg font-bold text-dark">Điểm Đến Yêu Thích </h3>
                                <p class="text-sm text-gray-500">Lượt booking tính từ đầu kỳ</p>
                            </div>
                        </div>
                        <div id="locationBarChart" class="w-full h-64"></div>
                    </div>

                    <!-- Danh sách Recent Orders (Mới nhất) -->
                    <div class="bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-gray-100 flex flex-col hidden lg:flex">
                        <div class="mb-6 flex justify-between items-center">
                            <div>
                                <h3 class="text-lg font-bold text-dark">Giao Dịch Gần Nhất</h3>
                                <p class="text-sm text-gray-500">Đơn hàng vừa được thanh toán thành công</p>
                            </div>
                            <a href="{{ url('admin/order') }}" class="text-sm font-bold text-primary hover:underline">Xem Tất Cả</a>
                        </div>
                        
                        <div class="space-y-4 flex-1">
                            
                            <div class="flex items-center justify-between p-4 bg-gray-50/50 rounded-xl border border-gray-100 hover:bg-gray-50 transition-colors">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center font-bold mr-3"><i class="fa-solid fa-check"></i></div>
                                    <div>
                                        <p class="text-sm font-bold text-dark mb-0.5">Vũ Đình Khoa</p>
                                        <p class="text-[10px] text-gray-500">Tour Hạ Long (3N2Đ) • 10 Phút trước</p>
                                    </div>
                                </div>
                                <span class="font-bold text-dark text-sm">+ 11.5M</span>
                            </div>

                            <div class="flex items-center justify-between p-4 bg-gray-50/50 rounded-xl border border-gray-100 hover:bg-gray-50 transition-colors">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center font-bold mr-3"><i class="fa-solid fa-check"></i></div>
                                    <div>
                                        <p class="text-sm font-bold text-dark mb-0.5">Lê Mai Anh</p>
                                        <p class="text-[10px] text-gray-500">Tour Sapa (2N1Đ) • 45 Phút trước</p>
                                    </div>
                                </div>
                                <span class="font-bold text-dark text-sm">+ 8.2M</span>
                            </div>

                            <div class="flex items-center justify-between p-4 bg-gray-50/50 rounded-xl border border-gray-100 hover:bg-gray-50 transition-colors">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-full bg-red-100 text-red-500 flex items-center justify-center font-bold mr-3"><i class="fa-solid fa-xmark"></i></div>
                                    <div>
                                        <p class="text-sm font-bold text-dark mb-0.5">Trần Quốc</p>
                                        <p class="text-[10px] text-gray-500">Khách Yêu Cầu Hoàn Tiền • 1 Giờ trước</p>
                                    </div>
                                </div>
                                <span class="font-bold text-gray-400 line-through text-sm">4.5M</span>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </main>
    </div>

    <!-- CHÈN APEXCHARTS CDN & KHỞI TẠO BIỂU ĐỒ BẰNG JAVASCRIPT -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            
            // 1. Biểu đồ Doanh Thu & Lượt xem (Line & Area Chart kết hợp)
            var revenueOptions = {
                series: [{
                    name: 'Doanh Thu (TrVND)',
                    type: 'area',
                    data: [120, 160, 140, 210, 180, 250, 310, 280, 400, 380, 420, 452.5]
                }, {
                    name: 'Lượt Truy Cập (K)',
                    type: 'line',
                    data: [80, 95, 85, 110, 100, 130, 150, 140, 190, 175, 210, 230]
                }],
                chart: {
                    height: 320,
                    type: 'line',
                    fontFamily: 'Plus Jakarta Sans',
                    toolbar: { show: false },
                    dropShadow: {
                        enabled: true,
                        top: 15,
                        left: 0,
                        blur: 10,
                        opacity: 0.1,
                        color: '#0ea5e9'
                    }
                },
                stroke: { width: [3, 3], curve: 'smooth' },
                fill: {
                    type: ['gradient', 'solid'],
                    gradient: {
                        shade: 'light',
                        type: 'vertical',
                        shadeIntensity: 0.5,
                        opacityFrom: 0.4,
                        opacityTo: 0.05,
                        stops: [0, 100]
                    }
                },
                colors: ['#0ea5e9', '#10b981'],
                labels: ['Th 1', 'Th 2', 'Th 3', 'Th 4', 'Th 5', 'Th 6', 'Th 7', 'Th 8', 'Th 9', 'Th 10', 'Th 11', 'Th 12'],
                xaxis: { 
                    axisBorder: { show: false }, 
                    axisTicks: { show: false } 
                },
                yaxis: {
                    labels: {
                        formatter: function (value) { return value + "M"; }
                    }
                },
                grid: {
                    borderColor: '#f1f5f9',
                    strokeDashArray: 4,
                },
                dataLabels: { enabled: false },
                legend: { position: 'top', horizontalAlign: 'right' },
                tooltip: {
                    theme: 'light',
                    y: { formatter: function (val) { return val; } }
                }
            };
            var revenueChart = new ApexCharts(document.querySelector("#revenueChart"), revenueOptions);
            revenueChart.render();

            // 2. Biểu đồ Donut phân bổ (Category Chart)
            var categoryOptions = {
                series: [55, 30, 15],
                chart: {
                    type: 'donut',
                    height: 280,
                    fontFamily: 'Plus Jakarta Sans',
                },
                labels: ['Tour Trong Nước', 'Tour Quốc Tế', 'Khác/Voucher'],
                colors: ['#0ea5e9', '#10b981', '#f59e0b'],
                plotOptions: {
                    pie: {
                        donut: {
                            size: '75%',
                            labels: {
                                show: true,
                                name: { show: true, fontSize: '12px', color: '#64748b' },
                                value: { show: true, fontSize: '24px', fontWeight: 'bold', color: '#0f172a' },
                                total: {
                                    show: true,
                                    label: 'Tổng tỷ trọng',
                                    color: '#64748b',
                                    formatter: function (w) { return "100%"; }
                                }
                            }
                        }
                    }
                },
                dataLabels: { enabled: false },
                legend: { show: false },
                stroke: { width: 5, colors: ['#ffffff'] }
            };
            var categoryChart = new ApexCharts(document.querySelector("#categoryChart"), categoryOptions);
            categoryChart.render();

            // 3. Biểu đồ Cột (Top Địa Điểm Bar Chart)
            var barOptions = {
                series: [{
                    name: 'Đơn Hàng',
                    data: [350, 280, 210, 185, 120]
                }],
                chart: {
                    type: 'bar',
                    height: 256,
                    fontFamily: 'Plus Jakarta Sans',
                    toolbar: { show: false }
                },
                colors: ['#0ea5e9'],
                plotOptions: {
                    bar: {
                        horizontal: true,
                        borderRadius: 6,
                        barHeight: '40%',
                        endingShape: 'rounded'
                    },
                },
                dataLabels: { enabled: false },
                grid: {
                    borderColor: '#f1f5f9',
                    strokeDashArray: 4,
                    xaxis: { lines: { show: true } },
                    yaxis: { lines: { show: false } },
                },
                xaxis: {
                    categories: ['Đà Nẵng', 'Hạ Long', 'Phú Quốc', 'Sapa', 'Đà Lạt'],
                    labels: { show: false },
                    axisBorder: { show: false },
                    axisTicks: { show: false },
                },
                yaxis: {
                    labels: { style: { colors: '#475569', fontWeight: 600 } }
                }
            };
            var barChart = new ApexCharts(document.querySelector("#locationBarChart"), barOptions);
            barChart.render();

        });
    </script>
@endsection
