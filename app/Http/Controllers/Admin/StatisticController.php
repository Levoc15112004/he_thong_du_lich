<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StatisticController extends Controller
{
    /**
     * Lưu snapshot thống kê theo TUẦN
     * date = ngày thứ 2 của tuần
     */
    private function saveWeeklyStatistics(Carbon $date)
    {
        $startOfWeek = $date->copy()->startOfWeek(Carbon::MONDAY);
        $endOfWeek   = $date->copy()->endOfWeek(Carbon::SUNDAY);

        $weekDate = $startOfWeek->toDateString(); // lưu date đại diện

        $totalOrders = DB::table('orders')
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->count();

        $totalRevenue = DB::table('payments')
            ->where('status', 1)
            ->whereBetween('payment_date', [$startOfWeek, $endOfWeek])
            ->sum('amount');

        $totalUsers = DB::table('users')
            ->whereDate('created_at', '<=', $endOfWeek)
            ->count();

        $totalViews = DB::table('views')
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->sum('view');

        DB::table('statistics')->updateOrInsert(
            ['date' => $weekDate],
            [
                'total_orders'  => $totalOrders,
                'total_revenue' => $totalRevenue,
                'total_users'   => $totalUsers,
                'total_views'   => $totalViews,
                'updated_at'    => now(),
                'created_at'    => now(),
            ]
        );
    }

    // báo cáo tổng hợp doanh thu
    public function index(Request $request)
    {
        $month = $request->month;
        $year  = $request->year ?? date('Y');

        // Snapshot tuần hiện tại
        $this->saveWeeklyStatistics(now());

        // Truy vấn đơn hàng hợp lệ (không tính đơn hủy status = 4)
        $ordersBaseQuery = DB::table('orders')->where('status', '!=', 4);

        if ($month) {
            $ordersBaseQuery->whereMonth('created_at', $month)->whereYear('created_at', $year);
        } elseif ($year) {
            $ordersBaseQuery->whereYear('created_at', $year);
        }

        // Tổng doanh thu & tổng đơn hàng từ orders
        $totalRevenue = (clone $ordersBaseQuery)->sum('total_price');
        $totalOrders  = (clone $ordersBaseQuery)->count();
        $totalUsers   = DB::table('users')->count();

        // Nếu filter không có đơn, lấy toàn bộ đơn không hủy làm số liệu tổng quan
        if ($totalRevenue == 0 && !$month && $year == date('Y')) {
            $totalRevenue = DB::table('orders')->where('status', '!=', 4)->sum('total_price');
            $totalOrders  = DB::table('orders')->where('status', '!=', 4)->count();
        }

        // Dữ liệu biểu đồ theo chu kỳ
        if ($month) {
            $revenueByWeek = DB::table('orders')
                ->where('status', '!=', 4)
                ->whereMonth('created_at', $month)
                ->whereYear('created_at', $year)
                ->select(
                    DB::raw('DATE(created_at) as week_start'),
                    DB::raw('SUM(total_price) as revenue'),
                    DB::raw('COUNT(id) as total_orders')
                )
                ->groupBy(DB::raw('DATE(created_at)'))
                ->orderBy('week_start')
                ->get();
        } else {
            $revenueByWeek = DB::table('orders')
                ->where('status', '!=', 4)
                ->whereYear('created_at', $year)
                ->select(
                    DB::raw('MIN(DATE(created_at)) as week_start'),
                    DB::raw('MONTH(created_at) as month_num'),
                    DB::raw('SUM(total_price) as revenue'),
                    DB::raw('COUNT(id) as total_orders')
                )
                ->groupBy(DB::raw('MONTH(created_at)'))
                ->orderBy('month_num')
                ->get();
        }

        // Doanh thu theo tháng
        $revenueByMonth = DB::table('orders')
            ->where('status', '!=', 4)
            ->select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(total_price) as revenue'),
                DB::raw('COUNT(id) as orders')
            )
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();

        // Top tour bán chạy
        $topTours = DB::table('orders')
            ->join('tours', 'orders.tour_id', '=', 'tours.id')
            ->where('orders.status', '!=', 4)
            ->select(
                'tours.name',
                DB::raw('COUNT(orders.id) as total_orders'),
                DB::raw('SUM(orders.total_price) as revenue')
            )
            ->when($month, function ($q) use ($month, $year) {
                $q->whereMonth('orders.created_at', $month)
                  ->whereYear('orders.created_at', $year);
            })
            ->when(!$month && $year, function ($q) use ($year) {
                $q->whereYear('orders.created_at', $year);
            })
            ->groupBy('tours.name')
            ->orderByDesc('total_orders')
            ->limit(10)
            ->get();

        // So sánh tuần này vs tuần trước
        $startThisWeek = now()->startOfWeek(Carbon::MONDAY);
        $endThisWeek   = now()->endOfWeek(Carbon::SUNDAY);
        $startLastWeek = now()->subWeek()->startOfWeek(Carbon::MONDAY);
        $endLastWeek   = now()->subWeek()->endOfWeek(Carbon::SUNDAY);

        $currentWeekRevenue  = DB::table('orders')->where('status', '!=', 4)->whereBetween('created_at', [$startThisWeek, $endThisWeek])->sum('total_price');
        $previousWeekRevenue = DB::table('orders')->where('status', '!=', 4)->whereBetween('created_at', [$startLastWeek, $endLastWeek])->sum('total_price');

        $revenueChangePercent = 0;
        if ($previousWeekRevenue > 0) {
            $revenueChangePercent = (($currentWeekRevenue - $previousWeekRevenue) / $previousWeekRevenue) * 100;
        } elseif ($currentWeekRevenue > 0) {
            $revenueChangePercent = 100;
        }

        return view('admins.Reports.index', [
            'totalRevenue' => $totalRevenue,
            'totalOrders'  => $totalOrders,
            'totalUsers'   => $totalUsers,
            'revenueByWeek' => $revenueByWeek,
            'revenueByMonth' => $revenueByMonth,
            'currentWeekRevenue'  => $currentWeekRevenue,
            'previousWeekRevenue' => $previousWeekRevenue,
            'revenueChangePercent' => round($revenueChangePercent, 2),
            'topTours' => $topTours,
            'filter' => [
                'month' => $month,
                'year'  => $year,
            ],
        ]);
    }
}
