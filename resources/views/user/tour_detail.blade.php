@extends('user.master')
@section('home')
    <div class="pt-24 pb-4 bg-white border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="flex text-sm text-gray-500 font-medium">
                <a href="{{ route('user.home') }}" class="hover:text-primary transition-colors">Trang chủ</a>
                <span class="mx-2">/</span>
                <a href="#" class="hover:text-primary transition-colors">Tour</a>
                <span class="mx-2">/</span>
                <span class="text-dark">{{ $tour->name }}</span>
            </nav>
        </div>
    </div>

    <!-- Tour Title & Info Area -->
    <section class="bg-white pb-6 border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-6">
            <!-- Title Area -->
            <div class="flex flex-col md:flex-row md:items-start justify-between">
                <div class="flex-1">
                    <div class="flex items-center space-x-3 mb-2">
                        <span
                            class="bg-purple-100 text-purple-700 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider">{{ $tour->category ? $tour->category->name : 'Tour' }}</span>
                        <div class="flex items-center text-sm font-medium text-gray-600">
                            <i class="fa-solid fa-qrcode mr-1 text-gray-400"></i> Code: WL-{{ $tour->id }}
                        </div>
                    </div>
                    <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-dark mb-4 leading-tight">{{ $tour->name }}</h1>

                    <div class="flex flex-wrap items-center text-sm text-gray-600 gap-y-2 gap-x-6">
                        <div class="flex items-center">
                            <div class="flex text-yellow-400 text-sm mr-2">
                                <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                    class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                    class="fa-solid fa-star"></i>
                            </div>
                            <span class="font-medium text-dark mr-1">5.0</span>
                            <a href="#reviews" class="text-primary hover:underline">(210 Đánh giá)</a>
                        </div>
                        <div class="flex items-center">
                            <i class="fa-solid fa-location-dot text-gray-400 mr-2"></i>
                            <span>{{ $tour->end_location }}</span>
                        </div>
                        <div class="flex items-center text-emerald-600 font-medium bg-emerald-50 px-2 py-0.5 rounded">
                            <i class="fa-regular fa-circle-check mr-1.5"></i>
                            Xác nhận ngay
                        </div>
                    </div>
                </div>

                <div class="mt-4 md:mt-0 flex items-center space-x-3">
                    <button
                        class="w-10 h-10 rounded-full border border-gray-200 flex items-center justify-center text-gray-500 hover:text-red-500 hover:border-red-500 hover:bg-red-50 transition-all"
                        title="Lưu tour">
                        <i class="fa-regular fa-heart"></i>
                    </button>
                    <button
                        class="w-10 h-10 rounded-full border border-gray-200 flex items-center justify-center text-gray-500 hover:text-primary hover:border-primary hover:bg-sky-50 transition-all"
                        title="Chia sẻ">
                        <i class="fa-solid fa-share-nodes"></i>
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content & Sidebar -->
    <section class="py-8 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row gap-8">

                <!-- Left Column: Gallery & Tour Info -->
                <div class="w-full lg:w-2/3 space-y-8">

                    <!-- Image Gallery Grid (Optimized for 2/3 width) -->
                    <div
                        class="grid grid-cols-4 grid-rows-2 gap-2 md:gap-3 rounded-3xl overflow-hidden h-[350px] md:h-[450px]">
                        @if($tour->images && $tour->images->count() > 0)
                            <div
                                class="col-span-4 md:col-span-3 row-span-2 relative group overflow-hidden h-full cursor-pointer">
                                <img src="{{ Str::startsWith($tour->images[0]->image, 'http') ? $tour->images[0]->image : asset($tour->images[0]->image) }}"
                                    alt="{{ $tour->name }}" class="w-full h-full object-cover gallery-image">
                                <div class="absolute inset-0 bg-black/10 group-hover:bg-black/0 transition-colors"></div>
                            </div>
                            @if($tour->images->count() > 1)
                            <div
                                class="hidden md:block col-span-1 row-span-1 relative group overflow-hidden h-full cursor-pointer">
                                <img src="{{ Str::startsWith($tour->images[1]->image, 'http') ? $tour->images[1]->image : asset($tour->images[1]->image) }}"
                                    alt="Tour Image 2" class="w-full h-full object-cover gallery-image">
                            </div>
                            @endif
                            @if($tour->images->count() > 2)
                            <div
                                class="hidden md:block col-span-1 row-span-1 relative group overflow-hidden h-full cursor-pointer">
                                <img src="{{ Str::startsWith($tour->images[2]->image, 'http') ? $tour->images[2]->image : asset($tour->images[2]->image) }}"
                                    alt="Tour Image 3" class="w-full h-full object-cover gallery-image">
                                @if($tour->images->count() > 3)
                                <div class="absolute inset-0 bg-black/40 flex items-center justify-center">
                                    <span
                                        class="text-white font-bold text-sm border-2 border-white px-3 py-1.5 rounded-lg backdrop-blur-sm hover:bg-white hover:text-dark transition-colors">Xem
                                        tất cả</span>
                                </div>
                                @endif
                            </div>
                            @endif
                        @else
                            <div class="col-span-4 md:col-span-3 row-span-2 relative group overflow-hidden h-full cursor-pointer">
                                <img src="{{ Str::startsWith($tour->image, 'http') ? $tour->image : asset($tour->image) }}"
                                    alt="{{ $tour->name }}" class="w-full h-full object-cover gallery-image">
                                <div class="absolute inset-0 bg-black/10 group-hover:bg-black/0 transition-colors"></div>
                            </div>
                        @endif
                    </div>

                    <!-- Quick Stats Cards -->
                    <div
                        class="grid grid-cols-2 md:grid-cols-4 gap-4 bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                        <div class="flex flex-col">
                            <span class="text-gray-400 text-sm mb-1"><i class="fa-regular fa-clock mr-1"></i> Thời
                                gian</span>
                            <span class="font-bold text-dark">{{ $tour->time }}</span>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-gray-400 text-sm mb-1"><i class="fa-solid fa-plane mr-1"></i> Khởi hành</span>
                            <span class="font-bold text-dark">{{ $tour->start_date ? \Carbon\Carbon::parse($tour->start_date)->format('d/m/Y') : 'Đang cập nhật' }}</span>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-gray-400 text-sm mb-1"><i class="fa-solid fa-user-group mr-1"></i> Số chỗ</span>
                            <span class="font-bold text-dark">{{ $tour->quantity }} khách</span>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-gray-400 text-sm mb-1"><i class="fa-solid fa-hotel mr-1"></i> Khách sạn</span>
                            <span class="font-bold text-dark">Tiêu chuẩn</span>
                        </div>
                    </div>

                    <!-- Overview -->
                    <div class="bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-gray-100">
                        <h2 class="text-2xl font-bold text-dark mb-4 border-b border-gray-100 pb-4">Tổng quan hành trình
                        </h2>
                        <div class="prose max-w-none text-gray-600 leading-relaxed text-justify">
                            {!! $tour->description !!}
                        </div>
                    </div>

                    <!-- Itinerary -->
                    <div class="bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-gray-100" id="itinerary">
                        <div class="flex items-center justify-between mb-6 border-b border-gray-100 pb-4">
                            <h2 class="text-2xl font-bold text-dark">Lịch trình chi tiết</h2>
                            <button class="text-primary text-sm font-medium hover:underline flex items-center">
                                <i class="fa-solid fa-download mr-1"></i> Tải lịch trình (PDF)
                            </button>
                        </div>

                        <div class="relative mt-6 pl-4 md:pl-0">
                            @foreach($tour->schedules->sortBy('day_number') as $schedule)
                            <div class="timeline-item relative pb-10 pl-10 md:pl-16">
                                <div class="timeline-line"></div>
                                <!-- Marker -->
                                <div class="absolute left-0 top-0 w-10 h-10 bg-primary/10 rounded-full flex items-center justify-center border-4 border-white z-10 md:-ml-0.5">
                                    <span class="text-primary font-bold">{{ $schedule->day_number }}</span>
                                </div>

                                <h3 class="text-xl font-bold text-dark mb-2">Ngày {{ $schedule->day_number }}: {{ $schedule->title }}</h3>
                                @if($schedule->location_name)
                                <div class="inline-block bg-gray-100 text-gray-600 text-xs px-3 py-1 rounded-full mb-4 font-medium flex items-center w-fit">
                                    <i class="fa-solid fa-map-marker-alt text-primary mr-1 flex-shrink-0"></i> {{ $schedule->location_name }}
                                </div>
                                @endif

                                <div class="text-gray-600 space-y-3 text-justify">
                                    {!! html_entity_decode($schedule->description) !!}
                                </div>

                                <!-- Images for schedule -->
                                @if($schedule->image)
                                <div class="flex space-x-3 mt-4 overflow-x-auto no-scrollbar pb-2">
                                    <img src="{{ Str::startsWith($schedule->image, 'http') ? $schedule->image : asset($schedule->image) }}"
                                        class="w-32 h-24 object-cover rounded-lg flex-shrink-0" alt="{{ $schedule->title }}">
                                </div>
                                @endif
                                @if($schedule->map_link)
                                <a href="{{ $schedule->map_link }}" target="_blank" class="text-sm text-primary hover:underline mt-2 inline-block"><i class="fa-solid fa-location-arrow"></i> Xem vị trí trên bản đồ</a>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Map Section -->
                    @php
                        $validSchedules = $tour->schedules->whereNotNull('latitude')->whereNotNull('longitude')->sortBy('day_number')->values();
                        $hasCoordinates = $validSchedules->count() > 0;
                        
                        $mapUrl = '';
                        if ($hasCoordinates) {
                            if ($validSchedules->count() == 1) {
                                $lat = $validSchedules[0]->latitude;
                                $lng = $validSchedules[0]->longitude;
                                $mapUrl = "https://maps.google.com/maps?q={$lat},{$lng}&hl=vi&z=14&output=embed";
                            } else {
                                $origin = $validSchedules->first()->latitude . ',' . $validSchedules->first()->longitude;
                                $destination = $validSchedules->last()->latitude . ',' . $validSchedules->last()->longitude;
                                
                                $waypoints = '';
                                for ($i = 1; $i < $validSchedules->count() - 1; $i++) {
                                    $waypoints .= '+to:' . $validSchedules[$i]->latitude . ',' . $validSchedules[$i]->longitude;
                                }
                                
                                $mapUrl = "https://maps.google.com/maps?saddr={$origin}&daddr={$destination}{$waypoints}&hl=vi&output=embed";
                            }
                        }
                    @endphp

                    @if($hasCoordinates)
                    <div class="bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-gray-100 mt-8" id="tour-map">
                        <div class="flex items-center justify-between mb-6 border-b border-gray-100 pb-4">
                            <h2 class="text-2xl font-bold text-dark">Bản đồ chi tiết hành trình</h2>
                        </div>
                        <div class="w-full h-[500px] rounded-xl overflow-hidden shadow-inner border border-gray-100">
                            <iframe width="100%" height="100%" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="{{ $mapUrl }}"></iframe>
                        </div>
                    </div>
                    @elseif($tour->embedding)
                    <div class="bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-gray-100 mt-8" id="tour-map">
                        <div class="flex items-center justify-between mb-6 border-b border-gray-100 pb-4">
                            <h2 class="text-2xl font-bold text-dark">Bản đồ hành trình</h2>
                        </div>
                        <div class="w-full h-80 rounded-xl overflow-hidden shadow-inner">
                            {!! $tour->embedding !!}
                        </div>
                    </div>
                    @endif

                    <!-- Inclusions / Exclusions -->
                    <div class="bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-gray-100">
                        <h2 class="text-2xl font-bold text-dark mb-6 border-b border-gray-100 pb-4">Chi tiết giá Tour</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <!-- Included -->
                            <div>
                                <h3 class="text-lg font-bold text-emerald-600 mb-4 flex items-center">
                                    <div class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center mr-2">
                                        <i class="fa-solid fa-check"></i>
                                    </div>
                                    Bao gồm
                                </h3>
                                <ul class="space-y-3 text-gray-600 text-sm">
                                    <li class="flex items-start"><i
                                            class="fa-solid fa-circle text-[8px] text-gray-300 mt-1.5 mr-2"></i> Vé máy bay
                                        khứ hồi (Hành lý 7kg xách tay + 20kg ký gửi)</li>
                                    <li class="flex items-start"><i
                                            class="fa-solid fa-circle text-[8px] text-gray-300 mt-1.5 mr-2"></i> Khách sạn
                                        tiêu chuẩn 4 sao (2 người/phòng)</li>
                                    <li class="flex items-start"><i
                                            class="fa-solid fa-circle text-[8px] text-gray-300 mt-1.5 mr-2"></i> Các bữa ăn
                                        theo lịch trình (3 bữa sáng, 7 bữa chính)</li>
                                    <li class="flex items-start"><i
                                            class="fa-solid fa-circle text-[8px] text-gray-300 mt-1.5 mr-2"></i> Vé tham
                                        quan tất cả các điểm trong chương trình</li>
                                    <li class="flex items-start"><i
                                            class="fa-solid fa-circle text-[8px] text-gray-300 mt-1.5 mr-2"></i> Hướng dẫn
                                        viên chuyên nghiệp, nhiệt tình</li>
                                    <li class="flex items-start"><i
                                            class="fa-solid fa-circle text-[8px] text-gray-300 mt-1.5 mr-2"></i> Bảo hiểm
                                        du lịch mức 50.000.000 VNĐ</li>
                                </ul>
                            </div>

                            <!-- Excluded -->
                            <div>
                                <h3 class="text-lg font-bold text-red-500 mb-4 flex items-center">
                                    <div class="w-8 h-8 rounded-full bg-red-100 flex items-center justify-center mr-2">
                                        <i class="fa-solid fa-xmark"></i>
                                    </div>
                                    Không bao gồm
                                </h3>
                                <ul class="space-y-3 text-gray-600 text-sm">
                                    <li class="flex items-start"><i
                                            class="fa-solid fa-circle text-[8px] text-gray-300 mt-1.5 mr-2"></i> Vé cáp
                                        treo Bà Nà Hills (Khách tự túc mua nếu có nhu cầu)</li>
                                    <li class="flex items-start"><i
                                            class="fa-solid fa-circle text-[8px] text-gray-300 mt-1.5 mr-2"></i> Chi phí cá
                                        nhân: giặt ủi, điện thoại, ăn uống ngoài chương trình</li>
                                    <li class="flex items-start"><i
                                            class="fa-solid fa-circle text-[8px] text-gray-300 mt-1.5 mr-2"></i> Phụ thu
                                        phòng đơn (nếu có yêu cầu ngủ riêng)</li>
                                    <li class="flex items-start"><i
                                            class="fa-solid fa-circle text-[8px] text-gray-300 mt-1.5 mr-2"></i> Tiền tip
                                        cho HDV và tài xế (không bắt buộc)</li>
                                    <li class="flex items-start"><i
                                            class="fa-solid fa-circle text-[8px] text-gray-300 mt-1.5 mr-2"></i> Thuế VAT
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Reviews -->
                    <div class="bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-gray-100" id="reviews">
                        <div class="flex items-center justify-between mb-8 border-b border-gray-100 pb-4">
                            <h2 class="text-2xl font-bold text-dark">Đánh giá từ khách hàng</h2>
                            <button
                                class="bg-dark text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-800 transition-colors">
                                Viết đánh giá
                            </button>
                        </div>

                        <!-- Rating Summary -->
                        <div
                            class="flex flex-col md:flex-row items-center bg-gray-50 rounded-xl p-6 mb-8 border border-gray-100">
                            <div class="text-center md:border-r md:border-gray-200 md:pr-8 md:mr-8 mb-4 md:mb-0">
                                <h3 class="text-5xl font-bold text-dark mb-1">5.0</h3>
                                <div class="flex text-yellow-400 text-sm justify-center mb-1">
                                    <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                        class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                        class="fa-solid fa-star"></i>
                                </div>
                                <p class="text-gray-500 text-sm">Dựa trên 210 đánh giá</p>
                            </div>

                            <div class="flex-1 w-full space-y-2 text-sm text-gray-600 font-medium">
                                <div class="flex items-center">
                                    <span class="w-24">Tuyệt vời (5<i
                                            class="fa-solid fa-star text-yellow-400 text-[10px] ml-1"></i>)</span>
                                    <div class="flex-1 h-2 bg-gray-200 rounded-full mx-3 overflow-hidden">
                                        <div class="h-full bg-yellow-400 w-[90%]"></div>
                                    </div>
                                    <span class="w-8 text-right">189</span>
                                </div>
                                <div class="flex items-center">
                                    <span class="w-24">Khá tốt (4<i
                                            class="fa-solid fa-star text-yellow-400 text-[10px] ml-1"></i>)</span>
                                    <div class="flex-1 h-2 bg-gray-200 rounded-full mx-3 overflow-hidden">
                                        <div class="h-full bg-yellow-400 w-[8%]"></div>
                                    </div>
                                    <span class="w-8 text-right">18</span>
                                </div>
                                <div class="flex items-center text-gray-400">
                                    <span class="w-24">Trung bình (3<i
                                            class="fa-solid fa-star text-yellow-400 text-[10px] ml-1"></i>)</span>
                                    <div class="flex-1 h-2 bg-gray-200 rounded-full mx-3">
                                        <div class="h-full bg-yellow-400 w-[2%]"></div>
                                    </div>
                                    <span class="w-8 text-right">3</span>
                                </div>
                            </div>
                        </div>

                        <!-- Review List -->
                        <div class="space-y-6">
                            <!-- Review 1 -->
                            <div class="border-b border-gray-100 pb-6 last:border-0 last:pb-0">
                                <div class="flex justify-between items-start mb-3">
                                    <div class="flex items-center">
                                        <img src="https://i.pravatar.cc/150?img=11" alt="Avatar"
                                            class="w-10 h-10 rounded-full mr-3">
                                        <div>
                                            <p class="font-bold text-dark text-sm">Nguyễn Hoàng Anh</p>
                                            <p class="text-xs text-gray-400">Gia đình du lịch • Đã xác nhận đặt tour</p>
                                        </div>
                                    </div>
                                    <span class="text-xs text-gray-400">12/08/2026</span>
                                </div>
                                <div class="flex text-yellow-400 text-xs mb-2">
                                    <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                        class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                        class="fa-solid fa-star"></i>
                                </div>
                                <h4 class="font-bold text-dark mb-1">Trải nghiệm tuyệt vời cho gia đình!</h4>
                                <p class="text-gray-600 text-sm">Tour tổ chức rất chuyên nghiệp. Hướng dẫn viên bạn Quân
                                    rất nhiệt tình, am hiểu lịch sử và hỗ trợ gia đình có người lớn tuổi cực kỳ chu đáo.
                                    Khách sạn đẹp, đồ ăn ngon miệng. Điểm trừ nhỏ là ngày đầu lịch trình hơi dày một chút.
                                </p>
                            </div>

                            <!-- Review 2 -->
                            <div class="border-b border-gray-100 pb-6 last:border-0 last:pb-0">
                                <div class="flex justify-between items-start mb-3">
                                    <div class="flex items-center">
                                        <img src="https://i.pravatar.cc/150?img=5" alt="Avatar"
                                            class="w-10 h-10 rounded-full mr-3">
                                        <div>
                                            <p class="font-bold text-dark text-sm">Trần Lê Thu Hương</p>
                                            <p class="text-xs text-gray-400">Cặp đôi • Đã xác nhận đặt tour</p>
                                        </div>
                                    </div>
                                    <span class="text-xs text-gray-400">05/08/2026</span>
                                </div>
                                <div class="flex text-yellow-400 text-xs mb-2">
                                    <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                        class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                        class="fa-solid fa-star"></i>
                                </div>
                                <h4 class="font-bold text-dark mb-1">Cảnh đẹp, đồ ăn siêu ngon</h4>
                                <p class="text-gray-600 text-sm">Thích nhất là buổi tối ở Hội An và đi thuyền trên sông
                                    Hương. Wanderlust đã sắp xếp thời gian hợp lý để chúng mình có thể tự do khám phá và
                                    chụp ảnh. Rất đáng tiền!</p>
                            </div>
                        </div>

                        <div class="mt-6 text-center">
                            <button class="text-primary font-medium hover:underline">Xem thêm tất cả đánh giá <i
                                    class="fa-solid fa-arrow-right ml-1 text-sm"></i></button>
                        </div>
                    </div>

                </div>

                <!-- Right Column: Booking Widget (Sticky) -->
                <div class="w-full lg:w-1/3">
                    <div
                        class="bg-white rounded-2xl shadow-float border border-gray-100 sticky-sidebar overflow-hidden z-20">

                        <!-- Price Tag -->
                        <div class="bg-dark p-6 text-white text-center relative overflow-hidden">
                            <div class="absolute -right-6 -top-6 w-24 h-24 bg-red-500 rounded-full opacity-20 blur-xl">
                            </div>
                            
                            <p class="text-gray-400 text-sm mb-1">Giá trọn gói từ</p>
                            
                            <h3 class="text-4xl font-bold text-emerald-400">{{ number_format($tour->sale_price, 0, ',', '.') }}<span
                                    class="text-xl text-emerald-400 font-normal">đ</span></h3>
                        </div>

                        <!-- Booking Form -->
                        <div class="p-6">
                            <form class="space-y-5">
                                <!-- Date Selection -->
                                <div>
                                    <label class="block text-sm font-bold text-dark mb-2">Ngày khởi hành</label>
                                    <div class="relative">
                                        <i class="fa-regular fa-calendar absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                        <input type="text" readonly
                                            class="w-full bg-gray-50 border border-gray-200 rounded-xl py-3 pl-10 pr-4 text-gray-700 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors cursor-default"
                                            value="{{ $tour->start_date ? \Carbon\Carbon::parse($tour->start_date)->format('d/m/Y') : 'Đang cập nhật' }}">
                                    </div>
                                    <p class="text-xs text-secondary mt-1"><i class="fa-solid fa-bolt mr-1"></i> Còn trống <span id="slots-available">{{ $tour->quantity > 0 ? $tour->quantity - 1 : 0 }}</span> chỗ ngày này</p>
                                </div>

                                <!-- Guests Selection -->
                                <div>
                                    <label class="block text-sm font-bold text-dark mb-2">Số lượng khách</label>
                                    <div class="space-y-3">
                                        <!-- Adult -->
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <p class="text-sm font-medium text-dark">Khách hàng</p>
                                                <p class="text-xs text-gray-500">Mọi độ tuổi</p>
                                            </div>
                                            <div class="flex items-center border border-gray-200 rounded-lg">
                                                <button type="button" id="btn-minus"
                                                    class="w-8 h-8 flex items-center justify-center text-gray-500 hover:bg-gray-100 rounded-l-lg">-</button>
                                                <span id="guest-count" class="w-8 text-center text-sm font-medium">1</span>
                                                <button type="button" id="btn-plus"
                                                    class="w-8 h-8 flex items-center justify-center text-primary hover:bg-gray-100 rounded-r-lg">+</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Total calculation -->
                                <div class="border-t border-gray-100 pt-4 mt-2">
                                    <div class="flex justify-between items-center mb-2 text-gray-600 text-sm">
                                        <span id="price-calculation">{{ number_format($tour->sale_price, 0, ',', '.') }}đ x 1 Người</span>
                                        <span id="price-subtotal" class="font-medium text-dark">{{ number_format($tour->sale_price, 0, ',', '.') }}đ</span>
                                    </div>
                                    <div class="flex justify-between items-center font-bold text-lg">
                                        <span class="text-dark">Tổng tiền:</span>
                                        <span id="price-total" class="text-primary">{{ number_format($tour->sale_price, 0, ',', '.') }}đ</span>
                                    </div>
                                </div>

                                <!-- CTA Button -->
                                <a  href="{{ route('user.cart') }}" id="btn-checkout"
                                    class="w-full bg-primary hover:bg-sky-600 text-white font-bold py-4 rounded-xl shadow-lg shadow-sky-500/30 transition-all duration-300 transform hover:-translate-y-1 mt-2 flex justify-center items-center">
                                    <i class="fa-solid fa-lock text-sm mr-2 opacity-80"></i> Đặt Tour Ngay
                                </a>

                                <button type="button"
                                    class="w-full bg-white border-2 border-primary text-primary hover:bg-sky-50 font-bold py-3 rounded-xl transition-all duration-300 mt-3">
                                    Nhận Tư Vấn (Miễn Phí)
                                </button>
                            </form>

                            <!-- Trust Badges -->
                            <div class="mt-6 pt-4 border-t border-gray-100 grid grid-cols-2 gap-4">
                                <div class="text-center">
                                    <i class="fa-solid fa-shield-halved text-gray-400 text-xl mb-1"></i>
                                    <p class="text-[10px] text-gray-500 font-medium">Bảo mật thanh toán</p>
                                </div>
                                <div class="text-center">
                                    <i class="fa-regular fa-handshake text-gray-400 text-xl mb-1"></i>
                                    <p class="text-[10px] text-gray-500 font-medium">Cam kết chất lượng</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Related Tours Section -->
    <section class="py-16 bg-white border-t border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl md:text-3xl font-bold text-dark mb-8">Có Thể Bạn Sẽ Thích</h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($relatedTours as $relatedTour)
                <div
                    class="bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-soft transition-all group">
                    <div class="relative h-48 overflow-hidden">
                        <img src="{{ Str::startsWith($relatedTour->image, 'http') ? $relatedTour->image : asset($relatedTour->image) }}"
                            alt="{{ $relatedTour->name }}"
                            class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">
                    </div>
                    <div class="p-5">
                        <div class="flex justify-between items-center mb-1 text-xs text-gray-500">
                            <span><i class="fa-solid fa-location-dot text-primary mr-1"></i> {{ $relatedTour->end_location }}</span>
                            <span>{{ $relatedTour->time }}</span>
                        </div>
                        <h3
                            class="font-bold text-dark mb-2 line-clamp-1 hover:text-primary cursor-pointer transition-colors">
                            <a href="{{ route('user.tourDetail.index', ['id' => $relatedTour->id]) }}">{{ $relatedTour->name }}</a>
                        </h3>
                        <div class="flex justify-between items-end mt-4 pt-4 border-t border-gray-50">
                            <div>
                                <p class="text-[10px] text-gray-400 line-through">{{ number_format($relatedTour->price, 0, ',', '.') }}đ</p>
                                <p class="text-base font-bold text-emerald-600">{{ number_format($relatedTour->sale_price, 0, ',', '.') }}đ</p>
                            </div>
                            <a href="{{ route('user.tourDetail.index', ['id' => $relatedTour->id]) }}" class="text-sm text-primary font-medium hover:underline">Chi tiết</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>


    <script>

        // Header scroll effect
        const header = document.getElementById('header');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 10) {
                header.classList.add('shadow-md');
                header.classList.replace('glass-effect', 'bg-white');
            } else {
                header.classList.remove('shadow-md');
                header.classList.replace('bg-white', 'glass-effect');
            }
        });

        // Mobile menu toggle
        const btn = document.getElementById('mobile-menu-btn');
        // Logic for mobile menu would go here (omitted for brevity as it's same as index)

        // Quantity and Price Calculation Logic
        document.addEventListener('DOMContentLoaded', function() {
            const maxSlots = {{ $tour->quantity ?? 0 }};
            const salePrice = {{ $tour->sale_price ?? 0 }};
            let currentGuests = 1;
            
            if(maxSlots === 0) currentGuests = 0; // Handle sold out case

            const guestCountEl = document.getElementById('guest-count');
            const slotsAvailableEl = document.getElementById('slots-available');
            const priceCalcEl = document.getElementById('price-calculation');
            const priceSubtotalEl = document.getElementById('price-subtotal');
            const priceTotalEl = document.getElementById('price-total');
            
            const btnMinus = document.getElementById('btn-minus');
            const btnPlus = document.getElementById('btn-plus');

            function formatCurrency(number) {
                return new Intl.NumberFormat('vi-VN').format(number) + 'đ';
            }

            function updateTotals() {
                guestCountEl.textContent = currentGuests;
                slotsAvailableEl.textContent = Math.max(0, maxSlots - currentGuests);
                
                const total = currentGuests * salePrice;
                priceCalcEl.textContent = formatCurrency(salePrice) + ' x ' + currentGuests + ' Khách';
                priceSubtotalEl.textContent = formatCurrency(total);
                priceTotalEl.textContent = formatCurrency(total);

                const checkoutBtn = document.getElementById('btn-checkout');
                if (checkoutBtn) {
                   checkoutBtn.href = "{{ route('user.cart') }}?tour_id={{ $tour->id }}&qty=" + currentGuests;
                }
            }

            if(btnPlus && btnMinus) {
                btnPlus.addEventListener('click', () => {
                    if (currentGuests < maxSlots) {
                        currentGuests++;
                        updateTotals();
                    }
                });

                btnMinus.addEventListener('click', () => {
                    if (currentGuests > 1) {
                        currentGuests--;
                        updateTotals();
                    }
                });
            }
        });
    </script>
@endsection
