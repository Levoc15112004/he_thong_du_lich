@extends('users.master')

@section('home')
<style>
    .blog-container {
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
        transform: translateY(-8px);
        box-shadow: 0 30px 60px -15px rgba(59, 130, 246, 0.12);
    }

    .hero-gradient {
        background: radial-gradient(circle at top right, rgba(59, 130, 246, 0.1), transparent),
                    radial-gradient(circle at bottom left, rgba(139, 92, 246, 0.05), transparent);
    }

    .glass-badge {
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    .line-clamp-custom {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>

<div class="blog-container min-h-screen">
    {{-- HERO SECTION --}}
    <section class="relative pt-32 pb-16 overflow-hidden hero-gradient">
        <div class="max-w-7xl mx-auto px-4 md:px-6 relative z-10 text-center">
            <div class="inline-flex items-center gap-2 bg-blue-50 text-blue-600 px-4 py-2 rounded-full border border-blue-100 mb-6 font-bold text-sm  ">
                <i class="fas fa-journal-whills"></i>
                Cẩm nang du lịch 2026
            </div>
            <h1 class="text-4xl sm:text-5xl md:text-6xl font-bold text-slate-900  mb-4">
                Nhật ký <span class="text-gradient">hành trình</span>
            </h1>
            <p class="text-slate-500 font-medium text-base md:text-lg max-w-2xl mx-auto px-4">
                Khám phá những câu chuyện, kinh nghiệm và nguồn cảm hứng bất tận cho chuyến đi tiếp theo của bạn.
            </p>
        </div>
    </section>

    <main class="max-w-7xl mx-auto px-6 pb-24">
        {{-- TOP SECTION: FEATURED & LATEST --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 mb-20">

            {{-- FEATURED POST (LEFT) --}}
            @if($featuredBlog)
            <div class="lg:col-span-8">
                <a href="{{ route('blog.show', $featuredBlog->id) }}" class="relative block group h-[350px] md:h-[550px] rounded-[2.5rem] md:rounded-[3rem] overflow-hidden shadow-2xl transition-all duration-700">
                    <img src="{{ asset($featuredBlog->image) }}" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-1000">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-900/20 to-transparent"></div>

                    <div class="absolute bottom-0 p-6 md:p-14 w-full">
                        <span class="glass-badge px-4 py-2 rounded-full text-sm font-bold text-blue-600   mb-6 inline-block">
                            <i class="fas fa-star mr-2"></i> Bài viết tiêu điểm
                        </span>
                        <h2 class="text-3xl md:text-5xl font-bold text-white leading-tight mb-6 group-hover:text-blue-400 transition-colors ">
                            {{ $featuredBlog->title }}
                        </h2>
                        <div class="flex items-center gap-6 text-slate-300 text-sm font-bold  ">
                            <span class="flex items-center gap-2"><i class="far fa-user text-emerald-400"></i> {{ $featuredBlog->author ?? 'WanderVibe Team' }}</span>
                            <span class="flex items-center gap-2"><i class="far fa-calendar text-blue-400"></i> {{ $featuredBlog->created_at->format('d/m/Y') }}</span>
                            <span class="flex items-center gap-2"><i class="far fa-eye text-blue-400"></i> {{ $featuredBlog->views ?? 0 }}</span>
                        </div>
                    </div>
                </a>
            </div>
            @endif

            {{-- LATEST BLOGS (RIGHT) --}}
            <div class="lg:col-span-4 space-y-8">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-xl font-bold text-slate-900  ">Mới <span class="text-blue-600">cập nhật</span></h3>
                    <div class="h-px flex-1 bg-slate-100 ml-4"></div>
                </div>

                @foreach($latestBlogs as $blog)
                <a href="{{ route('blog.show', $blog->id) }}" class="flex gap-5 group cursor-pointer">
                    <div class="w-24 h-24 shrink-0 rounded-2xl overflow-hidden shadow-sm border border-slate-100">
                        <img src="{{ asset($blog->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    </div>
                    <div class="flex flex-col justify-center">
                        <span class="text-[9px] font-bold text-blue-600   mb-1">
                            {{ $blog->category->name ?? 'Tin tức' }}
                        </span>
                        <h4 class="font-bold text-slate-900 leading-snug group-hover:text-blue-600 transition-colors line-clamp-2">
                            {{ $blog->title }}
                        </h4>
                        <p class="text-sm text-slate-400 font-bold mt-2  ">
                            <i class="far fa-clock mr-1"></i> {{ $blog->created_at->diffForHumans() }}
                        </p>
                    </div>
                </a>
                @endforeach

                {{-- Decorative Card --}}
                <div class="premium-card p-8 bg-slate-900 text-white mt-10 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-blue-500/10 blur-[40px] rounded-full"></div>
                    <p class="text-xs font-bold text-blue-400   mb-2">Đăng ký bản tin</p>
                    <h5 class="text-lg font-bold mb-4  leading-tight">Nhận ưu đãi du lịch <br> mới nhất qua Email</h5>
                    <div class="flex gap-2">
                        <input type="text" placeholder="Email của bạn..." class="bg-white/5 border border-white/10 rounded-xl px-4 py-2 text-xs w-full outline-none focus:border-blue-500 transition-all">
                        <button class="bg-blue-600 p-2 rounded-xl hover:bg-blue-700 transition shadow-lg shadow-blue-900/20"><i class="fas fa-paper-plane"></i></button>
                    </div>
                </div>
            </div>
        </div>

        {{-- MAIN LISTING GRID --}}
        <div class="flex items-center gap-4 mb-12">
            <h3 class="text-2xl font-bold text-slate-900  ">Tất cả <span class="text-blue-600">bài viết</span></h3>
            <div class="h-px flex-1 bg-slate-100"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
            @foreach($blogs as $blog)
            <article class="premium-card overflow-hidden group flex flex-col h-full">
                {{-- Image with Overlay --}}
                <div class="relative h-64 overflow-hidden">
                    <img src="{{ asset($blog->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    <div class="absolute top-5 left-5">
                        <span class="glass-badge px-3 py-1.5 rounded-full text-[9px] font-bold text-slate-900   shadow-sm">
                            {{ $blog->category->name ?? 'Du lịch' }}
                        </span>
                    </div>
                </div>

                {{-- Content --}}
                <div class="p-4 flex flex-col flex-1">
                    <div class="flex items-center gap-4 mb-4 text-sm font-bold text-slate-400  ">
                        <span class="flex items-center gap-1"><i class="far fa-calendar"></i> {{ $blog->created_at->format('d/m/Y') }}</span>
                        <span class="w-1 h-1 bg-slate-300 rounded-full"></span>
                        <span class="flex items-center gap-1"><i class="far fa-eye"></i> {{ $blog->views ?? 0 }} lượt xem</span>
                    </div>

                    <h3 class="text-xl font-bold text-slate-900 leading-tight mb-4 group-hover:text-blue-600 transition-colors ">
                        <a href="{{ route('blog.show', $blog->id) }}">{{ $blog->title }}</a>
                    </h3>

                    <p class="text-slate-500 text-sm font-medium leading-relaxed mb-4 line-clamp-3">
                        {{ Str::limit($blog->description, 120) }}
                    </p>

                    <div class="mt-auto border-t border-slate-50 flex items-center justify-between">
                        <a href="{{ route('blog.show', $blog->id) }}" class="text-[11px] font-bold text-blue-600   flex items-center gap-2 group/btn">
                            Đọc bài viết <i class="fas fa-arrow-right group-hover/btn:translate-x-2 transition-transform"></i>
                        </a>
                        <button class="text-slate-300 hover:text-rose-500 transition-colors">
                            <i class="far fa-bookmark"></i>
                        </button>
                    </div>
                </div>
            </article>
            @endforeach
        </div>

        {{-- CUSTOM PAGINATION --}}
        {{-- <div class="mt-20 flex justify-center">
            <div class="bg-white p-2 rounded-[2rem] shadow-sm border border-slate-100 flex gap-1">
                {{ $blogs->links('vendor.pagination.tailwind-custom') }} {{-- Giả định bạn có file pagination custom --}}
            </div>
        </div> --}}
    </main>
</div>
@endsection
