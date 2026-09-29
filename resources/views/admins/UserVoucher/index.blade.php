@extends('admins.master')

@section('home')
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
        }

        .sidebar-item:hover {
            background-color: rgba(99, 102, 241, 0.1);
            color: #4f46e5;
        }

        .sidebar-item.active {
            background-color: #4f46e5;
            color: white;
        }

        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        .voucher-checkbox:checked+div {
            border-color: #4f46e5;
            background-color: #f5f3ff;
            box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.1);
        }
    </style>

    <main class="flex-1 flex flex-col h-screen overflow-hidden">

        <div class="min-h-screen bg-slate-50/50 py-4 sm:py-8">
            <div class="max-w-[120rem] mx-auto px-4 sm:px-6 lg:px-8">

                <!-- Messages -->
                @if (session('success'))
                    <div
                        class="mb-6 bg-emerald-50 border border-emerald-100 text-emerald-700 px-4 py-3 rounded-2xl flex items-center gap-3 shadow-sm">
                        <i class="fa-solid fa-circle-check text-lg"></i>
                        <span class="text-sm font-bold">{{ session('success') }}</span>
                    </div>
                @endif

                @if (session('error') || $errors->any())
                    <div class="mb-6 bg-rose-50 border border-rose-100 text-rose-700 px-4 py-3 rounded-2xl shadow-sm">
                        <div class="flex items-center gap-3 mb-1">
                            <i class="fa-solid fa-circle-exclamation text-lg"></i>
                            <span class="text-sm font-bold">Thông báo lỗi:</span>
                        </div>
                        <ul class="list-disc pl-10 text-xs font-medium">
                            @if (session('error'))
                                <li>{{ session('error') }}</li>
                            @endif
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Page Header -->
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6 mb-8">
                    <div>
                        <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 ">Cấp phát Voucher</h1>
                        <p class="mt-1 text-sm text-slate-500 font-medium">Gán mã giảm giá cho khách hàng và theo dõi lịch sử
                            sử dụng.</p>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-3">
                        <button type="button" onclick="openRandomAssignModal()"
                            class="inline-flex items-center justify-center px-5 py-3 bg-emerald-600 text-white rounded-2xl text-sm font-bold shadow-xl shadow-emerald-100 hover:bg-emerald-700 transition-all active:scale-95">
                            <i class="fa-solid fa-bolt mr-2 text-lg"></i>
                            Phát ngẫu nhiên
                        </button>

                        <button type="button" onclick="openAssignModal()"
                            class="inline-flex items-center justify-center px-5 py-3 bg-emerald-600 text-white rounded-2xl text-sm font-bold shadow-xl shadow-emerald-100 hover:bg-emerald-700 transition-all active:scale-95">
                            <i class="fa-solid fa-plus-circle mr-2 text-lg"></i>
                            Gán Voucher Mới
                        </button>
                    </div>
                </div>

                <!-- Search Bar -->
                <div class="mb-8 max-w-2xl">
                    <form method="GET" action="{{ route('admin.user_vouchers.index') }}" class="relative group">
                        <i
                            class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-emerald-500 transition-colors"></i>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Tìm kiếm người dùng hoặc mã voucher..."
                            class="w-full pl-12 pr-4 py-4 bg-white border border-slate-200 rounded-2xl focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all outline-none text-sm font-medium shadow-sm">
                    </form>
                </div>

                <!-- Stats Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-8">
                    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex items-center gap-5">
                        <div
                            class="w-14 h-14 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center text-xl shadow-inner">
                            <i class="fa-solid fa-users"></i>
                        </div>
                        <div>
                            <p class="text-slate-400 text-sm font-bold">Người dùng có Voucher</p>
                            <p class="text-2xl font-bold text-slate-900 mt-1">
                                {{ number_format($stats['users_have_voucher']) }}</p>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex items-center gap-5">
                        <div
                            class="w-14 h-14 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center text-xl shadow-inner">
                            <i class="fa-solid fa-ticket-simple"></i>
                        </div>
                        <div>
                            <p class="text-slate-400 text-sm font-bold">Voucher đã phát</p>
                            <p class="text-2xl font-bold text-slate-900 mt-1">{{ number_format($stats['total_assigned']) }}
                            </p>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex items-center gap-5">
                        <div
                            class="w-14 h-14 bg-rose-50 text-rose-600 rounded-2xl flex items-center justify-center text-xl shadow-inner">
                            <i class="fa-solid fa-calendar-check"></i>
                        </div>
                        <div>
                            <p class="text-slate-400 text-sm font-bold">Lượt gán trong ngày</p>
                            <p class="text-2xl font-bold text-slate-900 mt-1">{{ number_format($stats['assigned_today']) }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-white shadow-sm ring-1 ring-slate-200 rounded-3xl overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-50">
                        <h2 class="text-sm font-bold text-slate-900">Lịch sử cấp phát</h2>
                    </div>

                    <!-- Desktop Table View (Hidden on Mobile) -->
                    <div class="hidden lg:block overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-100">
                            <thead class="bg-slate-50/50">
                                <tr>
                                    <th scope="col" class="px-6 py-4 text-left text-sm font-bold text-slate-700">Người
                                        dùng</th>
                                    <th scope="col" class="px-6 py-4 text-center text-sm font-bold text-slate-700">Mã
                                        Voucher</th>
                                    <th scope="col" class="px-6 py-4 text-center text-sm font-bold text-slate-700">Giá trị
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-center text-sm font-bold text-slate-700">Hết hạn
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-center text-sm font-bold text-slate-700">Trạng
                                        thái</th>
                                    <th scope="col" class="px-6 py-4 text-right text-sm font-bold text-slate-700">Thao tác
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-slate-50">
                                @forelse ($userVouchers as $item)
                                    @php
                                        $voucher = $item->voucher;
                                        $isExpired =
                                            $voucher && $voucher->end_date ? $voucher->end_date->isPast() : false;
                                        $statusClass =
                                            $item->status == 1
                                                ? 'bg-emerald-50 text-emerald-700 border-emerald-100'
                                                : ($isExpired
                                                    ? 'bg-rose-50 text-rose-700 border-rose-100'
                                                    : 'bg-slate-50 text-slate-500 border-slate-200');
                                        $statusText =
                                            $item->status == 1 ? 'Đã sử dụng' : ($isExpired ? 'Hết hạn' : 'Chưa dùng');
                                    @endphp
                                    <tr class="hover:bg-slate-50/50 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center gap-3">
                                                <img src="https://ui-avatars.com/api/?name={{ urlencode($item->user->name ?? 'User') }}&background=EEF2FF&color=4F46E5&bold=true"
                                                    class="w-10 h-10 rounded-full shadow-sm ring-2 ring-white">
                                                <div>
                                                    <div class="text-sm font-bold text-slate-900">
                                                        {{ $item->user->name ?? '---' }}</div>
                                                    <div class="text-sm text-slate-400 font-medium">
                                                        {{ $item->user->email ?? '---' }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-center font-mono text-xs font-bold text-emerald-600 bg-emerald-50/30">
                                            {{ $voucher->code ?? '---' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-bold text-slate-700">
                                            @if ($voucher)
                                                {{ $voucher->discount_type === 'percent' ? $voucher->discount_value . '%' : number_format($voucher->discount_value) . '₫' }}
                                            @else
                                                ---
                                            @endif
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-center text-xs font-medium text-slate-500">
                                            {{ $voucher && $voucher->end_date ? $voucher->end_date->format('d/m/Y') : 'Vô thời hạn' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            @php
                                                if ($item->status == 0) {
                                                    $statusText = 'Chưa sử dụng';
                                                    $statusClass = 'bg-slate-50 text-slate-800 border-slate-300';
                                                } elseif ($item->status == 2) {
                                                    $statusText = 'Đã sử dụng';
                                                    $statusClass = 'bg-green-100 text-green-800 border-green-300';
                                                } else {
                                                    $statusText = 'Không xác định';
                                                    $statusClass = 'bg-red-100 text-red-800 border-red-300';
                                                }
                                            @endphp

                                            <span
                                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold border {{ $statusClass }}">
                                                {{ $statusText }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right">
                                            <form action="{{ route('admin.user_vouchers.destroy', $item->id) }}"
                                                method="POST" onsubmit="return confirm('Xác nhận thu hồi voucher?')">
                                                @csrf @method('DELETE')
                                                <button type="submit"
                                                    class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-all">
                                                    <i class="fa-solid fa-trash-can text-sm"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-12 text-center text-slate-400 ">Chưa có dữ liệu cấp
                                            phát.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Mobile Card View (Shown on Mobile) -->
                    <div class="lg:hidden divide-y divide-slate-100 bg-white">
                        @forelse ($userVouchers as $item)
                            @php
                                $voucher = $item->voucher;
                                $isExpired = $voucher && $voucher->end_date ? $voucher->end_date->isPast() : false;
                                $statusClass =
                                    $item->status == 1
                                        ? 'bg-emerald-50 text-emerald-600 border-emerald-100'
                                        : ($isExpired
                                            ? 'bg-rose-50 text-rose-600 border-rose-100'
                                            : 'bg-slate-50 text-slate-400 border-slate-100');
                                $statusText = $item->status == 1 ? 'Used' : ($isExpired ? 'Expired' : 'Unused');
                            @endphp
                            <div class="p-5 space-y-4">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($item->user->name ?? 'User') }}&background=EEF2FF&color=4F46E5&bold=true"
                                            class="w-11 h-11 rounded-full shadow-md ring-2 ring-white">
                                        <div>
                                            <h3 class="text-sm font-bold text-slate-900 leading-tight">
                                                {{ $item->user->name ?? '---' }}</h3>
                                            <p class="text-sm text-slate-400 font-medium truncate max-w-[150px]">
                                                {{ $item->user->email ?? '---' }}</p>
                                        </div>
                                    </div>
                                    <form action="{{ route('admin.user_vouchers.destroy', $item->id) }}" method="POST"
                                        onsubmit="return confirm('Thu hồi?')">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                            class="p-2.5 text-rose-600 bg-rose-50 rounded-xl active:scale-90 transition-transform">
                                            <i class="fa-solid fa-trash-can text-xs"></i>
                                        </button>
                                    </form>
                                </div>

                                <div
                                    class="flex items-center justify-between bg-slate-50/80 p-3 rounded-2xl border border-slate-100">
                                    <div>
                                        <span class="text-[9px] font-bold text-slate-400 block mb-0.5">Voucher Code</span>
                                        <span
                                            class="text-xs font-bold text-emerald-600">{{ $voucher->code ?? '---' }}</span>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-[9px] font-bold text-slate-400 block mb-0.5">Trạng thái</span>
                                        <span
                                            class="inline-flex px-2 py-0.5 rounded-lg text-[9px] font-bold border {{ $statusClass }}">
                                            {{ $statusText }}
                                        </span>
                                    </div>
                                </div>

                                <div class="flex items-center justify-between px-1">
                                    <div class="text-sm font-bold text-slate-700">
                                        <i class="fa-solid fa-tag mr-1 text-gray-300"></i>
                                        @if ($voucher)
                                            {{ $voucher->discount_type === 'percent' ? $voucher->discount_value . '%' : number_format($voucher->discount_value) . '₫' }}
                                        @else
                                            ---
                                        @endif
                                    </div>
                                    <div class="text-sm text-slate-400 font-medium ">
                                        <i class="fa-solid fa-clock mr-1 text-gray-200"></i>
                                        {{ $voucher && $voucher->end_date ? $voucher->end_date->format('d/m/Y') : 'No Limit' }}
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="p-10 text-center text-slate-400  text-sm">Chưa có bài viết nào.</div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    @if ($userVouchers->hasPages())
                        <div class="px-6 py-4 bg-slate-50 border-t border-slate-100">
                            {{ $userVouchers->links('pagination::tailwind') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- <div class="p-6">
                    {{ $userVouchers->links() }}
                </div> --}}

        <div class="py-4 flex justify-center">
            {{ $userVouchers->links('pagination::tailwind') }}
        </div>

        </div>
        </div>
    </main>

    <!-- Modal: Gán Voucher -->
    <div id="assignModal"
        class="fixed inset-0 z-[60] flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-sm hidden">
        <div id="modalContainer"
            class="bg-white w-full max-w-2xl rounded-[2.5rem] shadow-2xl overflow-hidden transform transition-all scale-95 opacity-0 duration-300 border border-white/20">
            <div class="p-8 border-b border-slate-50 flex items-center justify-between bg-slate-50/30">
                <div>
                    <h3 class="text-xl sm:text-3xl font-bold text-slate-900  ">Gán Voucher cho khách hàng</h3>
                    <p class="text-xs text-slate-400 font-medium mt-1">Chọn đối tượng và mã giảm giá áp dụng</p>
                </div>
                <button type="button" onclick="closeAssignModal()"
                    class="w-10 h-10 flex items-center justify-center text-slate-400 hover:text-slate-900 hover:bg-slate-50 rounded-2xl transition-all active:scale-90">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>

            <form id="assignVoucherForm" action="{{ route('admin.user_vouchers.store') }}" method="POST"
                class="p-8 space-y-8">
                @csrf
                <div class="space-y-2">
                    <label class="block text-sm font-bold text-slate-400 px-1">1. Đối tượng khách hàng</label>
                    <div class="relative group">
                        <i
                            class="fa-solid fa-user-tag absolute left-5 top-1/2 -translate-y-1/2 text-gray-300 group-focus-within:text-emerald-500 transition-colors"></i>
                        <select name="user_id" id="userSelect" required
                            class="w-full bg-slate-50 border-none rounded-2xl pl-12 pr-6 py-4 text-sm font-medium text-slate-900 focus:ring-4 focus:ring-emerald-500/10 focus:bg-white transition-all outline-none appearance-none shadow-inner">
                            <option value="" disabled selected>Chọn người dùng từ danh sách...</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                            @endforeach
                        </select>
                        <i
                            class="fa-solid fa-chevron-down absolute right-5 top-1/2 -translate-y-1/2 text-gray-300 pointer-events-none text-xs"></i>
                    </div>
                </div>

                <div class="space-y-4">
                    <div class="flex items-center justify-between px-1">
                        <label class="text-sm font-bold text-slate-400">2. Danh sách mã giảm giá</label>
                        <span id="selectedCount"
                            class="text-sm font-bold text-emerald-600 bg-emerald-50 px-3 py-1 rounded-full er shadow-sm">Đã
                            chọn: 0</span>
                    </div>

                    <div class="relative group">
                        <i
                            class="fa-solid fa-filter absolute left-4 top-1/2 -translate-y-1/2 text-gray-300 group-focus-within:text-emerald-500 transition-colors"></i>
                        <input type="text" id="voucherSearch" placeholder="Lọc nhanh theo mã hoặc giá trị..."
                            class="w-full pl-10 pr-4 py-3 bg-slate-50/50 border-none rounded-xl text-xs font-medium text-slate-900 focus:ring-4 focus:ring-emerald-500/10 focus:bg-white transition-all outline-none shadow-inner placeholder:text-gray-300">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 max-h-64 overflow-y-auto pr-2 custom-scrollbar"
                        id="voucherGrid">
                        @forelse ($availableVouchers as $voucher)
                            @php
                                $discountText =
                                    $voucher->discount_type === 'percent'
                                        ? $voucher->discount_value . '%'
                                        : number_format($voucher->discount_value) . '₫';
                            @endphp
                            <label class="relative block cursor-pointer group voucher-item">
                                <input type="checkbox" name="voucher_ids[]" value="{{ $voucher->id }}"
                                    class="voucher-checkbox peer sr-only">
                                <div
                                    class="p-4 bg-slate-50 border border-slate-100 rounded-2xl peer-checked:bg-emerald-50 peer-checked:border-emerald-200 peer-checked:shadow-lg peer-checked:shadow-emerald-50 transition-all hover:bg-slate-50/80 active:scale-[0.98]">
                                    <div class="flex justify-between items-start mb-3">
                                        <span
                                            class="text-sm font-bold text-emerald-600 bg-white px-2 py-1 rounded-lg shadow-sm border border-emerald-100">{{ $voucher->code }}</span>
                                        <div
                                            class="w-5 h-5 rounded-full border-2 border-slate-200 bg-white flex items-center justify-center peer-checked:border-emerald-500 peer-checked:bg-emerald-500 transition-all">
                                            <i
                                                class="fa-solid fa-check text-sm text-white opacity-0 peer-checked:opacity-100"></i>
                                        </div>
                                    </div>
                                    <p class="text-sm font-bold text-slate-900">{{ $discountText }}</p>
                                    <p class="text-sm text-slate-400 font-bold  mt-1">
                                        {{ $voucher->min_order_value ? 'Min: ' . number_format($voucher->min_order_value) . '₫' : 'No Minimum' }}
                                    </p>
                                </div>
                            </label>
                        @empty
                            <div
                                class="col-span-full py-8 text-center bg-slate-50 rounded-2xl border border-dashed border-slate-200">
                                <p class="text-xs font-bold text-slate-400">Không còn voucher khả dụng</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <div class="flex gap-4 pt-4 border-t border-slate-50">
                    <button type="button" onclick="closeAssignModal()"
                        class="flex-1 px-6 py-4 bg-white border border-slate-200 text-slate-500 font-bold text-xs rounded-2xl hover:bg-slate-50 transition-all active:scale-95">Hủy
                        bỏ</button>
                    <button type="submit" id="btnSubmit" disabled
                        class="flex-1 px-6 py-4 bg-emerald-600 text-white font-bold text-xs rounded-2xl shadow-xl shadow-emerald-100 hover:bg-emerald-700 transition-all active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed">Xác
                        nhận gán (0)</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal: Phát Ngẫu Nhiên -->
    <div id="randomAssignModal"
        class="fixed inset-0 z-[60] flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-sm hidden">
        <div id="randomModalContainer"
            class="bg-white w-full max-w-lg rounded-[2.5rem] shadow-2xl overflow-hidden transform transition-all scale-95 opacity-0 duration-300 border border-white/20">
            <div class="p-8 border-b border-slate-50 flex items-center justify-between bg-slate-50/30">
                <div>
                    <h3 class="text-xl sm:text-3xl font-bold text-slate-900  ">Phát Voucher Ngẫu Nhiên</h3>
                    <p class="text-xs text-slate-400 font-medium mt-1">Hệ thống tự động chọn người dùng chưa có mã</p>
                </div>
                <button type="button" onclick="closeRandomAssignModal()"
                    class="w-10 h-10 flex items-center justify-center text-slate-400 hover:text-slate-900 hover:bg-slate-50 rounded-2xl transition-all active:scale-90">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>

            <form id="randomAssignForm" action="{{ route('admin.user_vouchers.assign_random_users') }}" method="POST"
                class="p-8 space-y-8">
                @csrf
                <div class="space-y-2">
                    <label class="block text-sm font-bold text-slate-400 px-1">1. Chọn loại Voucher</label>
                    <div class="relative group">
                        <i
                            class="fa-solid fa-ticket absolute left-5 top-1/2 -translate-y-1/2 text-gray-300 group-focus-within:text-emerald-500 transition-colors"></i>
                        <select name="voucher_id" id="random_voucher_id" required
                            class="w-full bg-slate-50 border-none rounded-2xl pl-12 pr-6 py-4 text-sm font-medium text-slate-800 focus:ring-4 focus:ring-emerald-500/10 focus:bg-white transition-all outline-none appearance-none shadow-inner">
                            <option value="">-- Chọn voucher từ kho --</option>
                            @foreach ($summerVouchers as $voucher)
                                <option value="{{ $voucher->id }}">{{ $voucher->name }} (Còn:
                                    {{ $voucher->quantity - $voucher->used_count }})</option>
                            @endforeach
                        </select>
                        <i
                            class="fa-solid fa-chevron-down absolute right-5 top-1/2 -translate-y-1/2 text-gray-300 pointer-events-none text-xs"></i>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-bold text-slate-400 px-1">2. Số lượng người dùng nhận</label>
                    <div class="relative group">
                        <i
                            class="fa-solid fa-users-viewfinder absolute left-5 top-1/2 -translate-y-1/2 text-gray-300 group-focus-within:text-emerald-500 transition-colors"></i>
                        <input type="number" id="random_total_users" name="total_users" min="1" step="1"
                            required
                            class="w-full bg-slate-50 border-none rounded-2xl pl-12 pr-6 py-4 text-sm font-medium text-slate-900 focus:ring-4 focus:ring-emerald-500/10 focus:bg-white transition-all outline-none shadow-inner placeholder:text-gray-300"
                            placeholder="Nhập số lượng user (Ví dụ: 50)">
                    </div>
                </div>

                <div class="flex gap-4 pt-4 border-t border-slate-50">
                    <button type="button" onclick="closeRandomAssignModal()"
                        class="flex-1 px-6 py-4 bg-white border border-slate-200 text-slate-500 font-bold text-xs rounded-2xl hover:bg-slate-50 transition-all active:scale-95">Hủy
                        bỏ</button>
                    <button type="submit"
                        class="flex-1 px-6 py-4 bg-emerald-600 text-white font-bold text-xs rounded-2xl shadow-xl shadow-emerald-100 hover:bg-emerald-700 transition-all active:scale-95">Xác
                        nhận phát</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const assignModal = document.getElementById('assignModal');
        const modalContainer = document.getElementById('modalContainer');
        const assignForm = document.getElementById('assignVoucherForm');
        const selectedCountLabel = document.getElementById('selectedCount');
        const btnSubmit = document.getElementById('btnSubmit');

        function getVoucherCheckboxes() {
            return document.querySelectorAll('.voucher-checkbox');
        }

        function updateSelectedCount() {
            const checked = document.querySelectorAll('.voucher-checkbox:checked').length;
            selectedCountLabel.innerText = `Đã chọn: ${checked}`;
            btnSubmit.disabled = checked === 0;
            btnSubmit.innerText = `Xác nhận gán (${checked})`;
        }

        document.addEventListener('change', function(e) {
            if (e.target.classList.contains('voucher-checkbox')) {
                updateSelectedCount();
            }
        });

        function openAssignModal() {
            assignModal.classList.remove('hidden');
            setTimeout(() => {
                modalContainer.classList.remove('scale-95', 'opacity-0');
            }, 10);
        }

        function closeAssignModal() {
            modalContainer.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                assignModal.classList.add('hidden');
                assignForm.reset();
                updateSelectedCount();
            }, 300);
        }

        document.getElementById('voucherSearch').addEventListener('input', function(e) {
            const term = e.target.value.toLowerCase();
            const items = document.querySelectorAll('.voucher-item');

            items.forEach(item => {
                const text = item.innerText.toLowerCase();
                item.style.display = text.includes(term) ? 'block' : 'none';
            });
        });

        assignModal.addEventListener('click', function(e) {
            if (e.target === assignModal) {
                closeAssignModal();
            }
        });

        updateSelectedCount();

        @if ($errors->any())
            openAssignModal();
        @endif


        // random voucher
        const randomAssignModal = document.getElementById('randomAssignModal');
        const randomModalContainer = document.getElementById('randomModalContainer');
        const randomAssignForm = document.getElementById('randomAssignForm');
        const randomTotalUsersInput = document.getElementById('random_total_users');
        const randomVoucherSelect = document.getElementById('random_voucher_id');

        function openRandomAssignModal() {
            if (!randomAssignModal || !randomModalContainer) return;

            randomAssignModal.classList.remove('hidden');

            setTimeout(() => {
                randomModalContainer.classList.remove('scale-95', 'opacity-0');
            }, 10);

            setTimeout(() => {
                if (randomVoucherSelect) {
                    randomVoucherSelect.focus();
                }
            }, 200);
        }

        function closeRandomAssignModal() {
            if (!randomAssignModal || !randomModalContainer) return;

            randomModalContainer.classList.add('scale-95', 'opacity-0');

            setTimeout(() => {
                randomAssignModal.classList.add('hidden');

                if (randomAssignForm) {
                    randomAssignForm.reset();
                }
            }, 300);
        }

        if (randomAssignModal) {
            randomAssignModal.addEventListener('click', function(e) {
                if (e.target === randomAssignModal) {
                    closeRandomAssignModal();
                }
            });
        }

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && randomAssignModal && !randomAssignModal.classList.contains('hidden')) {
                closeRandomAssignModal();
            }
        });

        if (randomAssignForm) {
            randomAssignForm.addEventListener('submit', function(e) {
                if (!randomVoucherSelect || !randomTotalUsersInput) return;

                const voucherId = randomVoucherSelect.value;
                const totalUsers = parseInt(randomTotalUsersInput.value);

                if (!voucherId) {
                    e.preventDefault();
                    alert('Vui lòng chọn voucher.');
                    randomVoucherSelect.focus();
                    return;
                }

                if (!randomTotalUsersInput.value || isNaN(totalUsers) || totalUsers < 1) {
                    e.preventDefault();
                    alert('Vui lòng nhập số lượng user hợp lệ.');
                    randomTotalUsersInput.focus();
                    return;
                }

                randomTotalUsersInput.value = totalUsers;
            });
        }
    </script>
@endsection

