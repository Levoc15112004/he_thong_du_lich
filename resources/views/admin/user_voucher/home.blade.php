@extends('admin.master')

@section('content')
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden">

        <!-- Header Topbar -->
        <header class="h-20 bg-surface border-b border-gray-100 flex items-center justify-between px-6 lg:px-10 z-10 hidden md:flex flex-shrink-0">
            <div class="flex items-center flex-1">
                <button class="md:hidden text-gray-500 hover:text-primary mr-4 focus:outline-none">
                    <i class="fa-solid fa-bars text-xl"></i>
                </button>
                <h2 class="text-xl font-bold text-dark hidden sm:block">Lịch Sử Sử Dụng Voucher Của Khách Hàng</h2>
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
                            <input type="text" placeholder="Tìm theo Tên khách, Email hoặc Mã Voucher..." class="w-full bg-white border border-gray-200 rounded-xl py-2.5 pl-10 pr-4 text-sm text-dark focus:outline-none focus:border-primary admin-input transition-all">
                        </div>
                        <select class="bg-white border border-gray-200 rounded-xl py-2.5 px-4 text-sm text-gray-600 focus:outline-none focus:border-primary admin-input transition-all w-full sm:w-auto">
                            <option value="">Lọc theo Trạng thái</option>
                            <option value="0">Chưa sử dụng</option>
                            <option value="1">Đã sử dụng</option>
                        </select>
                    </div>

                    <a href="{{ route('admin.user_vouchers.create') }}" class="bg-dark text-white font-medium px-5 py-2.5 rounded-xl hover:bg-gray-800 transition-colors shadow-soft flex items-center justify-center flex-shrink-0 cursor-pointer">
                        <i class="fa-solid fa-plus mr-2"></i> Cấp Phát Voucher
                    </a>
                </div>

                <!-- Table -->
                <div class="bg-white rounded-2xl border border-gray-100 shadow-card overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse min-w-[900px]">
                            <thead>
                                <tr class="bg-gray-50/80 text-xs uppercase text-gray-500 font-bold tracking-wider border-b border-gray-100">
                                    <th class="py-4 px-6 w-16 text-center">ID</th>
                                    <th class="py-4 px-6">Thông tin Khách Hàng</th>
                                    <th class="py-4 px-6">Voucher Sở Hữu</th>
                                    <th class="py-4 px-6 text-center">Trạng thái</th>
                                    <th class="py-4 px-6 text-center">Thời gian sử dụng</th>
                                    <th class="py-4 px-6 text-center">Hành động</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm divide-y divide-gray-50">
                                @forelse($user_vouchers as $item)
                                <tr class="hover:bg-sky-50/30 transition-colors group">
                                    <td class="py-4 px-6 text-center text-gray-400 font-medium">#{{ $item->id }}</td>
                                    <td class="py-4 px-6">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 rounded-full bg-indigo-100 text-indigo-500 flex items-center justify-center font-bold font-serif text-lg mr-3 shadow-sm border border-white">{{ strtoupper(substr($item->user->name ?? '?', 0, 1)) }}</div>
                                            <div>
                                                <p class="font-bold text-dark text-sm mb-0.5">{{ $item->user->name ?? 'Không rõ' }}</p>
                                                <p class="text-[11px] text-gray-500">{{ $item->user->email ?? '' }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4 px-6">
                                        <p class="font-bold text-dark text-sm mb-0.5 font-mono text-sky-600">{{ $item->voucher->code ?? 'Lỗi Voucher' }}</p>
                                        <p class="text-[11px] text-gray-500 line-clamp-1">{{ $item->voucher->name ?? '' }}</p>
                                    </td>
                                    <td class="py-4 px-6 text-center">
                                        @if($item->status == 1)
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-700 uppercase"><i class="fa-solid fa-check mr-1.5 opacity-50"></i> Đã sử dụng</span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-gray-100 text-gray-600 uppercase"><i class="fa-solid fa-clock mr-1.5 opacity-50"></i> Chưa dùng</span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-6 text-center">
                                        @if($item->used_at)
                                            <p class="text-xs text-emerald-600 font-bold">{{ \Carbon\Carbon::parse($item->used_at)->format('d/m/Y') }}</p>
                                            <p class="text-[10px] text-gray-500">{{ \Carbon\Carbon::parse($item->used_at)->format('H:i') }}</p>
                                        @else
                                            <span class="text-gray-400 text-xs italic">--</span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-6 text-center">
                                        <div class="flex items-center justify-center space-x-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                            <a href="{{ route('admin.user_vouchers.edit', $item->id) }}" class="w-8 h-8 rounded-lg bg-sky-50 text-primary flex items-center justify-center hover:bg-primary hover:text-white transition-colors cursor-pointer" title="Sửa">
                                                <i class="fa-solid fa-pen text-sm"></i>
                                            </a>
                                            <form action="{{ route('admin.user_vouchers.destroy', $item->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Bạn có chắc chắn muốn thu hồi (xóa) Voucher này từ khách không?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="w-8 h-8 rounded-lg bg-red-50 text-red-500 flex items-center justify-center hover:bg-red-500 hover:text-white transition-colors" title="Thu hồi">
                                                    <i class="fa-solid fa-trash-can text-sm"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="py-8 text-center text-gray-500">
                                        Không có dữ liệu nào.
                                    </td>
                                </tr>
                                @endforelse

                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="px-6 py-4 border-t border-gray-50 flex items-center justify-between">
                        {{ $user_vouchers->links('pagination::tailwind') }}
                    </div>
                </div>

            </div>
        </main>
    </div>
@endsection
