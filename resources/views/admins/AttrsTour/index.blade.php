@extends('admins.master')

@section('title', 'Quản lý thuộc tính Tour')

@section('home')
<div class="min-h-screen bg-transparent dark:bg-transparent px-4 sm:px-6 lg:px-8 py-6">
    <div class="max-w-[90rem] mx-auto">

        <!-- Tiêu đề + nút thêm (Responsive) -->
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-6">
            <h2 class="text-xl sm:text-3xl font-bold text-slate-900 dark:text-white">
                Danh sách thuộc tính Tour
            </h2>

            <div class="flex items-center gap-3">
                <a href="{{ route('admin.attr.create') }}"
                   class="flex items-center justify-center gap-2 px-6 py-3 bg-[#863c20] text-white font-medium rounded-2xl shadow-xl shadow-xs hover:bg-[#a34c2a] transition-colors active:scale-95 group">
                    <i class="fa-solid fa-plus text-sm group-hover:rotate-90 transition-transform duration-300"></i>
                    <span class="text-sm font-medium">Thêm thuộc tính mới</span>
                </a>
            </div>
        </div>



        @if (session('success'))
            <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-2xl flex items-center gap-3 shadow-sm">
                <i class="fa-solid fa-circle-check text-lg"></i>
                <span class="text-sm font-bold">{{ session('success') }}</span>
            </div>
        @endif

        <div class="space-y-6">
            <!-- Card 1: Phương tiện di chuyển -->
            <div class="bg-white dark:bg-slate-900 shadow-sm border border-slate-200 dark:border-slate-800 rounded-xl overflow-hidden">
                <div class="bg-slate-100 dark:bg-slate-800 text-slate-800 dark:text-white border-b border-slate-200 dark:border-slate-700 px-4 py-3 font-bold text-base sm:text-lg flex items-center justify-between">
                    <span>Phương tiện di chuyển</span>
                    <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-blue-50 text-blue-600 dark:bg-blue-900/40 dark:text-blue-300">{{ $attrTransport->count() }} mục</span>
                </div>

                <div class="p-4">
                    @if($attrTransport->isEmpty())
                        <div class="text-center py-6 text-slate-500 dark:text-slate-400">
                            Chưa có phương tiện di chuyển nào. Vui lòng thêm mới.
                        </div>
                    @else
                        <ul class="divide-y divide-slate-200 dark:divide-slate-800">
                            @foreach($attrTransport as $key => $item)
                                <li class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3 py-3">
                                    <div class="flex items-center gap-4">
                                        <span class="text-slate-500 dark:text-slate-400 w-8 text-sm">{{ $key + 1 }}</span>
                                        <span class="font-medium text-slate-700 dark:text-slate-200 text-base sm:text-lg break-words">{{ $item->value }}</span>
                                    </div>
                                    <div class="flex gap-2 sm:gap-3 sm:justify-end">
                                        <a href="{{ route('admin.attr.edit', $item->id) }}"
                                            class="px-3 py-2 bg-blue-100 text-blue-600 hover:bg-blue-200 rounded-lg transition text-sm">
                                            <i class="fa-solid fa-pen"></i>
                                        </a>
                                        <form action="{{ route('admin.attr.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-3 py-2 bg-red-100 text-red-600 hover:bg-red-200 rounded-lg transition text-sm">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>

            <!-- Card 2: Loại tour -->
            <div class="bg-white dark:bg-slate-900 shadow-sm border border-slate-200 dark:border-slate-800 rounded-xl overflow-hidden">
                <div class="bg-slate-100 dark:bg-slate-800 text-slate-800 dark:text-white border-b border-slate-200 dark:border-slate-700 px-4 py-3 font-bold text-base sm:text-lg flex items-center justify-between">
                    <span>Loại tour / Tiêu chuẩn lưu trú</span>
                    <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-orange-50 text-orange-600 dark:bg-orange-900/40 dark:text-orange-300">{{ $tourType->count() }} mục</span>
                </div>

                <div class="p-4">
                    @if($tourType->isEmpty())
                        <div class="text-center py-6 text-slate-500 dark:text-slate-400">
                            Chưa có loại tour nào. Vui lòng thêm mới.
                        </div>
                    @else
                        <ul class="divide-y divide-slate-200 dark:divide-slate-800">
                            @foreach($tourType as $key => $item)
                                <li class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3 py-3">
                                    <div class="flex items-center gap-4">
                                        <span class="text-slate-500 dark:text-slate-400 w-8 text-sm">{{ $key + 1 }}</span>
                                        <span class="font-medium text-slate-700 dark:text-slate-200 text-base sm:text-lg break-words">{{ $item->value }}</span>
                                    </div>
                                    <div class="flex gap-2 sm:gap-3 sm:justify-end">
                                        <a href="{{ route('admin.attr.edit', $item->id) }}"
                                            class="px-3 py-2 bg-blue-100 text-blue-600 hover:bg-blue-200 rounded-lg transition text-sm">
                                            <i class="fa-solid fa-pen"></i>
                                        </a>
                                        <form action="{{ route('admin.attr.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-3 py-2 bg-red-100 text-red-600 hover:bg-red-200 rounded-lg transition text-sm">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>

            @if(isset($otherAttrs) && $otherAttrs->isNotEmpty())
            <!-- Card 3: Thuộc tính khác -->
            <div class="bg-white dark:bg-slate-900 shadow-sm border border-slate-200 dark:border-slate-800 rounded-xl overflow-hidden">
                <div class="bg-slate-100 dark:bg-slate-800 text-slate-800 dark:text-white border-b border-slate-200 dark:border-slate-700 px-4 py-3 font-bold text-base sm:text-lg flex items-center justify-between">
                    <span>Thuộc tính khác</span>
                    <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-slate-200 text-slate-700 dark:bg-slate-700 dark:text-slate-200">{{ $otherAttrs->count() }} mục</span>
                </div>
                <div class="p-4">
                    <ul class="divide-y divide-slate-200 dark:divide-slate-800">
                        @foreach($otherAttrs as $key => $item)
                            <li class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3 py-3">
                                <div class="flex items-center gap-4">
                                    <span class="text-slate-500 dark:text-slate-400 w-8 text-sm">{{ $key + 1 }}</span>
                                    <span class="text-xs font-bold px-2 py-0.5 rounded bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300">{{ $item->name }}</span>
                                    <span class="font-medium text-slate-700 dark:text-slate-200 text-base sm:text-lg break-words">{{ $item->value }}</span>
                                </div>
                                <div class="flex gap-2 sm:gap-3 sm:justify-end">
                                    <a href="{{ route('admin.attr.edit', $item->id) }}"
                                        class="px-3 py-2 bg-blue-100 text-blue-600 hover:bg-blue-200 rounded-lg transition text-sm">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                    <form action="{{ route('admin.attr.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-2 bg-red-100 text-red-600 hover:bg-red-200 rounded-lg transition text-sm">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif
        </div>

    </div>
</div>
@endsection

