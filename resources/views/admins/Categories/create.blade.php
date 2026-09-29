@extends('admins.master')

@section('title', 'Thêm danh mục')

@section('home')
<div class="min-h-screen bg-slate-50 px-4 sm:px-6 lg:px-8 py-8">
    <div class="max-w-4xl mx-auto">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-8">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-teal-400 to-emerald-500 flex items-center justify-center text-white shadow-lg shadow-teal-200">
                    <i class="fa-solid fa-folder-plus text-lg"></i>
                </div>
                <div>
                    <h4 class="text-2xl sm:text-3xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-teal-700 to-emerald-600">
                        Thêm danh mục mới
                    </h4>
                    <p class="text-sm text-slate-500 mt-1">Khởi tạo một danh mục mới cho hệ thống</p>
                </div>
            </div>

            <a href="{{ route('categories.index') }}"
               class="inline-flex items-center gap-2 px-5 py-2.5 bg-white border border-slate-200 hover:border-slate-300 hover:bg-slate-50 text-slate-700 text-sm font-semibold rounded-xl transition-all duration-300 shadow-sm group">
               <i class="fa-solid fa-arrow-left group-hover:-translate-x-1 transition-transform"></i>
               <span>Quay lại</span>
            </a>
        </div>

        {{-- Thông báo lỗi tổng --}}
        @if ($errors->any())
            <div class="mb-6 rounded-2xl border border-rose-200 bg-rose-50/50 p-5 backdrop-blur-sm">
                <div class="flex items-center gap-3 mb-2">
                    <i class="fa-solid fa-circle-exclamation text-rose-500"></i>
                    <p class="font-semibold text-rose-700">Vui lòng kiểm tra lại thông tin:</p>
                </div>
                <ul class="list-disc list-inside text-rose-600 text-sm space-y-1 ml-6">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Card --}}
        <div class="bg-white/80 backdrop-blur-xl border border-white shadow-2xl shadow-slate-200/50 rounded-3xl overflow-hidden relative">
            <div class="absolute top-0 right-0 p-32 bg-teal-50 rounded-full blur-3xl opacity-50 -z-10 -translate-y-1/2 translate-x-1/2"></div>
            
            <div class="p-6 sm:p-10">
                <form action="{{ route('categories.store') }}" method="POST" class="space-y-8 relative z-10">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        {{-- Tên danh mục --}}
                        <div class="col-span-1 md:col-span-2">
                            <label class="block text-slate-700 font-semibold mb-2">
                                Tên danh mục <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fa-solid fa-tag text-slate-400"></i>
                                </div>
                                <input type="text"
                                       name="name"
                                       placeholder="Ví dụ: Du lịch Châu Á..."
                                       value="{{ old('name') }}"
                                       class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-11 pr-4 py-3
                                       text-slate-700 placeholder-slate-400 font-medium
                                       focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 focus:bg-white
                                       transition-all duration-300
                                       @error('name') border-rose-500 ring-rose-500/20 focus:ring-rose-500/20 focus:border-rose-500 @enderror">
                            </div>
                            @error('name')
                                <p class="text-rose-500 text-sm mt-2 flex items-center gap-1"><i class="fa-solid fa-circle-exclamation text-xs"></i>{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Danh mục cha --}}
                        <div>
                            <label class="block text-slate-700 font-semibold mb-2">
                                Danh mục cha
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fa-solid fa-sitemap text-slate-400"></i>
                                </div>
                                <select name="parent_id"
                                        class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-11 pr-4 py-3
                                        text-slate-700 font-medium appearance-none
                                        focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 focus:bg-white
                                        transition-all duration-300
                                        @error('parent_id') border-rose-500 focus:border-rose-500 @enderror">
                                    <option value="">-- Thuộc danh mục gốc --</option>
                                    @foreach($flat as $cat)
                                        <option value="{{ $cat->id }}" {{ old('parent_id') == $cat->id ? 'selected' : '' }}>
                                            {{ $cat->name }}
                                        </option>
                                        @foreach($cat->children as $child)
                                            <option value="{{ $child->id }}" {{ old('parent_id') == $child->id ? 'selected' : '' }}>
                                                &nbsp;&nbsp;&nbsp;&nbsp;↳ {{ $child->name }}
                                            </option>
                                        @endforeach
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none pointer-events-none">
                                    <i class="fa-solid fa-angle-down text-slate-400"></i>
                                </div>
                            </div>
                            @error('parent_id')
                                <p class="text-rose-500 text-sm mt-2 flex items-center gap-1"><i class="fa-solid fa-circle-exclamation text-xs"></i>{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Link --}}
                        <div>
                            <label class="block text-slate-700 font-semibold mb-2">
                                Link liên kết <span class="text-slate-400 font-normal text-sm ml-1">(Tùy chọn)</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fa-solid fa-link text-slate-400"></i>
                                </div>
                                <input type="text"
                                       name="link"
                                       placeholder="https://..."
                                       value="{{ old('link') }}"
                                       class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-11 pr-4 py-3
                                       text-slate-700 placeholder-slate-400 font-medium
                                       focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 focus:bg-white
                                       transition-all duration-300
                                       @error('link') border-rose-500 focus:border-rose-500 @enderror">
                            </div>
                            @error('link')
                                <p class="text-rose-500 text-sm mt-2 flex items-center gap-1"><i class="fa-solid fa-circle-exclamation text-xs"></i>{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <hr class="border-slate-100 my-8">

                    {{-- Buttons --}}
                    <div class="flex flex-col sm:flex-row sm:justify-end gap-4">
                        <a href="{{ route('categories.index') }}"
                           class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold rounded-xl transition-colors duration-300">
                           <i class="fa-solid fa-xmark text-lg"></i>
                           <span>Hủy bỏ</span>
                        </a>

                        <button type="submit"
                                class="inline-flex items-center justify-center gap-2 px-8 py-3 bg-gradient-to-r from-teal-500 to-emerald-600 hover:from-teal-600 hover:to-emerald-700 text-white font-semibold rounded-xl shadow-lg shadow-teal-200/50 hover:shadow-xl hover:shadow-teal-300/50 hover:-translate-y-0.5 transition-all duration-300">
                            <i class="fa-solid fa-check"></i>
                            <span>Lưu danh mục</span>
                        </button>
                    </div>

                </form>
            </div>
        </div>

    </div>
</div>
@endsection

