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
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Artisan;


class HomeController extends Controller
{
    private function getAdviceScore($weatherId, $temp)
    {
        $advice = 'Thời tiết khá lý tưởng. Chuẩn bị trang phục năng động và thoải mái.';
        $score = '9.0 / 10 Tốt';
        $bg = 'bg-emerald-100';
        $text = 'text-emerald-700';

        if ($weatherId >= 200 && $weatherId < 300) {
            $advice = 'Có dông sét nguy hiểm. Tránh các hoạt động ngoài trời, cáp treo hay tắm biển. Hãy chọn áo khoác chống nước và ưu tiên điểm du lịch trong nhà.';
            $score = '2.0 / 10 Rất Xấu';
            $bg = 'bg-rose-100';
            $text = 'text-rose-700';
        } elseif ($weatherId >= 300 && $weatherId < 600) {
            $advice = 'Trời có mưa. Nhớ mang theo ô (dù), áo mưa tiện lợi và túi chống nước cho thiết bị. Có thể mix đồ vintage để sống ảo ở các quán cafe.';
            $score = '5.0 / 10 Trung Bình';
            $bg = 'bg-slate-100';
            $text = 'text-slate-700';
        } elseif ($weatherId >= 600 && $weatherId < 700) {
            $advice = 'Săn tuyết hoặc băng giá! Hãy mặc áo ấm dày, áo phao măng tô, găng tay và giày bám tuyết thật tốt.';
            $score = '7.5 / 10 Khá Tốt';
            $bg = 'bg-sky-100';
            $text = 'text-sky-700';
        } elseif ($weatherId >= 700 && $weatherId < 800) {
            $advice = 'Sương mù hoặc tầm nhìn kém. Thời tiết lãng mạn dạo phố nhẹ nhàng hoặc săn mây trên đồi. Lái xe cẩn thận nhé!';
            $score = '7.0 / 10 Khá Tốt';
            $bg = 'bg-amber-100';
            $text = 'text-amber-700';
        } elseif ($weatherId === 800) {
            if ($temp > 30) {
                $advice = 'Nắng gắt, lên hình rực rỡ! Cực hợp váy maxi, bikini đi biển. Tuyệt đối không quên kem chống nắng, mũ rộng vành và kính râm.';
                $score = '9.5 / 10 Tuyệt Vời';
                $bg = 'bg-amber-100';
                $text = 'text-amber-700';
            } else {
                $advice = 'Trời quang mây tạnh, mát mẻ! Thời điểm vàng cho mọi bức ảnh check-in và hoạt động cắm trại, trekking ngoài trời.';
                $score = '10 / 10 Hoàn Hảo';
                $bg = 'bg-emerald-100';
                $text = 'text-emerald-700';
            }
        } elseif ($weatherId > 800) {
            $advice = 'Trời nhiều mây, ánh sáng dịu. Mặc trang phục sáng màu (trắng, vàng, pastel) để nổi bật khung hình. Thuận tiện dạo chơi không sợ nắng hắt.';
            $score = '8.5 / 10 Tốt';
            $bg = 'bg-sky-100';
            $text = 'text-sky-700';
        }

        return [
            'advice' => $advice,
            'scoreText' => $score,
            'scoreBg' => $bg,
            'scoreColor' => $text,
        ];
    }

    private function ensureToursSeeded()
    {
        if (Tour::where('status', 1)->count() <= 4) {
            try {
                Artisan::call('db:seed', [
                    '--class' => 'Tour200Seeder',
                    '--force' => true,
                ]);
            } catch (\Throwable $e) {
                // Silently fallback if DB is temporarily locked or slow
            }
        }
    }


    public function index(Request $request)
    {
        if (! Session::get('viewed')) {
            Session::put('viewed', true);
            DB::table('views')->insert([
                'view' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->ensureToursSeeded();

        $userId = Auth::id();
        $notifications = $userId ? Notification::where('user_id', $userId)->orderByDesc('created_at')->take(10)->get() : collect();
        $unreadCount = $userId ? Notification::where('user_id', $userId)->where('status', 'unread')->count() : 0;

        // Lấy trực tiếp banners mới nhất mà không lọc theo status
        $banners = Banner::latest()->take(4)->get();
        $categories = Category::where('status', 1)->whereNull('parent_id')->with('children')->orderBy('id', 'asc')->take(10)->get();
        $tours = Tour::where('status', 1)->orderByDesc('id')->paginate(8);

        // Top Buy Tours
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

        // Tour theo danh mục con
        $subCategories = Category::where('status', 1)->whereNotNull('parent_id')->with('parent')->orderByDesc('id')->take(10)->get();
        $categoryId = $request->query('category');
        $tourCate = Tour::where('status', 1)
            ->when($categoryId, fn ($q) => $q->where('category_id', $categoryId))
            ->orderByDesc('id')
            ->paginate(4)
            ->withQueryString();

        $user = Auth::user();
        $blogs = Blog::where('status', 1)->latest()->paginate(6);
        $recentBlogs = $blogs;

        // Hot Tours tính theo views
        $hotTours = Tour::where('status', 1)
            ->withCount(['views as total_views' => function ($query) {
                $query->select(DB::raw('coalesce(sum(view), 0)'));
            }])
            ->orderByDesc('total_views')
            ->limit(8)
            ->get();

        // Điểm đến hấp dẫn
        $destinations = Tour::where('status', 1)
            ->whereNotNull('end_location')
            ->select('end_location', DB::raw('MAX(image) as image'), DB::raw('COUNT(*) as total_tours'))
            ->groupBy('end_location')
            ->orderByDesc('total_tours')
            ->limit(12)
            ->get();

        // Thời tiết OpenWeather (fallback an toàn nếu API lỗi hoặc hết quota)
        $weatherData = null;
        $forecastData = [];
        try {
            $apiKey = config('services.openweather.key');
            if ($apiKey) {
                $response = Http::timeout(5)
                    ->withOptions(['verify' => false])
                    ->get('https://api.openweathermap.org/data/2.5/forecast', [
                        'q' => 'Da Lat,VN',
                        'appid' => $apiKey,
                        'units' => 'metric',
                        'lang' => 'vi',
                    ]);

                if ($response->successful()) {
                    $data = $response->json();
                    if (! empty($data['list'][0])) {
                        $weatherId = $data['list'][0]['weather'][0]['id'];
                        $adviceData = $this->getAdviceScore($weatherId, round($data['list'][0]['main']['temp']));

                        $weatherData = [
                            'city' => $data['city']['name'] ?? 'Đà Lạt',
                            'temp' => round($data['list'][0]['main']['temp']),
                            'desc' => $data['list'][0]['weather'][0]['description'] ?? 'Se lạnh',
                            'icon' => $data['list'][0]['weather'][0]['icon'] ?? '02d',
                            'advice' => $adviceData['advice'],
                            'scoreText' => $adviceData['scoreText'],
                            'scoreBg' => $adviceData['scoreBg'],
                            'scoreColor' => $adviceData['scoreColor'],
                        ];

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
            }
        } catch (\Throwable $e) {
            // Không ngắt trang nếu API bên ngoài gặp lỗi kết nối
        }

        if (empty($weatherData)) {
            $defaultWeather = \App\Http\Controllers\User\WeatherController::getFallbackWeatherData('Đà Lạt');
            $weatherData = $defaultWeather['current'];
            $forecastData = $defaultWeather['forecast'];
        }

        return view('users.home', compact(
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
            'recentBlogs',
            'hotTours',
            'destinations',
            'weatherData',
            'forecastData',
            'notifications',
            'unreadCount'
        ));
    }

    public function allTours()
    {
        $this->ensureToursSeeded();

        $categories = Category::where('status', 1)
            ->whereNull('parent_id')
            ->orderBy('id', 'asc')
            ->take(10)
            ->get();

        $userId = Auth::id();
        $notifications = $userId ? Notification::where('user_id', $userId)->orderByDesc('created_at')->take(10)->get() : collect();
        $unreadCount = $userId ? Notification::where('user_id', $userId)->where('status', 'unread')->count() : 0;

        $tours = Tour::where('status', 1)->orderByDesc('id')->paginate(12)->withQueryString();

        return view('users.tours', compact('tours', 'categories', 'notifications', 'unreadCount'));
    }

    public function ajax(Request $request)
    {
        $city = $request->get('city', 'Hanoi');

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

        return view('users.searchPage', compact('tours', 'categories', 'notifications', 'unreadCount'));
    }

    public function destination($location)
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

        $tours = Tour::where('end_location', '=', $location)
            ->orderByDesc('id')
            ->paginate(8);

        return view('users.destination', compact('tours', 'categories', 'notifications', 'unreadCount', 'location'));
    }

    public function TourCate($id)
    {
        $this->ensureToursSeeded();

        $categories = Category::where('status', 1)
            ->whereNull('parent_id')
            ->with('children')
            ->orderBy('id', 'asc')
            ->take(10)
            ->get();

        $currentCategory = Category::find($id);

        $notifications = Notification::where('user_id', Auth::id())
            ->orderByDesc('created_at')
            ->take(10)
            ->get();

        $unreadCount = Notification::where('user_id', Auth::id())
            ->where('status', 'unread')
            ->count();

        $subCategories = Category::where('status', 1)
            ->whereNotNull('parent_id')
            ->with('parent')
            ->orderByDesc('id')
            ->take(10)
            ->get();

        // chỉ lấy tour theo category được chọn
        $tourCate = Tour::where('status', 1)
            ->where('category_id', $id)
            ->orderByDesc('id')
            ->paginate(12)
            ->withQueryString();

        return view('users.TourCate', compact(
            'categories',
            'currentCategory',
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

        $user = User::findOrFail($id);

        return view('users.profile', compact('user', 'categories', 'notifications', 'unreadCount'));
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

        return view('users.contact', compact('categories', 'notifications', 'unreadCount'));
    }

    public function sendConsultation(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:50',
            'email' => 'nullable|email|max:255',
            'destination' => 'nullable|string|max:255',
            'tour_type' => 'nullable|string|max:255',
            'message' => 'nullable|string|max:2000',
        ]);

        $targetEmail = env('ADMIN_CONSULTATION_EMAIL', '22010058@st.phenikaa-uni.edu.vn');
        $senderName = $validated['name'];
        $senderPhone = $validated['phone'];
        $senderEmail = !empty($validated['email']) ? $validated['email'] : 'Không cung cấp';
        $destination = !empty($validated['destination']) ? $validated['destination'] : (!empty($validated['tour_type']) ? $validated['tour_type'] : 'Yêu cầu tư vấn tổng quan');
        $note = !empty($validated['message']) ? $validated['message'] : 'Khách mong muốn được tư vấn lộ trình chi tiết và báo giá.';
        $subject = "[WanderVibe] Yêu cầu nhận tư vấn mới từ " . $senderName;

        $content = "=== YÊU CẦU TƯ VẤN TOUR TỪ WANDERVIBE ===\n\n"
            . "• Họ và tên khách hàng: " . $senderName . "\n"
            . "• Số điện thoại / Zalo: " . $senderPhone . "\n"
            . "• Email khách hàng: " . $senderEmail . "\n"
            . "• Điểm đến / Gói quan tâm: " . $destination . "\n"
            . "• Lời nhắn / Ghi chú: " . $note . "\n"
            . "• Thời gian gửi yêu cầu: " . now()->format('d/m/Y H:i:s') . "\n\n"
            . "Hệ thống tự động chuyển tiếp từ website WanderVibe.";

        $htmlContent = "
            <div style='font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; border: 1px solid #e2e8f0; border-radius: 12px; overflow: hidden;'>
                <div style='background: linear-gradient(135deg, #059669, #10b981); padding: 20px; text-align: center; color: white;'>
                    <h2 style='margin: 0; font-size: 20px;'>YÊU CẦU TƯ VẤN TOUR MỚI</h2>
                    <p style='margin: 5px 0 0; opacity: 0.9; font-size: 13px;'>Từ website WanderVibe</p>
                </div>
                <div style='padding: 24px;'>
                    <table style='width: 100%; border-collapse: collapse;'>
                        <tr>
                            <td style='padding: 8px 0; font-weight: bold; width: 140px; color: #64748b;'>Họ và tên:</td>
                            <td style='padding: 8px 0; font-weight: bold; color: #0f172a;'>" . htmlspecialchars($senderName) . "</td>
                        </tr>
                        <tr>
                            <td style='padding: 8px 0; font-weight: bold; color: #64748b;'>Số điện thoại:</td>
                            <td style='padding: 8px 0; color: #059669; font-weight: bold; font-size: 16px;'>" . htmlspecialchars($senderPhone) . "</td>
                        </tr>
                        <tr>
                            <td style='padding: 8px 0; font-weight: bold; color: #64748b;'>Email:</td>
                            <td style='padding: 8px 0; color: #334155;'>" . htmlspecialchars($senderEmail) . "</td>
                        </tr>
                        <tr>
                            <td style='padding: 8px 0; font-weight: bold; color: #64748b;'>Điểm đến / Gói:</td>
                            <td style='padding: 8px 0; color: #334155;'>" . htmlspecialchars($destination) . "</td>
                        </tr>
                        <tr>
                            <td style='padding: 8px 0; font-weight: bold; color: #64748b; vertical-align: top;'>Lời nhắn:</td>
                            <td style='padding: 8px 0; color: #334155;'>" . nl2br(htmlspecialchars($note)) . "</td>
                        </tr>
                        <tr>
                            <td style='padding: 8px 0; font-weight: bold; color: #64748b;'>Thời gian gửi:</td>
                            <td style='padding: 8px 0; color: #64748b; font-size: 12px;'>" . now()->format('d/m/Y H:i:s') . "</td>
                        </tr>
                    </table>
                </div>
                <div style='background: #f8fafc; padding: 12px; text-align: center; font-size: 12px; color: #94a3b8; border-top: 1px solid #e2e8f0;'>
                    Thông báo tự động từ hệ thống WanderVibe.
                </div>
            </div>
        ";

        $mailSuccess = false;
        $resendApiKey = env('RESEND_API_KEY');

        // Gửi qua Resend HTTP API (Port 443 HTTPS - Hoạt động hoàn hảo trên Render không bị chặn SMTP)
        if (!empty($resendApiKey)) {
            try {
                $fromEmail = env('RESEND_FROM_EMAIL', 'WanderVibe <onboarding@resend.dev>');
                $response = Http::withToken($resendApiKey)
                    ->timeout(10)
                    ->post('https://api.resend.com/emails', [
                        'from' => $fromEmail,
                        'to' => [$targetEmail],
                        'subject' => $subject,
                        'html' => $htmlContent,
                        'text' => $content,
                    ]);

                if ($response->successful()) {
                    $mailSuccess = true;
                } else {
                    \Illuminate\Support\Facades\Log::error('Resend mail error: ' . $response->body());
                }
            } catch (\Throwable $e) {
                \Illuminate\Support\Facades\Log::error('Resend request exception: ' . $e->getMessage());
            }
        } else {
            // Fallback gửi qua SMTP thông thường nếu chưa set RESEND_API_KEY
            try {
                Mail::raw($content, function ($m) use ($targetEmail, $subject) {
                    $m->to($targetEmail)->subject($subject);
                });
                $mailSuccess = true;
            } catch (\Throwable $e) {
                \Illuminate\Support\Facades\Log::error('Send consultation mail error: ' . $e->getMessage());
            }
        }

        // Lưu thông báo cho Admin phòng khi SMTP bị lỗi mạng trên server/cloud
        try {
            $adminUsers = \App\Models\User::where('role', 'admin')->get();
            foreach ($adminUsers as $admin) {
                \App\Models\Notification::create([
                    'user_id' => $admin->id,
                    'title' => 'Yêu cầu tư vấn tour mới',
                    'message' => "Khách hàng {$senderName} ({$senderPhone}) yêu cầu tư vấn: {$destination}. Lời nhắn: {$note}",
                    'type' => 'system',
                    'status' => 'unread',
                ]);
            }
        } catch (\Throwable $ex) {
            \Illuminate\Support\Facades\Log::warning('Create consultation notification error: ' . $ex->getMessage());
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Cảm ơn bạn! Yêu cầu tư vấn đã được gửi thành công. WanderVibe sẽ liên hệ lại qua SĐT trong ít phút!',
                'mail_sent' => $mailSuccess,
            ]);
        }

        return back()->with('success', 'Cảm ơn bạn! Yêu cầu tư vấn đã được gửi thành công. WanderVibe sẽ liên hệ lại qua SĐT trong ít phút!');
    }

}
