@extends('admin.master')

@section('content')
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden">

        <!-- Header Topbar -->
        <header class="h-20 bg-surface border-b border-gray-100 flex items-center justify-between px-6 lg:px-10 z-10 hidden md:flex flex-shrink-0">
            <!-- Left: Mobile menu button & Search -->
            <div class="flex items-center flex-1">
                <button class="md:hidden text-gray-500 hover:text-primary mr-4 focus:outline-none">
                    <i class="fa-solid fa-bars text-xl"></i>
                </button>
                <h2 class="text-xl font-bold text-dark hidden sm:block">Quản Lý Danh Mục Tour</h2>
            </div>

            <!-- Right: Admin Profile -->
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

            <!-- ================= VIEW 1: DANH SÁCH TOUR ================= -->
            <div class="block">

                <!-- Toolbar: Search, Filters, Add Button -->
                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 mb-6">
                    <!-- Search & Filter -->
                    <div class="flex flex-col sm:flex-row gap-3 flex-1">
                        <div class="relative w-full sm:w-80">
                            <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <input type="text" placeholder="Tìm kiếm tên tour, điểm đến..." class="w-full bg-white border border-gray-200 rounded-xl py-2.5 pl-10 pr-4 text-sm text-dark focus:outline-none focus:border-primary admin-input transition-all">
                        </div>
                        <select class="bg-white border border-gray-200 rounded-xl py-2.5 px-4 text-sm text-gray-600 focus:outline-none focus:border-primary admin-input transition-all w-full sm:w-auto">
                            <option value="">Tất cả danh mục</option>
                            <option value="sea">Biển đảo</option>
                            <option value="mountain">Vùng núi</option>
                            <option value="culture">Văn hóa</option>
                        </select>
                    </div>

                    <!-- Add New Button -->
                    <a href="{{ route('admin.tours.create') }}" class="bg-dark text-white font-medium px-5 py-2.5 rounded-xl hover:bg-gray-800 transition-colors shadow-soft flex items-center justify-center flex-shrink-0 cursor-pointer">
                        <i class="fa-solid fa-plus mr-2"></i> Thêm Tour Mới
                    </a>
                </div>

                <!-- Data Table -->
                <div class="bg-white rounded-2xl border border-gray-100 shadow-card overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse min-w-[800px]">
                            <thead>
                                <tr class="bg-gray-50/80 text-xs uppercase text-gray-500 font-bold tracking-wider border-b border-gray-100">
                                    <th class="py-4 px-6 w-20 text-center whitespace-nowrap">ID</th>
                                    <th class="py-4 px-6 min-w-[300px] whitespace-nowrap">Thông tin Tour</th>
                                    <th class="py-4 px-6 whitespace-nowrap">Danh mục</th>
                                    <th class="py-4 px-6 text-right whitespace-nowrap">Giá bán</th>
                                    <th class="py-4 px-6 text-center whitespace-nowrap">Trạng thái</th>
                                    <th class="py-4 px-6 text-center whitespace-nowrap">Hành động</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm divide-y divide-gray-50">
                                @forelse($tours as $tour)
                                <!-- Tour Item -->
                                <tr class="hover:bg-sky-50/30 transition-colors group {{ $tour->status != 1 ? 'bg-gray-50/30' : '' }}">
                                    <td class="py-4 px-6 text-center text-gray-400 font-medium whitespace-nowrap">{{ str_pad($tour->id, 3, '0', STR_PAD_LEFT) }}</td>
                                    <td class="py-4 px-6 min-w-[250px]">
                                        <div class="flex items-center">
                                            @if($tour->image)
                                                <img src="{{ Str::startsWith($tour->image, 'http') ? $tour->image : asset($tour->image) }}" alt="Tour" class="w-12 h-12 rounded-lg object-cover mr-4 border border-gray-100 shadow-sm {{ $tour->status != 1 ? 'opacity-60' : '' }}">
                                            @else
                                                <div class="w-12 h-12 rounded-lg bg-gray-200 mr-4 border border-gray-100 flex items-center justify-center text-gray-400 {{ $tour->status != 1 ? 'opacity-60' : '' }}">No Img</div>
                                            @endif
                                            <div>
                                                <p class="font-bold {{ $tour->status != 1 ? 'text-gray-500' : 'text-dark' }} text-base mb-0.5 line-clamp-1 group-hover:text-primary transition-colors cursor-pointer">{{ $tour->name }}</p>
                                                <p class="text-xs {{ $tour->status != 1 ? 'text-gray-400' : 'text-gray-500' }}"><i class="fa-solid fa-clock {{ $tour->status != 1 ? 'text-gray-300' : 'text-gray-400' }} mr-1"></i> {{ $tour->time  }} </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4 px-6 whitespace-nowrap"><span class="{{ $tour->status != 1 ? 'text-gray-400' : 'text-gray-600' }} font-medium">{{ $tour->category->name ?? 'N/A' }}</span></td>
                                    <td class="py-4 px-6 text-right whitespace-nowrap">
                                        <p class="font-bold {{ $tour->status != 1 ? 'text-gray-400' : 'text-emerald-600' }} text-base">{{ number_format($tour->sale_price ?? 0, 0, ',', '.') }}đ</p>
                                    </td>
                                    <td class="py-4 px-6 text-center whitespace-nowrap">
                                        @if($tour->status == 1 || $tour->status == '1')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-700 uppercase">Đang mở bán</span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-gray-200 text-gray-600 uppercase">Tạm ngưng</span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-6 whitespace-nowrap">
                                        <div class="flex items-center justify-center space-x-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                            <a href="{{ route('admin.tours.edit', $tour->id) }}" class="w-8 h-8 rounded-lg bg-sky-50 text-primary flex items-center justify-center hover:bg-primary hover:text-white transition-colors cursor-pointer" title="Sửa">
                                                <i class="fa-solid fa-pen text-sm"></i>
                                            </a>
                                            <form action="{{ route('admin.tours.destroy', $tour->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Bạn có chắc chắn muốn xóa tour này?')">
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
                                    <td colspan="6" class="py-8 text-center text-gray-500">Chưa có tour nào</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="px-6 py-4 border-t border-gray-50 flex flex-col sm:flex-row items-center justify-between">
                        <p class="text-sm text-gray-500">Hiển thị {{ $tours->firstItem() ?? 0 }} đến {{ $tours->lastItem() ?? 0 }} trong số {{ $tours->total() }} tour</p>
                        <div class="mt-4 sm:mt-0">
                            {{ $tours->links('pagination::tailwind') }}
                        </div>
                    </div>
                </div>
            </div>

        </main>
    </div>
@endsection
