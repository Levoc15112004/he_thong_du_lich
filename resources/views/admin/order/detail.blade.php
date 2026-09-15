@extends('admin.master')

@section('content')
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden">

        <header class="h-20 bg-surface border-b border-gray-100 flex items-center justify-between px-6 lg:px-10 z-10 hidden md:flex flex-shrink-0">
            <div class="flex items-center flex-1">
                <button class="md:hidden text-gray-500 hover:text-primary mr-4 focus:outline-none">
                    <i class="fa-solid fa-bars text-xl"></i>
                </button>
                <h2 class="text-xl font-bold text-dark hidden sm:block">Chi Tiết Đơn Đặt Tour</h2>
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

        <main class="flex-1 overflow-x-hidden overflow-y-auto p-6 lg:p-10 relative">
            <div class="block pb-10">

                <div class="flex items-center justify-between mb-8">
                    <div class="flex items-center">
                        <a href="{{ route('admin.orders.index') }}" class="w-10 h-10 rounded-full bg-white border border-gray-200 flex items-center justify-center text-gray-500 hover:text-primary hover:border-primary transition-all mr-4 shadow-sm cursor-pointer">
                            <i class="fa-solid fa-arrow-left"></i>
                        </a>
                        <div>
                            <h2 class="text-2xl font-bold text-dark">Order #ORD-{{ str_pad($order->id, 3, '0', STR_PAD_LEFT) }}</h2>
                            <p class="text-sm text-gray-500 mt-1">Ngày đặt: {{ optional($order->created_at)->format('H:i d/m/Y') }} - Đặt qua hệ thống Web</p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                    <!-- Left Column (2/3): Order Details -->
                    <div class="lg:col-span-2 space-y-6">

                        <!-- Customer Info Card -->
                        <div class="bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-gray-100">
                            <h3 class="text-lg font-bold text-dark mb-6 flex items-center"><i class="fa-solid fa-user-astronaut text-primary mr-2"></i> Thông Tin Khách Hàng (Người Đặt)</h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-y-6 gap-x-8">
                                <div>
                                    <p class="text-xs text-gray-500 mb-1 uppercase font-semibold tracking-wider">Họ & Tên</p>
                                    <p class="text-base font-bold text-dark">{{ $order->name }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 mb-1 uppercase font-semibold tracking-wider">Tài khoản User (ID)</p>
                                    <p class="text-sm font-bold text-sky-600">{{ $order->user->name ?? 'Không có' }} (ID: #{{ $order->user_id }})</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 mb-1 uppercase font-semibold tracking-wider">Địa chỉ Email</p>
                                    <p class="text-sm font-medium text-dark flex items-center"><i class="fa-regular fa-envelope text-gray-400 mr-2"></i> {{ $order->email ?? 'Không có thông tin' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 mb-1 uppercase font-semibold tracking-wider">Số điện thoại</p>
                                    <p class="text-sm font-medium text-dark flex items-center"><i class="fa-solid fa-phone text-gray-400 mr-2"></i> {{ $order->phone }}</p>
                                </div>
                                <div class="md:col-span-2">
                                    <p class="text-xs text-gray-500 mb-1 uppercase font-semibold tracking-wider">Địa chỉ giao dịch</p>
                                    <p class="text-sm font-medium text-dark"><i class="fa-solid fa-location-dot text-gray-400 mr-2"></i> {{ $order->address ?? 'Không có thông tin' }}</p>
                                </div>
                                <div class="md:col-span-2 bg-gray-50 p-4 rounded-xl border border-gray-100">
                                    <p class="text-xs text-gray-500 mb-1 uppercase font-semibold tracking-wider">Ghi chú của khách hàng (Note)</p>
                                    <p class="text-sm font-medium text-gray-700 italic">"{{ $order->note ?? 'Không có ghi chú nào.' }}"</p>
                                </div>
                            </div>
                        </div>

                        <!-- Tour Info Card -->
                        <div class="bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-gray-100">
                            <h3 class="text-lg font-bold text-dark mb-6 flex items-center"><i class="fa-solid fa-map-location-dot text-primary mr-2"></i> Dịch Vụ Đã Đặt</h3>

                            <div class="flex flex-col md:flex-row gap-6">
                                <div class="w-full md:w-32 h-32 rounded-xl overflow-hidden flex-shrink-0 border border-gray-100">
                                    <img src="{{ isset($order->tour->main_img) ? asset('storage/' . $order->tour->main_img) : 'https://images.unsplash.com/photo-1540304618210-91a030046645?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80' }}" class="w-full h-full object-cover" alt="Tour image">
                                </div>

                                <div class="flex-1">
                                    <h4 class="text-xl font-bold text-dark mb-2">{{ $order->tour->name ?? 'N/A' }}</h4>
                                    <div class="flex flex-wrap gap-y-2 mb-4">
                                        <span class="text-xs font-semibold bg-sky-50 text-primary px-3 py-1 rounded-md mr-3">Tour ID: #{{ $order->tour_id }}</span>
                                        <span class="text-xs font-semibold bg-gray-100 text-gray-600 px-3 py-1 rounded-md mr-3">Thời gian đi: {{ $order->time }}</span>
                                    </div>

                                    <div class="border-t border-gray-100 pt-4 mt-2">
                                        <div class="flex justify-between items-center mb-2">
                                            <span class="text-sm text-gray-500">Đơn giá (1 khách)</span>
                                            <span class="text-sm font-bold text-dark">{{ number_format($order->tour->price ?? 0, 0, ',', '.') }}đ</span>
                                        </div>
                                        <div class="flex justify-between items-center">
                                            <span class="text-sm text-gray-500">Số lượng (Quantity)</span>
                                            <span class="text-sm font-bold text-dark text-lg">x{{ $order->quantity }} Khách</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column (1/3): Summary & Status Update -->
                    <div class="space-y-6">

                        <!-- Summary Card -->
                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden">
                            <!-- Background decoration -->
                            <div class="absolute -right-10 -top-10 text-gray-50 opacity-10">
                                <i class="fa-solid fa-receipt text-9xl"></i>
                            </div>

                            <h3 class="text-lg font-bold text-dark mb-6 relative z-10">Khái Toán (Summary)</h3>

                            <div class="space-y-3 relative z-10 border-b border-gray-100 pb-4 mb-4">
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-500">Tạm tính (Subtotal)</span>
                                    <span class="text-sm font-bold text-dark">{{ number_format(($order->total_price + $order->discount_amount), 0, ',', '.') }}đ</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-500">Giảm thêm (Discount)</span>
                                    <span class="text-sm font-bold text-emerald-500">- {{ number_format($order->discount_amount, 0, ',', '.') }}đ</span>
                                </div>
                            </div>

                            <div class="flex justify-between items-end relative z-10 mb-2">
                                <span class="text-base font-bold text-dark">Tổng Phải Thu (Total)</span>
                                <span class="text-2xl font-black text-primary">{{ number_format($order->total_price, 0, ',', '.') }}đ</span>
                            </div>
                            <p class="text-[10px] text-gray-400 text-right relative z-10">Thuế GTGT (VAT) đã bao gồm nếu có.</p>
                        </div>

                        <!-- Status Action Card -->
                        <form action="{{ route('admin.orders.update', $order->id) }}" method="POST" class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 sticky top-24">
                            @method('PUT')
                            @csrf

                            <h3 class="text-lg font-bold text-dark mb-4">Thay đổi Trạng thái Đơn</h3>

                            <div class="mb-5">
                                <label class="block text-sm font-medium text-dark mb-2">Tình trạng (Status) hiện tại</label>
                                <select name="status" class="w-full bg-amber-50 border border-amber-200 rounded-xl py-3 px-4 text-sm font-bold focus:outline-none focus:border-amber-400 admin-input transition-all text-amber-600">
                                    <option value="0" {{ $order->status == '0' ? 'selected' : '' }}>0 - Chờ xác nhận (Pending)</option>
                                    <option value="1" {{ $order->status == '1' ? 'selected' : '' }}>1 - Đã xác nhận (Confirmed)</option>
                                    <option value="2" {{ $order->status == '2' ? 'selected' : '' }}>2 - Hoàn thành (Completed)</option>
                                    <option value="3" {{ $order->status == '3' ? 'selected' : '' }}>3 - Đã hủy (Cancelled)</option>
                                </select>
                            </div>

                            <button type="submit" class="w-full bg-amber-500 hover:bg-amber-600 text-white font-bold py-3.5 rounded-xl transition-all duration-300 shadow-lg shadow-amber-500/30 transform hover:-translate-y-0.5 flex items-center justify-center mb-0">
                                <i class="fa-solid fa-arrows-rotate mr-2"></i> <span>Cập Nhật Tình Trạng</span>
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        </main>
    </div>
@endsection
