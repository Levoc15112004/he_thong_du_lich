@extends('admins.master')

@section('title', 'Quản lý thuộc tính Tour')

@section('home')
<div class="min-h-screen bg-slate-50 px-4 sm:px-6 lg:px-8 py-6">
    <div class="max-w-[90rem] mx-auto">

        <!-- Tiêu đề + nút thêm (Responsive) -->
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-6">
            <h2 class="text-xl sm:text-3xl font-bold text-slate-900">
                Danh sách thuộc tính Tour
            </h2>

            <div class="flex items-center gap-3">
                <a href="{{ route('admin.attr.create') }}"
                   class="flex items-center justify-center gap-2 px-6 py-3 bg-emerald-600 text-white font-medium rounded-2xl shadow-xl shadow-emerald-100 hover:bg-emerald-700 transition-all active:scale-95 group">
                    <i class="fa-solid fa-plus text-sm group-hover:rotate-90 transition-transform duration-300"></i>
                    <span class="text-sm font-medium   ">Thêm thuộc tính mới</span>
                </a>
            </div>
        </div>



        <!-- Card 2: Loại tour -->
        <div class="bg-white shadow rounded-xl overflow-hidden">
            <div class="bg-slate-50/50 text-black px-4 py-3 font-bold text-base sm:text-lg">
                Loại tour
            </div>

            <div class="p-4">
                @if($tourType->isEmpty())
                    <div class="text-center py-6 text-slate-500">
                        Chưa có loại tour nào. Vui lòng thêm mới.
                    </div>
                @else
                    <ul class="divide-y divide-slate-200">
                        @foreach($tourType as $key => $item)
                            <li class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3 py-3">

                                <!-- Thông tin -->
                                <div class="flex items-center gap-4">
                                    <span class="text-slate-500 w-8 text-sm">
                                        {{ $key + 1 }}
                                    </span>
                                    <span class="font-medium text-slate-700 text-base sm:text-lg break-words">
                                        {{ $item->value }}
                                    </span>
                                </div>

                                <!-- Hành động -->
                                <div class="flex gap-2 sm:gap-3 sm:justify-end">
                                    <!-- Nút sửa -->
                                    <a href="{{ route('admin.attr.edit', $item->id) }}"
                                        class="px-3 py-2 bg-blue-100 text-blue-600 hover:bg-blue-200 rounded-lg transition text-sm">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>

                                    <!-- Nút xóa -->
                                    <form action="{{ route('admin.attr.destroy', $item->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('Bạn có chắc muốn xóa?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="px-3 py-2 bg-red-100 text-red-600 hover:bg-red-200 rounded-lg transition text-sm">
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

    </div>
</div>
@endsection

