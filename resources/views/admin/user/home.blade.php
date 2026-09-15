@extends('admin.master')

@section('content')
    <style>
        .modal { transition: opacity 0.25s ease; }
        body.modal-active { overflow-x: hidden; overflow-y: hidden !important; }
    </style>
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden">

        <!-- Header Topbar -->
        <header class="h-20 bg-surface border-b border-gray-100 flex items-center justify-between px-6 lg:px-10 z-10 hidden md:flex flex-shrink-0">
            <div class="flex items-center flex-1">
                <button class="md:hidden text-gray-500 hover:text-primary mr-4 focus:outline-none">
                    <i class="fa-solid fa-bars text-xl"></i>
                </button>
                <h2 class="text-xl font-bold text-dark hidden sm:block">Quản Lý Người Dùng</h2>
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

                <!-- Toolbar -->
                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 mb-6">
                    <div class="flex flex-col sm:flex-row gap-3 flex-1">
                        <div class="relative w-full sm:w-80">
                            <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <input type="text" placeholder="Tìm kiếm tên, email, sđt..." class="w-full bg-white border border-gray-200 rounded-xl py-2.5 pl-10 pr-4 text-sm text-dark focus:outline-none focus:border-primary admin-input transition-all">
                        </div>
                        <select class="bg-white border border-gray-200 rounded-xl py-2.5 px-4 text-sm text-gray-600 focus:outline-none focus:border-primary admin-input transition-all w-full sm:w-auto">
                            <option value="">Tất cả vai trò</option>
                            <option value="user">Người dùng (User)</option>
                            <option value="admin">Quản trị viên (Admin)</option>
                        </select>
                        <select class="bg-white border border-gray-200 rounded-xl py-2.5 px-4 text-sm text-gray-600 focus:outline-none focus:border-primary admin-input transition-all w-full sm:w-auto">
                            <option value="">Tất cả trạng thái</option>
                            <option value="dang_hoat_dong">Đang hoạt động</option>
                            <option value="dung_hoat_dong">Dừng hoạt động</option>
                        </select>
                    </div>

                    <a href="{{ route('admin.users.create') }}" class="bg-dark text-white font-medium px-5 py-2.5 rounded-xl hover:bg-gray-800 transition-colors shadow-soft flex items-center justify-center flex-shrink-0 cursor-pointer">
                        <i class="fa-solid fa-plus mr-2"></i> Thêm Người Dùng
                    </a>
                </div>

                <!-- Table -->
                <div class="bg-white rounded-2xl border border-gray-100 shadow-card overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse min-w-[800px]">
                            <thead>
                                <tr class="bg-gray-50/80 text-xs uppercase text-gray-500 font-bold tracking-wider border-b border-gray-100">
                                    <th class="py-4 px-6 w-16 text-center">ID</th>
                                    <th class="py-4 px-6">Thông tin Người Dùng</th>
                                    <th class="py-4 px-6">Số điện thoại</th>
                                    <th class="py-4 px-6 text-center">Vai trò</th>
                                    <th class="py-4 px-6 text-center">Trạng thái</th>
                                    <th class="py-4 px-6 text-center">Hành động</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm divide-y divide-gray-50">
                                @forelse($users as $user)
                                <tr class="hover:bg-sky-50/30 transition-colors group">
                                    <td class="py-4 px-6 text-center text-gray-400 font-medium">#{{ $user->id }}</td>
                                    <td class="py-4 px-6">
                                        <div class="flex items-center">
                                            @if($user->avatar)
                                                <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" class="w-10 h-10 rounded-full object-cover mr-4 border border-gray-200 shadow-sm">
                                            @else
                                                <div class="w-10 h-10 rounded-full bg-gray-200 text-gray-500 flex items-center justify-center mr-4 border border-gray-100 shadow-sm font-bold">
                                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                                </div>
                                            @endif
                                            <div>
                                                <p class="font-bold text-dark text-base mb-0.5 transition-colors cursor-pointer group-hover:text-primary">{{ $user->name }}</p>
                                                <p class="text-xs text-gray-500">{{ $user->email }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4 px-6 text-gray-600">{{ $user->phone ?? 'N/A' }}</td>
                                    <td class="py-4 px-6 text-center">
                                        @if($user->role == 'admin')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[10px] font-bold bg-purple-100 text-purple-700 uppercase">Admin</span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[10px] font-bold bg-gray-100 text-gray-600 uppercase">User</span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-6 text-center">
                                        @if($user->status == '1' || $user->status == 1 || $user->status === 'dang_hoat_dong')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-700 uppercase">Đang hoạt động</span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-100 text-amber-700 uppercase">Dừng hoạt động</span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-6 text-center">
                                        <div class="flex items-center justify-center space-x-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                            <button onclick="toggleModal('modal-user-{{ $user->id }}')" class="w-8 h-8 rounded-lg bg-sky-50 text-primary flex items-center justify-center hover:bg-primary hover:text-white transition-colors cursor-pointer" title="Xem chi tiết">
                                                <i class="fa-solid fa-eye text-sm"></i>
                                            </button>
                                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Bạn có chắc chắn muốn xóa không?')">
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
                                    <td colspan="6" class="py-8 text-center text-gray-500">Chưa có người dùng nào</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="px-6 py-4 border-t border-gray-50 flex flex-col sm:flex-row items-center justify-between">
                        <p class="text-sm text-gray-500">Hiển thị {{ $users->firstItem() ?? 0 }} đến {{ $users->lastItem() ?? 0 }} trong số {{ $users->total() }} người dùng</p>
                        <div class="mt-4 sm:mt-0">
                            {{ $users->links('pagination::tailwind') }}
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    @foreach($users as $user)
    <div class="modal opacity-0 pointer-events-none fixed w-full h-full top-0 left-0 flex items-center justify-center z-50 transition-all duration-300" id="modal-user-{{ $user->id }}">
        <div class="modal-overlay absolute w-full h-full bg-slate-900/60 backdrop-blur-sm" onclick="toggleModal('modal-user-{{ $user->id }}')"></div>

        <div class="modal-container bg-white w-11/12 md:max-w-2xl mx-auto rounded-3xl shadow-2xl z-50 overflow-hidden transform scale-95 transition-transform duration-300">
            <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                <h3 class="text-xl font-bold text-dark flex items-center">
                    <i class="fa-solid fa-id-card text-primary mr-3 text-2xl"></i> Chi Tiết Khách Hàng #{{ $user->id }}
                </h3>
                <div class="modal-close cursor-pointer z-50 w-8 h-8 rounded-lg flex justify-center items-center hover:bg-gray-200 transition-colors" onclick="toggleModal('modal-user-{{ $user->id }}')">
                    <i class="fa-solid fa-xmark text-gray-500"></i>
                </div>
            </div>

            <div class="p-8 max-h-[80vh] overflow-y-auto">
                <div class="flex items-center mb-8 pb-8 border-b border-gray-100">
                    @if($user->avatar)
                        <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" class="w-24 h-24 rounded-full object-cover mr-6 border-4 border-gray-50 shadow-sm">
                    @else
                        <div class="w-24 h-24 rounded-full bg-sky-100 text-sky-500 flex items-center justify-center mr-6 border-4 border-white shadow-sm font-bold text-3xl">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    @endif
                    <div>
                        <h3 class="text-2xl font-bold text-dark mb-1">{{ $user->name }}</h3>
                        <p class="text-gray-500 flex items-center mb-2"><i class="fa-solid fa-envelope mr-2 w-4 text-center"></i> {{ $user->email }}</p>
                        <div class="flex space-x-2">
                            @if($user->role == 'admin')
                                <span class="px-3 py-1 bg-purple-100 text-purple-700 text-xs font-bold rounded-full uppercase">Admin</span>
                            @else
                                <span class="px-3 py-1 bg-gray-100 text-gray-600 text-xs font-bold rounded-full uppercase">User</span>
                            @endif

                            @if($user->status == '1' || $user->status == 1 || $user->status === 'dang_hoat_dong')
                                <span class="px-3 py-1 bg-emerald-100 text-emerald-700 text-xs font-bold rounded-full uppercase">Hoạt động</span>
                            @else
                                <span class="px-3 py-1 bg-amber-100 text-amber-700 text-xs font-bold rounded-full uppercase">Tạm khóa</span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-6">
                    <div class="bg-gray-50 rounded-2xl p-5 border border-gray-100">
                        <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wider mb-2"><i class="fa-solid fa-phone mr-1"></i> Số điện thoại</p>
                        <p class="text-dark font-bold text-base">{{ $user->phone ?? 'Chưa cập nhật' }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-2xl p-5 border border-gray-100">
                        <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wider mb-2"><i class="fa-solid fa-venus-mars mr-1"></i> Giới tính</p>
                        <p class="text-dark font-bold text-base">
                            @if($user->gender == 'male') Nam
                            @elseif($user->gender == 'female') Nữ
                            @elseif($user->gender == 'other') Khác
                            @else Chưa cập nhật @endif
                        </p>
                    </div>
                    <div class="bg-gray-50 rounded-2xl p-5 border border-gray-100">
                        <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wider mb-2"><i class="fa-solid fa-cake-candles mr-1"></i> Ngày sinh</p>
                        <p class="text-dark font-bold text-base">{{ $user->birthday ? date('d/m/Y', strtotime($user->birthday)) : 'Chưa cập nhật' }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-2xl p-5 border border-gray-100">
                        <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wider mb-2"><i class="fa-solid fa-map-location-dot mr-1"></i> Địa chỉ</p>
                        <p class="text-dark font-bold text-base">{{ $user->address ?? 'Chưa cập nhật' }}</p>
                    </div>
                    <div class="col-span-2 bg-gray-50 rounded-2xl p-5 border border-gray-100 flex justify-between items-center">
                        <div>
                            <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wider mb-1">Ngày đăng ký tài khoản</p>
                            <p class="text-dark font-bold text-sm">{{ optional($user->created_at)->format('H:i - d/m/Y') }}</p>
                        </div>
                        <div class="text-right">
                             <a href="{{ route('admin.users.edit', $user->id) }}" class="bg-primary text-white text-xs font-bold px-4 py-2 rounded-lg shadow-sm hover:bg-sky-600 transition-colors">
                                Sửa Hồ Sơ
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50 flex justify-end space-x-3">
                <button class="bg-white border border-gray-300 text-gray-600 font-bold px-6 py-2 rounded-xl hover:bg-gray-100 transition-colors" onclick="toggleModal('modal-user-{{ $user->id }}')">Đóng</button>
            </div>
        </div>
    </div>
    @endforeach

    <script>
        function toggleModal(modalID){
            const modal = document.getElementById(modalID);
            if(!modal) return;
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
