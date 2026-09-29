@extends('users.master')

@section('home')
<style>
    .category-container {
        font-family: 'Roboto', sans-serif;
        background-color: #f8fafc;
    }

    .text-gradient {
        background: linear-gradient(to right, #3b82f6, #8b5cf6);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .premium-card {
        background: white;
        border-radius: 2.5rem;
        border: 1px solid rgba(241, 245, 249, 1);
        transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .premium-card:hover {
        transform: translateY(-12px);
        box-shadow: 0 30px 60px -15px rgba(59, 130, 246, 0.12);
    }

    .hero-gradient {
        background: radial-gradient(circle at top right, rgba(59, 130, 246, 0.08), transparent),
                    radial-gradient(circle at bottom left, rgba(139, 92, 246, 0.05), transparent);
    }

    .glass-badge {
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    .btn-gradient {
        background: linear-gradient(to right, #3b82f6, #2563eb);
        transition: all 0.3s ease;
    }

    .btn-gradient:hover {
        filter: brightness(1.1);
        box-shadow: 0 10px 20px -5px rgba(59, 130, 246, 0.3);
    }

    .cate-pill {
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }
</style>

<div class="category-container min-h-screen">
    {{-- HERO HEADER --}}
    <section class="relative pt-32 pb-16 overflow-hidden hero-gradient">
        <div class="max-w-7xl mx-auto px-6 relative z-10 text-center">
            <div class="inline-flex items-center gap-2 bg-blue-50 text-blue-600 px-4 py-2 rounded-full border border-blue-100 mb-6 font-bold text-sm  ">
                <i class="fas fa-compass"></i>
                Khám phá theo cách riêng của bạn
            </div>
            <h1 class="text-5xl md:text-6xl font-bold text-slate-900  mb-4">
                Hành trình <span class="text-gradient">tuyệt vời nhất</span>
            </h1>
            <p class="text-slate-500 font-medium max-w-xl mx-auto">Tìm kiếm điểm đến lý tưởng và trải nghiệm những khoảnh khắc đáng nhớ cùng TravelGo.</p>
        </div>
    </section>

    <main class="max-w-7xl mx-auto px-6 pb-24">

        {{-- DANH SÁCH CATEGORY TABS (Đã sửa theo code cũ) --}}
        <div class="mb-16 flex justify-center">
            <div class="bg-white/60 backdrop-blur-md p-2 rounded-[2.5rem] border border-slate-100 shadow-sm inline-flex flex-wrap justify-center gap-2">
                {{-- <a href="{{ route('user.home') }}"
                   class="cate-pill px-7 py-3.5 rounded-full text-xs font-bold   transition-all
                   {{ !request()->category ? 'bg-slate-900 text-white shadow-xl shadow-slate-200' : 'text-slate-500 hover:text-blue-600' }}">
                   Tất cả hành trình
                </a> --}}
                @foreach ($subCategories as $cate)
                    <a href="{{ route('user.category', $cate->id) }}"
                       class="cate-pill px-7 py-3.5 rounded-full text-xs font-bold   transition-all
                       {{ request()->category == $cate->id ? 'bg-blue-600 text-white shadow-xl shadow-blue-200' : 'text-slate-500 hover:text-blue-600' }}">
                        {{ $cate->name }}
                    </a>
                @endforeach
            </div>
        </div>

        {{-- LỌC TOUR THEO CATEGORY LOGIC --}}
        @php
            if (request()->category) {
                $tourCate = $tourCate->filter(function ($t) {
                    return $t->category_id == request()->category;
                });
            }
        @endphp

        {{-- LƯỚI HIỂN THỊ TOUR --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10">
            @forelse ($tourCate as $tour)
                <div class="premium-card group flex flex-col h-full overflow-hidden">
                    {{-- Tour Image Area --}}
                    <div class="relative h-52 overflow-hidden">
                        <img src="{{ asset($tour->image) }}" alt="{{ $tour->name }}"
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-1000">

                        <div class="absolute top-5 left-5 flex flex-col gap-2">
                            <span class="glass-badge px-3 py-1.5 rounded-full text-[10px] font-bold text-blue-600  ">
                                <i class="far fa-clock mr-1.5"></i> {{ $tour->time }}
                            </span>
                        </div>

                        <div class="absolute bottom-5 left-5 right-5">
                             <div class="bg-slate-900/40 backdrop-blur-md px-4 py-2 rounded-2xl border border-white/20 inline-flex items-center gap-2">
                                <i class="fas fa-map-marker-alt text-blue-400 text-sm"></i>
                                <span class="text-[10px] font-medium text-white   truncate">
                                    {{ $tour->start_location }} <i class="fas fa-arrow-right mx-1 opacity-50"></i> {{ $tour->end_location }}
                                </span>
                             </div>
                        </div>
                    </div>

                    {{-- Tour Content Area --}}
                    <div class="p-4 flex flex-col flex-grow">
                        <div class="flex justify-between items-start mb-2">
                             <h2 class="text-lg font-bold text-slate-900 leading-tight group-hover:text-blue-600 transition-colors line-clamp-2 ">
                                {{ $tour->name }}
                            </h2>
                        </div>

                        <div class="mt-auto">
                            <div class="flex items-end justify-between mb-2  border-t border-slate-50">
                                <div>
                                    <p class="text-sm font-bold text-slate-400   ">Giá hành trình</p>
                                    <p class="text-2xl font-bold text-rose-500 er">
                                        {{ number_format($tour->sale_price) }}<span class="text-base ml-0.5 ">đ</span>
                                    </p>
                                </div>
                                {{-- <div class="flex flex-col items-end">
                                    <div class="flex text-yellow-400 text-sm mb-1">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                    </div>
                                    <span class="text-sm font-bold text-slate-300 ">99+ lượt đặt</span>
                                </div> --}}
                            </div>

                            <a href="{{ route('user.tourDetail.index', $tour->id) }}"
                               class="btn-gradient w-full block text-center py-3 rounded-2xl text-white font-bold text-sm shadow-lg shadow-blue-100">
                                Chi tiết & đặt Tour
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-32 text-center bg-white rounded-[3rem] border border-dashed border-slate-200">
                    <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-umbrella-beach text-slate-200 text-4xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-slate-900 mb-2 ">Chưa có tour trong danh mục này</h3>
                    <p class="text-slate-400 font-medium mb-8">TravelGo đang chuẩn bị những hành trình mới, hãy quay lại sau nhé!</p>
                    <a href="{{ route('user.home') }}" class="text-blue-600 font-bold text-sm   border-b-2 border-blue-600 pb-1">Khám phá các tour khác</a>
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
