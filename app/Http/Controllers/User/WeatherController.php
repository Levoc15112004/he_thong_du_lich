<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;

class WeatherController extends Controller
{
    private static $cityPresets = [
        'da lat' => ['city' => 'Đà Lạt', 'temp' => 19, 'desc' => 'Se lạnh, sương mù lãng mạn', 'icon' => '03d', 'weatherId' => 802],
        'sa pa' => ['city' => 'Sa Pa', 'temp' => 15, 'desc' => 'Mát lạnh trong lành, săn mây lý tưởng', 'icon' => '04d', 'weatherId' => 803],
        'sapa' => ['city' => 'Sa Pa', 'temp' => 15, 'desc' => 'Mát lạnh trong lành, săn mây lý tưởng', 'icon' => '04d', 'weatherId' => 803],
        'phu quoc' => ['city' => 'Phú Quốc', 'temp' => 29, 'desc' => 'Nắng đẹp, biển xanh sóng êm', 'icon' => '01d', 'weatherId' => 800],
        'da nang' => ['city' => 'Đà Nẵng', 'temp' => 27, 'desc' => 'Nắng ráo chan hòa, gió biển mát mẻ', 'icon' => '02d', 'weatherId' => 801],
        'ha noi' => ['city' => 'Hà Nội', 'temp' => 24, 'desc' => 'Trời thu mát mẻ, nắng nhẹ dễ chịu', 'icon' => '02d', 'weatherId' => 801],
        'ha long' => ['city' => 'Hạ Long', 'temp' => 25, 'desc' => 'Nắng dịu, mặt vịnh lặng như gương', 'icon' => '01d', 'weatherId' => 800],
        'ha giang' => ['city' => 'Hà Giang', 'temp' => 18, 'desc' => 'Trời trong xanh, cảnh sắc đèo kỳ vĩ', 'icon' => '02d', 'weatherId' => 801],
        'hoi an' => ['city' => 'Hội An', 'temp' => 26, 'desc' => 'Ấm áp, rực rỡ phố đèn lồng', 'icon' => '02d', 'weatherId' => 801],
        'hue' => ['city' => 'Huế', 'temp' => 25, 'desc' => 'Dịu dàng mát lành, dạo sông Hương', 'icon' => '03d', 'weatherId' => 802],
        'ho chi minh' => ['city' => 'TP. Hồ Chí Minh', 'temp' => 31, 'desc' => 'Nắng ấm nhiệt đới rạng rỡ', 'icon' => '01d', 'weatherId' => 800],
    ];

    public static function normalizeCity($raw)
    {
        $raw = mb_strtolower(trim($raw), 'UTF-8');
        $trans = [
            'à'=>'a','á'=>'a','ả'=>'a','ã'=>'a','ạ'=>'a','ă'=>'a','ằ'=>'a','ắ'=>'a','ẳ'=>'a','ẵ'=>'a','ặ'=>'a',
            'â'=>'a','ầ'=>'a','ấ'=>'a','ẩ'=>'a','ẫ'=>'a','ậ'=>'a','đ'=>'d',
            'è'=>'e','é'=>'e','ẻ'=>'e','ẽ'=>'e','ẹ'=>'e','ê'=>'e','ề'=>'e','ế'=>'e','ể'=>'e','ễ'=>'e','ệ'=>'e',
            'ì'=>'i','í'=>'i','ỉ'=>'i','ĩ'=>'i','ị'=>'i',
            'ò'=>'o','ó'=>'o','ỏ'=>'o','õ'=>'o','ọ'=>'o','ô'=>'o','ồ'=>'o','ố'=>'o','ổ'=>'o','ỗ'=>'o','ộ'=>'o',
            'ơ'=>'o','ờ'=>'o','ớ'=>'o','ở'=>'o','ỡ'=>'o','ợ'=>'o',
            'ù'=>'u','ú'=>'u','ủ'=>'u','ũ'=>'u','ụ'=>'u','ư'=>'u','ừ'=>'u','ứ'=>'u','ử'=>'u','ữ'=>'u','ự'=>'u',
            'ỳ'=>'y','ý'=>'y','ỷ'=>'y','ỹ'=>'y','ỵ'=>'y'
        ];
        return strtr($raw, $trans);
    }

    public static function getFallbackWeatherData($cityInput = 'Đà Lạt')
    {
        $normalized = self::normalizeCity($cityInput);
        $preset = null;
        foreach (self::$cityPresets as $key => $val) {
            if (str_contains($normalized, $key) || str_contains($key, $normalized)) {
                $preset = $val;
                break;
            }
        }

        if (! $preset) {
            $preset = [
                'city' => ucfirst($cityInput),
                'temp' => 26,
                'desc' => 'Nắng nhẹ dịu mát, thuận tiện du lịch',
                'icon' => '02d',
                'weatherId' => 801,
            ];
        }

        $instance = new self();
        $adviceData = $instance->getAdviceScore($preset['weatherId'], $preset['temp']);

        $current = [
            'city' => $preset['city'],
            'temp' => $preset['temp'],
            'desc' => $preset['desc'],
            'icon' => $preset['icon'],
            'advice' => $adviceData['advice'],
            'scoreText' => $adviceData['scoreText'],
            'scoreBg' => $adviceData['scoreBg'],
            'scoreColor' => $adviceData['scoreColor'],
        ];

        $forecast = [];
        $icons = ['01d', '02d', '03d', '02d', '01d'];
        for ($i = 1; $i <= 5; $i++) {
            $date = Carbon::now()->addDays($i)->format('d/m');
            $tempDiff = ($i % 2 === 0 ? 1 : -1) * ($i % 3);
            $forecast[] = [
                'date' => $date,
                'temp' => $preset['temp'] + $tempDiff,
                'icon' => $icons[($i - 1) % count($icons)],
            ];
        }

        return [
            'current' => $current,
            'forecast' => $forecast,
        ];
    }

    public function searchAjax(Request $request)
    {
        $city = $request->get('city', 'Đà Lạt');
        if (! $city) {
            $city = 'Đà Lạt';
        }

        $apiKey = config('services.openweather.key');
        $normalizedCity = self::normalizeCity($city);
        $searchQuery = ucfirst($normalizedCity) . ',VN';

        if ($apiKey) {
            try {
                $response = Http::timeout(5)
                    ->withOptions(['verify' => false])
                    ->get('https://api.openweathermap.org/data/2.5/forecast', [
                        'q' => $searchQuery,
                        'appid' => $apiKey,
                        'units' => 'metric',
                        'lang' => 'vi',
                    ]);

                if ($response->successful()) {
                    $data = $response->json();
                    if (! empty($data['list'][0])) {
                        $weatherId = $data['list'][0]['weather'][0]['id'];
                        $adviceData = $this->getAdviceScore($weatherId, round($data['list'][0]['main']['temp']));

                        $current = [
                            'city' => $data['city']['name'] ?? $city,
                            'temp' => round($data['list'][0]['main']['temp']),
                            'desc' => $data['list'][0]['weather'][0]['description'] ?? 'Mát mẻ',
                            'icon' => $data['list'][0]['weather'][0]['icon'] ?? '02d',
                            'advice' => $adviceData['advice'],
                            'scoreText' => $adviceData['scoreText'],
                            'scoreBg' => $adviceData['scoreBg'],
                            'scoreColor' => $adviceData['scoreColor'],
                        ];

                        $forecast = collect($data['list'])
                            ->filter(fn ($item) => str_contains($item['dt_txt'], '12:00:00'))
                            ->take(5)
                            ->map(fn ($item) => [
                                'date' => Carbon::parse($item['dt_txt'])->format('d/m'),
                                'temp' => round($item['main']['temp']),
                                'icon' => $item['weather'][0]['icon'] ?? '02d',
                            ])
                            ->values();

                        if ($forecast->isNotEmpty()) {
                            return response()->json([
                                'current' => $current,
                                'forecast' => $forecast,
                            ]);
                        }
                    }
                }
            } catch (\Throwable $e) {
                // fall through to fallback
            }
        }

        return response()->json(self::getFallbackWeatherData($city));
    }

    public function getAdviceScore($weatherId, $temp)
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
