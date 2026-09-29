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

        $transportValues = $attributesGrouped->get('transport', []);
        $tourTypeValues = $attributesGrouped->get('tour_type', []);
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
        // $user = User::findOrFail(Auth::user()->id);

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
