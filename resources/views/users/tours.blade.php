@extends('users.master')

@section('home')
<style>
    .search-container {
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
</style>

<div class="search-container min-h-screen">
    {{-- HERO HEADER --}}
    <section class="relative pt-32 pb-16 overflow-hidden hero-gradient">
        <div class="max-w-7xl mx-auto px-6 relative z-10 text-center">
            <div class="inline-flex items-center gap-2 bg-blue-50 text-blue-600 px-4 py-2 rounded-full border border-blue-100 mb-6 font-bold text-sm">
                <i class="fas fa-globe-asia"></i>
                Khám phá thế giới
            </div>
            <h1 class="text-4xl md:text-5xl font-bold text-slate-900 mb-4">
                Tất cả <span class="text-gradient">Hành Trình</span>
            </h1>
            <p class="text-slate-500 font-medium max-w-xl mx-auto">
                {{ $tours->total() }} điểm đến tuyệt vời đang chờ đón bạn khám phá.
            </p>
        </div>
    </section>

    <main class="max-w-7xl mx-auto px-6 pb-24">
        {{-- Lưới hiển thị tour --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10">
            @forelse ($tours as $tour)
                <div class="premium-card group flex flex-col h-full overflow-hidden">
                    {{-- Tour Image Area --}}
                    <div class="relative h-52 overflow-hidden">
                        <img src="{{ asset($tour->image) }}" alt="{{ $tour->name }}"
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-1000">

                        <div class="absolute top-5 left-5 flex flex-col gap-2">
                            <span class="glass-badge px-3 py-1.5 rounded-full text-[10px] font-bold text-blue-600">
                                <i class="far fa-clock mr-1.5"></i> {{ $tour->time }}
                            </span>
                        </div>

                        <div class="absolute bottom-5 left-5 right-5">
                             <div class="bg-slate-900/40 backdrop-blur-md px-4 py-2 rounded-2xl border border-white/20 inline-flex items-center gap-2">
                                <i class="fas fa-map-marker-alt text-blue-400 text-sm"></i>
                                <span class="text-[10px] font-medium text-white truncate">
                                    {{ $tour->start_location }} <i class="fas fa-arrow-right mx-1 opacity-50"></i> {{ $tour->end_location }}
                                </span>
                             </div>
                        </div>
                    </div>

                    {{-- Tour Content Area --}}
                    <div class="p-4 flex flex-col flex-grow">
                        <div class="flex justify-between items-start mb-2">
                             <h2 class="text-lg font-bold text-slate-900 leading-tight group-hover:text-blue-600 transition-colors line-clamp-2">
                                {{ $tour->name }}
                            </h2>
                        </div>

                        <div class="mt-auto">
                            <div class="flex items-end justify-between mb-2 border-t border-slate-50">
                                <div>
                                    <p class="text-sm font-bold text-slate-400">Giá hành trình</p>
                                    <p class="text-2xl font-bold text-rose-500 er">
                                        {{ number_format($tour->sale_price) }}<span class="text-base ml-0.5">đ</span>
                                    </p>
                                </div>
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
                        <i class="fas fa-search text-slate-200 text-4xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-slate-900 mb-2">Không tìm thấy tour nào</h3>
                    <p class="text-slate-400 font-medium mb-8">Rất tiếc, chúng tôi không tìm thấy hành trình nào phù hợp với tìm kiếm của bạn.</p>
                    <a href="{{ route('user.home') }}" class="text-blue-600 font-bold text-sm border-b-2 border-blue-600 pb-1">Trở về trang chủ</a>
                </div>
            @endforelse
        </div>

        {{-- Phân trang --}}
        <div class="mt-20 flex justify-center">
            @if($tours instanceof \Illuminate\Pagination\LengthAwarePaginator)
                <div class="bg-white p-3 rounded-[2.5rem] shadow-sm border border-slate-100">
                    {{ $tours->links('vendor.pagination.tailwind') }}
                </div>
            @endif
        </div>
    </main>
</div>
@endsection
