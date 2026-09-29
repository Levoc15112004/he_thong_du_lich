@extends('admins.master')

@section('title', 'Danh sách Banner')

@section('home')
<div class="min-h-screen bg-slate-50 px-4 sm:px-6 lg:px-8 py-8">
    <div class="max-w-7xl mx-auto space-y-8">

        {{-- HEADER --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between py-4 gap-4">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-teal-400 to-emerald-500 flex items-center justify-center text-white shadow-lg shadow-teal-200">
                    <i class="fa-solid fa-rectangle-ad text-2xl"></i>
                </div>
                <div>
                    <h4 class="text-2xl sm:text-3xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-teal-700 to-emerald-600">
                        Quản lý Banner
                    </h4>
                    <p class="text-sm text-slate-500 mt-1">Quản lý các bảng quảng cáo và hình ảnh nổi bật</p>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('admin.banners.create') }}"
                    class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-teal-500 to-emerald-600 text-white font-semibold rounded-xl shadow-lg shadow-teal-200 hover:shadow-xl hover:shadow-teal-300 hover:-translate-y-0.5 transition-all duration-300 group">
                    <i class="fa-solid fa-plus text-sm group-hover:rotate-90 transition-transform duration-300"></i>
                    <span>Thêm banner mới</span>
                </a>
            </div>
        </div>

        {{-- ALERTS --}}
        @if (session('success'))
            <div class="bg-emerald-50/80 backdrop-blur-sm border border-emerald-200 text-emerald-800 px-6 py-4 rounded-2xl flex items-center gap-3 shadow-sm">
                <div class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600">
                    <i class="fa-solid fa-check"></i>
                </div>
                <p class="font-medium">{{ session('success') }}</p>
            </div>
        @elseif(session('error'))
            <div class="bg-rose-50/80 backdrop-blur-sm border border-rose-200 text-rose-800 px-6 py-4 rounded-2xl flex items-center gap-3 shadow-sm">
                <div class="w-8 h-8 rounded-full bg-rose-100 flex items-center justify-center text-rose-600">
                    <i class="fa-solid fa-circle-exclamation"></i>
                </div>
                <p class="font-medium">{{ session('error') }}</p>
            </div>
        @endif

        {{-- DESKTOP TABLE VIEW --}}
        <div class="hidden lg:block bg-white/90 backdrop-blur-xl border border-white shadow-2xl shadow-slate-200/50 rounded-3xl overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-slate-100">
                        <th class="px-6 py-5 text-sm font-bold text-slate-700 w-16 text-center">Hình ảnh</th>
                        <th class="px-6 py-5 text-sm font-bold text-slate-700">Tên Banner</th>
                        <th class="px-6 py-5 text-sm font-bold text-slate-700">Liên kết (Link)</th>
                        <th class="px-6 py-5 text-sm font-bold text-slate-700 text-center w-40">Ngày tạo</th>
                        <th class="px-6 py-5 text-sm font-bold text-slate-700 text-center w-32">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($banners as $banner)
                        <tr class="hover:bg-slate-50/80 transition-colors group">
                            
                            <td class="px-6 py-4">
                                <div class="w-32 h-14 rounded-lg overflow-hidden border border-slate-200 shadow-sm mx-auto bg-slate-100 flex items-center justify-center">
                                    <img src="{{ asset($banner->image) }}" alt="Banner" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                </div>
                            </td>

                            <td class="px-6 py-4">
                                <h5 class="font-bold text-slate-800 text-base">{{ $banner->name }}</h5>
                                <span class="text-xs text-slate-400 font-medium font-mono">ID: #{{ $banner->id }}</span>
                            </td>

                            <td class="px-6 py-4">
                                @if (!empty($banner->link))
                                    <a href="{{ $banner->link }}" target="_blank" class="inline-flex items-center gap-2 text-sm text-teal-600 hover:text-teal-700 font-medium hover:underline bg-teal-50 px-3 py-1.5 rounded-lg border border-teal-100 transition-colors">
                                        <i class="fa-solid fa-link text-xs"></i> 
                                        <span class="max-w-[200px] truncate">{{ $banner->link }}</span>
                                    </a>
                                @else
                                    <span class="text-slate-400 text-sm italic py-1.5 px-3 bg-slate-50 rounded-lg inline-block border border-slate-100">Không có liên kết</span>
                                @endif
                            </td>

                            <td class="px-6 py-4 text-center">
                                <div class="inline-flex flex-col items-center">
                                    <span class="text-sm font-bold text-slate-700">{{ $banner->created_at->format('d/m/Y') }}</span>
                                    <span class="text-xs text-slate-500">{{ $banner->created_at->format('H:i') }}</span>
                                </div>
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex justify-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <a href="{{ route('admin.banners.edit', $banner->id) }}"
                                        class="w-10 h-10 flex items-center justify-center text-amber-500 bg-amber-50 border border-amber-200 rounded-xl hover:bg-amber-500 hover:text-white transition-all shadow-sm">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                    <form action="{{ route('admin.banners.destroy', $banner->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa banner này không?')">
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
                            <td colspan="5" class="py-16 text-center">
                                <div class="flex flex-col items-center justify-center text-slate-400">
                                    <i class="fa-regular fa-image text-5xl mb-4 text-slate-300"></i>
                                    <p class="text-lg font-medium">Chưa có banner nào được thêm.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- MOBILE CARDS VIEW --}}
        <div class="lg:hidden space-y-4">
            @forelse($banners as $banner)
                <div class="bg-white/90 backdrop-blur-xl border border-white rounded-3xl shadow-lg shadow-slate-200/50 p-5 relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-8 bg-teal-50/50 rounded-full blur-2xl -z-10 -translate-y-1/2 translate-x-1/2"></div>
                    
                    {{-- Banner Image --}}
                    <div class="w-full h-32 md:h-48 rounded-2xl overflow-hidden border border-slate-100 shadow-sm mb-4">
                        <img src="{{ asset($banner->image) }}" class="w-full h-full object-cover">
                    </div>

                    <div class="mb-4">
                        <h5 class="font-bold text-slate-800 text-lg leading-tight mb-1">{{ $banner->name }}</h5>
                        <p class="text-xs text-slate-500 font-medium">Ngày tạo: {{ $banner->created_at->format('d/m/Y') }}</p>
                    </div>

                    @if (!empty($banner->link))
                        <a href="{{ $banner->link }}" target="_blank" class="flex items-center gap-2 text-sm text-teal-700 bg-teal-50 px-4 py-2.5 rounded-xl border border-teal-100 font-medium mb-4 active:scale-95 transition-transform overflow-hidden">
                            <i class="fa-solid fa-link shrink-0 text-teal-500"></i>
                            <span class="truncate">{{ $banner->link }}</span>
                        </a>
                    @else
                        <div class="flex items-center gap-2 text-sm text-slate-500 bg-slate-50 px-4 py-2.5 rounded-xl border border-slate-100 italic mb-4">
                            <i class="fa-solid fa-link-slash shrink-0 text-slate-400"></i> Không có liên kết
                        </div>
                    @endif
                    
                    <div class="grid grid-cols-2 gap-3 pt-4 border-t border-slate-100">
                        <a href="{{ route('admin.banners.edit', $banner->id) }}" class="flex items-center justify-center gap-2 bg-amber-50 hover:bg-amber-500 text-amber-600 hover:text-white py-2.5 rounded-xl font-bold transition-colors text-sm border border-amber-100">
                            <i class="fa-solid fa-pen"></i> Sửa
                        </a>
                        <form action="{{ route('admin.banners.destroy', $banner->id) }}" method="POST" onsubmit="return confirm('Xác nhận xóa banner này?')">
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
                    <i class="fa-regular fa-image text-4xl mb-3 text-slate-300"></i>
                    <p class="text-slate-500 font-medium">Chưa có banner nào!</p>
                </div>
            @endforelse
        </div>

    </div>
</div>
@endsection
