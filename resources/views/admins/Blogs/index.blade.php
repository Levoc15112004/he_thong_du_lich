@extends('admins.master')

@section('title', 'Danh sách Bài viết Blog')

@section('home')
@php
    use Illuminate\Support\Str;
@endphp

<div class="min-h-screen bg-slate-50 px-4 sm:px-6 lg:px-8 py-8">
    <div class="max-w-7xl mx-auto space-y-8">

        {{-- HEADER --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between py-4 gap-4">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-teal-400 to-emerald-500 flex items-center justify-center text-white shadow-lg shadow-teal-200">
                    <i class="fa-solid fa-newspaper text-2xl"></i>
                </div>
                <div>
                    <h4 class="text-2xl sm:text-3xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-teal-700 to-emerald-600">
                        Quản lý Bài viết
                    </h4>
                    <p class="text-sm text-slate-500 mt-1">Tạo mới và quản lý nội dung bài viết trên blog hệ thống</p>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('admin.blogs.create') }}"
                    class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-teal-500 to-emerald-600 text-white font-semibold rounded-xl shadow-lg shadow-teal-200 hover:shadow-xl hover:shadow-teal-300 hover:-translate-y-0.5 transition-all duration-300 group">
                    <i class="fa-solid fa-plus text-sm group-hover:rotate-90 transition-transform duration-300"></i>
                    <span>Tạo bài viết mới</span>
                </a>
            </div>
        </div>

        {{-- SEARCH & FILTER --}}
        <div class="bg-white/80 backdrop-blur-xl border border-white p-6 rounded-3xl shadow-xl shadow-slate-100/50 flex flex-col sm:flex-row gap-4">
            <div class="relative flex-1 group">
                <i class="fa-solid fa-magnifying-glass absolute left-5 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-teal-500 transition-colors"></i>
                <input type="text" placeholder="Tìm kiếm tiêu đề bài viết..."
                    class="w-full pl-12 pr-6 py-3.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-700 font-medium focus:ring-4 focus:ring-teal-500/10 focus:border-teal-500 transition-all outline-none placeholder:text-slate-400">
            </div>
            <div class="w-full sm:w-auto relative group">
                <i class="fa-solid fa-filter absolute left-5 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-teal-500 transition-colors pointer-events-none z-10"></i>
                <select class="w-full sm:w-48 pl-12 pr-10 py-3.5 bg-slate-50 border border-slate-200 text-slate-700 rounded-xl font-medium outline-none focus:ring-4 focus:ring-teal-500/10 focus:border-teal-500 appearance-none relative">
                    <option value="">Tất cả trạng thái</option>
                    <option value="1">Đang hiển thị</option>
                    <option value="0">Đang ẩn</option>
                </select>
                <i class="fa-solid fa-chevron-down absolute right-5 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none text-xs"></i>
            </div>
        </div>

        {{-- DESKTOP TABLE VIEW --}}
        <div class="hidden lg:block bg-white/90 backdrop-blur-xl border border-white shadow-2xl shadow-slate-200/50 rounded-3xl overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-slate-100">
                        <th class="px-6 py-5 text-sm font-bold text-slate-700">Bài viết</th>
                        <th class="px-6 py-5 text-sm font-bold text-slate-700 text-center w-36">Trạng thái</th>
                        <th class="px-6 py-5 text-sm font-bold text-slate-700 text-center w-36">Ngày tạo</th>
                        <th class="px-6 py-5 text-sm font-bold text-slate-700 text-center w-32">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($blogs as $blog)
                        <tr class="hover:bg-slate-50/80 transition-colors group">
                            
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-4">
                                    <div class="w-24 h-16 rounded-xl overflow-hidden shadow-sm shrink-0 bg-slate-100 border border-slate-200">
                                        <img src="{{ $blog->image ? asset($blog->image) : asset('default.png') }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                    </div>
                                    <div class="min-w-0 pr-4">
                                        <h5 class="font-bold text-slate-800 text-base leading-tight mb-1 line-clamp-1 group-hover:text-teal-600 transition-colors" title="{{ $blog->title }}">{{ $blog->title }}</h5>
                                        <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed">{{ strip_tags($blog->content) }}</p>
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-4 text-center">
                                @if($blog->status)
                                    <span class="inline-flex px-3 py-1.5 bg-emerald-50 text-emerald-700 border border-emerald-100 rounded-lg text-xs font-bold shadow-sm justify-center w-28">
                                        Hiển thị
                                    </span>
                                @else
                                    <span class="inline-flex px-3 py-1.5 bg-slate-100 text-slate-600 border border-slate-200 rounded-lg text-xs font-bold shadow-sm justify-center w-28">
                                        Đang ẩn
                                    </span>
                                @endif
                            </td>

                            <td class="px-6 py-4 text-center">
                                <span class="text-sm font-bold text-slate-700 bg-slate-50 px-3 py-1.5 rounded-lg border border-slate-100 block mx-auto w-28">{{ $blog->created_at->format('d/m/Y') }}</span>
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex justify-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <a href="{{ route('admin.blogs.edit', $blog->id) }}"
                                        class="w-10 h-10 flex items-center justify-center text-amber-500 bg-amber-50 border border-amber-200 rounded-xl hover:bg-amber-500 hover:text-white transition-all shadow-sm">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                    <form action="{{ route('admin.blogs.destroy', $blog->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa bài viết này?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-10 h-10 flex items-center justify-center text-rose-500 bg-rose-50 border border-rose-200 rounded-xl hover:bg-rose-500 hover:text-white transition-all shadow-sm">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-16 text-center">
                                <div class="flex flex-col items-center justify-center text-slate-400">
                                    <i class="fa-regular fa-newspaper text-5xl mb-4 text-slate-300"></i>
                                    <p class="text-lg font-medium">Chưa có bài viết nào được đăng.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            
            @if($blogs->hasPages())
                <div class="px-6 py-4 border-t border-slate-50 bg-slate-50/50">
                    {{ $blogs->links('vendor.pagination.tailwind') }}
                </div>
            @endif
        </div>

        {{-- MOBILE CARDS VIEW --}}
        <div class="lg:hidden space-y-4">
            @forelse($blogs as $blog)
                <div class="bg-white/90 backdrop-blur-xl border border-white rounded-3xl shadow-lg shadow-slate-200/50 p-5 relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-8 bg-teal-50/50 rounded-full blur-2xl -z-10 -translate-y-1/2 translate-x-1/2"></div>
                    
                    <div class="flex gap-4">
                        <div class="w-24 h-24 rounded-2xl overflow-hidden shadow-sm shrink-0 border border-slate-100">
                            <img src="{{ $blog->image ? asset($blog->image) : asset('default.png') }}" class="w-full h-full object-cover">
                        </div>
                        <div class="flex-1 min-w-0">
                            <h5 class="font-bold text-slate-800 text-base leading-tight mb-2 line-clamp-2">{{ $blog->title }}</h5>
                            <div class="flex items-center flex-wrap gap-2">
                                @if($blog->status)
                                    <span class="px-2.5 py-1 bg-emerald-50 text-emerald-700 rounded-lg text-[10px] font-bold border border-emerald-100 uppercase tracking-wider">Public</span>
                                @else
                                    <span class="px-2.5 py-1 bg-slate-100 text-slate-500 rounded-lg text-[10px] font-bold border border-slate-200 uppercase tracking-wider">Draft</span>
                                @endif
                                <span class="text-[10px] font-semibold text-slate-400"><i class="fa-regular fa-calendar mr-1"></i>{{ $blog->created_at->format('d/m/Y') }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-4 bg-slate-50/80 p-3 rounded-xl border border-slate-100">
                        <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed">
                            {{ strip_tags($blog->content) }}
                        </p>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-3 pt-4 mt-4 border-t border-slate-100">
                        <a href="{{ route('admin.blogs.edit', $blog->id) }}" class="flex items-center justify-center gap-2 bg-amber-50 hover:bg-amber-500 text-amber-600 hover:text-white py-2.5 rounded-xl font-bold transition-colors text-sm border border-amber-100">
                            <i class="fa-solid fa-pen"></i> Chỉnh sửa
                        </a>
                        <form action="{{ route('admin.blogs.destroy', $blog->id) }}" method="POST" onsubmit="return confirm('Xác nhận xóa bài viết?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full flex items-center justify-center gap-2 bg-rose-50 hover:bg-rose-500 text-rose-600 hover:text-white py-2.5 rounded-xl font-bold transition-colors text-sm border border-rose-100">
                                <i class="fa-solid fa-trash"></i> Xóa
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="bg-white/80 p-10 rounded-3xl border border-dashed border-slate-300 text-center">
                    <i class="fa-regular fa-newspaper text-4xl mb-3 text-slate-300"></i>
                    <p class="text-slate-500 font-medium">Chưa có bài viết nào!</p>
                </div>
            @endforelse
            
            @if($blogs->hasPages())
                <div class="pt-2">
                    {{ $blogs->links('vendor.pagination.tailwind') }}
                </div>
            @endif
        </div>

    </div>
</div>
@endsection
