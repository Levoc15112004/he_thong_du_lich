@extends('users.master')

@section('meta_title', $tour->name . ' - Khám Phá ' . ($tour->end_location ?? 'Việt Nam') . ' | WanderVibe')
@section('meta_description', Str::limit(strip_tags($tour->description ?? 'Đặt tour ' . $tour->name . ' trọn gói giá tốt. Khởi hành từ ' . $tour->start_location . ' đến ' . $tour->end_location . ', lịch trình ' . $tour->time . ', bảo hiểm đầy đủ, xác nhận tức thì tại WanderVibe.'), 160))
@section('meta_keywords', $tour->name . ', tour ' . ($tour->end_location ?? 'du lich') . ', du lich ' . ($tour->end_location ?? 'viet nam') . ', gia tour ' . $tour->name)
@section('canonical', route('user.tourDetail.index', $tour->id))
@section('og_image', Str::startsWith($tour->image, ['http://', 'https://']) ? $tour->image : asset($tour->image))
@section('og_type', 'product')

@section('schema')
<script type="application/ld+json">
{
  "@context": "https://schema.org/",
  "@type": "Product",
  "name": "{{ addslashes($tour->name) }}",
  "image": "{{ Str::startsWith($tour->image, ['http://', 'https://']) ? $tour->image : asset($tour->image) }}",
  "description": "{{ addslashes(Str::limit(strip_tags($tour->description ?? $tour->name), 250)) }}",
  "sku": "WV-TOUR-{{ $tour->id }}",
  "offers": {
    "@type": "Offer",
    "url": "{{ route('user.tourDetail.index', $tour->id) }}",
    "priceCurrency": "VND",
    "price": "{{ $tour->sale_price ?: $tour->price }}",
    "priceValidUntil": "{{ now()->addMonths(6)->toDateString() }}",
    "availability": "{{ ($tour->quantity ?? 10) > 0 ? 'https://schema.org/InStock' : 'https://schema.org/SoldOut' }}",
    "seller": {
      "@type": "Organization",
      "name": "WanderVibe Travel"
    }
  },
  @if(($avgRating ?? 0) > 0)
  "aggregateRating": {
    "@type": "AggregateRating",
    "ratingValue": "{{ number_format($avgRating, 1) }}",
    "reviewCount": "{{ max(1, $reviews->count()) }}"
  },
  @endif
  "brand": {
    "@type": "Brand",
    "name": "WanderVibe"
  }
}
</script>
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement": [
    {
      "@type": "ListItem",
      "position": 1,
      "name": "Trang chủ",
      "item": "{{ url('/') }}"
    },
    {
      "@type": "ListItem",
      "position": 2,
      "name": "{{ addslashes($tour->category->name ?? 'Tour Du Lịch') }}",
      "item": "{{ route('user.category', $tour->category_id ?? 1) }}"
    },
    {
      "@type": "ListItem",
      "position": 3,
      "name": "{{ addslashes($tour->name) }}",
      "item": "{{ route('user.tourDetail.index', $tour->id) }}"
    }
  ]
}
</script>
@endsection

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
                    <a href="/" class="flex items-center text-orange-600 hover:text-orange-700 transition-colors whitespace-nowrap">
                        <i class="fa-solid text-[10px] fa-house mr-1.5 mb-0.5"></i>Trang chủ
                        <i class="fa-solid fa-angle-right ml-2 text-slate-300 text-xs"></i>
                    </a>
                </li>
                <li>
                    <a href="#" class="flex text-sm items-center hover:text-[#b85e3a] transition-colors whitespace-nowrap">
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
                <h1 class="font-serif text-3xl md:text-4xl font-bold text-slate-900 dark:text-white mb-4 leading-tight">
                    {{ $tour->name }}
                </h1>

                <div class="flex flex-wrap items-center gap-4 text-sm font-medium">
                    <span class="bg-amber-50 border border-amber-200 text-amber-700 px-3 py-1.5 rounded-full flex items-center gap-1">
                        <i class="fa-solid fa-star text-amber-400"></i> {{ number_format($avgRating ?? 0, 1) }}
                        <span class="text-amber-600/70 ml-1">({{ $totalReviews ?? 0 }} đánh giá)</span>
                    </span>

                    <span class="text-slate-500 bg-slate-50 px-3 py-1.5 rounded-full flex items-center gap-1.5 border border-slate-100">
                        <i class="fa-solid fa-location-dot text-orange-500"></i>
                        {{ $tour->start_location }} → {{ $tour->end_location }}
                    </span>
                </div>
            </div>

            <!-- ===== GRID CHÍNH ===== -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <!-- ================= LEFT CONTENT ================= -->
                <div class="lg:col-span-2 space-y-8">

                    <!-- ===== GALLERY SLIDER & VIDEO ===== -->
@php
    $galleryList = collect([$tour->image])->concat($images->pluck('image'))->filter()->unique()->values();
@endphp
<div class="bg-white dark:bg-[#1a1e22] rounded-2xl travel-card overflow-hidden border border-[#e8e3d8] dark:border-[#2b3239] p-3 shadow-sm">
    <div id="tourCarouselStage" class="relative h-[360px] md:h-[500px] rounded-xl overflow-hidden group">
        @foreach($galleryList as $idx => $img)
            @php $imgUrl = Str::startsWith($img, ['http://', 'https://']) ? $img : asset($img); @endphp
            <div class="carousel-slide absolute inset-0 transition-opacity duration-700 ease-in-out {{ $idx === 0 ? 'opacity-100 z-10' : 'opacity-0 z-0 pointer-events-none' }}" data-index="{{ $idx }}">
                <img src="{{ $imgUrl }}" alt="{{ $tour->name }} - Ảnh {{ $idx + 1 }}" class="w-full h-full object-cover">
            </div>
        @endforeach

        <button type="button" id="carouselPrevBtn" class="absolute left-3 top-1/2 -translate-y-1/2 z-20 w-10 h-10 rounded-full bg-black/40 hover:bg-black/70 text-white flex items-center justify-center transition-colors opacity-0 group-hover:opacity-100">
            <i class="fa-solid fa-chevron-left text-sm"></i>
        </button>
        <button type="button" id="carouselNextBtn" class="absolute right-3 top-1/2 -translate-y-1/2 z-20 w-10 h-10 rounded-full bg-black/40 hover:bg-black/70 text-white flex items-center justify-center transition-colors opacity-0 group-hover:opacity-100">
            <i class="fa-solid fa-chevron-right text-sm"></i>
        </button>

        <div class="absolute bottom-4 left-4 z-20 flex items-center gap-2">
            <span id="carouselCounter" class="bg-black/60 backdrop-blur-md text-white text-xs font-mono px-3 py-1 rounded-full border border-white/20">
                1 / {{ $galleryList->count() }}
            </span>
            <span class="bg-black/60 backdrop-blur-md text-emerald-300 text-xs font-medium px-3 py-1 rounded-full border border-white/20">
                <i class="fa-solid fa-camera mr-1"></i> Ảnh thực tế
            </span>
        </div>

        <button type="button" onclick="openTourVideoModal()" class="absolute bottom-4 right-4 z-20 bg-[#863c20] hover:bg-[#a34c2a] text-white text-xs font-bold px-3.5 py-1.5 rounded-lg shadow-md transition-colors flex items-center gap-2">
            <i class="fa-solid fa-play text-[10px]"></i>
            <span>Video Review</span>
        </button>
    </div>

    <div class="flex items-center gap-2.5 overflow-x-auto no-scrollbar pt-3 px-1" id="carouselThumbnails">
        @foreach($galleryList as $idx => $img)
            @php $imgUrl = Str::startsWith($img, ['http://', 'https://']) ? $img : asset($img); @endphp
            <button type="button" onclick="goToCarouselSlide({{ $idx }})" class="carousel-thumb relative shrink-0 w-20 h-14 md:w-24 md:h-16 rounded-lg overflow-hidden border-2 transition-colors {{ $idx === 0 ? 'border-[#863c20] ring-2 ring-[#863c20]/20' : 'border-transparent opacity-60 hover:opacity-100' }}" data-index="{{ $idx }}">
                <img src="{{ $imgUrl }}" class="w-full h-full object-cover">
            </button>
        @endforeach
    </div>
</div>

<div id="tourVideoModal" class="fixed inset-0 z-50 bg-black/80 backdrop-blur-sm flex items-center justify-center p-4 hidden">
    <div class="relative w-full max-w-4xl bg-black rounded-2xl overflow-hidden shadow-2xl border border-slate-700">
        <div class="flex items-center justify-between p-3.5 bg-slate-900 border-b border-slate-800 text-white">
            <span class="text-xs sm:text-sm font-bold flex items-center gap-2">
                <i class="fa-solid fa-film text-[#cf8a6e]"></i>
                <span>Thước Phim Trải Nghiệm Thực Tế: {{ $tour->name }}</span>
            </span>
            <button type="button" onclick="closeTourVideoModal()" class="w-8 h-8 rounded-lg hover:bg-slate-800 text-slate-400 hover:text-white flex items-center justify-center">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <div class="relative aspect-video w-full bg-black flex items-center justify-center overflow-hidden">
            <video id="tourNativeVideoPlayer" controls playsinline class="w-full h-full object-cover">
                <source id="tourNativeVideoSource" src="" type="video/mp4">
                Trình duyệt của bạn không hỗ trợ video HTML5.
            </video>
        </div>
        <div class="px-4 py-3 bg-slate-900 border-t border-slate-800 flex items-center justify-between text-xs text-slate-400">
            <span class="flex items-center gap-1.5"><i class="fa-solid fa-circle-check text-emerald-400"></i> Video trải nghiệm thực tế 4K Ultra HD</span>
            <span class="text-[#cf8a6e] font-semibold">Wanderlust Travel Vietnam</span>
        </div>
    </div>
</div>
<!-- ===== THÔNG TIN TOUR ===== -->
                    <div class="bg-white rounded-2xl travel-card shadow-sm border border-slate-100 p-8 space-y-8">

                        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-sm">
                            <div class="bg-slate-50 rounded-2xl p-4 text-center border border-slate-100">
                                <i class="fa-regular fa-calendar-check text-2xl text-orange-500 mb-2 block"></i>
                                <p class="text-slate-500 font-medium mb-1">Khởi hành</p>
                                <p class="font-bold text-slate-800 text-base">
                                     {{ \Carbon\Carbon::parse($tour->start_date)->format('d/m/Y') }}
                                </p>
                            </div>

                            <div class="bg-slate-50 rounded-2xl p-4 text-center border border-slate-100">
                                <i class="fa-regular fa-clock text-2xl text-orange-500 mb-2 block"></i>
                                <p class="text-slate-500 font-medium mb-1">Thời gian</p>
                                <p class="font-bold text-slate-800 text-base">{{ $tour->time }}</p>
                            </div>

                            <div class="bg-slate-50 rounded-2xl p-4 text-center border border-slate-100">
                                <i class="fa-solid fa-users text-2xl text-orange-500 mb-2 block"></i>
                                <p class="text-slate-500 font-medium mb-1">Số khách tối đa</p>
                                <p class="font-bold text-slate-800 text-base">{{ $quantity }}</p>
                            </div>

                            <div class="bg-slate-50 rounded-2xl p-4 text-center border border-slate-100">
                                <i class="fa-solid fa-person-walking-luggage text-2xl text-orange-500 mb-2 block"></i>
                                <p class="text-slate-500 font-medium mb-1">Còn trống</p>
                                <p
                                    class="font-bold text-base {{ $slots == 0 ? 'text-rose-500' : 'text-orange-600' }}">
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
                    <div class="bg-white rounded-2xl travel-card shadow-sm border border-slate-100 p-8">

                        <!-- TAB HEADER -->
                        <div class="flex gap-8 border-b border-slate-100 mb-8 overflow-x-auto custom-scrollbar">
                            <button onclick="switchTab('schedule')" id="tab-schedule"
                                class="pb-4 font-semibold text-lg border-b-2 border-[#b85e3a] text-[#b85e3a] whitespace-nowrap brand-font">
                                Lịch trình chi tiết
                            </button>

                            <button onclick="switchTab('review')" id="tab-review"
                                class="pb-4 font-semibold text-lg text-slate-400 hover:text-[#b85e3a] transition-colors whitespace-nowrap brand-font">
                                Đánh giá khách hàng ({{ $totalReviews }})
                            </button>
                        </div>

                        <!-- ===== TAB CONTENT: LỊCH TRÌNH ===== -->
                        <div id="content-schedule" class="space-y-6">

                            <div id="schedule-wrapper" class="space-y-8">
@foreach ($tourSchedules as $index => $day)
    <div class="schedule-item relative pl-8 border-l-2 border-[#b85e3a]/30">
        <span class="absolute -left-[9px] top-1.5 bg-[#863c20] w-4 h-4 rounded-full border-2 border-white shadow-xs"></span>
        <div class="w-full space-y-3">
            <h4 class="font-bold text-base text-slate-900 dark:text-white">
                {{ Str::startsWith($day->title, ['Ngày', 'ngay']) ? $day->title : 'Ngày ' . $day->day_number . ': ' . $day->title }}
            </h4>
            @php
                $desc = $day->description ?? '';
                $sections = [];
                if (preg_match_all('/(Buổi Sáng|Buổi Trưa|Buổi Chiều|Buổi Tối|Sáng|Trưa|Chiều|Tối):?\s*([^\n]+(?:\n(?!Buổi|Sáng|Trưa|Chiều|Tối)[^\n]+)*)/ui', $desc, $matches, PREG_SET_ORDER)) {
                    foreach ($matches as $m) {
                        $sections[trim($m[1], ':')] = trim($m[2]);
                    }
                }
            @endphp
            @if(!empty($sections))
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 pt-1">
                    @foreach($sections as $tKey => $tVal)
                        @php
                            $isMorning = Str::contains(mb_strtolower($tKey), 'sáng');
                            $isNoon = Str::contains(mb_strtolower($tKey), 'trưa');
                            $isAfternoon = Str::contains(mb_strtolower($tKey), 'chiều');
                            $slotTime = $isMorning ? '07:30 - 11:30' : ($isNoon ? '12:00 - 13:30' : ($isAfternoon ? '14:00 - 17:30' : '18:30 - 21:30'));
                        @endphp
                        <div class="p-3.5 rounded-xl bg-[#faf8f5] dark:bg-[#151719] border border-[#e8dfd1] dark:border-[#2b3239]">
                            <div class="flex items-center gap-2 mb-1.5">
                                <span class="text-[11px] font-bold text-[#863c20] dark:text-[#cf8a6e]">
                                    {{ Str::startsWith($tKey, 'Buổi') ? $tKey : 'Buổi ' . $tKey }}
                                </span>
                                <span class="text-[10px] text-slate-400 font-mono">• {{ $slotTime }}</span>
                            </div>
                            <p class="text-xs text-slate-700 dark:text-slate-300 leading-relaxed">{{ $tVal }}</p>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-slate-600 dark:text-slate-300 text-sm leading-relaxed p-4 rounded-xl bg-[#faf8f5] dark:bg-[#151719] border border-[#e8dfd1] dark:border-[#2b3239]">
                    {!! nl2br(e($desc)) !!}
                </p>
            @endif
        </div>
    </div>
@endforeach
</div>
</div>
<!-- ===== TAB CONTENT: ĐÁNH GIÁ ===== -->
                        <div id="content-review" class="hidden space-y-6">

                            {{-- ================= TỔNG QUAN ================= --}}
                            <div class="flex flex-col md:flex-row items-center gap-6 bg-slate-50 p-6 rounded-2xl travel-card border border-slate-100">
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
                                        class="flex items-center gap-2 text-orange-600 font-semibold hover:underline">

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
                        class="bg-white dark:bg-slate-900 rounded-2xl travel-card shadow-[0_15px_40px_rgba(0,0,0,0.06)] border border-slate-200/80 dark:border-slate-800
                        p-5 lg:p-6 sticky top-24 space-y-4">

                        <!-- ===== HEADER: TITLE & PRICE ===== -->
                        <div class="border-b border-slate-100 dark:border-slate-800 pb-3">
                            <div class="flex items-center justify-between mb-1.5">
                                <h2 class="text-xl font-bold text-slate-800 dark:text-white leading-tight brand-font">
                                    Đặt chỗ ngay
                                </h2>
                                <span class="text-[11px] font-semibold text-emerald-700 bg-emerald-50 dark:bg-emerald-950/60 dark:text-emerald-400 border border-emerald-200/60 px-2 py-0.5 rounded-full flex items-center gap-1">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span> Đang mở bán
                                </span>
                            </div>
                            <div class="flex items-baseline justify-between">
                                <div>
                                    <div class="flex items-baseline gap-1">
                                        <span id="topDisplayTourPrice" class="text-3xl font-extrabold text-rose-600 tracking-tight">
                                            {{ number_format($tour->sale_price ?: $tour->price) }}<span class="text-lg font-medium text-slate-500">đ</span>
                                        </span>
                                        <span class="text-xs text-slate-400">/ khách</span>
                                    </div>
                                    <p id="topPricePackageNote" class="text-[11px] text-slate-500 dark:text-slate-400 mt-0.5">Gói xe du lịch tiêu chuẩn</p>
                                </div>
                                @if($tour->price > $tour->sale_price && $tour->sale_price > 0)
                                    <span class="text-xs px-2 py-1 rounded-lg bg-rose-50 text-rose-600 font-bold border border-rose-100">
                                        -{{ round((($tour->price - $tour->sale_price) / $tour->price) * 100) }}%
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- ===== QUICK INFO COMPACT ROW ===== -->
                        <div class="flex items-center justify-between gap-2 p-2.5 rounded-xl bg-orange-50/60 dark:bg-slate-800/60 border border-orange-100/70 dark:border-slate-700 text-xs">
                            <div class="flex items-center gap-3 text-slate-700 dark:text-slate-300 min-w-0">
                                <div class="flex items-center gap-1.5 truncate">
                                    <i class="fa-regular fa-calendar text-[#863c20]"></i>
                                    <span class="font-semibold">{{ \Carbon\Carbon::parse($tour->start_date)->format('d/m/Y') }}</span>
                                </div>
                                <span class="text-orange-300">•</span>
                                <div class="flex items-center gap-1.5 truncate">
                                    <i class="fa-regular fa-clock text-[#863c20]"></i>
                                    <span class="font-semibold">{{ $tour->time }}</span>
                                </div>
                            </div>
                            <button type="button" onclick="openItineraryModal({{ $tour->id }})"
                                class="shrink-0 text-[11px] font-bold text-orange-600 hover:text-orange-700 bg-white hover:bg-orange-50 dark:bg-slate-700 dark:text-orange-400 px-2.5 py-1 rounded-lg border border-orange-200/80 dark:border-slate-600 transition shadow-2xs flex items-center gap-1">
                                <i class="fa-solid fa-map-location-dot"></i>
                                <span>Bản đồ</span>
                            </button>
                        </div>

                        <!-- ===== FORM ===== -->
<form action="{{ route('user.cart.add', $tour->id) }}" method="POST" class="space-y-3.5 text-slate-800 dark:text-slate-100">
    @csrf
    <!-- 1. LỊCH KHỞI HÀNH CỐ ĐỊNH -->
    <div class="space-y-1.5">
        <div class="flex items-center justify-between text-xs">
            <label class="font-bold text-slate-800 dark:text-slate-100 flex items-center gap-1.5">
                <i class="fa-regular fa-calendar-check text-[#863c20]"></i> Lịch khởi hành
            </label>
            <span class="text-[10px] text-emerald-600 font-semibold bg-emerald-50 dark:bg-emerald-950/60 px-2 py-0.5 rounded">Lịch định kỳ</span>
        </div>
        <div class="relative">
            <select name="departure_date" class="w-full text-xs font-semibold px-3 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-800 dark:text-white focus:outline-none focus:border-[#b85e3a] cursor-pointer appearance-none pr-8">
                @if(!empty($upcomingDates))
                    @foreach($upcomingDates as $idx => $dep)
                        <option value="{{ $dep['date'] }}" {{ $idx === 0 ? 'selected' : '' }}>
                            {{ $dep['label'] }} — {{ $dep['note'] }}
                        </option>
                    @endforeach
                @else
                    <option value="{{ $tour->start_date }}">Khởi hành: {{ \Carbon\Carbon::parse($tour->start_date)->format('d/m/Y') }} (Lịch định kỳ)</option>
                @endif
            </select>
            <i class="fa-solid fa-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-xs text-slate-400 pointer-events-none"></i>
        </div>
    </div>
    <!-- 2. PHƯƠNG TIỆN DI CHUYỂN -->
    <div class="space-y-1.5">
        <label class="block text-xs font-bold text-slate-800 dark:text-slate-100">
            <i class="fa-solid fa-van-shuttle text-[#863c20] mr-1"></i> Phương tiện di chuyển
        </label>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-xs">
            @foreach ($transportValues as $value)
                @php
                    $isFlight = Str::contains(mb_strtolower($value), ['máy bay', 'bay', 'flight']);
                    $transSurcharge = $isFlight ? 1800000 : 0;
                @endphp
                <label class="flex items-center gap-2 p-2.5 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 hover:border-[#b85e3a] cursor-pointer transition-all group has-[:checked]:border-[#b85e3a] has-[:checked]:bg-[#faf5f0] dark:has-[:checked]:bg-[#2a231f]">
                    <input type="radio" name="transport" value="{{ $value }}" data-surcharge="{{ $transSurcharge }}" {{ $loop->first ? 'checked' : '' }} class="text-[#863c20] transport-radio accent-[#863c20]">
                    <div class="min-w-0 flex-1">
                        <span class="font-bold text-[11px] text-slate-800 dark:text-white block truncate" title="{{ $value }}">{{ $value }}</span>
                        <span class="text-[10px] block mt-0.5 {{ $isFlight ? 'text-blue-600 font-bold' : 'text-emerald-600 font-semibold' }}">
                            {{ $isFlight ? '+1.800k (Khứ hồi)' : 'Đã bao gồm' }}
                        </span>
                    </div>
                </label>
            @endforeach
        </div>
    </div>

    <!-- 3. TIÊU CHUẨN LƯU TRÚ -->
    <div class="space-y-1.5">
        <label class="block text-xs font-bold text-slate-800 dark:text-slate-100">
            <i class="fa-solid fa-hotel text-[#863c20] mr-1"></i> Tiêu chuẩn lưu trú
        </label>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-xs">
            @foreach ($tourTypeValues as $value)
                @php
                    $isLuxury = Str::contains(mb_strtolower($value), ['4', '5', 'cao cấp', 'luxury']);
                    $hotelSurcharge = $isLuxury ? 800000 : 0;
                @endphp
                <label class="flex items-center gap-2 p-2.5 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 hover:border-[#b85e3a] cursor-pointer transition-all group has-[:checked]:border-[#b85e3a] has-[:checked]:bg-[#faf5f0] dark:has-[:checked]:bg-[#2a231f]">
                    <input type="radio" name="tour_type" value="{{ $value }}" data-surcharge="{{ $hotelSurcharge }}" {{ $loop->first ? 'checked' : '' }} class="text-[#863c20] hotel-radio accent-[#863c20]">
                    <div class="min-w-0 flex-1">
                        <span class="font-bold text-[11px] text-slate-800 dark:text-white block truncate" title="{{ $value }}">{{ $value }}</span>
                        <span class="text-[10px] block mt-0.5 {{ $isLuxury ? 'text-amber-700 dark:text-amber-400 font-bold' : 'text-slate-500 font-semibold' }}">
                            {{ $isLuxury ? '+800k (Hạng 5★)' : 'Đã bao gồm' }}
                        </span>
                    </div>
                </label>
            @endforeach
        </div>
    </div>
    <!-- 4. SỐ LƯỢNG HÀNH KHÁCH -->
    <div class="space-y-1.5">
        <div class="flex justify-between items-center text-xs">
            <label class="font-bold text-slate-800 dark:text-slate-100">
                <i class="fa-solid fa-user-group text-[#863c20] mr-1"></i> Số lượng khách
            </label>
            <span id="seat-status-label" class="text-[10px] font-semibold text-rose-600 bg-rose-50 border border-rose-200/80 px-2 py-0.5 rounded-full">
                Còn trống: {{ max($slots - 1, 0) }}
            </span>
        </div>
        <div class="flex items-center gap-2">
            <button type="button" onclick="stepQuantity(-1)" class="w-10 h-9 rounded-xl bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 font-bold transition flex items-center justify-center text-sm disabled:opacity-40">
                <i class="fa-solid fa-minus"></i>
            </button>
            <input type="number" id="tour-quantity-input" name="quantity" value="1" min="1" max="{{ $slots }}" class="flex-1 text-center font-bold text-sm py-2 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-white focus:outline-none focus:border-[#b85e3a] transition">
            <button type="button" onclick="stepQuantity(1)" class="w-10 h-9 rounded-xl bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 font-bold transition flex items-center justify-center text-sm disabled:opacity-40">
                <i class="fa-solid fa-plus"></i>
            </button>
        </div>
        @if ($slots == 0)
            <p class="text-rose-500 text-xs mt-1 font-semibold flex items-center gap-1.5 bg-rose-50 border border-rose-100 px-2.5 py-1.5 rounded-lg">
                <i class="fa-solid fa-triangle-exclamation"></i> Tour hiện đã kín chỗ
            </p>
        @endif
        <p id="quantity-error-msg" class="text-rose-500 text-xs mt-1 font-semibold flex items-center gap-1.5 hidden bg-rose-50 border border-rose-100 px-2.5 py-1.5 rounded-lg">
            <i class="fa-solid fa-triangle-exclamation"></i> Vượt quá số chỗ còn trống
        </p>
    </div>

    <!-- 5. TỔNG THANH TOÁN COMPACT -->
    <div class="p-3 rounded-xl bg-[#faf8f5] dark:bg-[#151719] border border-[#e8dfd1] dark:border-[#38424d] text-xs space-y-1.5">
        <div class="flex items-center justify-between text-slate-500 dark:text-slate-400 text-[11px]">
            <span>Phụ thu di chuyển: <strong id="displayTransSurcharge" class="text-[#863c20] dark:text-[#e08969] font-bold">+0đ</strong></span>
            <span>Lưu trú: <strong id="displayHotelSurcharge" class="text-[#863c20] dark:text-[#e08969] font-bold">+0đ</strong></span>
        </div>
        <div class="pt-2 border-t border-slate-200/80 dark:border-slate-700 flex justify-between items-end">
            <div>
                <span class="text-xs text-slate-600 dark:text-slate-300 font-bold block">Tổng thanh toán:</span>
                <span class="text-[10px] text-slate-400">(<span id="displayQtyCount">1</span> khách x <span id="displayPerPersonPrice">{{ number_format($tour->sale_price ?: $tour->price) }}đ</span>)</span>
            </div>
            <span id="displayDynamicPrice" class="text-2xl font-black text-[#b85e3a] leading-none">{{ number_format($tour->sale_price ?: $tour->price) }}đ</span>
        </div>
    </div>
    <input type="hidden" name="unit_price" id="unitPriceInput" value="{{ $tour->sale_price ?: $tour->price }}">

    <!-- CTA -->
    <button type="submit" id="book-tour-btn" {{ $slots == 0 ? 'disabled' : '' }}
        class="w-full py-3 rounded-xl bg-[#b85e3a] hover:bg-[#a34c2a] text-white font-bold text-sm shadow-md hover:shadow-lg transition-all active:scale-[0.99] disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2">
        <i class="fa-solid fa-bookmark"></i>
        <span>Giữ Chỗ Ngay</span>
    </button>

    <script>
        function stepQuantity(delta) {
            const qtyInput = document.getElementById('tour-quantity-input');
            if (!qtyInput) return;
            const current = parseInt(qtyInput.value) || 1;
            const max = parseInt(qtyInput.getAttribute('max')) || 999;
            const nextVal = Math.min(Math.max(1, current + delta), max);
            qtyInput.value = nextVal;
            qtyInput.dispatchEvent(new Event('input'));
        }

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
                        seatLabel.classList.replace('bg-rose-50', 'bg-rose-500');
                        errMsg.classList.remove('hidden');
                        bookBtn.disabled = true;
                    } else {
                        seatLabel.innerHTML = 'Còn trống: ' + remaining;
                        seatLabel.classList.replace('text-white', 'text-rose-600');
                        seatLabel.classList.replace('bg-rose-500', 'bg-rose-50');
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
                        class="bg-white rounded-2xl travel-card shadow-sm border border-slate-100 hover:shadow-xl overflow-hidden
                hover:-translate-y-1.5 transition-colors duration-200 flex flex-col h-full group cursor-pointer"
                        onclick="window.location.href='{{ route('user.tourDetail.index', $item->id) }}'">

                        <!-- Ảnh -->
                        <a href="{{ route('user.tourDetail.index', $item->id) }}" class="relative h-56 overflow-hidden block">
                            <img src="{{ Str::startsWith($item->image, ['http://', 'https://']) ? $item->image : asset($item->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            <div class="absolute bottom-3 left-3 bg-white/90 backdrop-blur-md px-3 py-1 rounded-full text-xs font-semibold text-orange-600 shadow-sm flex items-center gap-1.5">
                                <i class="fa-solid fa-map-pin"></i> {{ $item->end_location }}
                            </div>
                        </a>

                        <!-- Nội dung -->
                        <div class="p-6 flex flex-col flex-grow justify-between">
                            <div>
                                <a href="{{ route('user.tourDetail.index', $item->id) }}" class="block">
                                    <h3 class="text-xl font-bold text-slate-800 mb-3 line-clamp-2 min-h-[56px] brand-font group-hover:text-[#b85e3a] transition-colors">
                                        {{ $item->name }}
                                    </h3>
                                </a>

                                <div class="w-10 h-0.5 bg-slate-100 mb-4 rounded-full"></div>

                                <div class="flex items-end justify-between mt-2">
                                    <div>
                                        <p class="text-[11px] font-medium text-slate-400 font-medium mb-1">Chỉ từ</p>
                                        <p class="text-2xl font-bold text-rose-500">
                                            {{ number_format($item->sale_price, 0, '.', '.') }}<span class="text-sm ml-0.5 text-slate-500 font-normal">đ</span>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-6">
                                <a href="{{ route('user.tourDetail.index', $item->id) }}"
                                    class="w-full py-3.5 rounded-xl bg-orange-50 text-orange-700 hover:bg-orange-500 hover:text-white font-bold text-sm transition-colors flex items-center justify-center gap-2 border border-orange-100 group shadow-sm"
                                    onclick="event.stopPropagation()">
                                    <span>Xem chi tiết chuyến đi</span>
                                    <i class="fa-solid fa-arrow-right text-xs group-hover:translate-x-1.5 transition-transform"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </section>

        <div id="itineraryModal1" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/60 p-3 sm:p-6">
            <!-- MODAL WRAPPER -->
            <div id="modalContent"
                class="bg-white w-full max-w-6xl rounded-3xl shadow-2xl
                max-h-[88vh] flex flex-col
                transform scale-95 opacity-0 transition-colors duration-200 overflow-hidden">

                <!-- HEADER -->
                <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100 shrink-0 bg-slate-50/50">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-2xl bg-orange-50 text-orange-600 flex items-center justify-center border border-orange-100 shadow-sm">
                            <i class="fa-solid fa-map-location-dot text-lg"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-slate-800 brand-font">Lịch trình & Bản đồ chi tiết</h3>
                            <p class="text-xs text-slate-500" id="modalTourName">{{ $tour->name }}</p>
                        </div>
                    </div>

                    <button onclick="closeItineraryModal()"
                        class="w-10 h-10 flex items-center justify-center rounded-2xl text-slate-400 hover:text-rose-500 hover:bg-rose-50 transition">
                        <i class="fa-solid fa-xmark text-lg"></i>
                    </button>
                </div>

                <!-- CONTENT (2 COLUMNS) -->
                <div class="flex-1 grid grid-cols-1 lg:grid-cols-12 gap-0 overflow-hidden">
                    <!-- LEFT: ITINERARY STOPS (5 cols) -->
                    <div class="lg:col-span-5 p-4 sm:p-6 overflow-y-auto max-h-[40vh] lg:max-h-[calc(88vh-140px)] border-b lg:border-b-0 lg:border-r border-slate-100 custom-scrollbar space-y-3" id="modalTimelineList">
                        <div class="flex items-center justify-center py-12 text-slate-400">
                            <i class="fa-solid fa-spinner fa-spin text-2xl mr-2"></i> Đang tải dữ liệu lịch trình...
                        </div>
                    </div>

                    <!-- RIGHT: INTERACTIVE MAP (7 cols) -->
                    <div class="lg:col-span-7 relative h-[42vh] lg:h-auto min-h-[320px] bg-slate-100 flex flex-col">
                        <div id="interactiveMap" class="w-full h-full min-h-[320px] z-0"></div>

                        <!-- NAVIGATION BUTTON -->
                        <div class="absolute bottom-4 left-1/2 -translate-x-1/2 z-[1000] w-max">
                            <a id="directionsButton" target="_blank" href="#"
                                class="inline-flex items-center gap-2 px-5 py-2.5 bg-slate-900/90 hover:bg-slate-900 text-white font-bold text-xs sm:text-sm rounded-full shadow-xl backdrop-blur-md border border-white/20 transition-colors hover:scale-105 active:scale-95">
                                <i class="fa-solid fa-route text-orange-400"></i>
                                <span>Mở chỉ đường trên Google Maps</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- FOOTER -->
                <div class="px-6 py-3 border-t border-slate-100 text-right shrink-0 bg-slate-50/50 flex items-center justify-between">
                    <span class="text-xs text-slate-400 hidden sm:inline">Bấm vào từng chặng để xem chi tiết trên bản đồ</span>
                    <button onclick="closeItineraryModal()"
                        class="px-6 py-2 rounded-xl font-bold text-xs bg-slate-200 hover:bg-slate-300 text-slate-700 transition-colors">
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

                scheduleTab.classList.add('border-orange-500', 'text-orange-600');
                reviewTab.classList.remove('border-orange-500', 'text-orange-600');
                reviewTab.classList.add('text-slate-400');
            } else {
                reviewContent.classList.remove('hidden');
                scheduleContent.classList.add('hidden');

                reviewTab.classList.add('border-orange-500', 'text-orange-600');
                scheduleTab.classList.remove('border-orange-500', 'text-orange-600');
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



    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        let modal, modalContent, directionsBtn, leafletMap = null, markersGroup = null, polylineRoute = null;

        document.addEventListener('DOMContentLoaded', () => {
            modal = document.getElementById('itineraryModal1');
            modalContent = document.getElementById('modalContent');
            directionsBtn = document.getElementById('directionsButton');
        });

        function openItineraryModal(tourId) {
            showModal();
            const listEl = document.getElementById('modalTimelineList');
            if (listEl) {
                listEl.innerHTML = '<div class="flex items-center justify-center py-12 text-slate-400"><i class="fa-solid fa-spinner fa-spin text-xl mr-2 text-orange-500"></i> Đang tải dữ liệu...</div>';
            }

            fetch(`/tour/schedule/${tourId}/json`)
                .then(res => res.json())
                .then(data => {
                    renderTimelineStops(data.schedules);
                    initLeafletMap(data.schedules, data.center);
                })
                .catch(err => {
                    if (listEl) listEl.innerHTML = '<div class="text-center py-8 text-rose-500 font-semibold text-xs">Không thể tải dữ liệu lịch trình. Vui lòng thử lại!</div>';
                });
        }

        function renderTimelineStops(schedules) {
            const listEl = document.getElementById('modalTimelineList');
            if (!listEl) return;
            if (!schedules || schedules.length === 0) {
                listEl.innerHTML = '<div class="text-center py-8 text-slate-400 text-xs">Chưa có danh sách chặng cụ thể.</div>';
                return;
            }

            let html = '';
            schedules.forEach((item, index) => {
                const isActive = index === 0;
                html += `
                    <div onclick="focusScheduleDay(${item.day_number}, ${item.latitude}, ${item.longitude})"
                        id="timeline-item-${item.day_number}"
                        class="p-3.5 rounded-2xl border transition-colors cursor-pointer ${isActive ? 'bg-orange-50/70 border-orange-300 shadow-sm' : 'bg-white border-slate-200 hover:border-orange-200 hover:bg-slate-50'}">
                        <div class="flex items-start gap-2.5">
                            <span class="w-7 h-7 rounded-xl ${isActive ? 'bg-orange-600 text-white' : 'bg-slate-100 text-slate-700'} flex items-center justify-center font-bold text-xs shrink-0 shadow-sm">
                                N${item.day_number}
                            </span>
                            <div class="flex-1 min-w-0">
                                <h4 class="text-xs sm:text-sm font-bold text-slate-800 line-clamp-1">${item.title}</h4>
                                <p class="text-[11px] text-slate-500 mt-1 line-clamp-2">${item.description || 'Tham quan và khám phá điểm đến theo hành trình.'}</p>
                                ${item.location_name ? `
                                    <div class="mt-1.5 inline-flex items-center gap-1 text-[10px] font-semibold text-orange-700 bg-orange-100/60 px-2 py-0.5 rounded-md">
                                        <i class="fa-solid fa-location-dot text-orange-600"></i> ${item.location_name}
                                    </div>
                                ` : ''}
                            </div>
                        </div>
                    </div>
                `;
            });
            listEl.innerHTML = html;
        }

        function initLeafletMap(schedules, defaultCenter) {
            const mapContainer = document.getElementById('interactiveMap');
            if (!mapContainer) return;

            const center = defaultCenter || [16.0544, 108.2022];

            if (!leafletMap) {
                leafletMap = L.map('interactiveMap').setView(center, 12);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '&copy; OpenStreetMap'
                }).addTo(leafletMap);
                markersGroup = L.featureGroup().addTo(leafletMap);
            } else {
                markersGroup.clearLayers();
                if (polylineRoute) {
                    leafletMap.removeLayer(polylineRoute);
                    polylineRoute = null;
                }
            }

            const validPoints = (schedules || []).filter(s => s.latitude && s.longitude);
            const latlngs = [];

            if (validPoints.length > 0) {
                validPoints.forEach(pt => {
                    const latlng = [parseFloat(pt.latitude), parseFloat(pt.longitude)];
                    latlngs.push(latlng);

                    const customIcon = L.divIcon({
                        className: 'custom-map-pin',
                        html: `<div style="background:#059669;color:#fff;font-size:11px;font-weight:800;width:26px;height:26px;border-radius:50%;display:flex;align-items:center;justify-content:center;box-shadow:0 2px 6px rgba(0,0,0,0.35);border:2px solid #fff;">${pt.day_number}</div>`,
                        iconSize: [26, 26],
                        iconAnchor: [13, 13]
                    });

                    const marker = L.marker(latlng, { icon: customIcon }).addTo(markersGroup);
                    marker.bindPopup(`
                        <div style="font-family: inherit; min-width: 170px;">
                            <div style="font-weight: 800; font-size: 12px; color: #1e293b;">Ngày ${pt.day_number}: ${pt.title}</div>
                            <div style="font-size: 11px; color: #059669; font-weight: 600; margin-top: 3px;"><i class="fa-solid fa-location-dot"></i> ${pt.location_name || ''}</div>
                        </div>
                    `);
                });

                if (latlngs.length > 1) {
                    polylineRoute = L.polyline(latlngs, {
                        color: '#059669',
                        weight: 4,
                        opacity: 0.85,
                        dashArray: '6, 8'
                    }).addTo(leafletMap);
                }

                try {
                    leafletMap.fitBounds(markersGroup.getBounds().pad(0.2));
                } catch(e) {
                    leafletMap.setView(latlngs[0], 12);
                }

                const origin = validPoints[0];
                const destination = validPoints[validPoints.length - 1];
                const waypoints = validPoints.slice(1, -1);
                let dirUrl = `https://www.google.com/maps/dir/?api=1&origin=${origin.latitude},${origin.longitude}&destination=${destination.latitude},${destination.longitude}`;
                if (waypoints.length > 0) {
                    dirUrl += `&waypoints=${waypoints.map(w => `${w.latitude},${w.longitude}`).join('%7C')}`;
                }
                directionsBtn.href = dirUrl;
            } else {
                leafletMap.setView(center, 12);
                directionsBtn.href = `https://www.google.com/maps/search/?api=1&query=${center[0]},${center[1]}`;
            }

            setTimeout(() => { if (leafletMap) leafletMap.invalidateSize(); }, 300);
        }

        function focusScheduleDay(dayNumber, lat, lng) {
            document.querySelectorAll('#modalTimelineList > div').forEach(el => {
                el.classList.remove('bg-orange-50/70', 'border-orange-300', 'shadow-sm');
                el.classList.add('bg-white', 'border-slate-200');
            });
            const selected = document.getElementById(`timeline-item-${dayNumber}`);
            if (selected) {
                selected.classList.remove('bg-white', 'border-slate-200');
                selected.classList.add('bg-orange-50/70', 'border-orange-300', 'shadow-sm');
            }
            if (leafletMap && lat && lng) {
                leafletMap.flyTo([lat, lng], 14, { duration: 1 });
            }
        }

        function showModal() {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            setTimeout(() => {
                modalContent.classList.remove('scale-95', 'opacity-0');
                modalContent.classList.add('scale-100', 'opacity-100');
                if (leafletMap) leafletMap.invalidateSize();
            }, 50);
        }

        function closeItineraryModal() {
            modalContent.classList.replace('scale-100', 'scale-95');
            modalContent.classList.replace('opacity-100', 'opacity-0');
            setTimeout(() => {
                modal.classList.replace('flex', 'hidden');
            }, 250);
        }
    </script>

<script>
    const baseTourPrice = {{ $tour->sale_price > 0 ? $tour->sale_price : $tour->price }};
    function updateLivePrice() {
        const transEl = document.querySelector('input.transport-radio:checked');
        const hotelEl = document.querySelector('input.hotel-radio:checked');
        const qtyInput = document.getElementById('tour-quantity-input');
        
        const transSurcharge = transEl ? (parseInt(transEl.getAttribute('data-surcharge')) || 0) : 0;
        const hotelSurcharge = hotelEl ? (parseInt(hotelEl.getAttribute('data-surcharge')) || 0) : 0;
        const qty = qtyInput ? Math.max(1, parseInt(qtyInput.value) || 1) : 1;
        
        const unitPrice = baseTourPrice + transSurcharge + hotelSurcharge;
        const totalPrice = unitPrice * qty;
        
        // Cập nhật giá lớn ở đầu cột đặt chỗ
        const topPriceEl = document.getElementById('topDisplayTourPrice');
        if (topPriceEl) {
            topPriceEl.innerHTML = unitPrice.toLocaleString('vi-VN') + '<span class="text-xl ml-1 text-slate-500 font-medium">đ</span>';
        }
        const topNoteEl = document.getElementById('topPricePackageNote');
        if (topNoteEl) {
            topNoteEl.textContent = transSurcharge > 0 ? 'Gói vé máy bay khứ hồi' : 'Gói xe du lịch tiêu chuẩn';
        }

        // Cập nhật phụ thu từng mục trong bảng tính
        const transSurEl = document.getElementById('displayTransSurcharge');
        if (transSurEl) {
            transSurEl.textContent = transSurcharge > 0 ? '+' + transSurcharge.toLocaleString('vi-VN') + 'đ' : 'Đã bao gồm (+0đ)';
        }
        const hotelSurEl = document.getElementById('displayHotelSurcharge');
        if (hotelSurEl) {
            hotelSurEl.textContent = hotelSurcharge > 0 ? '+' + hotelSurcharge.toLocaleString('vi-VN') + 'đ' : 'Đã bao gồm (+0đ)';
        }
        
        // Cập nhật giá từng khách & tổng thanh toán
        const perPersonEl = document.getElementById('displayPerPersonPrice');
        if (perPersonEl) perPersonEl.textContent = unitPrice.toLocaleString('vi-VN') + 'đ';

        const displayPrice = document.getElementById('displayDynamicPrice');
        if (displayPrice) {
            displayPrice.textContent = totalPrice.toLocaleString('vi-VN') + 'đ';
        }
        const displayQty = document.getElementById('displayQtyCount');
        if (displayQty) {
            displayQty.textContent = qty;
        }
        const unitInput = document.getElementById('unitPriceInput');
        if (unitInput) {
            unitInput.value = unitPrice;
        }
    }
    document.querySelectorAll('input.transport-radio, input.hotel-radio').forEach(r => r.addEventListener('change', updateLivePrice));
    document.getElementById('tour-quantity-input')?.addEventListener('input', updateLivePrice);
    setTimeout(updateLivePrice, 100);
</script>


<script>
    const tourVideosByDest = {
        'Phú Quốc': 'https://assets.mixkit.co/videos/preview/mixkit-aerial-view-of-waves-crashing-on-a-rocky-shore-41484-large.mp4',
        'Hà Giang': 'https://assets.mixkit.co/videos/preview/mixkit-mountain-landscape-with-thick-white-clouds-40285-large.mp4',
        'Đà Lạt': 'https://assets.mixkit.co/videos/preview/mixkit-forest-stream-in-the-sunlight-529-large.mp4',
        'Hạ Long': 'https://assets.mixkit.co/videos/preview/mixkit-boat-traveling-on-a-calm-sea-at-sunset-41457-large.mp4',
        'Sa Pa': 'https://assets.mixkit.co/videos/preview/mixkit-mountain-landscape-with-thick-white-clouds-40285-large.mp4',
        'Sapa': 'https://assets.mixkit.co/videos/preview/mixkit-mountain-landscape-with-thick-white-clouds-40285-large.mp4',
        'Đà Nẵng': 'https://assets.mixkit.co/videos/preview/mixkit-boat-traveling-on-a-calm-sea-at-sunset-41457-large.mp4',
        'Hội An': 'https://assets.mixkit.co/videos/preview/mixkit-boat-traveling-on-a-calm-sea-at-sunset-41457-large.mp4',
        'Ninh Bình': 'https://assets.mixkit.co/videos/preview/mixkit-boat-traveling-on-a-calm-sea-at-sunset-41457-large.mp4'
    };

    function openTourVideoModal() {
        const modal = document.getElementById('tourVideoModal');
        const video = document.getElementById('tourNativeVideoPlayer');
        const source = document.getElementById('tourNativeVideoSource');
        const dest = "{{ $tour->end_location ?? '' }}";
        const tourName = "{{ addslashes($tour->name ?? '') }}";
        
        let videoSrc = 'https://assets.mixkit.co/videos/preview/mixkit-boat-traveling-on-a-calm-sea-at-sunset-41457-large.mp4';
        
        for (const [key, url] of Object.entries(tourVideosByDest)) {
            if (dest.includes(key) || tourName.includes(key)) {
                videoSrc = url;
                break;
            }
        }
        
        if (source && video) {
            source.src = videoSrc;
            video.load();
            video.play().catch(() => {});
        }
        if (modal) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }
        if (typeof stopCarousel === 'function') stopCarousel();
    }

    function closeTourVideoModal() {
        const modal = document.getElementById('tourVideoModal');
        const video = document.getElementById('tourNativeVideoPlayer');
        if (video) {
            video.pause();
        }
        if (modal) {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
        if (typeof startCarousel === 'function') startCarousel();
    }
</script>

@endsection