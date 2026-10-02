<?php

namespace Database\Seeders;

use App\Models\AttrTour;
use App\Models\Category;
use App\Models\Tour;
use App\Models\TourSchedule;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class Tour200Seeder extends Seeder
{
    public function run()
    {
        $catSea = Category::firstOrCreate(['name' => 'Biển đảo'], ['status' => 1]);
        $catMountain = Category::firstOrCreate(['name' => 'Vùng núi'], ['status' => 1]);
        $catCulture = Category::firstOrCreate(['name' => 'Văn hóa'], ['status' => 1]);
        $catEco = Category::firstOrCreate(['name' => 'Sinh thái'], ['status' => 1]);

        $catMap = [
            'sea' => $catSea->id,
            'mountain' => $catMountain->id,
            'culture' => $catCulture->id,
            'eco' => $catEco->id,
        ];

        $trans = AttrTour::firstOrCreate(['name' => 'transport', 'value' => 'Xe du lịch đời mới cao cấp']);
        $hotel = AttrTour::firstOrCreate(['name' => 'tour_type', 'value' => 'Khách sạn 4-5 sao cao cấp']);

        $destinations = [
            ['Phú Quốc', 'sea', 10.2899, 103.9840, [
                'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=800',
                'https://images.unsplash.com/photo-1544551763-46a013bb70d5?w=800',
                'https://images.unsplash.com/photo-1512343879784-a960bf40e7f2?w=800',
                'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?w=800',
                'https://images.unsplash.com/photo-1519046904884-53103b34b206?w=800',
            ], ['Bãi Sao & Sunset Sanato', 'Cáp treo Hòn Thơm', 'Grand World Phú Quốc', 'Làng chài Hàm Ninh']],
            ['Đà Lạt', 'mountain', 11.9404, 108.4583, [
                'https://images.unsplash.com/photo-1506744038136-46273834b3fb?w=800',
                'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?w=800',
                'https://images.unsplash.com/photo-1470071459604-3b5ec3a7fe05?w=800',
                'https://images.unsplash.com/photo-1432405972618-c60b0225b8f9?w=800',
                'https://images.unsplash.com/photo-1519681393784-d120267933ba?w=800',
            ], ['Hồ Tuyền Lâm & Trúc Lâm', 'Đồi chè Cầu Đất săn mây', 'Đỉnh Langbiang', 'Quảng trường Lâm Viên']],
            ['Sa Pa', 'mountain', 22.3364, 103.8438, [
                'https://images.unsplash.com/photo-1544735716-392fe2489ffa?w=800',
                'https://images.unsplash.com/photo-1528127269322-539801943592?w=800',
                'https://images.unsplash.com/photo-1472214103451-9374bd1c798e?w=800',
                'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?w=800',
            ], ['Đỉnh Fansipan 3.143m', 'Bản Cát Cát H’Mông', 'Thung lũng Mường Hoa', 'Đèo Ô Quy Hồ']],
            ['Hạ Long', 'sea', 20.9501, 107.0734, [
                'https://images.unsplash.com/photo-1528127269322-539801943592?w=800',
                'https://images.unsplash.com/photo-1559592413-7cec4d0cae2b?w=800',
                'https://images.unsplash.com/photo-1544551763-46a013bb70d5?w=800',
                'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=800',
            ], ['Hang Sửng Sốt', 'Đảo Titop ngắm vịnh', 'Hang Luồn chèo Kayak', 'Bãi Cháy Sun World']],
            ['Đà Nẵng', 'culture', 16.0544, 108.2022, [
                'https://images.unsplash.com/photo-1559592413-7cec4d0cae2b?w=800',
                'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=800',
                'https://images.unsplash.com/photo-1552465011-b4e21bf6e79a?w=800',
                'https://images.unsplash.com/photo-1519046904884-53103b34b206?w=800',
            ], ['Cầu Vàng Bà Nà Hills', 'Bán đảo Sơn Trà & Linh Ứng', 'Ngũ Hành Sơn', 'Cầu Rồng & Biển Mỹ Khê']],
            ['Hội An', 'culture', 15.8801, 108.3380, [
                'https://images.unsplash.com/photo-1559592413-7cec4d0cae2b?w=800',
                'https://images.unsplash.com/photo-1552465011-b4e21bf6e79a?w=800',
                'https://images.unsplash.com/photo-1544551763-46a013bb70d5?w=800',
                'https://images.unsplash.com/photo-1528127269322-539801943592?w=800',
            ], ['Phố cổ Hội An & Chùa Cầu', 'Rừng dừa Bảy Mẫu Cẩm Thanh', 'Làng gốm Thanh Hà', 'Đảo Cù Lao Chàm']],
            ['Hà Giang', 'mountain', 22.8233, 104.9839, [
                'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?w=800',
                'https://images.unsplash.com/photo-1506744038136-46273834b3fb?w=800',
                'https://images.unsplash.com/photo-1470071459604-3b5ec3a7fe05?w=800',
                'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?w=800',
            ], ['Đèo Mã Pí Lèng', 'Du thuyền Sông Nho Quế', 'Cột cờ Lũng Cú', 'Dinh Vua Mèo Đồng Văn']],
            ['Nha Trang', 'sea', 12.2388, 109.1967, [
                'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=800',
                'https://images.unsplash.com/photo-1512343879784-a960bf40e7f2?w=800',
                'https://images.unsplash.com/photo-1544551763-46a013bb70d5?w=800',
                'https://images.unsplash.com/photo-1552465011-b4e21bf6e79a?w=800',
            ], ['VinWonders Đảo Hòn Tre', 'Đảo Hòn Mun lặn san hô', 'Tháp Bà Ponagar', 'Viện Hải dương học']],
            ['Ninh Bình', 'culture', 20.2506, 105.9745, [
                'https://images.unsplash.com/photo-1528127269322-539801943592?w=800',
                'https://images.unsplash.com/photo-1506744038136-46273834b3fb?w=800',
                'https://images.unsplash.com/photo-1559592413-7cec4d0cae2b?w=800',
                'https://images.unsplash.com/photo-1472214103451-9374bd1c798e?w=800',
            ], ['Quần thể Tràng An', 'Hang Múa ngắm Tam Cốc', 'Chùa Bái Đính', 'Cố đô Hoa Lư']],
            ['Huế', 'culture', 16.4637, 107.5909, [
                'https://images.unsplash.com/photo-1559592413-7cec4d0cae2b?w=800',
                'https://images.unsplash.com/photo-1552465011-b4e21bf6e79a?w=800',
                'https://images.unsplash.com/photo-1528127269322-539801943592?w=800',
                'https://images.unsplash.com/photo-1519046904884-53103b34b206?w=800',
            ], ['Đại Nội Hoàng Cung', 'Chùa Thiên Mụ & Sông Hương', 'Lăng Khải Định', 'Làng hương Thủy Xuân']],
            ['Quy Nhơn', 'sea', 13.7820, 109.2197, [
                'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=800',
                'https://images.unsplash.com/photo-1512343879784-a960bf40e7f2?w=800',
                'https://images.unsplash.com/photo-1544551763-46a013bb70d5?w=800',
            ], ['Eo Gió ngắm hoàng hôn', 'Bãi biển Kỳ Co', 'Ghềnh Ráng Tiên Sa', 'Tháp Đôi Chăm Pa']],
            ['Phú Yên', 'sea', 13.0882, 109.3138, [
                'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?w=800',
                'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=800',
                'https://images.unsplash.com/photo-1512343879784-a960bf40e7f2?w=800',
            ], ['Gành Đá Đĩa kỳ thú', 'Bãi Xép hoa vàng cỏ xanh', 'Mũi Điện cực Đông', 'Đầm Ô Loan']],
            ['Côn Đảo', 'sea', 8.6835, 106.6062, [
                'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=800',
                'https://images.unsplash.com/photo-1544551763-46a013bb70d5?w=800',
                'https://images.unsplash.com/photo-1512343879784-a960bf40e7f2?w=800',
            ], ['Bãi Đầm Trầu cát vàng', 'Nghĩa trang Hàng Dương', 'Nhà tù Côn Đảo', 'Hòn Bảy Cạnh sinh thái']],
            ['Cần Thơ', 'eco', 10.0452, 105.7469, [
                'https://images.unsplash.com/photo-1544551763-46a013bb70d5?w=800',
                'https://images.unsplash.com/photo-1519046904884-53103b34b206?w=800',
                'https://images.unsplash.com/photo-1472214103451-9374bd1c798e?w=800',
            ], ['Chợ nổi Cái Răng', 'Bến Ninh Kiều về đêm', 'Cồn Sơn miệt vườn', 'Nhà cổ Bình Thủy']],
            ['Phan Thiết', 'sea', 10.9333, 108.1000, [
                'https://images.unsplash.com/photo-1509316975850-ff9c5deb0cd9?w=800',
                'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?w=800',
                'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=800',
            ], ['Đồi Cát Bay Mũi Né', 'Bàu Trắng tiểu sa mạc', 'Suối Tiên hẻm núi đỏ', 'Làng chài Mũi Né']],
            ['Mộc Châu', 'mountain', 20.8441, 104.6360, [
                'https://images.unsplash.com/photo-1506744038136-46273834b3fb?w=800',
                'https://images.unsplash.com/photo-1432405972618-c60b0225b8f9?w=800',
                'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?w=800',
                'https://images.unsplash.com/photo-1470071459604-3b5ec3a7fe05?w=800',
            ], ['Đồi chè Trái Tim', 'Thác Dải Yếm', 'Rừng thông Bản Áng', 'Thung lũng mận Nà Ka']],
            ['Cao Bằng', 'mountain', 22.6667, 106.2500, [
                'https://images.unsplash.com/photo-1506744038136-46273834b3fb?w=800',
                'https://images.unsplash.com/photo-1544551763-46a013bb70d5?w=800',
                'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?w=800',
            ], ['Thác Bản Giốc hùng vĩ', 'Động Ngườm Ngao', 'Suối Lê Nin & Pác Bó', 'Hồ Thang Hen']],
            ['Buôn Ma Thuột', 'eco', 12.6675, 108.0383, [
                'https://images.unsplash.com/photo-1432405972618-c60b0225b8f9?w=800',
                'https://images.unsplash.com/photo-1472214103451-9374bd1c798e?w=800',
                'https://images.unsplash.com/photo-1506744038136-46273834b3fb?w=800',
            ], ['Bảo tàng Thế giới Cà phê', 'Thác Dray Nur kỳ vĩ', 'Hồ Lắk & Buôn Jun', 'Khu du lịch Buôn Đôn']],
            ['Vũng Tàu', 'sea', 10.3460, 107.0843, [
                'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=800',
                'https://images.unsplash.com/photo-1512343879784-a960bf40e7f2?w=800',
                'https://images.unsplash.com/photo-1473496169904-658ba7c44d8a?w=800',
            ], ['Tượng Chúa Kito Vua', 'Ngọn Hải Đăng cổ', 'Mũi Nghinh Phong', 'Bãi Sau & Bãi Trước']],
            ['An Giang', 'eco', 10.5216, 105.1259, [
                'https://images.unsplash.com/photo-1544551763-46a013bb70d5?w=800',
                'https://images.unsplash.com/photo-1552465011-b4e21bf6e79a?w=800',
                'https://images.unsplash.com/photo-1472214103451-9374bd1c798e?w=800',
            ], ['Rừng tràm Trà Sư', 'Miếu Bà Chúa Xứ Núi Sam', 'Chùa Lầu phong cách Nhật', 'Khu du lịch Núi Cấm']],
        ];

        $packages = [
            ['Khám Phá Trọn Gói', 3, 2, 3500000, 0.15],
            ['Nghỉ Dưỡng 5 Sao Cao Cấp', 4, 3, 6500000, 0.20],
            ['Trải Nghiệm Sinh Thái & Văn Hóa', 3, 2, 3200000, 0.12],
            ['Check-in Sống Ảo & Ẩm Thực', 3, 2, 3800000, 0.18],
            ['Trekking & Săn Mây Ngoạn Mục', 2, 1, 2400000, 0.10],
            ['Gia Đình Thư Giãn Trọn Vẹn', 4, 3, 5800000, 0.15],
            ['Kỳ Nghỉ Lãng Mạn Cặp Đôi', 3, 2, 4200000, 0.22],
            ['Tour Tiết Kiệm Cuối Tuần', 2, 1, 1990000, 0.10],
            ['Hành Trình Di Sản Chuyên Sâu', 4, 3, 5200000, 0.16],
            ['VIP Luxury Thượng Lưu', 5, 4, 9800000, 0.25],
        ];

        $startCities = ['Hà Nội', 'TP. Hồ Chí Minh', 'Đà Nẵng', 'Cần Thơ', 'Hải Phòng'];

        // Cập nhật ảnh chuẩn đẹp cho các tour đã có sẵn trong database (xóa ảnh spa cũ)
        foreach ($destinations as [$city, , , , $imgs]) {
            $imgList = is_array($imgs) ? $imgs : [$imgs];
            $toursOfCity = Tour::where('end_location', $city)->orderBy('id')->get();
            foreach ($toursOfCity as $idx => $t) {
                $chosenImg = $imgList[$idx % count($imgList)];
                if ($t->image !== $chosenImg) {
                    $t->update(['image' => $chosenImg]);
                }
            }
        }

        // Lấy danh sách tour đã tồn tại để tránh trùng lặp
        $existingTours = Tour::pluck('name')->flip()->toArray();

        $toursToInsert = [];
        $tourMeta = [];
        $now = Carbon::now();

        foreach ($destinations as $dIdx => [$city, $catKey, $lat, $lng, $imgs, $spots]) {
            $imgList = is_array($imgs) ? $imgs : [$imgs];
            foreach ($packages as $pIdx => [$pkgName, $days, $nights, $basePrice, $disc]) {
                $tourName = "Tour Du Lịch {$city} {$days}N{$nights}Đ - {$pkgName}";
                $startLoc = $startCities[($dIdx + $pIdx) % count($startCities)];
                $price = $basePrice + ($dIdx * 60000);
                $salePrice = (int) round($price * (1 - $disc));
                $img = $imgList[$pIdx % count($imgList)];

                if (!isset($existingTours[$tourName])) {
                    $toursToInsert[] = [
                        'name' => $tourName,
                        'time' => "{$days} Ngày {$nights} Đêm",
                        'price' => $price,
                        'sale_price' => $salePrice,
                        'image' => $img,
                        'description' => "Hành trình khám phá {$city} trọn gói tiêu chuẩn cao cấp cùng WanderVibe. Xe limousine đưa đón, khách sạn sang trọng, bữa ăn đặc sản địa phương và bảo hiểm du lịch trọn gói.",
                        'start_location' => $startLoc,
                        'end_location' => $city,
                        'category_id' => $catMap[$catKey] ?? $catSea->id,
                        'quantity' => rand(20, 45),
                        'start_date' => Carbon::now()->addDays(($pIdx + 1) * 3)->toDateString(),
                        'status' => 1,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];
                }

                $tourMeta[$tourName] = [
                    'days' => $days,
                    'spots' => $spots,
                    'lat' => $lat,
                    'lng' => $lng,
                    'startLoc' => $startLoc,
                    'city' => $city,
                    'img' => $img,
                ];
            }
        }

        // Chèn hàng loạt Tour mới nếu có
        if (!empty($toursToInsert)) {
            foreach (array_chunk($toursToInsert, 100) as $chunk) {
                Tour::insert($chunk);
            }
        }

        // Lấy ID toàn bộ tour
        $tourIdMap = Tour::whereIn('name', array_keys($tourMeta))->pluck('id', 'name');

        // Lấy lịch trình đã có
        $existingSchedules = TourSchedule::whereIn('tour_id', $tourIdMap->values())
            ->select('tour_id', 'day_number')
            ->get()
            ->mapWithKeys(fn ($s) => [$s->tour_id . '_' . $s->day_number => true])
            ->toArray();

        $schedulesToInsert = [];
        $attrsToInsert = [];

        foreach ($tourMeta as $tourName => $meta) {
            $tId = $tourIdMap[$tourName] ?? null;
            if (!$tId) continue;

            $attrsToInsert[] = ['tour_id' => $tId, 'attr_tour_id' => $trans->id, 'created_at' => $now, 'updated_at' => $now];
            $attrsToInsert[] = ['tour_id' => $tId, 'attr_tour_id' => $hotel->id, 'created_at' => $now, 'updated_at' => $now];

            $days = $meta['days'];
            $spots = $meta['spots'];
            $startLoc = $meta['startLoc'];
            $city = $meta['city'];
            $img = $meta['img'];
            $lat = $meta['lat'];
            $lng = $meta['lng'];

            for ($d = 1; $d <= $days; $d++) {
                if (isset($existingSchedules[$tId . '_' . $d])) {
                    continue;
                }

                $spotName = $spots[($d - 1) % count($spots)];
                $spotLat = round($lat + (($d - 1) * 0.015), 6);
                $spotLng = round($lng + (($d - 1) * 0.012), 6);

                $title = $d === 1
                    ? "Ngày 1: Đón đoàn tại {$startLoc} - Di chuyển đến {$city} - Nhận phòng"
                    : ($d === $days
                        ? "Ngày {$d}: Khám phá {$spotName} - Mua sắm đặc sản - Tiễn đoàn"
                        : "Ngày {$d}: Trải nghiệm danh thắng {$spotName}");

                $desc = "Buổi Sáng: Khám phá {$spotName} cùng HDV chuyên nghiệp. Buổi Trưa: Thưởng thức bữa trưa đặc sản vùng miền. Buổi Chiều: Hoạt động tự do và chụp ảnh kỷ niệm. Buổi Tối: Thưởng thức ẩm thực và dạo phố đêm.";

                $schedulesToInsert[] = [
                    'tour_id' => $tId,
                    'day_number' => $d,
                    'title' => $title,
                    'description' => $desc,
                    'location_name' => $spotName,
                    'latitude' => $spotLat,
                    'longitude' => $spotLng,
                    'map_link' => "https://maps.google.com/?q={$spotLat},{$spotLng}",
                    'image' => $img,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }

        // Chèn hàng loạt thuộc tính
        if (!empty($attrsToInsert)) {
            foreach (array_chunk($attrsToInsert, 200) as $chunk) {
                DB::table('tour_attr')->insertOrIgnore($chunk);
            }
        }

        // Chèn hàng loạt lịch trình
        if (!empty($schedulesToInsert)) {
            foreach (array_chunk($schedulesToInsert, 200) as $chunk) {
                TourSchedule::insert($chunk);
            }
        }
    }
}