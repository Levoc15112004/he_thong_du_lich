<?php

namespace Database\Seeders;

use App\Models\AttrTour;
use App\Models\Banner;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Tour;
use App\Models\TourSchedule;
use App\Models\Voucher;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class SampleDataSeeder extends Seeder
{
    public function run()
    {
        $catSea = Category::firstOrCreate(['name' => 'Biển đảo'], ['status' => 1]);
        $catMountain = Category::firstOrCreate(['name' => 'Vùng núi'], ['status' => 1]);
        $catCulture = Category::firstOrCreate(['name' => 'Văn hóa'], ['status' => 1]);

        Banner::firstOrCreate(['name' => 'Khám Phá Hè 2026'], [
            'image' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=1600&q=80',
            'link' => '#hot-tours',
            'status' => 1,
        ]);

        AttrTour::firstOrCreate(['name' => 'Phương tiện', 'value' => 'Xe du lịch đời mới']);
        AttrTour::firstOrCreate(['name' => 'Khách sạn', 'value' => 'Tiêu chuẩn 4-5 sao']);
        AttrTour::firstOrCreate(['name' => 'Ăn uống', 'value' => 'Bao gồm bữa ăn chính']);

        $tours = [
            [
                'name' => 'Tour Hạ Long 3N2Đ - Du Thuyền 5 Sao',
                'time' => '3 Ngày 2 Đêm',
                'price' => 4500000,
                'sale_price' => 3890000,
                'image' => 'https://images.unsplash.com/photo-1528127269322-539801943592?auto=format&fit=crop&w=800&q=80',
                'description' => 'Trải nghiệm du thuyền vịnh Hạ Long, chèo kayak hang Luồn và ngắm hoàng hôn vịnh biển.',
                'start_location' => 'Hà Nội',
                'end_location' => 'Hạ Long',
                'category_id' => $catSea->id,
                'quantity' => 20,
                'start_date' => Carbon::now()->addDays(5)->toDateString(),
            ],
            [
                'name' => 'Tour Sapa 3N2Đ - Chinh Phục Đỉnh Fansipan',
                'time' => '3 Ngày 2 Đêm',
                'price' => 3200000,
                'sale_price' => 2750000,
                'image' => 'https://images.unsplash.com/photo-1544735716-392fe2489ffa?auto=format&fit=crop&w=800&q=80',
                'description' => 'Hành trình săn mây nóc nhà Đông Dương, thăm bản Cát Cát và thung lũng Mường Hoa.',
                'start_location' => 'Hà Nội',
                'end_location' => 'Sapa',
                'category_id' => $catMountain->id,
                'quantity' => 25,
                'start_date' => Carbon::now()->addDays(7)->toDateString(),
            ],
            [
                'name' => 'Tour Đà Nẵng - Hội An - Bà Nà Hills 4N3Đ',
                'time' => '4 Ngày 3 Đêm',
                'price' => 5800000,
                'sale_price' => 4990000,
                'image' => 'https://images.unsplash.com/photo-1559592413-7cec4d0cae2b?auto=format&fit=crop&w=800&q=80',
                'description' => 'Khám phá Cầu Vàng Bà Nà Hills, phố cổ Hội An rực rỡ đèn lồng và biển Mỹ Khê.',
                'start_location' => 'TP. Hồ Chí Minh',
                'end_location' => 'Đà Nẵng',
                'category_id' => $catCulture->id,
                'quantity' => 30,
                'start_date' => Carbon::now()->addDays(10)->toDateString(),
            ],
            [
                'name' => 'Tour Phú Quốc 4N3Đ - Thiên Đường Biển Đảo',
                'time' => '4 Ngày 3 Đêm',
                'price' => 6500000,
                'sale_price' => 5490000,
                'image' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=800&q=80',
                'description' => 'Tour cano 4 đảo câu cá ngắm san hô, check-in cáp treo Hòn Thơm và Grand World.',
                'start_location' => 'Hà Nội',
                'end_location' => 'Phú Quốc',
                'category_id' => $catSea->id,
                'quantity' => 20,
                'start_date' => Carbon::now()->addDays(12)->toDateString(),
            ],
        ];

        foreach ($tours as $t) {
            $tour = Tour::firstOrCreate(['name' => $t['name']], $t);
            TourSchedule::firstOrCreate(
                ['tour_id' => $tour->id, 'day_number' => 1],
                [
                    'title' => 'Ngày 1: Khởi hành - Tham quan và nhận phòng',
                    'description' => 'Xe đón đoàn tại điểm hẹn, khởi hành đi tham quan và làm thủ tục nhận phòng khách sạn.',
                    'location_name' => $t['end_location'],
                ]
            );
            TourSchedule::firstOrCreate(
                ['tour_id' => $tour->id, 'day_number' => 2],
                [
                    'title' => 'Ngày 2: Trải nghiệm danh lam thắng cảnh',
                    'description' => 'Khám phá các điểm du lịch đặc sắc nhất theo lịch trình cùng hướng dẫn viên.',
                    'location_name' => $t['end_location'],
                ]
            );
        }

        Voucher::firstOrCreate(['code' => 'WANDERLUST'], [
            'name' => 'Giảm 10% Cho Khách Mới',
            'description' => 'Mã khuyến mãi chào mừng thành viên mới.',
            'discount_type' => 'percent',
            'discount_value' => 10,
            'max_discount' => 500000,
            'min_order_value' => 2000000,
            'quantity' => 100,
            'used_count' => 0,
            'start_date' => Carbon::now(),
            'end_date' => Carbon::now()->addMonths(6),
            'status' => 1,
        ]);

        Blog::firstOrCreate(['title' => 'Cẩm Nang Du Lịch Tự Túc 2026'], [
            'image' => 'https://images.unsplash.com/photo-1488646953014-85cb44e25828?auto=format&fit=crop&w=800&q=80',
            'content' => 'Tổng hợp các kinh nghiệm du lịch hữu ích, chuẩn bị hành lý và chọn tour trọn gói tối ưu.',
            'status' => 1,
        ]);
    }
}
