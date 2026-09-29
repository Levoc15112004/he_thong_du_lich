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

    // báo cáo theo tuần
    public function index(Request $request)
    {
        $month = $request->month;
        $year  = $request->year;

        // lưu tuần hiện tại
        $this->saveWeeklyStatistics(now());

       //truy vấn thống kê từ DB
        $statisticsQuery = DB::table('statistics');

        // filter theo tháng (các tuần trong tháng)
        if ($month) {
            $statisticsQuery
                ->whereMonth('date', $month)
                ->whereYear('date', $year ?? date('Y'));
        }
        // filter theo năm
        elseif ($year) {
            $statisticsQuery->whereYear('date', $year);
        }
        // mặc định năm hiện tại
        else {
            $statisticsQuery->whereYear('date', date('Y'));
        }

        // tổng quan
        $totalRevenue = (clone $statisticsQuery)->sum('total_revenue');
        $totalOrders  = (clone $statisticsQuery)->sum('total_orders');
        $totalUsers   = DB::table('users')->count();

        // doanh thu theo tuần
        $revenueByWeek = (clone $statisticsQuery)
            ->select(
                'date as week_start',
                'total_revenue as revenue',
                'total_orders'
            )
            ->orderBy('week_start')
            ->get();

        // top tour
        $topTours = DB::table('orders')
            ->join('tours', 'orders.tour_id', '=', 'tours.id')
            ->select(
                'tours.name',
                DB::raw('COUNT(orders.id) as total_orders'),
                DB::raw('SUM(orders.total_price) as revenue')
            )
            ->when($month, function ($q) use ($month, $year) {
                $q->whereMonth('orders.created_at', $month)
                  ->whereYear('orders.created_at', $year ?? date('Y'));
            })
            ->when(!$month && $year, function ($q) use ($year) {
                $q->whereYear('orders.created_at', $year);
            })
            ->groupBy('tours.name')
            ->orderByDesc('total_orders')
            ->limit(10)
            ->get();

            //  so sánh tuần
        $currentWeek = now()->startOfWeek(Carbon::MONDAY)->toDateString();
        $previousWeek = now()->subWeek()->startOfWeek(Carbon::MONDAY)->toDateString();

        $currentWeekRevenue = DB::table('statistics')
            ->where('date', $currentWeek)
            ->value('total_revenue') ?? 0;

        $previousWeekRevenue = DB::table('statistics')
            ->where('date', $previousWeek)
            ->value('total_revenue') ?? 0;

        $revenueChangePercent = 0;
        if ($previousWeekRevenue > 0) {
            $revenueChangePercent =
                (($currentWeekRevenue - $previousWeekRevenue) / $previousWeekRevenue) * 100;
        }

        // doanh thu theo tháng
        $revenueByMonth = DB::table('statistics')
            ->select(
                DB::raw('YEAR(date) as year'),
                DB::raw('MONTH(date) as month'),
                DB::raw('SUM(total_revenue) as revenue'),
                DB::raw('SUM(total_orders) as orders')
            )
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();


        return view('admins.Reports.index', [

            // tổng quan
            'totalRevenue' => $totalRevenue,
            'totalOrders'  => $totalOrders,
            'totalUsers'   => $totalUsers,

            // theo tuần
            'revenueByWeek' => $revenueByWeek,

            // theo tháng
            'revenueByMonth' => $revenueByMonth,

            // so sánh
            'currentWeekRevenue'  => $currentWeekRevenue,
            'previousWeekRevenue' => $previousWeekRevenue,
            'revenueChangePercent' => round($revenueChangePercent, 2),

            // top
            'topTours' => $topTours,

            // filter
            'filter' => [
                'month' => $month,
                'year'  => $year,
            ],
        ]);
    }
}
