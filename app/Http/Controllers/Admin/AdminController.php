<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function home()
    {
        $orders = Order::all();
        $totalRevenue = $orders->sum('total_price');
        $totalOrders = $orders->count();

        $todayOrders = Order::whereBetween('created_at', [
            now()->startOfMonth(),
            now()->endOfMonth(),
        ])->count();

        $yesterdayOrders = Order::whereBetween('created_at', [
            now()->subMonth()->startOfMonth(),
            now()->subMonth()->endOfMonth(),
        ])->count();
        $orderChange = $yesterdayOrders > 0 ? round((($todayOrders - $yesterdayOrders) / $yesterdayOrders) * 100, 1) : 0;

        $totalUsers = DB::table('users')->count();
        $todayUsers = DB::table('users')->whereBetween('created_at', [
            now()->startOfMonth(),
            now()->endOfMonth(),
        ])->count();

        $yesterdayUsers = DB::table('users')->whereBetween('created_at', [
            now()->subMonth()->startOfMonth(),
            now()->subMonth()->endOfMonth(),
        ])->count();
        $userChange = $yesterdayUsers > 0 ? round((($todayUsers - $yesterdayUsers) / $yesterdayUsers) * 100, 1) : 0;

        $totalTours = DB::table('tours')->count();
        $todayTours = DB::table('tours')->whereBetween('created_at', [
            now()->startOfMonth(),
            now()->endOfMonth(),
        ])->count();
        $yesterdayTours = DB::table('tours')->whereBetween('created_at', [
            now()->subMonth()->startOfMonth(),
            now()->subMonth()->endOfMonth(),
        ])->count();
        $tourChange = $yesterdayTours > 0 ? round((($todayTours - $yesterdayTours) / $yesterdayTours) * 100, 1) : 0;

        $views = DB::table('views')->count();
        $todayViews = DB::table('views')->whereBetween('created_at', [
            now()->startOfMonth(),
            now()->endOfMonth(),
        ])->count();

        $yesterdayViews = DB::table('views')->whereBetween('created_at', [
            now()->subMonth()->startOfMonth(),
            now()->subMonth()->endOfMonth(),
        ])->count();
        $viewChange = $yesterdayViews > 0 ? round((($todayViews - $yesterdayViews) / $yesterdayViews) * 100, 1) : 0;

        $todayRevenue = Order::whereBetween('created_at', [
            now()->startOfMonth(),
            now()->endOfMonth(),
        ])->sum('total_price');

        $yesterdayRevenue = Order::whereBetween('created_at', [
            now()->subMonth()->startOfMonth(),
            now()->subMonth()->endOfMonth(),
        ])->sum('total_price');
        $revenueChange = $yesterdayRevenue > 0 ? round((($todayRevenue - $yesterdayRevenue) / $yesterdayRevenue) * 100, 1) : 0;

        $pendingOrders = Order::where('status', '0')->count();
        $completedOrders = Order::where('status', '1')->count();

        
        $orderPending = Order::where('status', '0')->count();
        $orderCompleted = Order::where('status', '1')->count();
        $orderCancelled = Order::where('status', '2')->count();
        $orderConfirmed = Order::where('status', '3')->count();

        $topTours = \App\Models\Tour::with('category')
            ->withCount('orders')
            ->withSum('views', 'view')
            ->orderByDesc('orders_count')
            ->limit(5)
            ->get();

        $recentOrders = \App\Models\Order::with('user')
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        $monthlyRevenue = Order::selectRaw('MONTH(created_at) as month, YEAR(created_at) as year, SUM(total_price) as total')
            ->groupBy('month', 'year')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        return view('admin.dashboard', compact(
            'orders',
            'totalOrders',
            'views',
            'totalRevenue',
            'totalUsers',
            'totalTours',
            'todayOrders',
            'orderPending',
            'orderCompleted',
            'orderCancelled',
            'orderConfirmed',
            'topTours',
            'recentOrders',
            'userChange',
            'tourChange',
            'orderChange',
            'revenueChange',
            'viewChange',
            'monthlyRevenue'
        ));
    }

    public function login()
    {
        return view('admin.login');
    }

    public function postLogin(Request $request)
    {
        if (Auth::attempt([
            'email' => $request->email,
            'password' => $request->password,
        ])) {
            return redirect()->route('admin.home');
        } else {
            return redirect()->back()->with('error', 'Tài khoản hoặc mật khẩu không chính xác. Vui lòng thử lại')->withInput();
        }
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route('admin.home');
    }
}
