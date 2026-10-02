<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Notification;
use App\Models\Order;
use App\Models\Tour;
use Illuminate\Support\Facades\Auth;

class TourBookedController extends Controller
{
    public function myBookedTours()
    {
        // Nếu chưa đăng nhập
        if (! Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Vui lòng đăng nhập để xem tour đã đặt.');
        }

        $user = Auth::user();

        // Lấy danh mục menu
        $categories = Category::where('status', 1)
            ->whereNull('parent_id')
            ->with('children')
            ->orderByDesc('id')
            ->take(10)
            ->get();

        $notifications = Notification::where('user_id', Auth::id())
            ->orderByDesc('created_at')
            ->take(10)
            ->get();

        $unreadCount = Notification::where('user_id', Auth::id())
            ->where('status', 'unread')
            ->count();

        // lấy tất cả các đơn của user
        $orders = Order::with([
            'payments',
            'tour',
            'tour.schedules',
        ])
            ->where('user_id', $user->id)
            ->whereIn('status', [0, 1, 2, 3, 4])
            ->orderByDesc('id')
            ->get();

        // Thêm thông tin thanh toán cho mỗi order
        $orders->transform(function ($order) {

            $totalPaid = $order->payments
                ->where('status', 1)
                ->sum('amount');

            $depositPaid = $order->payments
                ->where('status', 1)
                ->where('payment_type', 'deposit')
                ->sum('amount');

            $finalPaid = $order->payments
                ->where('status', 1)
                ->where('payment_type', 'final')
                ->sum('amount');

            if ($totalPaid >= $order->total_price) {
                $paymentStatus = 'Đã thanh toán đủ';
            } elseif ($depositPaid > 0) {
                $paymentStatus = 'Đã đặt cọc';
            } else {
                $paymentStatus = 'Chưa thanh toán';
            }

            $order->paymentInfo = [
                'total_price' => $order->total_price,
                'total_paid' => $totalPaid,
                'deposit_paid' => $depositPaid,
                'final_paid' => $finalPaid,
                'payment_status' => $paymentStatus,
            ];

            return $order;
        });

        // tính tổng tất cả các đơn hàng trong giỏ hàng
        $total_price_all = $orders->sum(fn ($o) => $o->paymentInfo['total_price']);
        $total_paid_all = $orders->sum(fn ($o) => $o->paymentInfo['total_paid']);
        $total_remaining_all = $total_price_all - $total_paid_all;

        // Trả về view
        return view('users.tourBooked', [
            'categories' => $categories,
            'user' => $user,
            'orders' => $orders,
            'total_price_all' => $total_price_all,
            'total_paid_all' => $total_paid_all,
            'total_remaining_all' => $total_remaining_all,
            'notifications' => $notifications,
            'unreadCount' => $unreadCount,
        ]);
    }

    public function showSchedule($order_id)
    {
        // Lấy Order + Tour + Schedules
        $order = Order::with([
            'tour.images',
            'tour.attributes',
            'tour.schedules' => function ($q) {
                $q->orderBy('day_number', 'asc');
            },
        ])->findOrFail($order_id);

        $tour = $order->tour;

        return view('users.tourBooked', [
            'tour' => $tour,
            'schedules' => $tour->schedules,
            'mapUrl' => $tour->map_url ?? '',
            'directionsUrl' => $tour->directions_url ?? '',
        ]);
    }

    public function getScheduleData($order_id)
    {
        $order = Order::with([
            'tour.schedules' => function ($q) {
                $q->orderBy('day_number', 'asc');
            },
        ])->findOrFail($order_id);

        $tour = $order->tour;
        $schedules = $tour->schedules ?? collect();
        $destCoords = $this->getCityCoordinates($tour->end_location ?? 'Đà Nẵng');

        if ($schedules->isEmpty()) {
            $expectedDays = 3;
            if (preg_match('/(\d+)\s*(ngày|n)/i', ($tour->time ?? '').' '.($tour->name ?? ''), $matches)) {
                $expectedDays = max((int) $matches[1], 2);
            }

            $mockSchedules = collect();
            for ($d = 1; $d <= $expectedDays; $d++) {
                $latOffset = ($d - 1) * 0.015;
                $lngOffset = ($d - 1) * 0.012;
                $mockSchedules->push((object)[
                    'id' => 9990 + $d,
                    'tour_id' => $tour->id,
                    'day_number' => $d,
                    'title' => "Ngày {$d}: Khám phá điểm đến {$tour->end_location}",
                    'description' => "Trải nghiệm tham quan các danh lam thắng cảnh tiêu biểu tại {$tour->end_location}, thưởng thức ẩm thực bản địa.",
                    'location_name' => $tour->end_location,
                    'latitude' => round($destCoords[0] + $latOffset, 6),
                    'longitude' => round($destCoords[1] + $lngOffset, 6),
                ]);
            }
            $schedules = $mockSchedules;
        } else {
            foreach ($schedules as $index => $sch) {
                if (empty($sch->latitude) || empty($sch->longitude)) {
                    $sch->latitude = round($destCoords[0] + ($index * 0.012), 6);
                    $sch->longitude = round($destCoords[1] + ($index * 0.010), 6);
                }
            }
        }

        return response()->json([
            'tour' => $tour,
            'schedules' => $schedules,
            'center' => $destCoords,
        ]);
    }

    private function getCityCoordinates($cityName)
    {
        $map = [
            'Phú Quốc' => [10.2899, 103.9840],
            'Đà Lạt' => [11.9404, 108.4583],
            'Sa Pa' => [22.3364, 103.8438],
            'Sapa' => [22.3364, 103.8438],
            'Hạ Long' => [20.9501, 107.0734],
            'Đà Nẵng' => [16.0544, 108.2022],
            'Hội An' => [15.8801, 108.3380],
            'Nha Trang' => [12.2388, 109.1967],
            'Hà Giang' => [22.8233, 104.9839],
            'Ninh Bình' => [20.2506, 105.9745],
            'Huế' => [16.4637, 107.5909],
            'Quy Nhơn' => [13.7820, 109.2197],
            'Phú Yên' => [13.0882, 109.3138],
            'Côn Đảo' => [8.6835, 106.6062],
            'Cần Thơ' => [10.0452, 105.7469],
            'Phan Thiết' => [10.9333, 108.1000],
            'Mũi Né' => [10.9333, 108.1000],
            'Hà Nội' => [21.0285, 105.8542],
            'TP. Hồ Chí Minh' => [10.8231, 106.6297],
            'Sài Gòn' => [10.8231, 106.6297],
            'Buôn Ma Thuột' => [12.6675, 108.0383],
            'Mộc Châu' => [20.8441, 104.6360],
            'Cao Bằng' => [22.6667, 106.2500],
            'Vũng Tàu' => [10.3460, 107.0843],
            'An Giang' => [10.5216, 105.1259],
        ];

        foreach ($map as $key => $coords) {
            if (mb_stripos($cityName, $key) !== false || mb_stripos($key, $cityName) !== false) {
                return $coords;
            }
        }

        return [16.0544, 108.2022];
    }
}
