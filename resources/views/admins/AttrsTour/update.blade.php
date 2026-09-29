@extends('admins.master')

@section('title', 'Cập nhật thuộc tính Tour')

@section('home')
<div class="min-h-screen bg-slate-50 px-4 sm:px-6 lg:px-8 py-6">
    <div class="max-w-3xl mx-auto">

        <!-- Header Responsive -->
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-6">
            <h4 class="text-xl sm:text-3xl font-bold text-slate-900">
                Cập nhật thuộc tính Tour
            </h4>

            <a href="{{ route('admin.attr.index') }}"
               class="inline-flex items-center gap-2
                      bg-gray-300 hover:bg-gray-400
                      text-slate-800 text-sm font-medium px-4 py-2 rounded-lg">
                <i class="fa fa-arrow-left"></i> Quay lại
            </a>
        </div>

        <!-- Card -->
        <div class="bg-white shadow-lg rounded-2xl overflow-hidden">
            <div class="p-4 sm:p-6">

                {{-- Thông báo lỗi backend --}}
                @if ($errors->any())
                    <div class="mb-5 rounded-lg border border-red-300 bg-red-50 p-4">
                        <p class="font-semibold text-red-600 mb-2">
                            Vui lòng kiểm tra lại thông tin:
                        </p>
                        <ul class="list-disc list-inside text-red-500 text-sm space-y-1 break-words">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.attr.update', $attr->id) }}"
                      method="POST"
                      class="space-y-6"
                      novalidate>
                    @csrf
                    @method('PUT')

                    <!-- Loại thuộc tính -->
                    <div>
                        <label class="block text-slate-700 font-medium mb-2">
                            Loại thuộc tính <span class="text-red-500">*</span>
                        </label>

                        <select name="name"
                                required
                                oninvalid="this.setCustomValidity('Vui lòng chọn loại thuộc tính')"
                                oninput="this.setCustomValidity('')"
                                class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none
                                @error('name') border-red-500 @enderror">
                            <option value="">-- Chọn loại thuộc tính --</option>
                            <option value="transport"
                                {{ old('name', $attr->name) === 'transport' ? 'selected' : '' }}>
                                Phương tiện di chuyển
                            </option>
                            <option value="tour_type"
                                {{ old('name', $attr->name) === 'tour_type' ? 'selected' : '' }}>
                                Loại tour
                            </option>
                        </select>

                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Giá trị thuộc tính -->
                    <div>
                        <label class="block text-slate-700 font-medium mb-2">
                            Giá trị thuộc tính <span class="text-red-500">*</span>
                        </label>

                        <input type="text"
                               name="value"
                               value="{{ old('value', $attr->value) }}"
                               required
                               oninvalid="this.setCustomValidity('Vui lòng nhập giá trị thuộc tính')"
                               oninput="this.setCustomValidity('')"
                               placeholder="VD: Ô tô, Máy bay, Tour ghép đoàn..."
                               class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none
                               @error('value') border-red-500 @enderror">

                        @error('value')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Buttons Responsive -->
                    <div class="flex flex-col sm:flex-row sm:justify-end gap-3 pt-4">

                        <button type="submit"
                                class="bg-blue-600 text-sm font-medium hover:bg-blue-700
                               text-white px-6 py-2 rounded-lg">
                            <i class="fa fa-save"></i> Cập nhật
                        </button>

                        <a href="{{ route('admin.attr.index') }}"
                           class="w-full sm:w-auto text-center bg-gray-400 hover:bg-slate-500 text-white px-6 py-2 rounded-lg font-medium text-sm text-center">
                            <i class="fa fa-times"></i> Hủy
                        </a>

                    </div>

                </form>

            </div>
        </div>
    </div>
</div>
@endsection

