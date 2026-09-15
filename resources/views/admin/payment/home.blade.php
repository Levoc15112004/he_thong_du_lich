@extends('admin.master')

@section('content')
    <!-- CSS & JS dành riêng cho chức năng Modal -->
    <style>
        .modal { transition: opacity 0.25s ease; }
        body.modal-active { overflow-x: hidden; overflow-y: hidden !important; }
    </style>

    <div class="flex-1 flex flex-col min-w-0 overflow-hidden relative">

        <!-- Header Topbar -->
        <header class="h-20 bg-surface border-b border-gray-100 flex items-center justify-between px-6 lg:px-10 z-10 hidden md:flex flex-shrink-0">
            <div class="flex items-center flex-1">
                <button class="md:hidden text-gray-500 hover:text-primary mr-4 focus:outline-none">
                    <i class="fa-solid fa-bars text-xl"></i>
                </button>
                <h2 class="text-xl font-bold text-dark hidden sm:block">Lịch Sử Giao Dịch & Thanh Toán</h2>
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
                            <input type="text" placeholder="Tìm tên khách hàng hoặc mã GD..." class="w-full bg-white border border-gray-200 rounded-xl py-2.5 pl-10 pr-4 text-sm text-dark focus:outline-none focus:border-primary admin-input transition-all">
                        </div>
                        <select class="bg-white border border-gray-200 rounded-xl py-2.5 px-4 text-sm text-gray-600 focus:outline-none focus:border-primary admin-input transition-all w-full sm:w-auto">
                            <option value="">Tất cả phương thức</option>
                            <option value="vnpay">Cổng thanh toán VNPay</option>
                            <option value="momo">Ví điện tử MoMo</option>
                            <option value="bank">Chuyển khoản / Bank Transfer</option>
                        </select>
                        <select class="bg-white border border-gray-200 rounded-xl py-2.5 px-4 text-sm text-gray-600 focus:outline-none focus:border-primary admin-input transition-all w-full sm:w-auto">
                            <option value="">Trạng thái</option>
                            <option value="0">0 - Chờ thanh toán</option>
                            <option value="1">1 - Thành công</option>
                            <option value="2">2 - Thất bại</option>
                            <option value="3">3 - Đang xử lý</option>
                            <option value="4">4 - Đã hoàn tiền</option>
                        </select>
                    </div>

                    <button class="bg-white border border-gray-200 text-gray-600 font-medium px-4 py-2.5 rounded-xl hover:bg-gray-50 flex items-center transition-colors shadow-sm">
                        <i class="fa-solid fa-download mr-2 text-primary"></i> Xuất Excel
                    </button>
                </div>

                <!-- Table -->
                <div class="bg-white rounded-2xl border border-gray-100 shadow-card overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse min-w-[1000px]">
                            <thead>
                                <tr class="bg-gray-50/80 text-xs uppercase text-gray-500 font-bold tracking-wider border-b border-gray-100">
                                    <th class="py-4 px-6 w-16 text-center">ID</th>
                                    <th class="py-4 px-6">Khách hàng & Đơn (Order ID)</th>
                                    <th class="py-4 px-6 text-right">Số Tiền Khách Trả</th>
                                    <th class="py-4 px-6">Cổng Thanh Toán</th>
                                    <th class="py-4 px-6">Thời gian Giao dịch</th>
                                    <th class="py-4 px-6 text-center">Trạng Thái</th>
                                    <th class="py-4 px-6 text-center">Tác vụ</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm divide-y divide-gray-50">
                                @forelse($payments as $item)
                                <tr class="hover:bg-sky-50/30 transition-colors group">
                                    <td class="py-4 px-6 text-center text-gray-400 font-medium">#{{ $item->id }}</td>
                                    <td class="py-4 px-6">
                                        <div class="flex items-center">
                                            <div class="w-9 h-9 rounded-full bg-orange-100 text-orange-500 flex items-center justify-center font-bold mr-3">{{ strtoupper(substr($item->order->name ?? '?', 0, 1)) }}</div>
                                            <div>
                                                <p class="font-bold text-dark text-sm mb-0.5">{{ $item->order->name ?? 'Không rõ' }}</p>
                                                <p class="text-[10px] text-gray-400 font-mono">Đơn hàng: #ORD-{{ $item->order_id }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4 px-6 text-right font-bold {{ (string)$item->status === '1' ? 'text-emerald-600' : ((string)$item->status === '2' || (string)$item->status === '4' ? 'text-dark opacity-50 line-through' : 'text-amber-600') }}">
                                        {{ (string)$item->status === '1' ? '+' : '' }} {{ number_format($item->amount, 0, ',', '.') }}đ
                                    </td>
                                    <td class="py-4 px-6">
                                        <div class="flex flex-col">
                                            <span class="font-bold {{ $item->payment_type == 'momo' ? 'text-[#A50064]' : 'text-sky-700' }} text-xs mb-1">{{ strtoupper($item->payment_type) }}</span>
                                            <span class="text-[10px] text-gray-500">{{ $item->payment_method }}</span>
                                        </div>
                                    </td>
                                    <td class="py-4 px-6">
                                        <p class="text-xs text-dark font-medium">{{ \Carbon\Carbon::parse($item->payment_date)->format('d/m/Y') }}</p>
                                        <p class="text-[10px] text-gray-400">{{ \Carbon\Carbon::parse($item->payment_date)->format('H:i:s') }}</p>
                                    </td>
                                    <td class="py-4 px-6 text-center">
                                        @if((string)$item->status === '0')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-100 text-amber-700 uppercase"><i class="fa-solid fa-clock mr-1"></i> Chờ thanh toán</span>
                                        @elseif((string)$item->status === '1')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-700 uppercase"><i class="fa-solid fa-check mr-1"></i> Thành Công</span>
                                        @elseif((string)$item->status === '2')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-red-100 text-red-700 uppercase"><i class="fa-solid fa-xmark mr-1"></i> Thất bại</span>
                                        @elseif((string)$item->status === '3')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-blue-100 text-blue-700 uppercase"><i class="fa-solid fa-spinner mr-1"></i> Đang xử lý</span>
                                        @elseif((string)$item->status === '4')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-purple-100 text-purple-700 uppercase"><i class="fa-solid fa-arrow-rotate-left mr-1"></i> Đã hoàn tiền</span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-6 text-center">
                                        <div class="flex space-x-2 justify-center">
                                            <button onclick="toggleModal('modal-id-{{ $item->id }}')" class="bg-gray-100 text-gray-600 hover:text-primary hover:bg-sky-50 font-medium text-xs px-3 py-1.5 rounded-lg transition-colors border border-gray-200">
                                                Chi Tiết
                                            </button>
                                            <a href="{{ route('admin.payments.destroy', $item->id) }}" class="bg-red-50 text-red-500 hover:bg-red-500 hover:text-white transition-colors border border-red-100 font-medium text-xs px-3 py-1.5 rounded-lg" title="Xóa" onclick="return confirm('Bạn có chắc chắn muốn xóa giao dịch này?');">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="py-8 text-center text-gray-500">
                                        Không có giao dịch nào.
                                    </td>
                                </tr>
                                @endforelse

                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Pagination -->
                <div class="mt-4">
                    {{ $payments->links('pagination::tailwind') }}
                </div>

            </div>
        </main>
    </div>

    @foreach($payments as $item)
    @php
        $statusStr = (string)$item->status;
        $isSuccess = ($statusStr === '1');

        if ($statusStr === '0') {
            $modalColor = 'amber';
            $modalIcon = 'fa-clock';
            $modalTitle = 'Giao Dịch Chờ Thanh Toán';
        } elseif ($statusStr === '1') {
            $modalColor = 'emerald';
            $modalIcon = 'fa-check';
            $modalTitle = 'Thanh Toán Thành Công';
        } elseif ($statusStr === '2') {
            $modalColor = 'red';
            $modalIcon = 'fa-xmark';
            $modalTitle = 'Thanh Toán Thất Bại';
        } elseif ($statusStr === '3') {
            $modalColor = 'blue';
            $modalIcon = 'fa-spinner';
            $modalTitle = 'Đang Xử Lý Thanh Toán';
        } elseif ($statusStr === '4') {
            $modalColor = 'purple';
            $modalIcon = 'fa-arrow-rotate-left';
            $modalTitle = 'Đã Hoàn Tiền';
        } else {
            $modalColor = 'gray';
            $modalIcon = 'fa-info-circle';
            $modalTitle = 'Thông Tin Giao Dịch';
        }
    @endphp
    <!-- POPUP MODAL CHO TỪNG GIAO DỊCH -->
    <div class="modal opacity-0 pointer-events-none fixed w-full h-full top-0 left-0 flex items-center justify-center z-50 transition-all duration-300" id="modal-id-{{ $item->id }}">
        <div class="modal-overlay absolute w-full h-full bg-slate-900/60 backdrop-blur-sm" onclick="toggleModal('modal-id-{{ $item->id }}')"></div>

        <div class="modal-container bg-white w-11/12 md:max-w-2xl mx-auto rounded-2xl shadow-2xl z-50 overflow-y-auto transform scale-95 transition-transform duration-300">

            <div class="modal-content text-left p-0">
                <!-- Header Popup -->
                <div class="flex justify-between items-center p-6 border-b border-gray-100 bg-{{ $modalColor }}-50/50 rounded-t-2xl">
                    <p class="text-xl font-black text-{{ $isSuccess ? 'dark' : 'red-600' }} flex items-center">
                        <i class="fa-solid {{ $modalIcon }} text-{{ $modalColor }}-500 mr-2 text-2xl"></i> {{ $modalTitle }} <span class="bg-sky-100 text-sky-700 font-mono text-base px-2 py-1 rounded ml-2">#{{ $item->id }}</span>
                    </p>
                    <div class="modal-close cursor-pointer z-50 w-8 h-8 rounded-lg flex justify-center items-center hover:bg-gray-200 transition-colors" onclick="toggleModal('modal-id-{{ $item->id }}')">
                        <i class="fa-solid fa-xmark text-gray-400"></i>
                    </div>
                </div>

                <!-- Body Popup -->
                <div class="p-6 md:p-8 space-y-6">

                    <!-- Box xanh/đỏ tóm tắt -->
                    <div class="bg-{{ $modalColor }}-50 border border-{{ $modalColor }}-100 p-5 rounded-2xl flex flex-col md:flex-row items-center justify-between">
                        <div class="text-center md:text-left mb-4 md:mb-0">
                            <p class="text-xs font-bold text-{{ $modalColor }}-600 uppercase tracking-widest mb-1">Số tiền thanh toán</p>
                            <p class="text-3xl font-black text-{{ $modalColor }}-700">{{ number_format($item->amount, 0, ',', '.') }} <span class="text-{{ $modalColor }}-500 text-lg">VNĐ</span></p>
                        </div>
                        <div class="text-right">
                            <button class="bg-white border border-{{ $modalColor }}-200 text-{{ $modalColor }}-600 text-sm font-bold px-4 py-2 rounded-xl shadow-sm hover:shadow transition-shadow">{{ $modalTitle }}</button>
                        </div>
                    </div>

                    <!-- Lưới thông tin -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4 border-b border-gray-100 pb-2">Thông Tin Kỹ Thuật (Payments)</h4>
                            <ul class="space-y-3 text-sm">
                                <li class="flex justify-between"><span class="text-gray-500">Mã Đơn Tương Ứng:</span> <span class="font-bold text-primary hover:underline cursor-pointer">#ORD-{{ $item->order_id }}</span></li>
                                <li class="flex justify-between"><span class="text-gray-500">Khách Hàng:</span> <span class="font-bold text-dark">{{ $item->order->name ?? 'Không rõ' }}</span></li>
                                <li class="flex justify-between"><span class="text-gray-500">Cổng Thanh Toán:</span> <span class="font-bold text-sky-600">{{ strtoupper($item->payment_type) }}</span></li>
                                <li class="flex justify-between"><span class="text-gray-500">Phương Thức Dùng:</span> <span class="font-medium text-dark">{{ $item->payment_method }}</span></li>
                            </ul>
                        </div>
                        <div>
                            <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4 border-b border-gray-100 pb-2">Trace & Cổng Đối Soát</h4>
                            <ul class="space-y-3 text-sm">
                                <li class="flex justify-between"><span class="text-gray-500">Giao dịch Charge ID:</span> <span class="font-mono text-[11px] text-gray-600 bg-gray-50 px-1 border border-gray-200 rounded">{{ $item->charge_id }}</span></li>
                                <li class="flex justify-between"><span class="text-gray-500">Trạng thái (Status):</span> <span class="font-mono text-[11px] text-gray-600 bg-gray-50 px-1 border border-gray-200 rounded">{{ $statusStr }}</span></li>
                                <li class="flex justify-between"><span class="text-gray-500">Ngày tạo Yêu Cầu:</span> <span class="text-dark font-mono text-xs">{{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y H:i:s') }}</span></li>
                                <li class="flex justify-between"><span class="text-gray-500">Xác nhận lúc:</span> <span class="text-dark font-mono text-xs text-{{ $modalColor }}-600 font-bold">{{ \Carbon\Carbon::parse($item->payment_date)->format('d/m/Y H:i:s') }}</span></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Footer Popup -->
                <div class="flex justify-end pt-4 p-6 border-t border-gray-100 bg-gray-50 rounded-b-2xl">
                    <button class="modal-close bg-white border border-gray-300 text-gray-600 font-bold px-6 py-2.5 rounded-xl hover:bg-gray-100 transition-colors mr-3" onclick="toggleModal('modal-id-{{ $item->id }}')">Đóng Thẻ</button>
                    <a href="{{ route('admin.payments.destroy', $item->id) }}" class="bg-red-500 border border-transparent text-white font-bold px-6 py-2.5 rounded-xl block hover:bg-red-600 transition-all text-center" onclick="return confirm('Xóa giao dịch này vĩnh viễn?');">Xóa Giao Dịch Mẫu</a>
                </div>
            </div>
        </div>
    </div>
    @endforeach


    <script>
        // Script điều khiển đóng mở Popup dạng Tailwind Modal
        function toggleModal(modalID){
            const modal = document.getElementById(modalID);
            const container = modal.querySelector('.modal-container');

            modal.classList.toggle('opacity-0');
            modal.classList.toggle('pointer-events-none');
            document.body.classList.toggle('modal-active');

            if(!modal.classList.contains('opacity-0')){
                container.classList.remove('scale-95');
                container.classList.add('scale-100');
            } else {
                container.classList.add('scale-95');
                container.classList.remove('scale-100');
            }
        }
    </script>
@endsection
