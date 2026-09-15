@extends('admin.master')

@section('content')
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden">

        <!-- Header Topbar -->
        <header class="h-20 bg-surface border-b border-gray-100 flex items-center justify-between px-6 lg:px-10 z-10 hidden md:flex flex-shrink-0">
            <div class="flex items-center flex-1">
                <button class="md:hidden text-gray-500 hover:text-primary mr-4 focus:outline-none">
                    <i class="fa-solid fa-bars text-xl"></i>
                </button>
                <h2 class="text-xl font-bold text-dark hidden sm:block">Quản Lý Đơn Đặt Tour (Orders)</h2>
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
                            <input type="text" placeholder="Tìm tên khách, mã order, sđt..." class="w-full bg-white border border-gray-200 rounded-xl py-2.5 pl-10 pr-4 text-sm text-dark focus:outline-none focus:border-primary admin-input transition-all">
                        </div>
                        <select class="bg-white border border-gray-200 rounded-xl py-2.5 px-4 text-sm text-gray-600 focus:outline-none focus:border-primary admin-input transition-all w-full sm:w-auto">
                            <option value="">Tất cả trạng thái</option>
                            <option value="0">Chờ xác nhận (0)</option>
                            <option value="1">Đã xác nhận (1)</option>
                            <option value="2">Hoàn thành (2)</option>
                            <option value="3">Đã hủy (3)</option>
                        </select>
                        <input type="date" class="bg-white border border-gray-200 rounded-xl py-2.5 px-4 text-sm text-gray-600 focus:outline-none focus:border-primary admin-input transition-all w-full sm:w-auto" title="Lọc theo ngày đặt">
                    </div>
                </div>

                <!-- Table -->
                <div class="bg-white rounded-2xl border border-gray-100 shadow-card overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse min-w-[1000px]">
                            <thead>
                                <tr class="bg-gray-50/80 text-xs uppercase text-gray-500 font-bold tracking-wider border-b border-gray-100">
                                    <th class="py-4 px-6 w-24 text-center whitespace-nowrap">Mã Order</th>
                                    <th class="py-4 px-6 whitespace-nowrap">Khách hàng</th>
                                    <th class="py-4 px-6 min-w-[250px]">Chuyến đi (Tour)</th>
                                    <th class="py-4 px-6 text-center whitespace-nowrap">Số lượng</th>
                                    <th class="py-4 px-6 text-right whitespace-nowrap">Tổng tiền</th>
                                    <th class="py-4 px-6 text-center whitespace-nowrap">Trạng thái</th>
                                    <th class="py-4 px-6 text-center whitespace-nowrap">Hành động</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm divide-y divide-gray-50">
                                @forelse($orders as $order)
                                <tr class="hover:bg-sky-50/30 transition-colors group {{ $order->status == 3 ? 'bg-gray-50/30' : '' }}">
                                    <td class="py-4 px-6 text-center whitespace-nowrap">
                                        <span class="font-bold {{ $order->status == 3 ? 'text-gray-500' : 'text-dark' }}">#ORD-{{ str_pad($order->id, 3, '0', STR_PAD_LEFT) }}</span>
                                        <p class="text-[10px] text-gray-400 mt-1">{{ optional($order->created_at)->format('d/m/Y') }}</p>
                                    </td>
                                    <td class="py-4 px-6 whitespace-nowrap">
                                        <p class="font-bold {{ $order->status == 3 ? 'text-gray-500' : 'text-dark' }} text-sm">{{ $order->name }}</p>
                                        <p class="text-xs {{ $order->status == 3 ? 'text-gray-400' : 'text-gray-500' }}"><i class="fa-solid fa-phone {{ $order->status == 3 ? 'text-gray-300' : 'text-gray-400' }} mr-1 text-[10px]"></i> {{ $order->phone }}</p>
                                    </td>
                                    <td class="py-4 px-6">
                                        <p class="font-bold {{ $order->status == 3 ? 'text-gray-500' : 'text-dark' }} text-sm line-clamp-2 leading-relaxed">{{ $order->tour->name ?? 'N/A' }}</p>
                                        <p class="text-xs {{ $order->status == 3 ? 'text-gray-400' : 'text-gray-500' }} mt-1"><i class="fa-solid fa-calendar-days {{ $order->status == 3 ? 'text-gray-300' : 'text-gray-400' }} mr-1 text-[10px]"></i> Đi: {{ $order->time ?? 'N/A' }}</p>
                                    </td>
                                    <td class="py-4 px-6 text-center whitespace-nowrap"><span class="font-bold {{ $order->status == 3 ? 'text-gray-500' : 'text-dark' }}">{{ $order->quantity }}</span> khách</td>
                                    <td class="py-4 px-6 text-right font-bold whitespace-nowrap {{ $order->status == 3 ? 'text-gray-500' : 'text-emerald-600' }}">{{ number_format($order->total_price, 0, ',', '.') }}đ</td>
                                    <td class="py-4 px-6 text-center whitespace-nowrap">
                                        @if($order->status == '1' || $order->status == 1)
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-700 uppercase">Đã xác nhận (1)</span>
                                        @elseif($order->status == '2' || $order->status == 2)
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-blue-100 text-blue-700 uppercase">Hoàn thành (2)</span>
                                        @elseif($order->status == '3' || $order->status == 3)
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-red-100 text-red-600 uppercase">Đã Hủy (3)</span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-100 text-amber-700 uppercase">Chờ duyệt (0)</span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-6 text-center whitespace-nowrap">
                                        <div class="flex items-center justify-center space-x-2">
                                            <a href="{{ route('admin.orders.show', ['id' => $order->id]) }}"
                                                    class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-sky-50 text-primary hover:bg-primary hover:text-white transition-colors shadow-sm" title="Xem chi tiết">
                                                <i class="fa-solid fa-eye text-sm pointer-events-none"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="py-8 text-center text-gray-500">Chưa có đơn đặt nào</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="px-6 py-4 border-t border-gray-50 flex flex-col sm:flex-row items-center justify-between">
                        <p class="text-sm text-gray-500">Hiển thị {{ $orders->firstItem() ?? 0 }} đến {{ $orders->lastItem() ?? 0 }} trong số {{ $orders->total() }} đơn đặt</p>
                        <div class="mt-4 sm:mt-0">
                            {{ $orders->links('pagination::tailwind') }}
                        </div>
                    </div>
                </div>

            </div>
        </main>
    </div>

@endsection
