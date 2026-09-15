@extends('admin.master')

@section('content')
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden">

        <!-- Header Topbar -->
        <header class="h-20 bg-surface border-b border-gray-100 flex items-center justify-between px-6 lg:px-10 z-10 hidden md:flex flex-shrink-0">
            <div class="flex items-center flex-1">
                <button class="md:hidden text-gray-500 hover:text-primary mr-4 focus:outline-none">
                    <i class="fa-solid fa-bars text-xl"></i>
                </button>
                <h2 class="text-xl font-bold text-dark hidden sm:block">Quản Lý Voucher Khuyến Mãi</h2>
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

                <!-- Dashboard Stats cho Voucher -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <!-- Tổng Voucher -->
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 font-medium mb-1">Tổng Voucher Đã Tạo</p>
                            <h3 class="text-3xl font-black text-dark">{{ $totalVouchers }}</h3>
                            <p class="text-[11px] text-gray-400 mt-2">Tính từ khi hệ thống hoạt động</p>
                        </div>
                        <div class="w-14 h-14 rounded-full bg-sky-50 text-primary flex items-center justify-center text-2xl">
                            <i class="fa-solid fa-ticket"></i>
                        </div>
                    </div>

                    <!-- Voucher Đang Hoạt Động -->
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-emerald-100 flex items-center justify-between relative overflow-hidden">
                        <div class="absolute right-0 top-0 w-2 h-full bg-emerald-500"></div>
                        <div>
                            <p class="text-sm text-gray-500 font-medium mb-1">Đang Hoạt Động (Active)</p>
                            <h3 class="text-3xl font-black text-emerald-600">{{ $activeVouchers }}</h3>
                            <p class="text-[11px] text-gray-400 mt-2">Voucher còn hạn & đang bật</p>
                        </div>
                        <div class="w-14 h-14 rounded-full bg-emerald-50 text-emerald-500 flex items-center justify-center text-2xl">
                            <i class="fa-solid fa-bolt"></i>
                        </div>
                    </div>

                    <!-- Voucher Dừng Hoạt Động -->
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-red-100 flex items-center justify-between relative overflow-hidden">
                        <div class="absolute right-0 top-0 w-2 h-full bg-red-400"></div>
                        <div>
                            <p class="text-sm text-gray-500 font-medium mb-1">Dừng / Hết Hạn</p>
                            <h3 class="text-3xl font-black text-red-500">{{ $inactiveVouchers }}</h3>
                            <p class="text-[11px] text-gray-400 mt-2">Voucher đã tắt hoặc quá hạn</p>
                        </div>
                        <div class="w-14 h-14 rounded-full bg-red-50 text-red-400 flex items-center justify-center text-2xl">
                            <i class="fa-solid fa-ban"></i>
                        </div>
                    </div>
                </div>

                <!-- Toolbar: Search & Filters -->
                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 mb-6">
                    <div class="flex flex-col sm:flex-row gap-3 flex-1">
                        <div class="relative w-full sm:w-80">
                            <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <input type="text" placeholder="Tìm tên mã code, tên khuyến mãi..." class="w-full bg-white border border-gray-200 rounded-xl py-2.5 pl-10 pr-4 text-sm text-dark focus:outline-none focus:border-primary admin-input transition-all">
                        </div>
                        <select class="bg-white border border-gray-200 rounded-xl py-2.5 px-4 text-sm text-gray-600 focus:outline-none focus:border-primary admin-input transition-all w-full sm:w-auto">
                            <option value="">Tất cả trạng thái</option>
                            <option value="1">Đang hoạt động</option>
                            <option value="0">Dừng hoạt động</option>
                        </select>
                    </div>

                    <a href="{{ route('admin.vouchers.create') }}" class="bg-dark text-white font-medium px-5 py-2.5 rounded-xl hover:bg-gray-800 transition-colors shadow-soft flex items-center justify-center flex-shrink-0 cursor-pointer">
                        <i class="fa-solid fa-plus mr-2"></i> Tạo Voucher Mới
                    </a>
                </div>

                <!-- Table -->
                <div class="bg-white rounded-2xl border border-gray-100 shadow-card overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse min-w-[1000px]">
                            <thead>
                                <tr class="bg-gray-50/80 text-xs uppercase text-gray-500 font-bold tracking-wider border-b border-gray-100">
                                    <th class="py-4 px-6">Mã & Tên Voucher</th>
                                    <th class="py-4 px-6 text-center">Kiểu giảm</th>
                                    <th class="py-4 px-6 text-right">Giá trị (Min|Max)</th>
                                    <th class="py-4 px-6 text-center">Đã Dùng / Số Lượng</th>
                                    <th class="py-4 px-6 text-center">Thời hạn</th>
                                    <th class="py-4 px-6 text-center">Status</th>
                                    <th class="py-4 px-6 text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm divide-y divide-gray-50">

                                @forelse($vouchers as $item)
                                <tr class="hover:bg-sky-50/30 transition-colors group">
                                    <td class="py-4 px-6">
                                        <div class="flex flex-col">
                                            <span class="inline-flex font-mono text-xs font-bold text-primary bg-sky-50 border border-sky-100 px-2 py-1 rounded w-fit mb-1">{{ $item->code }}</span>
                                            <span class="font-bold text-dark text-sm line-clamp-1">{{ $item->name }}</span>
                                        </div>
                                    </td>
                                    <td class="py-4 px-6 text-center">
                                        <span class="text-xs font-bold text-gray-500 bg-gray-100 px-2 py-1 rounded">{{ $item->discount_type == 'percent' ? '% (%)' : 'Giá (VNĐ)' }}</span>
                                    </td>
                                    <td class="py-4 px-6 text-right">
                                        <p class="font-bold {{ $item->discount_type == 'percent' ? 'text-dark' : 'text-emerald-600' }}">-{{ $item->discount_type == 'percent' ? $item->discount_value . '%' : number_format($item->discount_value, 0, ',', '.') . 'đ' }}</p>
                                        <div class="text-[10px] text-gray-400 mt-1">
                                            @if($item->max_discount)
                                                Tối đa: {{ number_format($item->max_discount, 0, ',', '.') }}đ |
                                            @endif
                                            @if($item->min_order_value)
                                                Đơn từ: {{ number_format($item->min_order_value, 0, ',', '.') }}đ
                                            @endif
                                        </div>
                                    </td>
                                    <td class="py-4 px-6 text-center">
                                        <div class="flex flex-col items-center">
                                            <span class="font-bold text-dark">{{ (int)$item->used_count }} / {{ $item->quantity }}</span>
                                            <div class="w-full h-1.5 bg-gray-100 rounded-full mt-1.5 overflow-hidden">
                                                @php $percent = $item->quantity > 0 ? ((int)$item->used_count / $item->quantity) * 100 : 0; @endphp
                                                <div class="h-full {{ $percent >= 100 ? 'bg-red-500' : 'bg-primary' }} rounded-full" style="width: {{ $percent }}%"></div>
                                            </div>
                                            @if($percent >= 100)
                                                <span class="text-[10px] text-red-500 font-bold mt-1">Đã hết lượt</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="py-4 px-6 text-center">
                                        <p class="text-xs text-gray-600">{{ \Carbon\Carbon::parse($item->start_date)->format('d/m/Y') }}</p>
                                        <p class="text-[10px] text-gray-400">đến {{ \Carbon\Carbon::parse($item->end_date)->format('d/m/Y') }}</p>
                                    </td>
                                    <td class="py-4 px-6 text-center">
                                        @if($item->status == 1)
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-700 uppercase">Hoạt động</span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-red-100 text-red-700 uppercase">Dừng HĐ</span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-6 text-center">
                                        <div class="flex items-center justify-center space-x-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                            <a href="{{ route('admin.vouchers.edit', $item->id) }}" class="w-8 h-8 rounded-lg bg-sky-50 text-primary flex items-center justify-center hover:bg-primary hover:text-white transition-colors cursor-pointer" title="Sửa">
                                                <i class="fa-solid fa-pen text-sm"></i>
                                            </a>
                                            <form action="{{ route('admin.vouchers.destroy', $item->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Bạn có chắc chắn muốn xóa?')">
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
                                    <td colspan="7" class="py-8 text-center text-gray-500">
                                        Không có dữ liệu khuyến mãi nào.
                                    </td>
                                </tr>
                                @endforelse

                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="px-6 py-4 border-t border-gray-50 flex items-center justify-between">
                        {{ $vouchers->links('pagination::tailwind') }}
                    </div>
                </div>

            </div>
        </main>
    </div>
@endsection
