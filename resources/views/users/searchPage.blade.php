@extends('users.master')

@section('home')
<style>
    .search-container {
        font-family: 'Roboto', sans-serif;
    }

    .text-gradient {
        background: linear-gradient(135deg, #10b981 0%, #06b6d4 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .premium-card {
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .premium-card:hover {
        transform: translateY(-8px);
    }

    .hero-gradient {
        background: radial-gradient(circle at 10% 20%, rgba(16, 185, 129, 0.12), transparent 50%),
                    radial-gradient(circle at 90% 80%, rgba(6, 182, 212, 0.10), transparent 50%);
    }
</style>

<div class="search-container min-h-screen bg-slate-50 dark:bg-[#0b1120] text-slate-800 dark:text-slate-100 transition-colors duration-300">
    {{-- HERO HEADER --}}
    <section class="relative pt-32 pb-16 overflow-hidden hero-gradient">
        <div class="max-w-7xl mx-auto px-6 relative z-10 text-center">
            <div class="inline-flex items-center gap-2 bg-emerald-50 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-300 px-4 py-2 rounded-full border border-emerald-200/80 dark:border-emerald-800/80 mb-6 font-bold text-xs uppercase tracking-wider shadow-sm">
                <i class="fa-solid fa-magnifying-glass text-emerald-500"></i>
                Kết Quả Tìm Kiếm Tour
            </div>
            <h1 class="text-4xl sm:text-5xl font-extrabold text-slate-900 dark:text-white tracking-tight mb-4">
                Tìm Thấy <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-500 to-teal-400">{{ $tours->total() }}</span> Hành Trình Phù Hợp
            </h1>
            <p class="text-slate-600 dark:text-slate-300 font-normal text-sm sm:text-base max-w-2xl mx-auto leading-relaxed">
                Khám phá các tour du lịch trọn gói chất lượng cao cùng WanderVibe với lịch trình linh hoạt và giá ưu đãi nhất.
            </p>
        </div>
    </section>

    <main class="max-w-7xl mx-auto px-6 pb-24">
        {{-- Lưới hiển thị tour --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @forelse ($tours as $tour)
                <div class="premium-card group flex flex-col h-full overflow-hidden bg-white dark:bg-slate-800/90 rounded-3xl border border-slate-100 dark:border-slate-700/80 shadow-sm hover:shadow-xl transition-all duration-300 cursor-pointer"
                     onclick="window.location.href='{{ route('user.tourDetail.index', $tour->id) }}'">
                    {{-- Tour Image Area --}}
                    <a href="{{ route('user.tourDetail.index', $tour->id) }}" class="relative h-52 overflow-hidden block">
                        <img src="{{ Str::startsWith($tour->image, ['http://', 'https://']) ? $tour->image : asset($tour->image) }}" alt="{{ $tour->name }}"
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">

                        <div class="absolute top-4 left-4 flex flex-col gap-2">
                            <span class="glass-badge px-3 py-1.5 rounded-full text-[10px] font-bold text-emerald-700 bg-white/90 backdrop-blur-md border border-white/40 shadow-sm">
                                <i class="far fa-clock mr-1 text-emerald-600"></i> {{ $tour->time }}
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
                                 <h2 class="text-base font-extrabold text-slate-900 dark:text-white group-hover:text-emerald-500 transition-colors line-clamp-2 leading-snug">
                                     {{ $tour->name }}
                                 </h2>
                             </a>
                        </div>

                        <div class="mt-auto pt-3 border-t border-slate-100 dark:border-slate-700/80">
                            <div class="flex items-baseline justify-between mb-3">
                                <div>
                                    <p class="text-[11px] font-medium text-slate-500 dark:text-slate-400">Giá trọn gói từ</p>
                                    <p class="text-xl font-extrabold text-rose-600 dark:text-rose-500">
                                        {{ number_format($tour->sale_price ?? $tour->price) }}<span class="text-sm font-semibold ml-0.5">đ</span>
                                    </p>
                                </div>
                                @if($tour->price > $tour->sale_price)
                                    <p class="text-xs text-slate-400 dark:text-slate-500 line-through">
                                        {{ number_format($tour->price) }}đ
                                    </p>
                                @endif
                            </div>

                            <a href="{{ route('user.tourDetail.index', $tour->id) }}"
                               class="w-full block text-center py-3 rounded-xl bg-gradient-to-r from-orange-500 via-amber-500 to-orange-600 hover:from-orange-600 hover:to-amber-600 text-white font-extrabold text-sm shadow-md shadow-orange-500/20 hover:scale-[1.02] active:scale-[0.98] transition-all duration-300"
                               onclick="event.stopPropagation()">
                                Xem Chi Tiết & Đặt Tour
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-28 text-center bg-white dark:bg-slate-800/80 rounded-3xl border border-dashed border-slate-200 dark:border-slate-700">
                    <div class="w-20 h-20 bg-emerald-50 dark:bg-emerald-950/60 rounded-full flex items-center justify-center mx-auto mb-4 text-emerald-500 text-3xl">
                        <i class="fas fa-search"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2">Không Tìm Thấy Tour Nào</h3>
                    <p class="text-slate-500 dark:text-slate-400 font-medium mb-6">Rất tiếc, chúng tôi chưa tìm thấy hành trình phù hợp với từ khóa của bạn. Hãy thử tìm địa danh khác nhé!</p>
                    <a href="{{ route('user.home') }}" class="inline-flex items-center gap-2 px-6 py-2.5 rounded-full bg-emerald-600 text-white font-bold text-sm shadow-md shadow-emerald-500/20 hover:bg-emerald-700 transition-colors">
                        Trở Về Trang Chủ
                    </a>
                </div>
            @endforelse
        </div>

        {{-- Phân trang --}}
        <div class="mt-20 flex justify-center">
            @if($tours instanceof \Illuminate\Pagination\LengthAwarePaginator)
                <div class="bg-white dark:bg-slate-800 p-2 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700">
                    {{ $tours->links('vendor.pagination.tailwind') }}
                </div>
            @endif
        </div>
    </main>
</div>
@endsection
