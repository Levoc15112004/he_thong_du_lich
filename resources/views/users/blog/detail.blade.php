@extends('users.master')

@section('home')
<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-28">

    <div class="flex flex-col lg:flex-row gap-12">

        <!-- Article -->
        <article class="lg:w-2/3 bg-white dark:bg-slate-800/95 rounded-3xl overflow-hidden shadow-sm border border-slate-100 dark:border-slate-700/80 p-6 md:p-10">

            <!-- Breadcrumb -->
            <nav class="flex mb-6 text-sm text-slate-500 dark:text-slate-400">
                <a href="{{ url('/blog') }}" class="hover:text-emerald-600 transition-colors">Cẩm Nang Du Lịch</a>
                <span class="mx-2">/</span>
                <span class="text-slate-800 dark:text-slate-200 font-medium truncate">{{ $blog->title }}</span>
            </nav>

            <!-- Title -->
            <header class="mb-8">
                <h1 class="text-3xl md:text-4xl font-extrabold text-slate-900 dark:text-white mb-4 leading-tight tracking-tight">
                    {{ $blog->title }}
                </h1>

                <div class="flex items-center gap-4 text-slate-500 dark:text-slate-400 text-sm">
                    <img src="https://i.pravatar.cc/150?u={{ $blog->id }}"
                         class="w-8 h-8 rounded-full shadow-xs">
                    <span class="font-bold text-slate-900 dark:text-white">WanderVibe Editor</span>

                    <span>•</span>

                    <span>
                        <i class="far fa-calendar-alt mr-1 text-emerald-500"></i>
                        {{ $blog->created_at->format('d/m/Y') }}
                    </span>
                </div>
            </header>

            <!-- Featured image -->
            @if($blog->image)
            <div class="mb-10">
                <img src="{{ asset($blog->image) }}"
                     alt="{{ $blog->title }}"
                     class="w-full h-[300px] md:h-[450px] object-cover rounded-xl shadow">
            </div>
            @endif

            <!-- CONTENT CKEDITOR -->
            <div class="blog-content prose max-w-none text-gray-800 leading-relaxed">
                {!! $blog->content !!}
            </div>

            <!-- Footer -->
            <div class="mt-12 pt-8 border-t flex justify-between items-center flex-wrap gap-4">

                <div class="flex gap-2">
                    <span class="bg-gray-100 px-3 py-1 rounded-full text-xs text-gray-600">
                        #Blog
                    </span>
                </div>

                <div class="flex items-center gap-3">
                    <span class="text-base text-gray-500">Chia sẻ:</span>
                    <a href="#" class="hover:text-blue-600"><i class="fab fa-facebook-f"></i></a>
                </div>

            </div>

        </article>

        <!-- Sidebar -->
        <aside class="lg:w-1/3 space-y-8">

            <!-- Search -->
            <div class="bg-white dark:bg-slate-800/90 p-6 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700/80">
                <h3 class="text-base font-extrabold text-slate-900 dark:text-white mb-4">Tìm Kiếm Bài Viết</h3>
                <input type="text"
                       placeholder="Nhập từ khóa..."
                       class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white rounded-xl focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 text-sm">
            </div>

            <!-- Popular -->
            <div class="bg-white dark:bg-slate-800/90 p-6 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700/80">
                <h3 class="text-xl font-extrabold text-slate-900 dark:text-white mb-6">Bài Viết Phổ Biến</h3>

                <div class="space-y-5">
                    @foreach($popularBlogs as $item)
                        <a href="{{ route('blog.show', $item->id) }}" class="flex gap-4 group">

                            <img src="{{ asset($item->image) }}"
                                 class="w-20 h-20 object-cover rounded-xl shadow-xs shrink-0">

                            <div>
                                <h4 class="font-bold text-base text-slate-900 dark:text-white group-hover:text-emerald-500 transition-colors line-clamp-2 leading-snug">
                                    {{ $item->title }}
                                </h4>

                                <span class="text-xs font-medium text-slate-400 dark:text-slate-500 mt-1 block">
                                    {{ $item->created_at->format('d/m/Y') }}
                                </span>
                            </div>

                        </a>
                    @endforeach
                </div>
            </div>

        </aside>

    </div>

    <!-- Related -->
    <section class="mt-20">
        <h2 class="text-2xl font-extrabold text-slate-900 dark:text-white mb-8 tracking-tight">Có Thể Bạn Quan Tâm</h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

            @foreach($relatedBlogs as $item)
                <div class="bg-white dark:bg-slate-800/90 rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-slate-100 dark:border-slate-700/80 group">

                    <a href="{{ route('blog.show', $item->id) }}" class="block overflow-hidden h-48">
                        <img src="{{ asset($item->image) }}"
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    </a>

                    <div class="p-6">
                        <a href="{{ route('blog.show', $item->id) }}">
                            <h3 class="font-extrabold text-lg text-slate-900 dark:text-white line-clamp-2 mb-2 group-hover:text-emerald-500 transition-colors">
                                {{ $item->title }}
                            </h3>
                        </a>

                        <p class="text-slate-500 dark:text-slate-400 text-sm line-clamp-2 mb-4 leading-relaxed">
                            {{ \Illuminate\Support\Str::limit(strip_tags($item->content), 120) }}
                        </p>

                        <a href="{{ route('blog.show', $item->id) }}"
                           class="inline-flex items-center gap-1.5 text-emerald-600 dark:text-emerald-400 font-bold text-sm hover:underline">
                            <span>Đọc tiếp</span>
                            <i class="fa-solid fa-arrow-right text-xs"></i>
                        </a>
                    </div>

                </div>
            @endforeach

        </div>
    </section>

</main>

{{-- CSS FIX CKEDITOR --}}
<style>
.blog-content figure.image {
    text-align: center;
    margin: 20px 0;
}

.blog-content figure.image img {
    display: inline-block;
    max-width: 100%;
    border-radius: 10px;
}

.blog-content figure.image figcaption {
    font-size: 14px;
    color: #666;
    margin-top: 6px;
}
</style>

@endsection
