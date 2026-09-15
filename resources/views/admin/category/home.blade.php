@extends('admin.master')

@section('content')
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden">

        <!-- Header Topbar -->
        <header class="h-20 bg-surface border-b border-gray-100 flex items-center justify-between px-6 lg:px-10 z-10 hidden md:flex flex-shrink-0">
            <div class="flex items-center flex-1">
                <button class="md:hidden text-gray-500 hover:text-primary mr-4 focus:outline-none">
                    <i class="fa-solid fa-bars text-xl"></i>
                </button>
                <h2 class="text-xl font-bold text-dark hidden sm:block">Quản Lý Danh Mục</h2>
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
                            <input type="text" placeholder="Tìm kiếm danh mục..." class="w-full bg-white border border-gray-200 rounded-xl py-2.5 pl-10 pr-4 text-sm text-dark focus:outline-none focus:border-primary admin-input transition-all">
                        </div>
                        <select class="bg-white border border-gray-200 rounded-xl py-2.5 px-4 text-sm text-gray-600 focus:outline-none focus:border-primary admin-input transition-all w-full sm:w-auto">
                            <option value="">Tất cả trạng thái</option>
                            <option value="1">Hiển thị</option>
                            <option value="0">Tạm ẩn</option>
                        </select>
                    </div>

                    <a href="{{ route('categories.create') }}" class="bg-dark text-white font-medium px-5 py-2.5 rounded-xl hover:bg-gray-800 transition-colors shadow-soft flex items-center justify-center flex-shrink-0 cursor-pointer">
                        <i class="fa-solid fa-plus mr-2"></i> Thêm Danh Mục
                    </a>
                </div>

                <!-- Card -->
                <div class="bg-white rounded-2xl border border-gray-100 shadow-card p-4 sm:p-5 overflow-x-auto min-h-[400px]">
                    @if($tree->isEmpty())
                        <div class="text-center text-gray-500 py-12 flex flex-col items-center justify-center h-full">
                            <i class="fa-regular fa-folder-open text-4xl text-gray-300 mb-3"></i>
                            <p class="font-medium">Chưa có danh mục nào. Vui lòng thêm mới.</p>
                        </div>
                    @else
                        <!-- Save Order Button (hiển thị khi có danh mục) -->
                        <div class="flex justify-end mb-4">
                            <button id="save-order" class="px-4 py-2 bg-emerald-500 text-white font-medium rounded-lg shadow-sm hover:bg-emerald-600 transition-colors flex items-center shrink-0">
                                <i class="fa-solid fa-layer-group mr-2"></i> Lưu vị trí / Thứ tự
                            </button>
                        </div>

                        <div class="dd" id="nestable">
                            <ol class="dd-list space-y-2">
                                @foreach($tree as $node)
                                    @include('admin.category._node', ['node' => $node])
                                @endforeach
                            </ol>
                        </div>
                    @endif
                </div>

            </div>
        </main>
    </div>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- jQuery (Yêu cầu cho Nestable) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Nestable Script -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Nestable/2012-10-15/jquery.nestable.min.js"></script>

    <script>
    $(document).ready(function() {
        if ($('#nestable').length > 0) {
            $('#nestable').nestable({
                maxDepth: 5
            });

            $('#save-order').on('click', function(){
                const tree = $('#nestable').nestable('serialize');

                $.post("{{ route('categories.reorder') }}", {
                    tree: tree,
                    _token: "{{ csrf_token() }}"
                })
                .done(() => {
                    alert('Đã cập nhật vị trí danh mục thành công!');
                    location.reload();
                })
                .fail(() => {
                    alert('Lỗi cập nhật. Tính năng di chuyển cần được cài đặt package xử lý Tree Nested trong Backend.');
                });
            });
        }
    });
    </script>
@endsection
