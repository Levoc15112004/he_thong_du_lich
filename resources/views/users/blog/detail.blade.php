@extends('users.master')

@section('home')
<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-28">

    <div class="flex flex-col lg:flex-row gap-12">

        <!-- Article -->
        <article class="lg:w-2/3 bg-white rounded-2xl overflow-hidden shadow-sm p-6 md:p-10">

            <!-- Breadcrumb -->
            <nav class="flex mb-6 text-base text-gray-500">
                <a href="{{ url('/blog') }}" class="hover:text-blue-600">Blog</a>
                <span class="mx-2">/</span>
                <span class="text-gray-800 font-medium">{{ $blog->title }}</span>
            </nav>

            <!-- Title -->
            <header class="mb-8">
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4 leading-tight">
                    {{ $blog->title }}
                </h1>

                <div class="flex items-center gap-4 text-gray-500 text-base">
                    <img src="https://i.pravatar.cc/150?u={{ $blog->id }}"
                         class="w-8 h-8 rounded-full">
                    <span class="font-medium text-gray-900">Admin</span>

                    <span>•</span>

                    <span>
                        <i class="far fa-calendar-alt mr-1"></i>
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
            <div class="bg-white p-6 rounded-2xl shadow-sm">
                <h3 class="text-lg font-bold mb-4">Tìm kiếm bài viết</h3>
                <input type="text"
                       placeholder="Nhập từ khóa..."
                       class="w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- Popular -->
            <div class="bg-white p-6 rounded-2xl shadow-sm">
                <h3 class="text-2xl font-bold mb-6">Bài viết phổ biến</h3>

                <div class="space-y-5">
                    @foreach($popularBlogs as $item)
                        <a href="{{ route('blog.show', $item->id) }}" class="flex gap-4 group">

                            <img src="{{ asset($item->image) }}"
                                 class="w-20 h-20 object-cover rounded-lg">

                            <div>
                                <h4 class="font-semibold text-xl group-hover:text-blue-600 line-clamp-2">
                                    {{ $item->title }}
                                </h4>

                                <span class="text-base text-gray-400">
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
        <h2 class="text-2xl font-bold mb-8">Có thể bạn quan tâm</h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

            @foreach($relatedBlogs as $item)
                <div class="bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-md transition">

                    <img src="{{ asset($item->image) }}"
                         class="w-full h-48 object-cover">

                    <div class="p-5">
                        <h3 class="font-bold text-lg line-clamp-2 mb-2">
                            {{ $item->title }}
                        </h3>

                        <p class="text-gray-500 text-base line-clamp-2 mb-4">
                            {{ \Illuminate\Support\Str::limit(strip_tags($item->content), 120) }}
                        </p>

                        <a href="{{ route('blog.show', $item->id) }}"
                           class="text-blue-600 font-semibold text-base hover:underline">
                            Đọc tiếp →
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
