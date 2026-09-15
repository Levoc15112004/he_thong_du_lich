<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Notification;
use App\Models\Tour;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        if (! Session::get('viewed')) {
            Session::put('viewed', true);
            DB::table('views')->insert([
                'view' => 1,
            ]);
        }

        $notifications = Notification::where('user_id', Auth::id())
            ->orderByDesc('created_at')
            ->take(10)
            ->get();

        $unreadCount = Notification::where('user_id', Auth::id())
            ->where('status', 'unread')
            ->count();

        $banners = Banner::latest()->take(2)->get();
        $categories = Category::where('status', 1)
            ->whereNull('category_id')
            ->with('children')
            ->orderByDesc('id')
            ->take(10)
            ->get();

        $tours = Tour::where('status', 1)
            ->orderByDesc('id')
            ->paginate(8);

        //  tour hot nhất
        $bookedTourIds = DB::table('orders')->pluck('tour_id')->toArray();
        $counted = array_count_values($bookedTourIds);
        arsort($counted);
        $sortedIds = array_keys($counted);

        $topBuy = collect();
        if (! empty($sortedIds)) {
            $topBuy = Tour::where('status', 1)
                ->whereIn('id', $sortedIds)
                ->orderByRaw('FIELD(id, '.implode(',', $sortedIds).')')
                ->take(5)
                ->get();
        }

        $mainTour = $topBuy->first();
        $otherTours = $topBuy->slice(1);

        //  danh mục con
        $subCategories = Category::where('status', 1)
            ->whereNotNull('category_id')
            ->with('parent')
            ->orderByDesc('id')
            ->take(10)
            ->get();

        // Tour theo danh mục con
        $categoryId = $request->query('category');
        $tourCate = Tour::where('status', 1)
            ->when($categoryId, function ($query) use ($categoryId) {
                $query->where('category_id', $categoryId);
            })
            ->orderByDesc('id')
            ->paginate(4)
            ->withQueryString(); // giữ category khi chuyển trang

        $user = Auth::check() ? Auth::user() : null;

        $blogs = Blog::where('status', 1)
            ->latest()
            ->paginate(6);

        // Thời tiết
        $weatherData = null;
        $forecastData = [];

        try {
            $response = Http::timeout(10)
                ->retry(2, 500)
                ->get('https://api.openweathermap.org/data/2.5/forecast', [
                    'q' => 'Hanoi,VN',
                    'appid' => config('services.openweather.key'),
                    'units' => 'metric',
                    'lang' => 'vi',
                ]);

            if ($response->successful()) {
                $data = $response->json();

                if (! empty($data['list'][0])) {
                    //  Thời tiết hiện tại
                    $weatherData = [
                        'city' => $data['city']['name'],
                        'temp' => round($data['list'][0]['main']['temp']),
                        'desc' => $data['list'][0]['weather'][0]['description'],
                        'icon' => $data['list'][0]['weather'][0]['icon'],
                    ];

                    // dự báo 5 ngày
                    $forecastData = collect($data['list'])
                        ->filter(fn ($item) => str_contains($item['dt_txt'], '12:00:00'))
                        ->take(5)
                        ->map(fn ($item) => [
                            'date' => Carbon::parse($item['dt_txt'])->format('d/m'),
                            'temp' => round($item['main']['temp']),
                            'icon' => $item['weather'][0]['icon'],
                        ])
                        ->values()
                        ->toArray();
                }
            }
        } catch (\Exception $e) {
            // Không làm crash trang web khi lỗi API thời tiết
        }

        // Cập nhật các biến cho home view mới
        $hotTours = Tour::select('tours.*')
            ->selectSub(function ($query) {
             $query->from('views')
            ->selectRaw('COALESCE(SUM(views.view), 0)')
            ->whereColumn('views.tour_id', 'tours.id');
            }, 'total_views')
            ->with('category')
            ->where('tours.status', 1)
            ->orderByDesc('total_views')
            ->limit(4)
            ->get();

        $destinations = Tour::select('end_location', DB::raw('MIN(image) as image'), DB::raw('COUNT(*) as total_tours'))
            ->where('status', 1)
            ->groupBy('end_location')
            ->limit(8)
            ->get();

        $recentBlogs = Blog::where('status', 1)
            ->latest()
            ->take(3)
            ->get();

        return view('user.home', compact(
            'banners',
            'categories',
            'tours',
            'mainTour',
            'otherTours',
            'subCategories',
            'tourCate',
            'categoryId',
            'user',
            'blogs',
            'weatherData',
            'forecastData',
            'notifications',
            'unreadCount',
            'hotTours',
            'destinations',
            'recentBlogs'
        ));
    }

    public function ajax(Request $request)
    {
        $city = $request->get('city', 'Hanoi');

        try {
            $response = Http::timeout(10)
                ->get('https://api.openweathermap.org/data/2.5/forecast', [
                    'q' => $city,
                    'appid' => config('services.openweather.key'),
                    'units' => 'metric',
                    'lang' => 'vi',
                ]);

            if ($response->failed()) {
                return response()->json([
                    'error' => 'Không lấy được dữ liệu thời tiết',
                ], 500);
            }
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Không lấy được dữ liệu thời tiết',
            ], 500);
        }

        $data = $response->json();

        return response()->json([
            'current' => [
                'city' => $data['city']['name'],
                'temp' => round($data['list'][0]['main']['temp']),
                'desc' => $data['list'][0]['weather'][0]['description'],
                'icon' => $data['list'][0]['weather'][0]['icon'],
            ],
            'forecast' => collect($data['list'])
                ->filter(fn ($item) => str_contains($item['dt_txt'], '12:00:00'))
                ->take(5)
                ->map(fn ($item) => [
                    'date' => \Carbon\Carbon::parse($item['dt_txt'])->format('d/m'),
                    'temp' => round($item['main']['temp']),
                    'icon' => $item['weather'][0]['icon'],
                ])
                ->values(),
        ]);
    }

    public function markAsRead($id)
    {
        $notification = Notification::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if ($notification->status === 'unread') {
            $notification->update([
                'status' => 'read',
            ]);
        }

        return redirect()->back();
    }

    public function default()
    {
        $hotTours = Tour::select('tours.*', DB::raw('COALESCE(SUM(views.view), 0) as total_views'))
            ->leftJoin('views', 'tours.id', '=', 'views.tour_id')
            ->groupBy('tours.id')
            ->orderByDesc('total_views')
            ->limit(6)
            ->get();

        $destinations = Tour::select('end_location')->distinct()->limit(6)->get();

        return response()->json([
            'hotTours' => $hotTours,
            'destinations' => $destinations,
        ]);
    }

    public function search(Request $request)
    {
        $keyword = $request->keyword;

        if (! $keyword) {
            return response()->json([]);
        }

        $tours = Tour::where('name', 'like', "%$keyword%")
            ->orWhere('end_location', 'like', "%$keyword%")
            ->limit(10)
            ->get();

        return response()->json($tours);
    }

    public function searchHome(Request $request)
    {
        $categories = Category::where('status', 1)
            ->whereNull('category_id')
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
        $keyword = $request->keyword;

        if (! $keyword) {
            return response()->json([]);
        }

        $tours = Tour::where(function ($query) use ($keyword) {
            $query->where('name', 'like', "%{$keyword}%")
                ->orWhere('end_location', 'like', "%{$keyword}%");
        })
            ->orderByDesc('id')
            ->paginate(8);

        return view('user.searchPage', compact('tours', 'categories', 'notifications', 'unreadCount'));
    }

    public function TourCate($id)
    {
        $categories = Category::where('status', 1)
            ->whereNull('category_id')
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

        $subCategories = Category::where('status', 1)
            ->whereNotNull('category_id')
            ->with('parent')
            ->orderByDesc('id')
            ->take(10)
            ->get();

        // chỉ lấy tour theo category được chọn
        $tourCate = Tour::where('status', 1)
            ->where('category_id', $id)
            ->orderByDesc('id')
            ->paginate(8);

        return view('user.TourCate', compact(
            'categories',
            'subCategories',
            'tourCate',
            'id',
            'notifications',
            'unreadCount'
        ));
    }

    public function profile($id)
    {
        $categories = Category::where('status', 1)
            ->whereNull('category_id')
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

        $user = User::findOrFail($id);

        return view('user.profile', compact('user', 'categories', 'notifications', 'unreadCount'));
    }

    public function updateProfile(Request $request)
    {
        $user = User::findOrFail(Auth::id());

        $avatarPath = $user->avatar;

        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('fontend/img'), $filename);

            $avatarPath = 'fontend/img/'.$filename;
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'gender' => $request->gender,
            'birthday' => $request->birthday,
            'avatar' => $avatarPath,
        ]);

        return back()->with('success', 'Cập nhật thông tin thành công!');
    }

    public function contact()
    {
        $categories = Category::where('status', 1)
            ->whereNull('category_id')
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

        return view('user.contact', compact('categories', 'notifications', 'unreadCount'));
    }
}
