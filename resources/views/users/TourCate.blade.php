@extends('users.master')

@section('home')


<div class="category-container min-h-screen bg-slate-50 dark:bg-[#0b1120] text-slate-800 dark:text-slate-100 transition-colors duration-300">
    {{-- HERO HEADER --}}
    <section class="relative pt-28 sm:pt-32 pb-12 border-b border-[#e8e3d8] dark:border-[#2b3239] bg-[#faf8f5] dark:bg-[#151719]">
        <div class="max-w-7xl mx-auto px-6 relative z-10 text-center">
            <div class="stamp-badge mb-4">
                <i class="fa-solid fa-compass text-orange-500"></i>
                Khám Phá Theo Cách Riêng Của Bạn
            </div>
            <h1 class="font-serif mb-3">
                Hành Trình {{ $currentCategory->name ?? 'Khám Phá' }}
            </h1>
            <p class="text-slate-600 dark:text-slate-300 font-normal text-sm sm:text-base max-w-2xl mx-auto leading-relaxed">
                Tìm kiếm điểm đến lý tưởng và trải nghiệm những khoảnh khắc đáng nhớ cùng WanderVibe.
            </p>
        </div>
    </section>

    <main class="max-w-7xl mx-auto px-6 pb-24">

        {{-- DANH SÁCH CATEGORY TABS --}}
        <div class="mb-12 flex justify-center">
            <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-md p-1.5 rounded-full border border-slate-200/80 dark:border-slate-700 shadow-sm inline-flex flex-wrap justify-center gap-2">
                <a href="{{ route('user.tours') }}"
                   class="cate-pill px-6 py-2.5 rounded-full text-xs sm:text-sm font-bold transition-colors text-slate-600 dark:text-slate-300 hover:text-orange-600 dark:hover:text-orange-400 hover:bg-orange-50 dark:hover:bg-slate-700">
                   Tất cả hành trình
                </a>
                @foreach ($categories as $cate)
                    <a href="{{ route('user.category', $cate->id) }}"
                       class="cate-pill px-6 py-2.5 rounded-full text-xs sm:text-sm font-bold transition-colors
                       {{ $id == $cate->id ? 'bg-[#b85e3a] text-white shadow-xs' : 'text-slate-600 dark:text-slate-300 hover:text-orange-600 dark:hover:text-orange-400 hover:bg-orange-50 dark:hover:bg-slate-700' }}">
                        {{ $cate->name }}
                    </a>
                @endforeach
            </div>
        </div>

        {{-- LƯỚI HIỂN THỊ TOUR --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @forelse ($tourCate as $tour)
                <div class="travel-card group flex flex-col h-full overflow-hidden bg-white travel-card rounded-2xl transition-colors duration-200 cursor-pointer"
                     onclick="window.location.href='{{ route('user.tourDetail.index', $tour->id) }}'">
                    {{-- Tour Image Area --}}
                    <a href="{{ route('user.tourDetail.index', $tour->id) }}" class="relative h-52 overflow-hidden block">
                        <img src="{{ Str::startsWith($tour->image, ['http://', 'https://']) ? $tour->image : asset($tour->image) }}" alt="{{ $tour->name }}"
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">

                        <div class="absolute top-4 left-4 flex flex-col gap-2">
                            <span class="glass-badge px-3 py-1.5 rounded-full text-[10px] font-bold text-orange-700 bg-white/90 backdrop-blur-md border border-white/40 shadow-sm">
                                <i class="far fa-clock mr-1 text-orange-600"></i> {{ $tour->time }}
                            </span>
                        </div>

                        <div class="absolute bottom-4 left-4 right-4">
                             <div class="bg-slate-900/60 backdrop-blur-md px-3.5 py-1.5 rounded-xl border border-white/20 inline-flex items-center gap-1.5 text-xs text-white">
                                <i class="fas fa-map-marker-alt text-amber-400 text-xs"></i>
                                <span class="font-medium truncate">
                                    {{ $tour->start_location ?? 'Hà Nội' }} <i class="fas fa-arrow-right mx-1 opacity-70 text-[10px]"></i> {{ $tour->end_location }}
                                </span>
                             </div>
                        </div>
                    </a>

                    {{-- Tour Content Area --}}
                    <div class="p-5 flex flex-col flex-grow">
                        <div class="mb-3">
                            <a href="{{ route('user.tourDetail.index', $tour->id) }}" class="block">
                                <h2 class="font-serif text-base font-bold text-slate-900 dark:text-white group-hover:text-[#b85e3a] transition-colors line-clamp-2 leading-snug">
                                    {{ $tour->name }}
                                </h2>
                            </a>
                        </div>

                        <div class="mt-auto pt-3 border-t border-slate-100">
                            <div class="flex items-baseline justify-between mb-3">
                                <div>
                                    <p class="text-[11px] font-semibold text-slate-400 font-medium">Giá hành trình</p>
                                    <p class="text-xl font-extrabold text-[#b85e3a] font-serif">
                                        {{ number_format($tour->sale_price ?? $tour->price) }}<span class="text-sm font-semibold ml-0.5">đ</span>
                                    </p>
<span class="text-[10px] text-slate-400 block -mt-0.5">Giá từ • Gói xe du lịch</span>
                                </div>
                                @if($tour->price > $tour->sale_price)
                                    <p class="text-xs text-slate-400 line-through">
                                        {{ number_format($tour->price) }}đ
                                    </p>
                                @endif
                            </div>

                            <a href="{{ route('user.tourDetail.index', $tour->id) }}"
                               class="w-full block text-center py-2.5 rounded-xl bg-[#b85e3a] hover:bg-[#a34c2a] text-white font-bold text-xs font-medium shadow-xs transition-colors"
                               onclick="event.stopPropagation()">
                                Chi tiết & đặt Tour
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-24 text-center bg-white rounded-3xl border border-dashed border-slate-200">
                    <div class="w-20 h-20 bg-orange-50 rounded-full flex items-center justify-center mx-auto mb-4 text-orange-500 text-3xl">
                        <i class="fas fa-compass"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-2">Chưa có tour trong danh mục này</h3>
                    <p class="text-slate-500 font-medium mb-6">WanderVibe đang chuẩn bị những hành trình mới, hãy khám phá các điểm đến khác nhé!</p>
                    <a href="{{ route('user.tours') }}" class="inline-flex items-center gap-2 px-6 py-2.5 rounded-full bg-[#863c20] text-white font-bold text-sm shadow-md shadow-xs hover:bg-[#a34c2a] transition-colors">
                        Khám phá tất cả tour
                    </a>
                </div>
            @endforelse
        </div>

        {{-- CUSTOM PAGINATION --}}
        <div class="mt-20 flex justify-center">
            @if($tourCate instanceof \Illuminate\Pagination\LengthAwarePaginator)
                <div class="bg-white dark:bg-slate-800 p-2 sm:p-3 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700">
                    {{ $tourCate->links('vendor.pagination.tailwind') }}
                </div>
            @endif
        </div>
    </main>

    {{-- Banner Decoration --}}
    <section class="max-w-7xl mx-auto px-6 mb-24">
        <div class="rounded-3xl p-10 sm:p-14 relative overflow-hidden flex flex-col md:flex-row items-center justify-between gap-8 bg-gradient-to-br from-slate-900 via-slate-850 to-slate-900 border border-slate-800 shadow-2xl text-white">
            <div class="absolute top-0 right-0 w-80 h-80 bg-orange-500/10 blur-[120px] rounded-full pointer-events-none"></div>
            <div class="absolute bottom-0 left-0 w-40 h-40 bg-rose-500/10 blur-[80px] rounded-full pointer-events-none"></div>

            <div class="relative z-10 max-w-xl">
                <h3 class="text-2xl sm:text-3xl font-extrabold text-white mb-3 tracking-tight">
                    Bạn Muốn Một Hành Trình <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-400 via-rose-400 to-amber-300">Riêng Biệt?</span>
                </h3>
                <p class="text-slate-300 text-sm sm:text-base font-normal leading-relaxed">
                    Hãy để đội ngũ travel planner của WanderVibe thiết kế tour cá nhân hóa dựa trên sở thích, số lượng người và ngân sách riêng của bạn.
                </p>
            </div>
            <a href="{{ route('contact') }}" class="relative z-10 whitespace-nowrap bg-[#863c20] hover:bg-[#a34c2a] text-white px-8 py-4 rounded-2xl font-extrabold text-sm sm:text-base shadow-xl shadow-xs hover:scale-105 active:scale-95 transition-colors">
                Nhận Tư Vấn Ngay <i class="fa-solid fa-arrow-right ml-2 text-xs"></i>
            </a>
        </div>
    </section>
</div>
@endsection
