@extends('admins.master')

@section('title', 'Thêm Tour du lịch mới')

@section('home')
<div class="min-h-screen bg-slate-50 px-4 sm:px-6 lg:px-8 py-8">
    <div class="max-w-5xl mx-auto space-y-8">

        {{-- HEADER --}}
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-teal-400 to-emerald-500 flex items-center justify-center text-white shadow-lg shadow-teal-200">
                    <i class="fa-solid fa-map-location-dot text-lg"></i>
                </div>
                <div>
                    <h4 class="text-2xl sm:text-3xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-teal-700 to-emerald-600">
                        Thêm mới Tour du lịch
                    </h4>
                    <p class="text-sm text-slate-500 mt-1">Khởi tạo một chuyến đi mới trên hệ thống</p>
                </div>
            </div>

            <a href="{{ route('admin.tours.index') }}"
               class="inline-flex items-center gap-2 px-5 py-2.5 bg-white border border-slate-200 hover:border-slate-300 hover:bg-slate-50 text-slate-700 text-sm font-semibold rounded-xl transition-all duration-300 shadow-sm group">
                <i class="fa-solid fa-arrow-left group-hover:-translate-x-1 transition-transform"></i>
                <span>Quay lại</span>
            </a>
        </div>

        {{-- ERROR --}}
        @if ($errors->any())
            <div class="mb-6 rounded-2xl border border-rose-200 bg-rose-50/50 p-5 backdrop-blur-sm">
                <div class="flex items-center gap-3 mb-2">
                    <i class="fa-solid fa-circle-exclamation text-rose-500 text-lg"></i>
                    <p class="font-semibold text-rose-700 text-base">Vui lòng kiểm tra lại thông tin:</p>
                </div>
                <ul class="list-disc list-inside text-rose-600 text-sm space-y-1 ml-7">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- FORM CARD --}}
        <div class="bg-white/90 backdrop-blur-xl border border-white shadow-2xl shadow-slate-200/50 rounded-3xl overflow-hidden relative">
            <div class="absolute top-0 right-0 p-32 bg-teal-50 rounded-full blur-3xl opacity-60 -z-10 -translate-y-1/2 translate-x-1/2"></div>
            
            <form action="{{ route('admin.tours.store') }}" method="POST" enctype="multipart/form-data" class="relative z-10 p-6 sm:p-10 space-y-10">
                @csrf

                {{-- ===== THÔNG TIN CƠ BẢN ===== --}}
                <section>
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-8 h-8 rounded-lg bg-teal-50 text-teal-600 flex items-center justify-center">
                            <i class="fa-solid fa-circle-info text-sm"></i>
                        </div>
                        <h5 class="text-lg font-bold text-slate-800">Thông tin cơ bản</h5>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label class="block text-slate-700 font-semibold mb-2">
                                Tên tour <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" name="name" value="{{ old('name') }}" placeholder="VD: Tour Đà Lạt - Thành phố mộng mơ..." class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-700 placeholder-slate-400 font-medium focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 transition-all duration-300 @error('name') border-rose-500 @enderror">
                        </div>

                        <div>
                            <label class="block text-slate-700 font-semibold mb-2">Giá tour <span class="text-rose-500">*</span></label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400 font-medium">VNĐ</span>
                                <input type="number" name="sale_price" value="{{ old('sale_price') }}" placeholder="0" min="0" class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-14 pr-4 py-3 text-slate-700 font-bold focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 transition-all duration-300 @error('sale_price') border-rose-500 @enderror">
                            </div>
                        </div>

                        <div>
                            <label class="block text-slate-700 font-semibold mb-2">
                                Danh mục <span class="text-rose-500">*</span>
                            </label>
                            <select name="category_id" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-700 font-medium focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 transition-all duration-300 cursor-pointer">
                                <option value="">-- Chọn danh mục --</option>
                                @foreach ($categoryOptions as $opt)
                                    <option value="{{ $opt['id'] }}" {{ $opt['selected'] ? 'selected' : '' }}>
                                        {{ $opt['name'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </section>

                <hr class="border-slate-100">

                {{-- ===== ĐỊA ĐIỂM & THỜI GIAN ===== --}}
                <section>
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-8 h-8 rounded-lg bg-teal-50 text-teal-600 flex items-center justify-center">
                            <i class="fa-solid fa-route text-sm"></i>
                        </div>
                        <h5 class="text-lg font-bold text-slate-800">Lộ trình & Tổ chức</h5>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-slate-700 font-semibold mb-2">Điểm bắt đầu <span class="text-rose-500">*</span></label>
                            <div class="relative">
                                <i class="fa-solid fa-location-dot absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                                <input type="text" name="start_location" placeholder="Hà Nội / Hồ Chí Minh" value="{{ old('start_location') }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-10 pr-4 py-3 text-slate-700 font-medium focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 transition-all duration-300">
                            </div>
                        </div>

                        <div>
                            <label class="block text-slate-700 font-semibold mb-2">Điểm kết thúc <span class="text-rose-500">*</span></label>
                            <div class="relative">
                                <i class="fa-solid fa-flag-checkered absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                                <input type="text" name="end_location" placeholder="Đà Nẵng / Phú Quốc" value="{{ old('end_location') }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-10 pr-4 py-3 text-slate-700 font-medium focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 transition-all duration-300">
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-slate-700 font-semibold mb-2">Thời lượng <span class="text-rose-500">*</span></label>
                            <input type="text" name="time" placeholder="3 ngày 2 đêm" value="{{ old('time') }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-700 font-medium focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 transition-all duration-300">
                        </div>

                        <div>
                            <label class="block text-slate-700 font-semibold mb-2">Khởi hành lúc <span class="text-rose-500">*</span></label>
                            <input type="date" name="start_date" value="{{ old('start_date') }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-700 font-medium focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 transition-all duration-300 cursor-pointer">
                        </div>
                        
                        <div>
                            <label class="block text-slate-700 font-semibold mb-2">Số khách (Tối đa) <span class="text-rose-500">*</span></label>
                            <input type="number" name="quantity" placeholder="0" min="1" value="{{ old('quantity') }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-700 font-medium focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 transition-all duration-300">
                        </div>
                    </div>
                </section>

                <hr class="border-slate-100">

                {{-- ===== HÌNH ẢNH ===== --}}
                <section>
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-8 h-8 rounded-lg bg-teal-50 text-teal-600 flex items-center justify-center">
                            <i class="fa-solid fa-images text-sm"></i>
                        </div>
                        <h5 class="text-lg font-bold text-slate-800">Hình ảnh</h5>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-slate-700 font-semibold mb-2">Ảnh đại diện chính <span class="text-rose-500">*</span></label>
                            <label class="flex flex-col items-center justify-center w-full h-40 border-2 border-slate-200 border-dashed rounded-2xl cursor-pointer bg-slate-50 hover:bg-slate-100 transition-colors">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <i class="fa-solid fa-cloud-arrow-up text-3xl text-slate-400 mb-2"></i>
                                    <p class="text-sm text-slate-500 font-medium"><span class="text-teal-500">Tải ảnh lên</span> hoặc kéo thả</p>
                                </div>
                                <input type="file" name="file" class="hidden" accept="image/*" onchange="previewMain(event)">
                            </label>
                            <img id="main-preview" class="hidden mt-4 w-full h-48 object-cover rounded-xl shadow-md border border-slate-100">
                        </div>

                        <div>
                            <label class="block text-slate-700 font-semibold mb-2">Ảnh mô tả phụ (Nhiều ảnh)</label>
                            <label class="flex flex-col items-center justify-center w-full h-40 border-2 border-slate-200 border-dashed rounded-2xl cursor-pointer bg-slate-50 hover:bg-slate-100 transition-colors">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <i class="fa-regular fa-images text-3xl text-slate-400 mb-2"></i>
                                    <p class="text-sm text-slate-500 font-medium"><span class="text-teal-500">Tải nhiều ảnh lên</span></p>
                                </div>
                                <input type="file" name="files[]" multiple class="hidden" accept="image/*" onchange="previewGallery(event)">
                            </label>
                            <div id="gallery-preview" class="mt-4 grid grid-cols-4 gap-2"></div>
                        </div>
                    </div>
                </section>

                <hr class="border-slate-100">

                {{-- ===== THUỘC TÍNH & TRẠNG THÁI ===== --}}
                <section>
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-8 h-8 rounded-lg bg-teal-50 text-teal-600 flex items-center justify-center">
                            <i class="fa-solid fa-list-check text-sm"></i>
                        </div>
                        <h5 class="text-lg font-bold text-slate-800">Tùy chọn & Trạng thái</h5>
                    </div>

                    <div class="mb-8">
                        <label class="block text-slate-700 font-semibold mb-3">Loại hình Tour</label>
                        <div class="flex flex-wrap gap-3">
                            @foreach ($tourType as $item)
                                <label class="relative inline-flex items-center outline-none cursor-pointer group">
                                    <input type="checkbox" name="attr[]" value="{{ $item->id }}" class="peer sr-only" {{ in_array($item->id, old('attr', [])) ? 'checked' : '' }}>
                                    <div class="px-4 py-2 rounded-xl bg-slate-50 border border-slate-200 text-slate-600 font-medium text-sm transition-all duration-300 peer-checked:bg-teal-500 peer-checked:text-white peer-checked:border-teal-500 hover:bg-slate-100 peer-checked:hover:bg-teal-600 shadow-sm">
                                        {{ $item->value }}
                                    </div>
                                    <i class="fa-solid fa-check absolute top-0 right-0 -mt-2 -mr-2 bg-emerald-500 text-white p-1 rounded-full text-[8px] opacity-0 peer-checked:opacity-100 transition-opacity z-10 shadow-sm border-2 border-white"></i>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-slate-700 font-semibold mb-2">Mô tả Tour</label>
                            <textarea name="description" rows="5" placeholder="Viết mô tả hấp dẫn về trải nghiệm tour..." class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-700 font-medium focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 transition-all duration-300">{{ old('description') }}</textarea>
                        </div>
                        
                        <div>
                            <label class="block text-slate-700 font-semibold mb-2">Trạng thái phát hành</label>
                            <select name="status" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-700 font-medium focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 transition-all duration-300 cursor-pointer mb-4">
                                <option value="1" {{ old('status', 1) == 1 ? 'selected' : '' }}>Hoạt động (Hiển thị ngay)</option>
                                <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>Ẩn (Bản nháp)</option>
                            </select>
                            
                            <div class="p-4 bg-teal-50 border border-teal-100 rounded-xl">
                                <div class="flex gap-3">
                                    <i class="fa-regular fa-lightbulb text-teal-500 text-lg mt-0.5"></i>
                                    <p class="text-sm font-medium text-teal-700">Mẹo: Khi tour mới được tạo nhưng chưa hoàn chỉnh, bạn nên chọn "Ẩn" để lưu bản nháp và chỉ mở "Hoạt động" khi đã chắc chắn lộ trình.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <hr class="border-slate-100">

                {{-- ACTION BUTTONS --}}
                <div class="flex flex-col sm:flex-row justify-end gap-4 pt-2">
                    <a href="{{ route('admin.tours.index') }}"
                        class="inline-flex justify-center items-center gap-2 bg-slate-100 hover:bg-slate-200 text-slate-700 px-8 py-3.5 rounded-xl font-bold transition-all duration-300 text-sm">
                        <i class="fa-solid fa-xmark text-lg"></i> Hủy
                    </a>
                    
                    <button type="submit"
                        class="inline-flex justify-center items-center gap-2 bg-gradient-to-r from-teal-500 to-emerald-600 hover:from-teal-600 hover:to-emerald-700 text-white px-8 py-3.5 rounded-xl font-bold shadow-lg shadow-teal-200/50 hover:shadow-xl hover:shadow-teal-300/50 hover:-translate-y-0.5 transition-all duration-300 text-sm">
                        <i class="fa-solid fa-check text-lg"></i> Lưu Tour mới
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
    function previewMain(event) {
        const file = event.target.files[0];
        if (file) {
            const preview = document.getElementById('main-preview');
            preview.src = URL.createObjectURL(file);
            preview.classList.remove('hidden');
        }
    }

    function previewGallery(event) {
        const files = event.target.files;
        const container = document.getElementById('gallery-preview');
        container.innerHTML = ''; 
        
        for (let i = 0; i < files.length; i++) {
            const img = document.createElement('img');
            img.src = URL.createObjectURL(files[i]);
            img.className = 'w-full aspect-square object-cover rounded-lg shadow-sm border border-slate-100';
            container.appendChild(img);
        }
    }
</script>
@endsection

