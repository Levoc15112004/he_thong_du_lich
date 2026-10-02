@extends('users.master')

@section('home')
<style>
    .category-container {
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

    .cate-pill {
        transition: all 0.3s ease;
    }
</style>

<div class="category-container min-h-screen bg-slate-50 dark:bg-[#0b1120] text-slate-800 dark:text-slate-100 transition-colors duration-300">
    {{-- HERO HEADER --}}
    <section class="relative pt-32 pb-16 overflow-hidden hero-gradient">
        <div class="max-w-7xl mx-auto px-6 relative z-10 text-center">
            <div class="inline-flex items-center gap-2 bg-emerald-50 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-300 px-4 py-2 rounded-full border border-emerald-200/80 dark:border-emerald-800/80 mb-6 font-bold text-xs uppercase tracking-wider shadow-sm">
                <i class="fa-solid fa-compass text-emerald-500"></i>
                Khám Phá Theo Cách Riêng Của Bạn
            </div>
            <h1 class="text-4xl sm:text-5xl md:text-6xl font-extrabold text-slate-900 dark:text-white tracking-tight mb-4">
                Hành Trình <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-500 to-teal-400">{{ $currentCategory->name ?? 'Khám Phá' }}</span>
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
                   class="cate-pill px-6 py-2.5 rounded-full text-xs sm:text-sm font-bold transition-all text-slate-600 dark:text-slate-300 hover:text-emerald-600 dark:hover:text-emerald-400 hover:bg-emerald-50 dark:hover:bg-slate-700">
                   Tất cả hành trình
                </a>
                @foreach ($categories as $cate)
                    <a href="{{ route('user.category', $cate->id) }}"
                       class="cate-pill px-6 py-2.5 rounded-full text-xs sm:text-sm font-bold transition-all
                       {{ $id == $cate->id ? 'bg-gradient-to-r from-emerald-500 to-teal-600 text-white shadow-md shadow-emerald-500/25' : 'text-slate-600 dark:text-slate-300 hover:text-emerald-600 dark:hover:text-emerald-400 hover:bg-emerald-50 dark:hover:bg-slate-700' }}">
                        {{ $cate->name }}
                    </a>
                @endforeach
            </div>
        </div>

        {{-- LƯỚI HIỂN THỊ TOUR --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @forelse ($tourCate as $tour)
                <div class="premium-card group flex flex-col h-full overflow-hidden bg-white rounded-3xl border border-slate-100 shadow-sm hover:shadow-xl transition-all duration-300">
                    {{-- Tour Image Area --}}
                    <div class="relative h-52 overflow-hidden">
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
                    </div>

                    {{-- Tour Content Area --}}
                    <div class="p-5 flex flex-col flex-grow">
                        <div class="mb-3">
                             <h2 class="text-base font-extrabold text-slate-900 leading-snug group-hover:text-emerald-600 transition-colors line-clamp-2">
                                {{ $tour->name }}
                            </h2>
                        </div>

                        <div class="mt-auto pt-3 border-t border-slate-100">
                            <div class="flex items-baseline justify-between mb-3">
                                <div>
                                    <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Giá hành trình</p>
                                    <p class="text-xl font-extrabold text-rose-600">
                                        {{ number_format($tour->sale_price ?? $tour->price) }}<span class="text-sm font-semibold ml-0.5">đ</span>
                                    </p>
                                </div>
                                @if($tour->price > $tour->sale_price)
                                    <p class="text-xs text-slate-400 line-through">
                                        {{ number_format($tour->price) }}đ
                                    </p>
                                @endif
                            </div>

                            <a href="{{ route('user.tourDetail.index', $tour->id) }}"
                               class="w-full block text-center py-3 rounded-xl bg-gradient-to-r from-orange-500 via-amber-500 to-orange-600 hover:from-orange-600 hover:to-amber-600 text-white font-extrabold text-sm shadow-md shadow-orange-500/20 hover:scale-[1.02] active:scale-[0.98] transition-all duration-300">
                                Chi tiết & đặt Tour
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-24 text-center bg-white rounded-3xl border border-dashed border-slate-200">
                    <div class="w-20 h-20 bg-emerald-50 rounded-full flex items-center justify-center mx-auto mb-4 text-emerald-500 text-3xl">
                        <i class="fas fa-compass"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-2">Chưa có tour trong danh mục này</h3>
                    <p class="text-slate-500 font-medium mb-6">WanderVibe đang chuẩn bị những hành trình mới, hãy khám phá các điểm đến khác nhé!</p>
                    <a href="{{ route('user.tours') }}" class="inline-flex items-center gap-2 px-6 py-2.5 rounded-full bg-emerald-600 text-white font-bold text-sm shadow-md shadow-emerald-500/20 hover:bg-emerald-700 transition-colors">
                        Khám phá tất cả tour
                    </a>
                </div>
            @endforelse
        </div>

        {{-- CUSTOM PAGINATION --}}
        <div class="mt-20 flex justify-center">
            @if($tourCate instanceof \Illuminate\Pagination\LengthAwarePaginator)
                <div class="bg-white p-3 rounded-[2.5rem] shadow-sm border border-slate-100">
                    {{ $tourCate->links('vendor.pagination.tailwind') }}
                </div>
            @endif
        </div>
    </main>

    {{-- Banner Decoration --}}
    <section class="max-w-7xl mx-auto px-6 mb-24">
        <div class="premium-card bg-slate-950 p-16 relative overflow-hidden flex flex-col md:flex-row items-center justify-between gap-10">
            <div class="absolute top-0 right-0 w-80 h-80 bg-blue-600/10 blur-[120px] rounded-full"></div>
            <div class="absolute bottom-0 left-0 w-40 h-40 bg-violet-600/5 blur-[80px] rounded-full"></div>

            <div class="relative z-10 max-w-xl">
                <h3 class="text-2xl font-bold text-black mb-4 ">Bạn muốn một hành trình <span class="text-blue-500">riêng biệt?</span></h3>
                <p class="text-slate-400 text-lg font-medium leading-relaxed">Hãy để các chuyên gia của chúng tôi thiết kế tour cá nhân hóa dựa trên sở thích và ngân sách của bạn.</p>
            </div>
            <a href="#" class="relative z-10 bg-white text-slate-900 px-12 py-5 rounded-[2rem] font-bold text-sm   hover:bg-blue-600 hover:text-white transition-all shadow-2xl">
                Tư vấn ngay
            </a>
        </div>
    </section>
</div>
@endsection
