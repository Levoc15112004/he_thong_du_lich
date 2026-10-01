<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\AttrTour;
use App\Models\Category;
use App\Models\Notification;
use App\Models\Order;
use App\Models\Review;
use App\Models\Tour;
use App\Models\TourAttr;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TourDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
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

        $tour = Tour::with([
            'images',
            'schedules',
            'attrTours',
            'category',
            'favoritedBy',
        ])->find($id);

        if (! $tour) {
            return redirect()->back()->with('error', 'Tour không tồn tại');
        }

        DB::table('views')->updateOrInsert(
            ['tour_id' => $id],
            [
                'view' => DB::raw('COALESCE(view,0) + 1'),
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );

        $attributesGrouped = collect();
        $attrs = AttrTour::whereIn(
            'id',
            TourAttr::where('tour_id', $tour->id)->pluck('attr_tour_id')->toArray()
        )->get(['name', 'value']);

        $attributesGrouped = $attrs->groupBy('name')->map(function ($group) {
            return $group->pluck('value')->toArray();
        });

        $transportValues = $attributesGrouped->get('transport')
            ?: $attributesGrouped->get('Phương tiện')
            ?: $attributesGrouped->get('phuong_tien')
            ?: [];

        if (empty($transportValues)) {
            $transportValues = ['Xe du lịch đời mới cao cấp', 'Máy bay & Xe đưa đón'];
        }

        $tourTypeValues = $attributesGrouped->get('tour_type')
            ?: $attributesGrouped->get('Loại tour')
            ?: $attributesGrouped->get('Khách sạn')
            ?: [];

        if (empty($tourTypeValues)) {
            $tourTypeValues = ['Khách sạn 4-5 sao cao cấp', 'Resort / Khách sạn 3 sao'];
        }

        $quantity = $tour->quantity ?? 0;

        // lấy loại tour
        $tourType = $tour->attrTours()
            ->where('name', 'tour_type')
            ->value('value');

        // Tính số lượng chỗ còn trống (Mặc định - Đã đặt trong Order)
        $booked = Order::where('tour_id', $tour->id)->sum('quantity');
        $slots = max($quantity - $booked, 0);

        $tourRelate = Tour::where('category_id', $tour->category_id)
            ->where('id', '!=', $tour->id)
            ->limit(4)
            ->get();

        $images = $tour->images ?? collect();
        $tourSchedules = $tour->schedules ?? collect();

        // Tự động bổ sung đủ số ngày lịch trình nếu tour 3-4 ngày mà DB chỉ mới có 1-2 ngày
        $expectedDays = 2;
        if (preg_match('/(\d+)\s*(ngày|n)/i', ($tour->time ?? '').' '.($tour->name ?? ''), $matches)) {
            $expectedDays = max((int) $matches[1], 2);
        }

        if ($tourSchedules->count() < $expectedDays) {
            $existingCount = $tourSchedules->count();
            $dest = $tour->end_location ?? 'Điểm đến';
            for ($d = $existingCount + 1; $d <= $expectedDays; $d++) {
                $mockDay = new \App\Models\TourSchedule();
                $mockDay->id = 9990 + $d;
                $mockDay->tour_id = $tour->id;
                $mockDay->day_number = $d;
                if ($d === $expectedDays) {
                    $mockDay->title = "Ngày {$d}: Tự do mua sắm đặc sản - Trả phòng - Tạm biệt {$dest}";
                    $mockDay->description = "Buổi Sáng: Dùng điểm tâm sáng buffet tại khách sạn, tự do dạo phố, chụp ảnh check-in và mua sắm đặc sản làm quà lưu niệm. Buổi Trưa: Làm thủ tục trả phòng, xe đưa đoàn ra sân bay/nhà xe khởi hành về lại điểm ban đầu. Kết thúc hành trình trọn vẹn và an toàn!";
                } else {
                    $mockDay->title = "Ngày {$d}: Khám phá văn hóa & Trải nghiệm sinh thái tại {$dest}";
                    $mockDay->description = "Buổi Sáng: Tham quan các danh lam thắng cảnh biểu tượng của địa phương và thưởng thức ẩm thực đặc sắc. Buổi Chiều: Tham gia các hoạt động vui chơi giải trí, tắm biển hoặc check-in ngắm hoàng hôn. Buổi Tối: Thưởng thức bữa tối ẩm thực địa phương và tự do khám phá phố đêm.";
                }
                $mockDay->image = $tour->image;
                $mockDay->location_name = $dest;
                $tourSchedules->push($mockDay);
            }
        }

        foreach ($tourSchedules as $schedule) {

            $parts = preg_split(
                '/Buổi (Sáng|Trưa|Chiều|Tối):/ui',
                $schedule->description,
                -1,
                PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY
            );

            $parsed = [];

            for ($i = 0; $i < count($parts); $i += 2) {
                $parsed[$parts[$i]] = trim($parts[$i + 1] ?? '');
            }

            $schedule->parsed = $parsed;
        }

        // dd($tourSchedules->pluck('parsed'));

        $orderIds = Order::where('tour_id', $tour->id)->pluck('id');
        $reviews = Review::whereIn('order_id', $orderIds)
            ->with('user')
            ->latest()
            ->get();

        $avgRating = Review::whereIn('order_id', $orderIds)->avg('rating');

        return view('users.tourDetail', compact(
            'tour',
            'categories',
            'tourRelate',
            'attributesGrouped',
            'images',
            'transportValues',
            'tourTypeValues',
            'quantity',
            'slots',
            'tourSchedules',
            'reviews',
            'avgRating',
            'notifications',
            'unreadCount'
        ));
    }

    public function getScheduleByTour($tour_id)
    {
        $tour = Tour::with([
            'schedules' => function ($q) {
                $q->orderBy('day_number', 'asc');
            },
        ])->findOrFail($tour_id);

        return response()->json([
            'tour' => $tour,
            'schedules' => $tour->schedules,
        ]);
    }
}
