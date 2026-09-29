<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;

class WeatherController extends Controller
{
    public function searchAjax(Request $request)
    {
        $city = $request->city;

        if (! $city) {
            return response()->json(['error' => 'Thiếu tên thành phố'], 422);
        }

        $response = Http::timeout(10)
            ->withOptions(['verify' => false])
            ->retry(2, 500)
            ->get('https://api.openweathermap.org/data/2.5/forecast', [
                'q' => $city,
                'appid' => config('services.openweather.key'),
                'units' => 'metric',
                'lang' => 'vi',
            ]);

        if (! $response->successful()) {
            return response()->json(['error' => 'Không tìm thấy thành phố'], 404);
        }

        $data = $response->json();

        $weatherId = $data['list'][0]['weather'][0]['id'];
        $adviceData = $this->getAdviceScore($weatherId, round($data['list'][0]['main']['temp']));

        //  Thời tiết hiện tại
        $current = [
            'city' => $data['city']['name'],
            'temp' => round($data['list'][0]['main']['temp']),
            'desc' => $data['list'][0]['weather'][0]['description'],
            'icon' => $data['list'][0]['weather'][0]['icon'],
            'advice' => $adviceData['advice'],
            'scoreText' => $adviceData['scoreText'],
            'scoreBg' => $adviceData['scoreBg'],
            'scoreColor' => $adviceData['scoreColor'],
        ];

        //  Dự báo 5 ngày
        $forecast = collect($data['list'])
            ->filter(fn ($item) => str_contains($item['dt_txt'], '12:00:00'))
            ->take(5)
            ->map(fn ($item) => [
                'date' => Carbon::parse($item['dt_txt'])->format('d/m'),
                'temp' => round($item['main']['temp']),
                'icon' => $item['weather'][0]['icon'],
            ])
            ->values();

        return response()->json([
            'current' => $current,
            'forecast' => $forecast,
        ]);
    }
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
}
