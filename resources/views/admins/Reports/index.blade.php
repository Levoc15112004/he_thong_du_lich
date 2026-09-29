@extends('admins.master')

@section('title', 'Báo cáo Tổng hợp Hệ thống')

@section('home')
<div class="min-h-screen bg-slate-50 px-4 sm:px-6 lg:px-8 py-8">
    <div class="max-w-[120rem] mx-auto space-y-8">

        {{-- HEADER --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between py-4 gap-4">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-teal-400 to-emerald-500 flex items-center justify-center text-white shadow-lg shadow-teal-200 shrink-0">
                    <i class="fa-solid fa-chart-pie text-2xl"></i>
                </div>
                <div>
                    <h4 class="text-2xl sm:text-3xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-teal-700 to-emerald-600">
                        Báo cáo Tổng hợp
                    </h4>
                    <p class="text-sm text-slate-500 mt-1">Phân tích chuyên sâu về doanh thu và thống kê kinh doanh</p>
                </div>
            </div>
            
            <div class="flex items-center gap-3">
                <div class="px-5 py-2.5 bg-white border border-slate-200 rounded-xl shadow-sm text-[10px] text-slate-500 font-bold uppercase tracking-wider flex items-center gap-2">
                    <i class="fa-solid fa-calendar-day text-teal-500 text-sm"></i>
                    Hôm nay: {{ \Carbon\Carbon::now()->format('d/m/Y') }}
                </div>
            </div>
        </div>

        {{-- TINH NĂNG LỌC --}}
        <div class="bg-white/90 backdrop-blur-xl p-6 rounded-3xl border border-slate-100 shadow-xl shadow-slate-200/50 relative overflow-hidden z-10">
            <div class="absolute top-0 right-0 p-32 bg-teal-50/50 rounded-full blur-3xl opacity-50 -z-10 -translate-y-1/2 translate-x-1/2"></div>
            
            <form method="GET" action="{{ route('admin.reports') }}">
                <div class="flex flex-col md:flex-row md:items-end gap-6 justify-between border-b border-slate-100 pb-3 mb-2">
                    <h5 class="text-base font-bold text-slate-800 flex items-center gap-2">
                        <i class="fa-solid fa-filter text-teal-500"></i> Bộ Lọc Báo Cáo
                    </h5>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 pt-2">
                    {{-- Month --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Chọn Tháng</label>
                        <div class="relative">
                            <i class="fa-solid fa-calendar-days absolute left-4 top-1/2 -translate-y-1/2 text-teal-500 z-10"></i>
                            <select name="month" class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-11 pr-4 py-3 text-slate-700 font-bold focus:outline-none focus:ring-4 focus:ring-teal-500/10 focus:border-teal-500 appearance-none relative z-0">
                                <option value="">Tất cả các tháng</option>
                                @for($i=1;$i<=12;$i++)
                                    <option value="{{ $i }}" {{ request('month') == $i ? 'selected' : '' }}>
                                        Tháng {{ $i }}
                                    </option>
                                @endfor
                            </select>
                            <i class="fa-solid fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none text-xs z-10"></i>
                        </div>
                    </div>

                    {{-- Year --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Chọn Năm</label>
                        <div class="relative">
                            <i class="fa-solid fa-calendar absolute left-4 top-1/2 -translate-y-1/2 text-blue-500 z-10"></i>
                            <select name="year" class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-11 pr-4 py-3 text-slate-700 font-bold focus:outline-none focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 appearance-none relative z-0">
                                @for($i=2023;$i<=2035;$i++)
                                    <option value="{{ $i }}" {{ request('year', date('Y')) == $i ? 'selected' : '' }}>
                                        Năm {{ $i }}
                                    </option>
                                @endfor
                            </select>
                            <i class="fa-solid fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none text-xs z-10"></i>
                        </div>
                    </div>

                    {{-- Button --}}
                    <div class="lg:col-span-2 flex items-end">
                        <button class="w-full lg:w-48 bg-gradient-to-r from-teal-500 to-emerald-600 hover:from-teal-600 hover:to-emerald-700 text-white py-3 px-6 rounded-xl font-bold shadow-lg shadow-teal-200/50 hover:shadow-xl hover:shadow-teal-300 transition-all active:scale-95 flex items-center justify-center gap-2">
                            <i class="fa-solid fa-magnifying-glass-chart"></i> Áp Dụng Lọc
                        </button>
                    </div>
                </div>
            </form>
        </div>

        {{-- SUMMARY CARDS --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

            {{-- Revenue --}}
            <div class="bg-white/90 backdrop-blur-xl p-6 rounded-3xl border border-slate-100 shadow-xl shadow-slate-200/50 flex flex-col justify-between group overflow-hidden relative">
                <div class="absolute -right-6 -bottom-6 text-9xl text-emerald-50 opacity-50 group-hover:scale-110 transition-transform duration-500"><i class="fa-solid fa-sack-dollar"></i></div>
                <div class="flex items-center gap-4 mb-6 relative z-10">
                    <div class="w-14 h-14 rounded-2xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-2xl shadow-inner shrink-0 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-wallet"></i>
                    </div>
                    <div>
                        <h6 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Tổng Doanh Thu</h6>
                        <p class="text-3xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-emerald-500 to-teal-600">{{ number_format($totalRevenue) }} ₫</p>
                    </div>
                </div>
            </div>

            {{-- Orders --}}
            <div class="bg-white/90 backdrop-blur-xl p-6 rounded-3xl border border-slate-100 shadow-xl shadow-slate-200/50 flex flex-col justify-between group overflow-hidden relative">
                <div class="absolute -right-6 -bottom-6 text-9xl text-blue-50 opacity-50 group-hover:scale-110 transition-transform duration-500"><i class="fa-solid fa-file-invoice-dollar"></i></div>
                <div class="flex items-center gap-4 mb-6 relative z-10">
                    <div class="w-14 h-14 rounded-2xl bg-blue-100 text-blue-600 flex items-center justify-center text-2xl shadow-inner shrink-0 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-cart-shopping"></i>
                    </div>
                    <div>
                        <h6 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Đơn Hàng Giao Dịch</h6>
                        <p class="text-3xl font-bold text-slate-800">{{ number_format($totalOrders) }} <span class="text-base text-slate-400 font-bold">Đơn</span></p>
                    </div>
                </div>
            </div>

            {{-- Users --}}
            <div class="bg-white/90 backdrop-blur-xl p-6 rounded-3xl border border-slate-100 shadow-xl shadow-slate-200/50 flex flex-col justify-between group overflow-hidden relative">
                <div class="absolute -right-6 -bottom-6 text-9xl text-amber-50 opacity-50 group-hover:scale-110 transition-transform duration-500"><i class="fa-solid fa-users-viewfinder"></i></div>
                <div class="flex items-center gap-4 mb-6 relative z-10">
                    <div class="w-14 h-14 rounded-2xl bg-amber-100 text-amber-600 flex items-center justify-center text-2xl shadow-inner shrink-0 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-users"></i>
                    </div>
                    <div>
                        <h6 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Người Dùng Mới</h6>
                        <p class="text-3xl font-bold text-slate-800">{{ number_format($totalUsers) }} <span class="text-base text-slate-400 font-bold">Người</span></p>
                    </div>
                </div>
            </div>

        </div>

        {{-- MAIN CONTENT GRID --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            {{-- CHART SECTION (Takes 2/3) --}}
            <div class="lg:col-span-2 bg-white/90 backdrop-blur-xl p-6 rounded-3xl border border-slate-100 shadow-xl shadow-slate-200/50">
                <div class="flex items-center justify-between mb-8 border-b border-slate-100 pb-4">
                    <h5 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                        <i class="fa-solid fa-chart-area text-blue-500"></i> Xu hướng Doanh thu (Theo khoảng thời gian)
                    </h5>
                </div>
                
                <div class="h-[380px] w-full">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>

            {{-- TOP TOURS (Takes 1/3) --}}
            <div class="bg-white/90 backdrop-blur-xl p-6 rounded-3xl border border-slate-100 shadow-xl shadow-slate-200/50">
                <div class="flex items-center justify-between mb-6 border-b border-slate-100 pb-4">
                    <h5 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                        <i class="fa-solid fa-ranking-star text-amber-500"></i> Bảng Vàng Tours
                    </h5>
                </div>

                <div class="space-y-4 max-h-[380px] overflow-y-auto pr-2 custom-scrollbar">
                    @forelse($topTours as $index => $tour)
                        <div class="bg-slate-50 border border-slate-100 rounded-2xl p-4 flex items-center gap-4 hover:border-teal-200 transition-colors">
                            <div class="w-10 h-10 rounded-full font-bold text-lg flex items-center justify-center shrink-0 shadow-inner
                                {{ $index == 0 ? 'bg-gradient-to-r from-amber-300 to-yellow-500 text-yellow-900 shadow-yellow-200/50' : 
                                  ($index == 1 ? 'bg-gradient-to-r from-slate-300 to-gray-400 text-slate-800 shadow-slate-300/50' : 
                                  ($index == 2 ? 'bg-gradient-to-r from-orange-300 to-amber-600 text-orange-950 shadow-orange-200/50' : 
                                  'bg-white text-slate-400 border border-slate-200')) }}">
                                {{ $index + 1 }}
                            </div>
                            <div class="min-w-0">
                                <h6 class="font-bold text-slate-800 text-sm leading-tight mb-1 truncate" title="{{ $tour->name }}">{{ $tour->name }}</h6>
                                <div class="flex items-center gap-3 text-[11px] font-bold">
                                    <span class="text-slate-500 bg-white px-2 py-0.5 rounded border border-slate-200"><i class="fa-solid fa-receipt mr-1"></i>{{ $tour->total_orders }} Đơn</span>
                                    <span class="text-emerald-600"><i class="fa-solid fa-coins mr-1"></i>{{ number_format($tour->revenue) }} ₫</span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-slate-400 py-10">
                            <i class="fa-solid fa-medal text-4xl mb-3 opacity-50"></i>
                            <p class="text-sm font-medium">Chưa có dữ liệu Tour bán được</p>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>

    </div>
</div>

<style>
    .custom-scrollbar::-webkit-scrollbar {
        width: 4px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 4px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background-color: #cbd5e1;
        border-radius: 4px;
    }
</style>

{{-- SCRIPT CHART JS --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    @php
        $labels = $revenueByWeek->map(function ($item) {
            return 'Ngày ' . \Carbon\Carbon::parse($item->week_start)->format('d/m');
        });
    @endphp

    const labels = @json($labels);
    const dataVals = @json($revenueByWeek->pluck('revenue'));

    const ctx = document.getElementById('revenueChart').getContext('2d');
    
    // Create Gradient for Chart Line Area
    let gradient = ctx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(16, 185, 129, 0.4)'); // Emerald 500
    gradient.addColorStop(1, 'rgba(16, 185, 129, 0.0)');  // Transparent
    
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Doanh thu (VNĐ)',
                data: dataVals,
                borderColor: '#10b981', // emerald-500
                backgroundColor: gradient,
                borderWidth: 3,
                fill: true,
                tension: 0.4, // Smooth curvy curves
                pointRadius: 4,
                pointBackgroundColor: '#ffffff',
                pointBorderColor: '#10b981',
                pointBorderWidth: 2,
                pointHoverRadius: 6,
                pointHoverBackgroundColor: '#10b981',
                pointHoverBorderColor: '#ffffff',
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                intersect: false,
                mode: 'index',
            },
            plugins: {
                legend: {
                    display: false // Hide legend to look cleaner
                },
                tooltip: {
                    backgroundColor: 'rgba(15, 23, 42, 0.9)', // slate-900
                    titleFont: { size: 13, family: "'Inter', sans-serif" },
                    bodyFont: { size: 14, family: "'Inter', sans-serif", weight: 'bold' },
                    padding: 12,
                    cornerRadius: 8,
                    callbacks: {
                        label: function(context) {
                            return ' ' + context.parsed.y.toLocaleString('vi-VN') + ' ₫';
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false,
                        drawBorder: false
                    },
                    ticks: {
                        font: { family: "'Inter', sans-serif", size: 11 },
                        color: '#64748b' // slate-500
                    }
                },
                y: {
                    border: { display: false },
                    grid: {
                        color: '#f1f5f9', // slate-100
                        drawTicks: false
                    },
                    ticks: {
                        font: { family: "'Inter', sans-serif", size: 11 },
                        color: '#64748b', // slate-500
                        padding: 10,
                        callback: value => value.toLocaleString('vi-VN') + ' đ'
                    }
                }
            }
        }
    });
});
</script>

@endsection
