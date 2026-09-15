@extends('admin.master')

@section('content')
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden">

        <!-- Header Topbar -->
        <header class="h-20 bg-surface border-b border-gray-100 flex items-center justify-between px-6 lg:px-10 z-10 hidden md:flex flex-shrink-0">
            <div class="flex items-center flex-1">
                <button class="md:hidden text-gray-500 hover:text-primary mr-4 focus:outline-none">
                    <i class="fa-solid fa-bars text-xl"></i>
                </button>
                <h2 class="text-xl font-bold text-dark hidden sm:block">Quản Lý Chi Tiết (Lộ Trình) Tour</h2>
            </div>

            <div class="flex items-center space-x-4">
                <button class="w-10 h-10 rounded-full bg-gray-50 text-gray-500 flex items-center justify-center hover:bg-gray-100 hover:text-primary transition-colors relative">
                    <i class="fa-regular fa-bell"></i>
                </button>
                <div class="h-8 w-px bg-gray-200"></div>
                <div class="relative group cursor-pointer pb-2">
                    <div class="flex items-center">
                        <img src="https://i.pravatar.cc/150?img=11" alt="Admin" class="w-9 h-9 rounded-full border-2 border-white shadow-sm">
                        <span class="ml-2 text-sm font-bold text-dark hidden sm:block">{{ Auth::check() ? Auth::user()->name : 'Admin' }}</span>
                    </div>
                    <!-- Dropdown -->
                    <div class="absolute right-0 top-full w-48 bg-white border border-gray-100 rounded-xl shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50 overflow-hidden">
                        <form action="{{ route('logout.admin') }}" method="POST" class="block">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-3 text-sm text-red-600 hover:bg-red-50 flex items-center font-medium">
                                <i class="fa-solid fa-arrow-right-from-bracket mr-2"></i> Đăng xuất
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Scrollable Area -->
        <main class="flex-1 overflow-x-hidden overflow-y-auto p-6 lg:p-10 relative">
            <div class="block">

                <!-- Toolbar: Search & Filters -->
                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 mb-6">
                    <div class="flex flex-col sm:flex-row gap-3 flex-1">
                        <div class="relative w-full sm:w-80">
                            <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <input type="text" placeholder="Tìm tên địa điểm, lịch trình..." class="w-full bg-white border border-gray-200 rounded-xl py-2.5 pl-10 pr-4 text-sm text-dark focus:outline-none focus:border-primary admin-input transition-all">
                        </div>
                        <select class="bg-white border border-gray-200 rounded-xl py-2.5 px-4 text-sm text-gray-600 focus:outline-none focus:border-primary admin-input transition-all w-full sm:w-auto">
                            <option value="">-- Lọc theo Tour --</option>
                            <option value="1">Tour Khám phá Vịnh Hạ Long</option>
                            <option value="2">Tour Khám phá Sapa</option>
                        </select>
                    </div>

                    <a href="{{ route('admin.tour_schedules.create') }}" class="bg-dark text-white font-medium px-5 py-2.5 rounded-xl hover:bg-gray-800 transition-colors shadow-soft flex items-center justify-center flex-shrink-0 cursor-pointer">
                        <i class="fa-solid fa-plus mr-2"></i> Thêm Lịch Trình
                    </a>
                </div>

                <!-- Table -->
                <div class="bg-white rounded-2xl border border-gray-100 shadow-card overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse min-w-[1000px]">
                            <thead>
                                <tr class="bg-gray-50/80 text-xs uppercase text-gray-500 font-bold tracking-wider border-b border-gray-100">
                                    <th class="py-4 px-6 w-16 text-center">ID</th>
                                    <th class="py-4 px-6">Tour Thuộc Về</th>
                                    <th class="py-4 px-6 text-center">Ngày số</th>
                                    <th class="py-4 px-6">Lộ trình (Title / Location)</th>
                                    <th class="py-4 px-6 text-center">Bản đồ (Map)</th>
                                    <th class="py-4 px-6 text-center">Hành động</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm divide-y divide-gray-50">
                                @forelse($tour_details as $item)
                                <tr class="hover:bg-sky-50/30 transition-colors group">
                                    <td class="py-4 px-6 text-center text-gray-400 font-medium">#{{ $item->id }}</td>
                                    <td class="py-4 px-6">
                                        <p class="font-bold text-dark text-sm mb-0.5 line-clamp-1">{{ $item->tour ? $item->tour->name : 'N/A' }}</p>
                                        <p class="text-[10px] text-gray-400 font-mono">ID Tour: #{{ $item->tour_id }}</p>
                                    </td>
                                    <td class="py-4 px-6 text-center">
                                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-primary text-white font-bold">Ngày {{ $item->day_number }}</span>
                                    </td>
                                    <td class="py-4 px-6">
                                        <div class="flex items-center">
                                            @if($item->image)
                                                <img src="{{ Str::startsWith($item->image, 'http') ? $item->image : asset($item->image) }}" alt="Thumbnail" class="w-12 h-12 rounded object-cover mr-4 border border-gray-100 shadow-sm">
                                            @else
                                                <div class="w-12 h-12 rounded bg-gray-100 flex items-center justify-center mr-4 text-gray-400 border border-gray-200 border-dashed">
                                                    <i class="fa-regular fa-image"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <p class="font-bold text-dark text-sm mb-0.5 transition-colors cursor-pointer group-hover:text-primary">{{ $item->title }}</p>
                                                <p class="text-xs text-gray-500"><i class="fa-solid fa-location-dot text-gray-400 mr-1 text-[10px]"></i> {{ $item->location_name }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4 px-6 text-center">
                                        @if($item->map_link || ($item->latitude && $item->longitude))
                                            <a href="{{ $item->map_link ?? '#' }}" class="text-emerald-500 hover:text-emerald-600" title="Đã có tọa độ" target="_blank"><i class="fa-solid fa-map-location-dot text-lg"></i></a>
                                        @else
                                            <span class="text-gray-300"><i class="fa-solid fa-map-location-dot text-lg"></i></span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-6 text-center">
                                        <div class="flex items-center justify-center space-x-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                            <a href="{{ route('admin.tour_schedules.edit', $item->id) }}" class="w-8 h-8 rounded-lg bg-sky-50 text-primary flex items-center justify-center hover:bg-primary hover:text-white transition-colors cursor-pointer" title="Sửa">
                                                <i class="fa-solid fa-pen text-sm"></i>
                                            </a>
                                            <form action="{{ route('admin.tour_schedules.destroy', $item->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Bạn có chắc chắn muốn xóa lộ trình này?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="w-8 h-8 rounded-lg bg-red-50 text-red-500 flex items-center justify-center hover:bg-red-500 hover:text-white transition-colors" title="Xóa">
                                                    <i class="fa-solid fa-trash-can text-sm"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="py-8 text-center text-gray-500">
                                        Không có dữ liệu lịch trình nào.
                                    </td>
                                </tr>
                                @endforelse

                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="px-6 py-4 border-t border-gray-50 flex items-center justify-between">
                        {{ $tour_details->links('pagination::tailwind') }}
                    </div>
                </div>
            </div>
        </main>
    </div>
@endsection
