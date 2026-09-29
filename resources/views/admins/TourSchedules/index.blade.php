@extends('admins.master')

@section('title', 'Danh sách Lịch trình Tour')

@section('home')
<div class="min-h-screen bg-slate-50 px-4 sm:px-6 lg:px-8 py-8">
    <div class="max-w-7xl mx-auto space-y-8">

        {{-- HEADER --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between py-4 gap-4">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-teal-400 to-emerald-500 flex items-center justify-center text-white shadow-lg shadow-teal-200">
                    <i class="fa-solid fa-calendar-days text-2xl"></i>
                </div>
                <div>
                    <h4 class="text-2xl sm:text-3xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-teal-700 to-emerald-600">
                        Danh sách Lịch trình
                    </h4>
                    <p class="text-sm text-slate-500 mt-1">Quản lý chi tiết lịch trình của các chuyến đi</p>
                </div>
            </div>

            <a href="{{ route('admin.tour_schedules.create') }}"
                class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-teal-500 to-emerald-600 text-white font-semibold rounded-xl shadow-lg shadow-teal-200 hover:shadow-xl hover:shadow-teal-300 hover:-translate-y-0.5 transition-all duration-300 group">
                <i class="fa-solid fa-plus text-sm group-hover:rotate-90 transition-transform duration-300"></i>
                <span>Thêm lịch trình mới</span>
            </a>
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

        {{-- FILTER & SEARCH --}}
        <div class="bg-white/80 backdrop-blur-xl border border-white p-6 rounded-3xl shadow-xl shadow-slate-100/50">
            <form method="GET" action="{{ route('admin.tour_schedules.index') }}" class="flex flex-col sm:flex-row gap-4 items-center">
                <div class="relative flex-1 w-full group">
                    <i class="fa-solid fa-magnifying-glass absolute left-5 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-teal-500 transition-colors"></i>
                    <input type="text" name="keyword" value="{{ request('keyword') }}"
                        placeholder="Tìm kiếm theo tên tour, địa điểm, tiêu đề..."
                        class="w-full pl-12 pr-6 py-3.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-700 font-medium focus:ring-4 focus:ring-teal-500/10 focus:border-teal-500 transition-all outline-none placeholder:text-slate-400">
                </div>
                <div class="flex gap-3 w-full sm:w-auto">
                    @if (request('keyword'))
                        <a href="{{ route('admin.tour_schedules.index') }}"
                            class="flex-1 sm:flex-none px-6 py-3.5 bg-slate-100 text-slate-600 rounded-xl font-bold hover:bg-slate-200 transition-all flex items-center justify-center">
                            Xóa lọc
                        </a>
                    @endif
                    <button type="submit"
                        class="flex-1 sm:flex-none px-8 py-3.5 bg-slate-800 text-white rounded-xl font-bold hover:bg-slate-900 transition-all shadow-lg shadow-slate-200">
                        Tìm kiếm
                    </button>
                </div>
            </form>
        </div>

        {{-- DESKTOP TABLE VIEW --}}
        <div class="hidden lg:block bg-white/90 backdrop-blur-xl border border-white shadow-2xl shadow-slate-200/50 rounded-3xl overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-slate-100">
                        <th class="px-6 py-5 text-sm font-bold text-slate-700 w-16 text-center">Ảnh</th>
                        <th class="px-6 py-5 text-sm font-bold text-slate-700">Tên Tour</th>
                        <th class="px-6 py-5 text-sm font-bold text-slate-700 text-center">Ngày</th>
                        <th class="px-6 py-5 text-sm font-bold text-slate-700">Tiêu đề - Địa điểm</th>
                        <th class="px-6 py-5 text-sm font-bold text-slate-700 text-center w-32">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse ($tourSchedules as $schedule)
                        <tr class="hover:bg-slate-50/80 transition-colors group">
                            <td class="px-6 py-4">
                                @if ($schedule->image)
                                    <div class="w-16 h-12 rounded-lg overflow-hidden shadow-sm border border-slate-100 mx-auto">
                                        <img src="{{ asset($schedule->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                    </div>
                                @else
                                    <div class="w-16 h-12 rounded-lg bg-slate-100 flex items-center justify-center text-slate-400 mx-auto">
                                        <i class="fa-solid fa-image text-lg"></i>
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <span class="font-semibold text-slate-800">{{ $schedule->tour->name ?? 'Không có' }}</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-3 py-1 bg-teal-50 text-teal-700 rounded-lg font-bold text-sm border border-teal-100 shadow-sm">
                                    Ngày {{ $schedule->day_number }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-bold text-slate-800">{{ $schedule->title }}</div>
                                <div class="flex items-center gap-2 mt-1 text-sm text-slate-500">
                                    <i class="fa-solid fa-location-dot text-rose-500"></i>
                                    {{ $schedule->location_name ?? '---' }}
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex justify-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <a href="{{ route('admin.tour_schedules.edit', $schedule->id) }}"
                                        class="w-10 h-10 flex items-center justify-center text-amber-500 bg-amber-50 border border-amber-200 rounded-xl hover:bg-amber-500 hover:text-white transition-all shadow-sm">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                    <form action="{{ route('admin.tour_schedules.destroy', $schedule->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa lịch trình này?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="w-10 h-10 flex items-center justify-center text-rose-500 bg-rose-50 border border-rose-200 rounded-xl hover:bg-rose-500 hover:text-white transition-all shadow-sm">
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
                                    <i class="fa-regular fa-calendar-xmark text-5xl mb-4 text-slate-300"></i>
                                    <p class="text-lg font-medium">Chưa có lịch trình nào!</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            @if($tourSchedules->hasPages())
                <div class="px-6 py-4 border-t border-slate-50 bg-slate-50/50">
                    {{ $tourSchedules->links('vendor.pagination.tailwind') }}
                </div>
            @endif
        </div>

        {{-- MOBILE CARDS VIEW --}}
        <div class="lg:hidden space-y-4">
            @forelse ($tourSchedules as $schedule)
                <div class="bg-white/90 backdrop-blur-xl border border-white rounded-3xl shadow-lg shadow-slate-200/50 p-5 relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-8 bg-teal-50/50 rounded-full blur-2xl -z-10 -translate-y-1/2 translate-x-1/2"></div>
                    
                    <div class="flex gap-4">
                        <div class="w-20 h-20 shrink-0 rounded-2xl overflow-hidden shadow-sm border border-slate-100 bg-slate-50">
                            @if ($schedule->image)
                                <img src="{{ asset($schedule->image) }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-slate-400">
                                    <i class="fa-solid fa-image text-xl"></i>
                                </div>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-start justify-between gap-2 mb-1">
                                <span class="px-2.5 py-1 bg-teal-50 text-teal-700 rounded-lg font-bold text-xs border border-teal-100 shrink-0">
                                    Ngày {{ $schedule->day_number }}
                                </span>
                                <span class="text-xs font-semibold text-slate-500 truncate bg-slate-100 px-2 py-1 rounded-md">
                                    {{ $schedule->tour->name ?? 'Không có' }}
                                </span>
                            </div>
                            <h5 class="font-bold text-slate-800 text-base leading-tight mb-1 truncate">{{ $schedule->title }}</h5>
                            <div class="flex items-center gap-1.5 text-xs text-slate-500">
                                <i class="fa-solid fa-location-dot text-rose-500 shrink-0"></i>
                                <span class="truncate">{{ $schedule->location_name ?? '---' }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-3 mt-5 pt-4 border-t border-slate-100">
                        <a href="{{ route('admin.tour_schedules.edit', $schedule->id) }}" class="flex items-center justify-center gap-2 bg-amber-50 hover:bg-amber-500 text-amber-600 hover:text-white py-2.5 rounded-xl font-bold transition-colors text-sm border border-amber-100">
                            <i class="fa-solid fa-pen"></i> Sửa
                        </a>
                        <form action="{{ route('admin.tour_schedules.destroy', $schedule->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa lịch trình này?')">
                            @csrf
                            @method('DELETE')
                            <button class="w-full flex items-center justify-center gap-2 bg-rose-50 hover:bg-rose-500 text-rose-600 hover:text-white py-2.5 rounded-xl font-bold transition-colors text-sm border border-rose-100">
                                <i class="fa-solid fa-trash"></i> Xóa
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="bg-white/80 p-10 rounded-3xl border border-dashed border-slate-300 text-center">
                    <i class="fa-regular fa-calendar-xmark text-4xl mb-3 text-slate-300"></i>
                    <p class="text-slate-500 font-medium">Chưa có lịch trình nào!</p>
                </div>
            @endforelse
            
            @if($tourSchedules->hasPages())
                <div class="pt-2">
                    {{ $tourSchedules->links('vendor.pagination.tailwind') }}
                </div>
            @endif
        </div>

    </div>
</div>
@endsection
