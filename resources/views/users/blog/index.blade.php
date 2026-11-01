@extends('users.master')

@section('home')


<div class="blog-container min-h-screen bg-slate-50 dark:bg-[#0b1120] text-slate-800 dark:text-slate-100 transition-colors duration-300">
    {{-- HERO SECTION --}}
    <section class="relative pt-28 sm:pt-36 pb-14 bg-[#faf8f5] dark:bg-[#151719] border-b border-[#e8e3d8] dark:border-[#2b3239]">
        <div class="max-w-7xl mx-auto px-4 md:px-6 relative z-10 text-center">
            <div class="stamp-badge mb-4">
                <i class="fa-solid fa-book-open-reader text-orange-500"></i>
                Cẩm Nang Du Lịch 2026
            </div>
            <h1 class="font-serif text-3xl sm:text-5xl md:text-6xl font-bold text-slate-900 dark:text-white tracking-tight mb-4">
                Nhật Ký <span class="text-[#b85e3a] font-serif italic">Hành Trình Du Lịch</span>
            </h1>
            <p class="text-slate-600 dark:text-slate-300 font-normal text-sm sm:text-base max-w-2xl mx-auto leading-relaxed">
                Khám phá những câu chuyện, kinh nghiệm thực tế và nguồn cảm hứng bất tận cho chuyến đi tiếp theo của bạn cùng WanderVibe.
            </p>
        </div>
    </section>

    <main class="max-w-7xl mx-auto px-6 pb-24">
        {{-- TOP SECTION: FEATURED & LATEST --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 mb-20">

            {{-- FEATURED POST (LEFT) --}}
            @if($featuredBlog)
            <div class="lg:col-span-8">
                <a href="{{ route('blog.show', $featuredBlog->id) }}" class="relative block group h-[350px] md:h-[550px] rounded-2xl overflow-hidden shadow-2xl transition-all duration-700">
                    <img src="{{ asset($featuredBlog->image) }}" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-1000">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-900/20 to-transparent"></div>

                    <div class="absolute bottom-0 p-6 md:p-14 w-full">
                        <span class="glass-badge px-4 py-2 rounded-full text-sm font-bold text-[#b85e3a]   mb-6 inline-block">
                            <i class="fas fa-star mr-2"></i> Bài viết tiêu điểm
                        </span>
                        <h2 class="text-3xl md:text-5xl font-bold text-white leading-tight mb-6 group-hover:text-[#cf8a6e] transition-colors ">
                            {{ $featuredBlog->title }}
                        </h2>
                        <div class="flex items-center gap-6 text-slate-300 text-sm font-bold  ">
                            <span class="flex items-center gap-2"><i class="far fa-user text-orange-400"></i> {{ $featuredBlog->author ?? 'WanderVibe Team' }}</span>
                            <span class="flex items-center gap-2"><i class="far fa-calendar text-[#cf8a6e]"></i> {{ $featuredBlog->created_at->format('d/m/Y') }}</span>
                            <span class="flex items-center gap-2"><i class="far fa-eye text-[#cf8a6e]"></i> {{ $featuredBlog->views ?? 0 }}</span>
                        </div>
                    </div>
                </a>
            </div>
            @endif

            {{-- LATEST BLOGS (RIGHT) --}}
            <div class="lg:col-span-4 space-y-8">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-xl font-bold text-slate-900  ">Mới <span class="text-[#b85e3a]">cập nhật</span></h3>
                    <div class="h-px flex-1 bg-slate-100 ml-4"></div>
                </div>

                @foreach($latestBlogs as $blog)
                <a href="{{ route('blog.show', $blog->id) }}" class="flex gap-5 group cursor-pointer">
                    <div class="w-24 h-24 shrink-0 rounded-2xl overflow-hidden shadow-sm border border-slate-100">
                        <img src="{{ asset($blog->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    </div>
                    <div class="flex flex-col justify-center">
                        <span class="text-[9px] font-bold text-[#b85e3a]   mb-1">
                            {{ $blog->category->name ?? 'Tin tức' }}
                        </span>
                        <h4 class="font-bold text-slate-900 leading-snug group-hover:text-[#b85e3a] transition-colors line-clamp-2">
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
                    <p class="text-xs font-bold text-[#cf8a6e]   mb-2">Đăng ký bản tin</p>
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
            <h3 class="text-2xl font-bold text-slate-900  ">Tất cả <span class="text-[#b85e3a]">bài viết</span></h3>
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

                    <h3 class="text-xl font-bold text-slate-900 leading-tight mb-4 group-hover:text-[#b85e3a] transition-colors ">
                        <a href="{{ route('blog.show', $blog->id) }}">{{ $blog->title }}</a>
                    </h3>

                    <p class="text-slate-500 text-sm font-medium leading-relaxed mb-4 line-clamp-3">
                        {{ Str::limit($blog->description, 120) }}
                    </p>

                    <div class="mt-auto border-t border-slate-50 flex items-center justify-between">
                        <a href="{{ route('blog.show', $blog->id) }}" class="text-[11px] font-bold text-[#b85e3a]   flex items-center gap-2 group/btn">
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
