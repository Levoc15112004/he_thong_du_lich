@extends('users.master')

@section('home')
    @php
        $totalReviews = $reviews->count();

        $ratingCounts = [
            5 => $reviews->where('rating', 5)->count(),
            4 => $reviews->where('rating', 4)->count(),
            3 => $reviews->where('rating', 3)->count(),
            2 => $reviews->where('rating', 2)->count(),
            1 => $reviews->where('rating', 1)->count(),
        ];

    @endphp


    <div class="container mx-auto px-4 md:px-16 pt-24 md:pt-32 py-12">

        <!-- Breadcrumb -->
        <nav class="text-sm mb-6">
            <ul class="flex flex-wrap items-center gap-x-2 gap-y-2 text-slate-500">
                <li>
                    <a href="/" class="flex items-center text-teal-600 hover:text-teal-700 transition-colors whitespace-nowrap">
                        <i class="fa-solid text-[10px] fa-house mr-1.5 mb-0.5"></i>Trang chủ
                        <i class="fa-solid fa-angle-right ml-2 text-slate-300 text-xs"></i>
                    </a>
                </li>
                <li>
                    <a href="#" class="flex text-sm items-center hover:text-teal-600 transition-colors whitespace-nowrap">
                        {{ $tour->category->name ?? 'Danh mục' }}
                        <i class="fa-solid fa-angle-right ml-2 text-slate-300 text-xs"></i>
                    </a>
                </li>
                <li class="font-medium text-slate-700">{{ $tour->name }}</li>
            </ul>
        </nav>


        <main class=" max-w-7xl mx-auto px-4 pb-16">

            <!-- ===== HEADER TOUR ===== -->
            <div class="mt-6 mb-8">
                <h1 class="text-3xl md:text-4xl font-bold text-slate-800 mb-4 leading-tight brand-font">
                    {{ $tour->name }}
                </h1>

                <div class="flex flex-wrap items-center gap-4 text-sm font-medium">
                    <span class="bg-amber-50 border border-amber-200 text-amber-700 px-3 py-1.5 rounded-full flex items-center gap-1">
                        <i class="fa-solid fa-star text-amber-400"></i> {{ number_format($avgRating ?? 0, 1) }}
                        <span class="text-amber-600/70 ml-1">({{ $totalReviews ?? 0 }} đánh giá)</span>
                    </span>

                    <span class="text-slate-500 bg-slate-50 px-3 py-1.5 rounded-full flex items-center gap-1.5 border border-slate-100">
                        <i class="fa-solid fa-location-dot text-teal-500"></i>
                        {{ $tour->start_location }} → {{ $tour->end_location }}
                    </span>
                </div>
            </div>

            <!-- ===== GRID CHÍNH ===== -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <!-- ================= LEFT CONTENT ================= -->
                <div class="lg:col-span-2 space-y-8">

                    <!-- ===== GALLERY ===== -->
                    <div class="bg-white rounded-[2rem] overflow-hidden shadow-sm border border-slate-100 p-2">
                        <div class="relative h-[350px] md:h-[500px] rounded-[1.5rem] overflow-hidden">
                            <img id="mainImage" src="{{ asset($tour->image) }}" alt="{{ $tour->name }}"
                                class="w-full h-full object-cover transition-transform duration-700 hover:scale-105">
                        </div>

                        <style>
                            .tour-gallery-grid {
                                display: grid;
                                gap: 8px;
                                padding: 8px;
                                grid-template-columns: repeat(4, 1fr);
                            }
                            @media (min-width: 640px) {
                                .tour-gallery-grid { grid-template-columns: repeat(6, 1fr); }
                            }
                            @media (min-width: 768px) {
                                .tour-gallery-grid { grid-template-columns: repeat(8, 1fr); }
                            }
                            .tour-gallery-grid img {
                                width: 100%;
                                height: 64px;
                                object-fit: cover;
                                border-radius: 6px;
                                cursor: pointer;
                                transition: opacity 0.3s;
                            }
                            @media (min-width: 768px) {
                                .tour-gallery-grid img { height: 80px; }
                            }
                            .tour-gallery-grid img:hover {
                                opacity: 0.8;
                            }
                        </style>
                        <div class="tour-gallery-grid">
                            @foreach ($images as $image)
                                <img src="{{ asset($image->image) }}" class="thumbnail">
                            @endforeach
                        </div>
                    </div>


                    <!-- ===== THÔNG TIN TOUR ===== -->
                    <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 p-8 space-y-8">

                        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-sm">
                            <div class="bg-slate-50 rounded-2xl p-4 text-center border border-slate-100">
                                <i class="fa-regular fa-calendar-check text-2xl text-teal-500 mb-2 block"></i>
                                <p class="text-slate-500 font-medium mb-1">Khởi hành</p>
                                <p class="font-bold text-slate-800 text-base">
                                    {{ \Carbon\Carbon::parse($tour->start_date)->format('d/m/Y') }}
                                </p>
                            </div>

                            <div class="bg-slate-50 rounded-2xl p-4 text-center border border-slate-100">
                                <i class="fa-regular fa-clock text-2xl text-teal-500 mb-2 block"></i>
                                <p class="text-slate-500 font-medium mb-1">Thời gian</p>
                                <p class="font-bold text-slate-800 text-base">{{ $tour->time }}</p>
                            </div>

                            <div class="bg-slate-50 rounded-2xl p-4 text-center border border-slate-100">
                                <i class="fa-solid fa-users text-2xl text-teal-500 mb-2 block"></i>
                                <p class="text-slate-500 font-medium mb-1">Số khách tối đa</p>
                                <p class="font-bold text-slate-800 text-base">{{ $quantity }}</p>
                            </div>

                            <div class="bg-slate-50 rounded-2xl p-4 text-center border border-slate-100">
                                <i class="fa-solid fa-person-walking-luggage text-2xl text-teal-500 mb-2 block"></i>
                                <p class="text-slate-500 font-medium mb-1">Còn trống</p>
                                <p
                                    class="font-bold text-base {{ $slots == 0 ? 'text-rose-500' : 'text-emerald-600' }}">
                                    {{ $slots }} chỗ
                                </p>
                            </div>
                        </div>

                        <div class="pt-4 border-t border-slate-100">
                            <h3 class="text-xl font-bold mb-4 brand-font text-slate-800">Giới thiệu chuyến đi</h3>
                            <p class="text-slate-600 text-base leading-loose font-light">
                                {{ $tour->description }}
                            </p>
                        </div>
                    </div>

                    <!-- ===== LỊCH TRÌNH + ĐÁNH GIÁ ===== -->
                    <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 p-8">

                        <!-- TAB HEADER -->
                        <div class="flex gap-8 border-b border-slate-100 mb-8 overflow-x-auto custom-scrollbar">
                            <button onclick="switchTab('schedule')" id="tab-schedule"
                                class="pb-4 font-semibold text-lg border-b-2 border-teal-500 text-teal-600 whitespace-nowrap brand-font">
                                Lịch trình chi tiết
                            </button>

                            <button onclick="switchTab('review')" id="tab-review"
                                class="pb-4 font-semibold text-lg text-slate-400 hover:text-teal-600 transition-colors whitespace-nowrap brand-font">
                                Đánh giá khách hàng ({{ $totalReviews }})
                            </button>
                        </div>

                        <!-- ===== TAB CONTENT: LỊCH TRÌNH ===== -->
                        <div id="content-schedule" class="space-y-6">

                            <div id="schedule-wrapper">

                                @foreach ($tourSchedules as $index => $day)
                                    <div class="schedule-item {{ $index >= 2 ? 'hidden extra-day' : '' }}">

                                        <div class="relative pl-8 border-l-2 border-teal-100">

                                            <!-- DOT -->
                                            <span
                                                class="absolute -left-[9px] top-5 bg-teal-500 w-4 h-4 rounded-full border-2 border-white"></span>

                                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-start">

                                                <!-- TEXT -->
                                                <div class="mt-4 md:col-span-2 space-y-2">
                                                    <h4 class="font-bold text-base text-gray-800">
                                                        Ngày {{ $day->day_number }}: {{ $day->title }}
                                                    </h4>

                                                    <p class="text-gray-600 text-sm leading-relaxed">
                                                        {!! nl2br(e($day->description)) !!}
                                                    </p>
                                                </div>

                                                <!-- IMAGE -->
                                                @if ($day->image)
                                                    <div class="flex justify-center md:justify-end">
                                                        <img src="{{ asset($day->image) }}"
                                                            class="w-full md:w-68 h-44 object-cover rounded-xl shadow-md
                                transition-transform duration-300 hover:scale-105">
                                                    </div>
                                                @endif

                                            </div>
                                        </div>

                                    </div>
                                @endforeach

                            </div>

                            <!-- BUTTON -->
                            @if ($tourSchedules->count() > 2)
                                <div class="mt-4 flex justify-center">
                                    <button onclick="toggleSchedule()" id="btn-schedule"
                                        class="flex items-center gap-2 text-teal-600 font-semibold hover:underline">

                                        <span id="btn-text">Xem thêm lịch trình</span>
                                        <i id="btn-icon" class="fa-solid fa-chevron-down"></i>
                                    </button>
                                </div>
                            @endif


                        </div>

                        <!-- ===== TAB CONTENT: ĐÁNH GIÁ ===== -->
                        <div id="content-review" class="hidden space-y-6">

                            {{-- ================= TỔNG QUAN ================= --}}
                            <div class="flex flex-col md:flex-row items-center gap-6 bg-slate-50 p-6 rounded-[2rem] border border-slate-100">
                                <div class="text-center min-w-[140px]">
                                    <p class="text-4xl font-bold text-amber-500 mb-1">
                                        {{ number_format($avgRating ?? 0, 1) }}
                                    </p>

                                    <div class="text-amber-400 mt-1">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <i
                                                class="fa-solid fa-star {{ $i <= round($avgRating) ? '' : 'text-slate-300' }}"></i>
                                        @endfor
                                    </div>

                                    <p class="text-sm text-slate-500 mt-1 font-medium">
                                        {{ $totalReviews }} đánh giá
                                    </p>
                                </div>

                                <div class="flex-1 space-y-2 text-sm">
                                    @for ($i = 5; $i >= 1; $i--)
                                        <div class="flex text-lg items-center gap-2">
                                            <span class="w-14"> <i class="fa-solid fa-star text-amber-500 mr-1"></i>
                                                {{ $i }}</span>
                                            <div class="flex-1 bg-slate-200 rounded-full h-2 overflow-hidden">
                                                <div class="bg-amber-400 h-2"
                                                    style="width: {{ $totalReviews ? ($ratingCounts[$i] / $totalReviews) * 100 : 0 }}%">
                                                </div>
                                            </div>
                                            <span class="w-8 text-right">{{ $ratingCounts[$i] }}</span>
                                        </div>
                                    @endfor
                                </div>
                            </div>

                            {{-- ================= DANH SÁCH REVIEW ================= --}}
                            <div id="review-wrapper" class="space-y-4">

                                @forelse($reviews as $index => $review)
                                    <div class="{{ $index >= 3 ? 'hidden extra-review' : '' }}">
                                        <div class="border border-slate-100 rounded-[1.5rem] p-6 shadow-sm">

                                            <div class="flex justify-between items-center mb-1">
                                                <p class="font-bold text-lg text-slate-800 brand-font">
                                                    {{ $review->user->name ?? 'Người dùng' }}
                                                </p>

                                                <div class="text-amber-400 text-sm">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <i
                                                            class="fa-solid fa-star {{ $i <= $review->rating ? '' : 'text-slate-300' }}"></i>
                                                    @endfor
                                                </div>
                                            </div>

                                            <p class="text-slate-600 text-base leading-relaxed mt-2">
                                                {{ $review->comment }}
                                            </p>

                                            {{-- PHẢN HỒI ADMIN --}}
                                            @if ($review->reply)
                                                <div
                                                    class="mt-4 bg-slate-50 p-4 rounded-xl text-sm border-l-4 border-amber-400">
                                                    <strong class="text-slate-800 font-semibold mb-1 block">Phản hồi từ Care Team:</strong>
                                                    <p class="text-slate-600">
                                                        {{ $review->reply }}
                                                    </p>
                                                </div>
                                            @endif

                                        </div>
                                    </div>
                                @empty
                                    <p class="text-center text-lg text-slate-500 py-6">
                                        Chưa có đánh giá nào cho chuyến đi này.
                                    </p>
                                @endforelse

                            </div>

                            @if ($reviews->count() > 3)
                                <div class="mt-4 flex justify-center">
                                    <button onclick="toggleReview()" id="btn-review"
                                        class="flex items-center gap-2 text-teal-600 font-semibold hover:underline">

                                        <span id="review-text">Xem thêm đánh giá</span>
                                        <i id="review-icon" class="fa-solid fa-chevron-down"></i>
                                    </button>
                                </div>
                            @endif
                        </div>

                    </div>

                </div>

                <!-- ================= RIGHT BOOKING ================= -->
                <div class="lg:col-span-1">
                    <div
                        class="bg-white rounded-[2rem] shadow-[0_15px_40px_rgba(0,0,0,0.06)] border border-slate-100
                        p-6 lg:p-8 sticky top-28 space-y-6">

                        <!-- ===== TITLE ===== -->
                        <h2 class="text-2xl font-bold text-slate-800 leading-snug brand-font border-b border-slate-100 pb-4">
                            Đặt chỗ ngay
                        </h2>

                        <!-- ===== PRICE ===== -->
                        <div class="space-y-1">
                            <p class="text-sm font-medium text-slate-400 uppercase tracking-widest mb-1">Giá hành trình</p>
                            <p class="text-4xl font-bold text-rose-500 tracking-tight">
                                {{ number_format($tour->sale_price) }}<span class="text-xl ml-1 text-slate-500 font-medium">đ</span>
                            </p>
                        </div>

                        <!-- ===== QUICK INFO ===== -->
                        <div class="grid grid-cols-2 gap-4 text-xs mt-6 mb-4">
                            <div class="bg-teal-50/50 rounded-2xl p-4">
                                <p class="text-slate-400 mb-1 font-medium">Khởi hành</p>
                                <p class="font-bold text-sm text-slate-700">
                                    {{ \Carbon\Carbon::parse($tour->start_date)->format('d/m/Y') }}
                                </p>
                            </div>
                            <div class="bg-teal-50/50 rounded-2xl p-4">
                                <p class="text-slate-400 mb-1 font-medium">Lịch trình</p>
                                <p class="font-bold text-sm text-slate-700">
                                    {{ $tour->time }}
                                </p>
                            </div>
                        </div>

                        <button onclick="openItineraryModal({{ $tour->id }})"
                            class="w-full flex items-center justify-center gap-2 py-3.5 border-2 border-teal-100/60 rounded-2xl mb-6 hover:bg-teal-50 hover:border-teal-200 transition-all text-teal-600 font-semibold group shadow-sm bg-white">
                            <i data-lucide="map" class="w-5 h-5 group-hover:scale-110 transition-transform"></i>
                            <span>Xem bản đồ lịch trình</span>
                        </button>

                        <!-- ===== FORM ===== -->
                        <form action="{{ route('user.cart.add', $tour->id) }}" method="POST" class="space-y-4 text-slate-800">
                            @csrf

                            <!-- TRANSPORT -->
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">
                                    Phương tiện di chuyển
                                </label>

                                <div class="grid grid-cols-1 gap-3 text-sm">
                                    @foreach ($transportValues as $value)
                                        <label
                                            class="flex items-center justify-between px-4 py-3 rounded-xl bg-slate-50 border border-slate-200
                                             hover:border-emerald-500 hover:bg-white cursor-pointer transition-all shadow-sm group">
                                            <span class="font-semibold text-slate-700 group-hover:text-emerald-600 z-10">{{ $value }}</span>
                                            <input type="radio" name="transport" value="{{ $value }}"
                                                {{ $loop->first ? 'checked' : '' }} class="text-emerald-500 focus:ring-emerald-500 z-10 focus:ring-2">
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <!-- TOUR TYPE -->
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1 mt-2">
                                    Loại hình lưu trú
                                </label>

                                <div class="grid grid-cols-1 gap-3 text-sm">
                                    @foreach ($tourTypeValues as $value)
                                        <label
                                            class="flex items-center justify-between px-4 py-3 rounded-xl bg-slate-50 border border-slate-200
                                            hover:border-emerald-500 hover:bg-white cursor-pointer transition-all shadow-sm group">
                                            <span class="font-semibold text-slate-700 group-hover:text-emerald-600 z-10">{{ $value }}</span>
                                            <input type="radio" name="tour_type" value="{{ $value }}"
                                                {{ $loop->first ? 'checked' : '' }} class="text-emerald-500 focus:ring-emerald-500 z-10 focus:ring-2">
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <!-- QUANTITY -->
                            <div>
                                <label class="flex justify-between items-center text-xs font-bold text-slate-700 mb-1 mt-2">
                                    <span>Hành khách</span>
                                    <span id="seat-status-label" class="text-[10px] uppercase tracking-wider text-rose-600 bg-rose-100 border border-rose-200 px-2 py-0.5 rounded-full shadow-sm">
                                        Còn trống: {{ max($slots - 1, 0) }}
                                    </span>
                                </label>

                                <input type="number" id="tour-quantity-input" name="quantity" value="1" min="1"
                                    max="{{ $slots }}" placeholder="Nhập số lượng"
                                    class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 placeholder-slate-400 text-sm focus:outline-none focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-500/10 transition-all">

                                @if ($slots == 0)
                                    <p class="text-rose-500 text-xs mt-2 font-bold flex items-center gap-1.5 bg-rose-50 border border-rose-100 px-3 py-2 rounded-xl">
                                        <i class="fa-solid fa-triangle-exclamation"></i> Rất tiếc, tour đã kín chỗ
                                    </p>
                                @endif
                                <p id="quantity-error-msg" class="text-rose-500 text-xs mt-2 font-bold flex items-center gap-1.5 hidden bg-rose-50 border border-rose-100 px-3 py-2 rounded-xl">
                                    <i class="fa-solid fa-triangle-exclamation"></i> Vượt quá số chỗ còn trống
                                </p>
                            </div>

                            <!-- CTA -->
                            <button type="submit" id="book-tour-btn" {{ $slots == 0 ? 'disabled' : '' }}
                                class="w-full py-3.5 mt-2 rounded-xl bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 text-white font-bold text-sm uppercase tracking-wider shadow-lg shadow-emerald-500/25 hover:scale-[1.01] active:scale-[0.99] transition-all disabled:opacity-50 disabled:cursor-not-allowed">
                                <i class="fa-solid fa-bookmark mr-2"></i> Giữ Chỗ Ngay
                            </button>

                            <script>
                                document.addEventListener('DOMContentLoaded', () => {
                                    const maxSlots = {{ $slots }};
                                    const qtyInput = document.getElementById('tour-quantity-input');
                                    const seatLabel = document.getElementById('seat-status-label');
                                    const bookBtn = document.getElementById('book-tour-btn');
                                    const errMsg = document.getElementById('quantity-error-msg');

                                    if(qtyInput) {
                                        qtyInput.addEventListener('input', () => {
                                            let currentVal = parseInt(qtyInput.value) || 0;
                                            
                                            if (currentVal < 0) {
                                                currentVal = 1;
                                                qtyInput.value = 1;
                                            }

                                            // Hiển thị số lượng còn dư
                                            let remaining = maxSlots - currentVal;
                                            
                                            if (remaining < 0) {
                                                seatLabel.innerHTML = 'Còn trống: 0';
                                                seatLabel.classList.replace('text-rose-600', 'text-white');
                                                seatLabel.classList.replace('bg-rose-100', 'bg-rose-500');
                                                errMsg.classList.remove('hidden');
                                                bookBtn.disabled = true;
                                            } else {
                                                seatLabel.innerHTML = 'Còn trống: ' + remaining;
                                                seatLabel.classList.replace('text-white', 'text-rose-600');
                                                seatLabel.classList.replace('bg-rose-500', 'bg-rose-100');
                                                errMsg.classList.add('hidden');
                                                bookBtn.disabled = (maxSlots === 0);
                                            }
                                        });
                                    }
                                });
                            </script>

                        </form>

                    </div>
                </div>

            </div>
        </main>

        <!-- Tour liên quan -->
        <section class="mt-8 mb-20 max-w-7xl mx-auto px-4">
            <h2 class="text-3xl font-bold mb-8 brand-font text-slate-800">Có thể bạn sẽ thích</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 px-2">

                @foreach ($tourRelate as $item)
                    <div
                        class="bg-white rounded-[2rem] shadow-sm border border-slate-100 hover:shadow-xl overflow-hidden
                hover:-translate-y-1.5 transition-all duration-300 flex flex-col h-full group">

                        <!-- Ảnh -->
                        <a href="{{ route('user.tourDetail.index', $item->id) }}" class="relative h-56 overflow-hidden block">
                            <img src="{{ asset($item->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            <div class="absolute bottom-3 left-3 bg-white/90 backdrop-blur-md px-3 py-1 rounded-full text-xs font-semibold text-teal-600 shadow-sm flex items-center gap-1.5">
                                <i class="fa-solid fa-map-pin"></i> {{ $item->end_location }}
                            </div>
                        </a>

                        <!-- Nội dung -->
                        <div class="p-6 flex flex-col flex-grow justify-between">
                            <div>
                                <h3 class="text-xl font-bold text-slate-800 mb-3 line-clamp-2 min-h-[56px] brand-font group-hover:text-teal-600 transition-colors">
                                    {{ $item->name }}
                                </h3>

                                <div class="w-10 h-0.5 bg-slate-100 mb-4 rounded-full"></div>

                                <div class="flex items-end justify-between mt-2">
                                    <div>
                                        <p class="text-[11px] font-medium text-slate-400 uppercase tracking-widest mb-1">Chỉ từ</p>
                                        <p class="text-2xl font-bold text-rose-500">
                                            {{ number_format($item->sale_price, 0, '.', '.') }}<span class="text-sm ml-0.5 text-slate-500 font-normal">đ</span>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <form action="{{ route('user.cart.add', $item->id) }}" method="POST" class="mt-6">
                                @csrf
                                <button type="submit"
                                    class="w-full py-3.5 rounded-xl bg-emerald-50 text-emerald-700 hover:bg-emerald-500 hover:text-white font-bold text-sm transition-all flex items-center justify-center gap-2 border border-emerald-100 group shadow-sm">
                                    <span>Xem chi tiết chuyến đi</span>
                                    <i class="fa-solid fa-arrow-right text-xs group-hover:translate-x-1.5 transition-transform"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach

            </div>
        </section>

        <div id="itineraryModal1" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/60">

            <!-- MODAL WRAPPER -->
            <div id="modalContent"
                class="bg-white w-full max-w-6xl mx-4 rounded-3xl shadow-2xl
                max-h-[80vh] flex flex-col
                transform scale-95 opacity-0 transition-all duration-300">

                <!-- HEADER -->
                <div class="flex items-center justify-between p-6 border-b border-slate-100 shrink-0">
                    <h3 class="text-2xl font-bold text-slate-800 flex items-center gap-3 brand-font">
                        <i class="fa-solid fa-route text-teal-500"></i>
                        Lịch Trình Chi Tiết Tour
                    </h3>

                    <button onclick="closeItineraryModal()"
                        class="w-10 h-10 flex items-center justify-center
                           rounded-full text-slate-400 hover:text-rose-500
                           hover:bg-rose-50 transition">
                        <i class="fa-solid fa-xmark text-xl"></i>
                    </button>
                </div>

                <!-- CONTENT -->
                <div class="flex-1 p-4 md:p-6">
                    <div class="relative w-full h-[60vh] min-h-[400px] rounded-[2rem] border border-slate-200 bg-slate-50 shadow-inner overflow-hidden z-0">
                        <!-- Thẻ chứa bản đồ Google Map iframe -->
                        <iframe id="googleMapFrame" class="w-full h-full border-0" loading="lazy"></iframe>

                        <!-- Nút mở lộ trình ra bên ngoài Google Maps -->
                        <div class="absolute bottom-6 left-1/2 -translate-x-1/2 w-max z-[1000]">
                            <a id="directionsButton" target="_blank"
                                class="flex items-center gap-2 px-6 py-3
                              bg-gradient-to-r from-teal-500 to-emerald-500 hover:scale-[1.03]
                              text-white font-bold rounded-full shadow-xl transition-transform duration-300 border border-white/20 backdrop-blur-md">
                                <i class="fa-solid fa-route border-r border-white/20 pr-2 mr-1"></i>
                                Mở lộ trình trên Google Maps
                            </a>
                        </div>
                    </div>
                </div>

                <!-- FOOTER -->
                <div class="p-6 border-t border-slate-100 text-right shrink-0">
                    <button onclick="closeItineraryModal()"
                        class="px-8 py-3 rounded-xl font-bold text-sm
                           bg-slate-100 hover:bg-slate-200 text-slate-700 transition-colors">
                        Đóng cửa sổ
                    </button>
                </div>

            </div>
        </div>
    </div>


    <script>
        function changeImage(src) {
            document.getElementById('mainImage').src = src;
        }

        function toggleAccordion(id) {
            const content = document.getElementById(id);
            const arrow = document.getElementById("arrow-" + id);

            // Ẩn/tắt nội dung
            if (content.classList.contains("hidden")) {
                content.classList.remove("hidden");
                arrow.classList.add("rotate-180");
            } else {
                content.classList.add("hidden");
                arrow.classList.remove("rotate-180");
            }
        }

        document.addEventListener('DOMContentLoaded', () => {

            // Lấy tất cả header accordion
            const headers = document.querySelectorAll('.accordion-header');

            headers.forEach(header => {
                header.addEventListener('click', () => {

                    const day = header.dataset.day;
                    const content = document.querySelector(`[data-content="${day}"]`);
                    const icon = document.querySelector(`[data-icon="${day}"]`);

                    //  Đóng tất cả content khác
                    document.querySelectorAll('.accordion-content').forEach(item => {
                        if (item.dataset.content !== day) {
                            item.classList.add('hidden');
                        }
                    });

                    //  Reset icon của ngày khác
                    document.querySelectorAll('[data-icon]').forEach(item => {
                        if (item.dataset.icon !== day) {
                            item.classList.remove('rotate-180');
                        }
                    });

                    //  Toggle content hiện tại
                    if (content) {
                        content.classList.toggle('hidden');
                    }

                    //  Toggle icon hiện tại
                    if (icon) {
                        icon.classList.toggle('rotate-180');
                    }
                });
            });

            //  Mặc định mở ngày 1
            const firstContent = document.querySelector('[data-content="1"]');
            const firstIcon = document.querySelector('[data-icon="1"]');

            if (firstContent) firstContent.classList.remove('hidden');
            if (firstIcon) firstIcon.classList.add('rotate-180');
        });

        document.addEventListener('DOMContentLoaded', function() {
            const mainImage = document.getElementById('mainImage');
            const thumbnails = document.querySelectorAll('.thumbnail');

            thumbnails.forEach(img => {
                img.addEventListener('click', function() {
                    mainImage.src = this.src;
                });
            });
        });

        function switchTab(tab) {
            const scheduleTab = document.getElementById('tab-schedule');
            const reviewTab = document.getElementById('tab-review');

            const scheduleContent = document.getElementById('content-schedule');
            const reviewContent = document.getElementById('content-review');

            if (tab === 'schedule') {
                scheduleContent.classList.remove('hidden');
                reviewContent.classList.add('hidden');

                scheduleTab.classList.add('border-teal-500', 'text-teal-600');
                reviewTab.classList.remove('border-teal-500', 'text-teal-600');
                reviewTab.classList.add('text-slate-400');
            } else {
                reviewContent.classList.remove('hidden');
                scheduleContent.classList.add('hidden');

                reviewTab.classList.add('border-teal-500', 'text-teal-600');
                scheduleTab.classList.remove('border-teal-500', 'text-teal-600');
                scheduleTab.classList.add('text-slate-400');
            }
        }
    </script>

    <script>
        function toggleSchedule() {
            const extraDays = document.querySelectorAll('.extra-day');
            const btnText = document.getElementById('btn-text');
            const btnIcon = document.getElementById('btn-icon');

            const isHidden = extraDays[0].classList.contains('hidden');

            extraDays.forEach(item => {
                if (isHidden) {
                    item.classList.remove('hidden');
                } else {
                    item.classList.add('hidden');
                }
            });

            // Đổi text + icon
            if (isHidden) {
                btnText.innerText = 'Thu gọn';
                btnIcon.classList.remove('fa-chevron-down');
                btnIcon.classList.add('fa-chevron-up');
            } else {
                btnText.innerText = 'Xem thêm lịch trình';
                btnIcon.classList.remove('fa-chevron-up');
                btnIcon.classList.add('fa-chevron-down');
            }
        }
    </script>

    <script>
        function toggleReview() {
            const items = document.querySelectorAll('.extra-review');
            const text = document.getElementById('review-text');
            const icon = document.getElementById('review-icon');

            const isHidden = items[0].classList.contains('hidden');

            items.forEach(item => {
                if (isHidden) {
                    item.classList.remove('hidden');
                } else {
                    item.classList.add('hidden');
                }
            });

            if (isHidden) {
                text.innerText = 'Thu gọn';
                icon.classList.replace('fa-chevron-down', 'fa-chevron-up');
            } else {
                text.innerText = 'Xem thêm đánh giá';
                icon.classList.replace('fa-chevron-up', 'fa-chevron-down');
            }
        }
    </script>



    <script>
        let modal, modalContent, directionsBtn, mapFrame;

        document.addEventListener('DOMContentLoaded', () => {
            modal = document.getElementById('itineraryModal1');
            modalContent = document.getElementById('modalContent');
            directionsBtn = document.getElementById('directionsButton');
            mapFrame = document.getElementById('googleMapFrame');
        });

        function openItineraryModal(tourId) {
            fetch(`/tour/schedule/${tourId}/json`)
                .then(res => res.json())
                .then(data => {
                    showModal();
                    loadFullRouteMap(data.schedules);
                })
                .catch(err => console.error(err));
        }

        function loadFullRouteMap(schedules) {
            if (!schedules || schedules.length === 0) {
                mapFrame.src = "https://www.google.com/maps?q=16.047079,108.206230&output=embed";
                directionsBtn.href = "#";
                return;
            }

            const validPoints = schedules.filter(s => s.latitude && s.longitude);
            if (validPoints.length === 0) {
                mapFrame.src = "https://www.google.com/maps?q=16.047079,108.206230&output=embed";
                directionsBtn.href = "#";
                return;
            }

            if (validPoints.length === 1) {
                mapFrame.src = `https://www.google.com/maps?q=${validPoints[0].latitude},${validPoints[0].longitude}&output=embed`;
                directionsBtn.href = `https://www.google.com/maps/dir/?api=1&destination=${validPoints[0].latitude},${validPoints[0].longitude}`;
                return;
            }

            // Dùng Google Map Direction Embed kết nối nối các trạm
            const origin = validPoints[0];
            const destination = validPoints[validPoints.length - 1];
            const waypoints = validPoints.slice(1, -1);

            // Sử dụng q= thay vì saddr= để tránh lỗi iframe Google Maps mặc định bị thu nhỏ toàn thế giới
            // Điều này hiển thị bản đồ chuẩn có ghim vị trí zoom rõ.
            mapFrame.src = `https://www.google.com/maps?q=${origin.latitude},${origin.longitude}&output=embed&z=12`;

            // Nút mở hướng dẫn chỉ đường app ngoài (Vẽ toàn bộ lộ trình saddr daddr)
            let dirUrl = `https://www.google.com/maps/dir/?api=1&origin=${origin.latitude},${origin.longitude}&destination=${destination.latitude},${destination.longitude}`;
            if (waypoints.length > 0) {
                dirUrl += `&waypoints=${waypoints.map(w => `${w.latitude},${w.longitude}`).join('%7C')}`;
            }
            directionsBtn.href = dirUrl;
        }

        function showModal() {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            setTimeout(() => {
                modalContent.classList.remove('scale-95', 'opacity-0');
                modalContent.classList.add('scale-100', 'opacity-100');
            }, 10);
        }

        function closeItineraryModal() {
            modalContent.classList.replace('scale-100', 'scale-95');
            modalContent.classList.replace('opacity-100', 'opacity-0');
            setTimeout(() => {
                modal.classList.replace('flex', 'hidden');
                mapFrame.src = ""; // Clear iframe để tối ưu tốc độ và không dính map cũ mở lần sau
            }, 500);
        }
    </script>
@endsection
