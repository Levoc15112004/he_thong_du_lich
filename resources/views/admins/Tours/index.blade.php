@extends('admins.master')

@section('title', 'Quản lý Tour du lịch')

@section('home')
<div class="min-h-screen bg-slate-50 px-4 sm:px-6 lg:px-8 py-8">
    <div class="max-w-[120rem] mx-auto space-y-8">

        {{-- Header & Actions --}}
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-teal-400 to-emerald-500 flex items-center justify-center text-white shadow-lg shadow-teal-200">
                    <i class="fa-solid fa-map-location-dot text-lg"></i>
                </div>
                <div>
                    <h4 class="text-2xl sm:text-3xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-teal-700 to-emerald-600">
                        Danh sách Tour
                    </h4>
                    <p class="text-sm text-slate-500 mt-1">Quản lý các chuyến đi và lộ trình du lịch</p>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row items-center gap-3">
                <form action="" method="GET" class="relative w-full sm:w-auto">
                    <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="Tìm tên, địa điểm..."
                           class="w-full sm:w-64 pl-10 pr-4 py-3 bg-white border border-slate-200 rounded-xl text-sm font-medium text-slate-700 focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 transition-all shadow-sm">
                    <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    @if(request('status') !== null) <input type="hidden" name="status" value="{{ request('status') }}"> @endif
                </form>

                <form action="" method="GET" class="w-full sm:w-auto min-w-[150px] relative">
                    <select name="status" onchange="this.form.submit()" class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-sm font-medium text-slate-700 focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 transition-all shadow-sm cursor-pointer appearance-none">
                        <option value="">Tất cả trạng thái</option>
                        <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Đang hoạt động</option>
                        <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Đã ẩn</option>
                    </select>
                    <i class="fa-solid fa-angle-down absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none"></i>
                    @if(request('keyword')) <input type="hidden" name="keyword" value="{{ request('keyword') }}"> @endif
                </form>

                <a href="{{ route('admin.tours.create') }}" class="w-full sm:w-auto flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-teal-500 to-emerald-600 hover:from-teal-600 hover:to-emerald-700 text-white font-semibold rounded-xl shadow-lg shadow-teal-200/50 hover:shadow-xl hover:shadow-teal-300/50 hover:-translate-y-0.5 transition-all duration-300 group">
                    <i class="fa-solid fa-plus text-sm group-hover:rotate-90 transition-transform"></i>
                    <span>Tạo Tour mới</span>
                </a>
            </div>
        </div>

        {{-- Desktop Table --}}
        <div class="hidden lg:block bg-white/80 backdrop-blur-xl border border-white shadow-2xl shadow-slate-200/50 rounded-3xl overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-100">
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Thông tin Tour</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-center">Giá bán</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-center">Thời gian</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-center">Số chỗ</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-center">Trạng thái</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-right">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($tours as $tour)
                        <tr class="hover:bg-slate-50/50 transition-colors group">
                            <td class="px-6 py-5">
                                <div class="flex items-center gap-5">
                                    <div class="w-24 h-24 rounded-2xl overflow-hidden shadow-md shadow-slate-200 shrink-0 border border-slate-100 relative group-hover:shadow-lg transition-all">
                                        <img src="{{ asset($tour->image) }}" onerror="this.src='/default.png'" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                    </div>
                                    <div class="flex flex-col min-w-0 max-w-md">
                                        <a href="{{ route('admin.tours.edit', $tour->id) }}" class="text-base font-bold text-slate-800 hover:text-teal-600 transition-colors line-clamp-2 mb-2 leading-snug">
                                            {{ $tour->name }}
                                        </a>
                                        <div class="flex items-center gap-2 text-[11px] font-semibold text-slate-500 bg-slate-100 w-fit px-3 py-1.5 rounded-lg border border-slate-200">
                                            <span>{{ $tour->start_location }}</span>
                                            <i class="fa-solid fa-arrow-right-long text-slate-400"></i>
                                            <span>{{ $tour->end_location }}</span>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-5 text-center">
                                <span class="inline-block text-sm font-bold text-teal-600 bg-teal-50 px-3 py-1.5 rounded-xl border border-teal-100/50 shadow-sm">{{ number_format($tour->sale_price) }}đ</span>
                            </td>
                            <td class="px-6 py-5 text-center">
                                <span class="text-sm font-medium text-slate-600">{{ $tour->time ?? '---' }}</span>
                            </td>
                            <td class="px-6 py-5 text-center">
                                <div class="inline-flex flex-col items-center">
                                    <span class="text-lg font-bold text-slate-700 leading-none">{{ $tour->quantity ?? '0' }}</span>
                                    <span class="text-[10px] uppercase tracking-wider font-semibold text-slate-400 mt-1">Khách</span>
                                </div>
                            </td>
                            <td class="px-6 py-5 text-center">
                                @php
                                    $statusConfig = [
                                        1 => ['class' => 'bg-emerald-50 text-emerald-600 border-emerald-200', 'icon' => 'fa-circle-check', 'text' => 'Hoạt động'],
                                        0 => ['class' => 'bg-slate-50 text-slate-500 border-slate-200', 'icon' => 'fa-eye-slash', 'text' => 'Đã ẩn']
                                    ];
                                    $cfg = $statusConfig[$tour->status] ?? ['class' => 'bg-amber-50 text-amber-600 border-amber-200', 'icon' => 'fa-clock', 'text' => 'Chờ duyệt'];
                                @endphp
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-bold border {{ $cfg['class'] }}">
                                    <i class="fa-solid {{ $cfg['icon'] }}"></i> {{ $cfg['text'] }}
                                </span>
                            </td>
                            <td class="px-6 py-5 text-right">
                                <div class="flex justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <a href="{{ route('admin.tours.edit', $tour->id) }}" 
                                       class="w-10 h-10 flex items-center justify-center text-teal-600 bg-teal-50 hover:bg-teal-500 hover:text-white rounded-xl transition-all duration-300 hover:shadow-lg hover:shadow-teal-200/50" title="Chỉnh sửa">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <form action="{{ route('admin.tours.destroy', $tour->id) }}" method="POST" onsubmit="return confirm('Xác nhận xóa Tour này? Mọi dữ liệu liên quan sẽ bị ảnh hưởng.');">
                                        @csrf @method('DELETE')
                                        <button class="w-10 h-10 flex items-center justify-center text-rose-500 bg-rose-50 hover:bg-rose-500 hover:text-white rounded-xl transition-all duration-300 hover:shadow-lg hover:shadow-rose-200/50" title="Xóa">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-20 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-20 h-20 mb-4 rounded-full bg-slate-50 flex items-center justify-center text-slate-400">
                                        <i class="fa-solid fa-suitcase-rolling text-3xl"></i>
                                    </div>
                                    <h5 class="text-base font-semibold text-slate-600">Không tìm thấy tour nào</h5>
                                    <p class="text-sm text-slate-400 mt-1">Vui lòng thử nghiệm tính năng tìm kiếm hoặc thêm mới.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            
            @if($tours->hasPages())
                <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/30">
                    {{ $tours->appends(request()->query())->links('pagination::tailwind') }}
                </div>
            @endif
        </div>

        {{-- Mobile Cards --}}
        <div class="lg:hidden space-y-4">
            @forelse($tours as $tour)
                <div class="bg-white/80 backdrop-blur-md rounded-3xl p-4 shadow-lg shadow-slate-200/50 border border-white relative overflow-hidden group">
                    <div class="absolute top-0 right-0 max-w-[50%] p-1 bg-white/50 backdrop-blur-xl rounded-bl-2xl border-b border-l border-white shadow-sm z-10">
                         @php
                            $statusConfig = [
                                1 => ['class' => 'bg-emerald-500', 'text' => 'Hiển thị'],
                                0 => ['class' => 'bg-slate-400', 'text' => 'Ẩn']
                            ];
                            $cfg = $statusConfig[$tour->status] ?? ['class' => 'bg-amber-500', 'text' => 'Chờ'];
                        @endphp
                        <span class="flex items-center gap-1.5 text-[10px] font-bold uppercase tracking-widest text-white {{ $cfg['class'] }} px-2.5 py-1.5 rounded-xl shadow-inner">
                            <span class="w-1.5 h-1.5 rounded-full bg-white animate-pulse"></span> {{ $cfg['text'] }}
                        </span>
                    </div>

                    <div class="flex gap-4">
                        <div class="w-28 h-28 rounded-2xl overflow-hidden shrink-0 shadow-md border border-slate-100">
                            <img src="{{ asset($tour->image) }}" onerror="this.src='/default.png'" class="w-full h-full object-cover">
                        </div>
                        <div class="flex-1 min-w-0 pt-1 flex flex-col justify-between py-1">
                            <div>
                                <h3 class="font-bold text-slate-800 leading-tight mb-2 line-clamp-2 text-sm">{{ $tour->name }}</h3>
                                <div class="flex items-center gap-1 text-[11px] font-medium text-slate-500 mb-2">
                                    <i class="fa-solid fa-location-dot text-slate-300"></i>
                                    <span class="truncate">{{ $tour->start_location }} - {{ $tour->end_location }}</span>
                                </div>
                            </div>
                            <span class="text-sm font-bold text-teal-600 bg-teal-50 w-fit px-2 py-1 rounded-lg border border-teal-100">{{ number_format($tour->sale_price) }}đ</span>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3 mt-4">
                        <div class="bg-slate-50 rounded-2xl p-3 flex flex-col items-center justify-center border border-slate-100">
                            <span class="text-[10px] font-semibold text-slate-400 uppercase tracking-widest mb-1">Thời gian</span>
                            <span class="text-xs font-bold text-slate-700">{{ $tour->time ?? '---' }}</span>
                        </div>
                        <div class="bg-slate-50 rounded-2xl p-3 flex flex-col items-center justify-center border border-slate-100">
                            <span class="text-[10px] font-semibold text-slate-400 uppercase tracking-widest mb-1">Số chỗ</span>
                            <span class="text-xs font-bold text-slate-700">{{ $tour->quantity ?? '0' }} Khách</span>
                        </div>
                    </div>

                    <div class="flex gap-3 mt-4 pt-4 border-t border-slate-100">
                        <a href="{{ route('admin.tours.edit', $tour->id) }}" class="flex-1 py-3 flex items-center justify-center gap-2 bg-slate-50 hover:bg-teal-50 text-teal-600 rounded-xl text-xs font-bold transition-colors border border-slate-100">
                            <i class="fa-solid fa-pen-to-square"></i> Cập nhật
                        </a>
                        <form action="{{ route('admin.tours.destroy', $tour->id) }}" method="POST" class="flex-1">
                            @csrf @method('DELETE')
                            <button class="w-full py-3 flex items-center justify-center gap-2 bg-slate-50 hover:bg-rose-50 text-rose-500 rounded-xl text-xs font-bold transition-colors border border-slate-100" onclick="return confirm('Xác nhận xóa?')">
                                <i class="fa-solid fa-trash-can"></i> Xóa
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="text-center p-8 bg-white rounded-3xl shadow-sm border border-slate-100">
                    <p class="text-sm font-medium text-slate-500">Chưa có dữ liệu tour phù hợp.</p>
                </div>
            @endforelse

            @if($tours->hasPages())
                <div class="mt-4 flex justify-center">
                    {{ $tours->appends(request()->query())->links('pagination::tailwind') }}
                </div>
            @endif
        </div>

    </div>
</div>
@endsection
