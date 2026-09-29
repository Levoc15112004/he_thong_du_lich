@extends('admins.master')

@section('title', 'Quản lý Hỗ trợ Khách hàng')

@section('home')
<div class="min-h-screen bg-slate-50 px-4 sm:px-6 lg:px-8 py-8">
    <div class="max-w-7xl mx-auto space-y-8">

        {{-- HEADER --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between py-4 gap-4">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-teal-400 to-emerald-500 flex items-center justify-center text-white shadow-lg shadow-teal-200 shrink-0">
                    <i class="fa-solid fa-headset text-2xl"></i>
                </div>
                <div>
                    <h4 class="text-2xl sm:text-3xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-teal-700 to-emerald-600">
                        Quản lý Hỗ trợ Khách hàng
                    </h4>
                    <p class="text-sm text-slate-500 mt-1">Theo dõi, kiểm tra và quản lý các phiên chat hỗ trợ trực tuyến</p>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <div class="px-5 py-2.5 bg-white border border-slate-200 rounded-xl shadow-sm flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-teal-50 text-teal-600 flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-comments"></i>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 font-medium">Tổng số phiên</p>
                        <p class="text-sm font-bold text-slate-800">{{ $sessions->total() }} phiên</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- ALERTS --}}
        @if(session('success'))
            <div class="bg-emerald-50/80 backdrop-blur-sm border border-emerald-200 text-emerald-800 px-6 py-4 rounded-2xl flex items-center gap-3 shadow-sm">
                <div class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 shrink-0">
                    <i class="fa-solid fa-check"></i>
                </div>
                <p class="font-medium">{{ session('success') }}</p>
            </div>
        @endif

        {{-- SEARCH & FILTER --}}
        <div class="bg-white/80 backdrop-blur-xl border border-white p-4 sm:p-6 rounded-3xl shadow-xl shadow-slate-100/50">
            <form method="GET" class="flex flex-col sm:flex-row gap-4 items-center">
                <div class="relative flex-1 w-full group">
                    <i class="fa-solid fa-magnifying-glass absolute left-5 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-teal-500 transition-colors"></i>
                    <input type="text"
                           name="search"
                           value="{{ request('search') }}"
                           placeholder="Tìm kiếm Email hoặc tên khách hàng..."
                           class="w-full pl-12 pr-6 py-3.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-700 font-medium focus:ring-4 focus:ring-teal-500/10 focus:border-teal-500 transition-all outline-none placeholder:text-slate-400">
                </div>
                <button type="submit" class="w-full sm:w-auto px-8 py-3.5 bg-gradient-to-r from-teal-500 to-emerald-600 text-white rounded-xl font-bold shadow-lg shadow-teal-200 hover:shadow-xl hover:shadow-teal-300 hover:-translate-y-0.5 transition-all duration-300 flex items-center justify-center gap-2">
                    <i class="fa-solid fa-search"></i> Tìm kiếm
                </button>
            </form>
        </div>

        {{-- DESKTOP TABLE VIEW --}}
        <div class="hidden lg:block bg-white/90 backdrop-blur-xl border border-white shadow-2xl shadow-slate-200/50 rounded-3xl overflow-hidden relative">
            <div class="absolute top-0 right-0 p-32 bg-teal-50/50 rounded-full blur-3xl opacity-50 -z-10 -translate-y-1/2 translate-x-1/2"></div>
            
            <table class="w-full text-left border-collapse relative z-10">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-slate-100">
                        <th class="px-6 py-5 text-sm font-bold text-slate-700 w-16">#</th>
                        <th class="px-6 py-5 text-sm font-bold text-slate-700">Khách hàng</th>
                        <th class="px-6 py-5 text-sm font-bold text-slate-700 text-center">Trạng thái</th>
                        <th class="px-6 py-5 text-sm font-bold text-slate-700 text-center w-40">Bắt đầu / Kết thúc</th>
                        <th class="px-6 py-5 text-sm font-bold text-slate-700 text-center w-36">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($sessions as $index => $session)
                        <tr class="hover:bg-slate-50/80 transition-colors group">
                            
                            <td class="px-6 py-4">
                                <span class="w-8 h-8 rounded-full bg-slate-100 border border-slate-200 text-slate-500 font-bold text-xs flex items-center justify-center group-hover:bg-teal-50 group-hover:text-teal-600 group-hover:border-teal-200 transition-colors">
                                    {{ $sessions->firstItem() + $index }}
                                </span>
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-full overflow-hidden border-2 border-white shadow-md bg-slate-100 flex items-center justify-center shrink-0">
                                        <i class="fa-solid fa-user text-slate-400 text-lg"></i>
                                    </div>
                                    <div>
                                        <h5 class="font-bold text-slate-800 text-base leading-tight group-hover:text-teal-600 transition-colors">{{ $session->user->name ?? 'Không xác định' }}</h5>
                                        <div class="flex items-center gap-1.5 mt-0.5">
                                            <i class="fa-solid fa-envelope text-slate-400 text-xs shrink-0"></i>
                                            <span class="text-xs text-slate-500 font-medium">{{ $session->user->email ?? '---' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-4 text-center">
                                @if($session->status == 1)
                                    <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-emerald-50 border border-emerald-100 rounded-xl shadow-sm">
                                        <span class="relative flex h-2.5 w-2.5">
                                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                            <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500"></span>
                                        </span>
                                        <span class="text-emerald-700 text-xs font-bold whitespace-nowrap">Đang chat</span>
                                    </div>
                                @else
                                    <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-slate-50 border border-slate-200 rounded-xl shadow-sm">
                                        <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-slate-300"></span>
                                        <span class="text-slate-600 text-xs font-bold whitespace-nowrap">Đã kết thúc</span>
                                    </div>
                                @endif
                            </td>

                            <td class="px-6 py-4 text-center">
                                <div class="flex flex-col items-center gap-1">
                                    <span class="text-xs font-bold text-slate-700 bg-slate-50 px-2 py-1 rounded-lg border border-slate-100 tooltip" title="Thời gian bắt đầu"><i class="fa-solid fa-hourglass-start text-emerald-500 mr-1"></i>{{ optional($session->started_at)->format('H:i d/m/y') }}</span>
                                    <span class="text-xs font-bold text-slate-500 bg-slate-50 px-2 py-1 rounded-lg border border-slate-100 tooltip" title="Thời gian kết thúc"><i class="fa-solid fa-flag-checkered text-rose-400 mr-1"></i>{{ $session->ended_at ? $session->ended_at->format('H:i d/m/y') : 'Đang tiếp diễn' }}</span>
                                </div>
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex justify-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <a href="{{ route('admin.chat.show', $session->id) }}"
                                        class="w-10 h-10 flex items-center justify-center text-teal-600 bg-teal-50 border border-teal-200 rounded-xl hover:bg-teal-500 hover:text-white transition-all shadow-sm tooltip" title="Xem chi tiết chat">
                                        <i class="fa-regular fa-comment-dots"></i>
                                    </a>
                                    <form action="{{ route('admin.chat.destroy', $session->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa vĩnh viễn đoạn hội thoại này không?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-10 h-10 flex items-center justify-center text-rose-500 bg-rose-50 border border-rose-200 rounded-xl hover:bg-rose-500 hover:text-white transition-all shadow-sm tooltip" title="Xóa hội thoại">
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
                                    <i class="fa-solid fa-comment-slash text-5xl mb-4 text-slate-300"></i>
                                    <p class="text-lg font-medium">Không tìm thấy phiên hỗ trợ nào.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            
            @if($sessions->hasPages())
                <div class="px-6 py-4 border-t border-slate-50 bg-white relative z-10">
                    {{ $sessions->withQueryString()->links('vendor.pagination.tailwind') }}
                </div>
            @endif
        </div>

        {{-- MOBILE CARDS VIEW --}}
        <div class="lg:hidden space-y-4">
            @forelse($sessions as $session)
                <div class="bg-white/90 backdrop-blur-xl border border-white rounded-3xl shadow-lg shadow-slate-200/50 p-5 relative overflow-hidden group">
                    <div class="absolute top-0 right-0 p-8 bg-teal-50/50 rounded-full blur-2xl -z-10 -translate-y-1/2 translate-x-1/2"></div>
                    
                    <div class="flex items-center justify-between mb-4 pb-4 border-b border-slate-50">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full overflow-hidden border-2 border-white shadow-sm bg-slate-100 flex items-center justify-center shrink-0">
                                <i class="fa-solid fa-user text-slate-400 text-sm"></i>
                            </div>
                            <div>
                                <h5 class="font-bold text-slate-800 text-sm leading-tight group-hover:text-teal-600 transition-colors">{{ $session->user->name ?? 'Không xác định' }}</h5>
                                <span class="text-xs text-slate-500 truncate">{{ $session->user->email ?? '---' }}</span>
                            </div>
                        </div>
                        @if($session->status == 1)
                            <div class="w-2.5 h-2.5 bg-emerald-500 rounded-full shadow-sm shadow-emerald-200 animate-pulse"></div>
                        @else
                            <div class="w-2.5 h-2.5 bg-slate-300 rounded-full"></div>
                        @endif
                    </div>
                    
                    <div class="bg-slate-50/80 p-3 rounded-xl border border-slate-100 space-y-2 mb-4">
                        <div class="flex items-center justify-between text-xs font-semibold text-slate-600">
                            <span class="flex items-center gap-1.5"><i class="fa-solid fa-play text-emerald-500"></i> Bắt đầu:</span>
                            <span>{{ optional($session->started_at)->format('H:i d/m') }}</span>
                        </div>
                        <div class="flex items-center justify-between text-xs font-semibold text-slate-600">
                            <span class="flex items-center gap-1.5"><i class="fa-solid fa-stop text-rose-500"></i> Kết thúc:</span>
                            <span>{{ $session->ended_at ? $session->ended_at->format('H:i d/m') : '---' }}</span>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-3 pt-2">
                        <a href="{{ route('admin.chat.show', $session->id) }}" class="flex items-center justify-center gap-2 bg-teal-50 hover:bg-teal-500 text-teal-600 hover:text-white py-2.5 rounded-xl font-bold transition-colors text-sm border border-teal-100">
                            <i class="fa-regular fa-comment-dots"></i> Chi tiết
                        </a>
                        <form action="{{ route('admin.chat.destroy', $session->id) }}" method="POST" onsubmit="return confirm('Xác nhận xóa hội thoại?')">
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
                    <i class="fa-solid fa-comment-slash text-4xl mb-3 text-slate-300"></i>
                    <p class="text-slate-500 font-medium">Không có dữ liệu hỗ trợ!</p>
                </div>
            @endforelse
            
            @if($sessions->hasPages())
                <div class="pt-2">
                    {{ $sessions->withQueryString()->links('vendor.pagination.tailwind') }}
                </div>
            @endif
        </div>

    </div>
</div>
@endsection
