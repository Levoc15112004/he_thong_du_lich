@extends('admins.master')

@section('title', 'Cập nhật Tour du lịch')

@section('home')
<div class="min-h-screen bg-transparent dark:bg-transparent px-4 sm:px-6 lg:px-8 py-8">
    <div class="max-w-5xl mx-auto space-y-8">

        {{-- HEADER --}}
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-amber-400 to-orange-500 flex items-center justify-center text-white shadow-lg shadow-amber-200">
                    <i class="fa-solid fa-pen-to-square text-lg"></i>
                </div>
                <div>
                    <h4 class="text-2xl sm:text-3xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-amber-600 to-orange-500">
                        Cập nhật Tour du lịch
                    </h4>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Chỉnh sửa thông tin chuyến đi <strong>{{ $tour->name }}</strong></p>
                </div>
            </div>

            <a href="{{ route('admin.tours.index') }}"
               class="inline-flex items-center gap-2 px-5 py-2.5 bg-white border border-slate-200 dark:border-slate-800 hover:border-slate-300 hover:bg-slate-50 text-slate-700 dark:text-slate-200 text-sm font-semibold rounded-xl transition-colors duration-200 shadow-sm group">
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
            <div class="absolute top-0 right-0 p-32 bg-amber-50 rounded-full blur-3xl opacity-60 -z-10 -translate-y-1/2 translate-x-1/2"></div>
            
            <form action="{{ route('admin.tours.update', $tour->id) }}" method="POST" enctype="multipart/form-data" class="relative z-10 p-6 sm:p-10 space-y-10">
                @csrf
                @method('PUT')

                {{-- ===== THÔNG TIN CƠ BẢN ===== --}}
                <section>
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-8 h-8 rounded-lg bg-orange-50 text-orange-500 flex items-center justify-center">
                            <i class="fa-solid fa-circle-info text-sm"></i>
                        </div>
                        <h5 class="text-lg font-bold text-slate-800 dark:text-white">Thông tin cơ bản</h5>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="md:col-span-3">
                            <label class="block text-slate-700 dark:text-slate-200 font-semibold mb-2">
                                Tên tour <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" name="name" value="{{ old('name', $tour->name) }}" class="w-full bg-slate-50 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-3 text-slate-700 dark:text-slate-200 font-medium focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-colors duration-200 @error('name') border-rose-500 @enderror">
                        </div>

                        <div>
                            <label class="block text-slate-700 dark:text-slate-200 font-semibold mb-2">Giá niêm yết (Gốc)</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400 font-medium">VNĐ</span>
                                <input type="number" name="price" value="{{ old('price', $tour->price) }}" placeholder="Tự tính nếu để trống" min="0" class="w-full bg-slate-50 border border-slate-200 dark:border-slate-800 rounded-xl pl-14 pr-4 py-3 text-slate-700 dark:text-slate-200 font-bold focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-colors duration-200">
                            </div>
                        </div>

                        <div>
                            <label class="block text-slate-700 dark:text-slate-200 font-semibold mb-2">Giá bán / Khuyến mãi <span class="text-rose-500">*</span></label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400 font-medium">VNĐ</span>
                                <input type="number" name="sale_price" value="{{ old('sale_price', $tour->sale_price) }}" min="0" class="w-full bg-slate-50 border border-slate-200 dark:border-slate-800 rounded-xl pl-14 pr-4 py-3 text-slate-700 dark:text-slate-200 font-bold focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-colors duration-200 @error('sale_price') border-rose-500 @enderror">
                            </div>
                        </div>

                        <div>
                            <label class="block text-slate-700 dark:text-slate-200 font-semibold mb-2">
                                Danh mục <span class="text-rose-500">*</span>
                            </label>
                            <select name="category_id" class="w-full bg-slate-50 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-3 text-slate-700 dark:text-slate-200 font-medium focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-colors duration-200 cursor-pointer">
                                <option value="">-- Chọn danh mục --</option>
                                @foreach ($categoryOptions as $opt)
                                    <option value="{{ $opt['id'] }}" {{ old('category_id', $tour->category_id) == $opt['id'] ? 'selected' : '' }}>
                                        {{ $opt['name'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </section>

                <hr class="border-slate-100 dark:border-slate-800">

                {{-- ===== ĐỊA ĐIỂM & THỜI GIAN ===== --}}
                <section>
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-8 h-8 rounded-lg bg-orange-50 text-orange-500 flex items-center justify-center">
                            <i class="fa-solid fa-route text-sm"></i>
                        </div>
                        <h5 class="text-lg font-bold text-slate-800 dark:text-white">Lộ trình & Tổ chức</h5>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-slate-700 dark:text-slate-200 font-semibold mb-2">Điểm bắt đầu <span class="text-rose-500">*</span></label>
                            <div class="relative">
                                <i class="fa-solid fa-location-dot absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                                <input type="text" name="start_location" value="{{ old('start_location', $tour->start_location) }}" class="w-full bg-slate-50 border border-slate-200 dark:border-slate-800 rounded-xl pl-10 pr-4 py-3 text-slate-700 dark:text-slate-200 font-medium focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-colors duration-200">
                            </div>
                        </div>

                        <div>
                            <label class="block text-slate-700 dark:text-slate-200 font-semibold mb-2">Điểm kết thúc <span class="text-rose-500">*</span></label>
                            <div class="relative">
                                <i class="fa-solid fa-flag-checkered absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                                <input type="text" name="end_location" value="{{ old('end_location', $tour->end_location) }}" class="w-full bg-slate-50 border border-slate-200 dark:border-slate-800 rounded-xl pl-10 pr-4 py-3 text-slate-700 dark:text-slate-200 font-medium focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-colors duration-200">
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-slate-700 dark:text-slate-200 font-semibold mb-2">Thời lượng <span class="text-rose-500">*</span></label>
                            <input type="text" name="time" value="{{ old('time', $tour->time) }}" class="w-full bg-slate-50 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-3 text-slate-700 dark:text-slate-200 font-medium focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-colors duration-200">
                        </div>

                        <div>
                            <label class="block text-slate-700 dark:text-slate-200 font-semibold mb-2">Khởi hành lúc <span class="text-rose-500">*</span></label>
                            <input type="date" name="start_date" value="{{ old('start_date', optional($tour->start_date)->format('Y-m-d')) }}" class="w-full bg-slate-50 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-3 text-slate-700 dark:text-slate-200 font-medium focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-colors duration-200 cursor-pointer">
                        </div>
                        
                        <div>
                            <label class="block text-slate-700 dark:text-slate-200 font-semibold mb-2">Số khách (Tối đa) <span class="text-rose-500">*</span></label>
                            <input type="number" name="quantity" min="1" value="{{ old('quantity', $tour->quantity) }}" class="w-full bg-slate-50 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-3 text-slate-700 dark:text-slate-200 font-medium focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-colors duration-200">
                        </div>
                    </div>
                </section>

                <hr class="border-slate-100 dark:border-slate-800">

                {{-- ===== HÌNH ẢNH ===== --}}
                <section>
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-8 h-8 rounded-lg bg-orange-50 text-orange-500 flex items-center justify-center">
                            <i class="fa-solid fa-images text-sm"></i>
                        </div>
                        <h5 class="text-lg font-bold text-slate-800 dark:text-white">Hình ảnh</h5>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-slate-700 dark:text-slate-200 font-semibold mb-2">Ảnh đại diện chính</label>
                            <div class="relative group rounded-2xl overflow-hidden border border-slate-200 dark:border-slate-800 bg-slate-50 inline-block w-full">
                                <img id="preview-main" src="{{ asset($tour->image) }}" class="w-full object-cover h-48">
                                <label class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm opacity-0 group-hover:opacity-100 transition-opacity flex flex-col items-center justify-center text-white cursor-pointer">
                                    <i class="fa-solid fa-cloud-arrow-up text-3xl mb-2"></i>
                                    <span class="font-medium">Đổi ảnh mới</span>
                                    <input type="file" name="file" class="hidden" accept="image/*" onchange="previewMainImage(event)">
                                </label>
                            </div>
                        </div>

                        <div>
                            <label class="block text-slate-700 dark:text-slate-200 font-semibold mb-2">Thêm ảnh mô tả phụ vào bộ sưu tập</label>
                            <label class="flex flex-col items-center justify-center w-full h-40 border-2 border-slate-200 dark:border-slate-800 border-dashed rounded-2xl cursor-pointer bg-slate-50 dark:bg-slate-900 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <i class="fa-regular fa-images text-3xl text-slate-400 mb-2"></i>
                                    <p class="text-sm text-slate-500 dark:text-slate-400 font-medium"><span class="text-orange-500">Tải thêm ảnh lên</span></p>
                                </div>
                                <input type="file" id="edit-gallery-input" name="files[]" multiple class="hidden" accept="image/*" onchange="previewGallery(event)">
                            </label>

                            <div id="new-gallery-preview" class="mt-4 grid grid-cols-3 sm:grid-cols-4 gap-3 hidden"></div>
                            
                            @if(count($tour->images))
                                <div id="gallery-wrapper" class="mt-5 pt-4 border-t border-slate-100 dark:border-slate-800">
                                    <p class="text-xs font-semibold text-slate-500 dark:text-slate-400 mb-2 flex items-center justify-between">
                                        <span>Các ảnh phụ hiện tại (bấm nút x để xóa ảnh lỗi):</span>
                                        <span class="text-[10px] text-slate-400">{{ count($tour->images) }} ảnh</span>
                                    </p>
                                    <div class="grid grid-cols-3 sm:grid-cols-4 gap-3">
                                        @foreach ($tour->images as $img)
                                            <div class="relative aspect-square rounded-xl overflow-hidden shadow-sm border border-slate-200 dark:border-slate-800 group" id="existing-img-{{ $img->id }}">
                                                <img src="{{ Str::startsWith($img->image, ['http://', 'https://']) ? $img->image : asset($img->image) }}" class="w-full h-full object-cover">
                                                <button type="button" onclick="deleteExistingImage({{ $img->id }})" class="absolute top-1.5 right-1.5 w-6 h-6 bg-rose-600 hover:bg-rose-700 text-white rounded-full flex items-center justify-center text-xs shadow-md transition-colors" title="Xóa ảnh này">
                                                    <i class="fa-solid fa-xmark"></i>
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </section>

                <hr class="border-slate-100 dark:border-slate-800">

                {{-- ===== THUỘC TÍNH & TRẠNG THÁI ===== --}}
                <section>
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-8 h-8 rounded-lg bg-orange-50 text-orange-500 flex items-center justify-center">
                            <i class="fa-solid fa-list-check text-sm"></i>
                        </div>
                        <h5 class="text-lg font-bold text-slate-800 dark:text-white">Tùy chọn & Trạng thái</h5>
                    </div>

                    <div class="mb-8">
                        <label class="block text-slate-700 dark:text-slate-200 font-semibold mb-3">Loại hình Tour</label>
                        <div class="flex flex-wrap gap-3">
                            @foreach ($tourType as $attr)
                                <label class="relative inline-flex items-center outline-none cursor-pointer group">
                                    <input type="checkbox" name="attr[]" value="{{ $attr->id }}" class="peer sr-only" {{ in_array($attr->id, old('attr', $tour->attrTours->pluck('id')->toArray())) ? 'checked' : '' }}>
                                    <div class="px-4 py-2 rounded-xl bg-slate-50 border border-slate-200 dark:border-slate-800 text-slate-600 font-medium text-sm transition-colors duration-200 peer-checked:bg-orange-500 peer-checked:text-white peer-checked:border-orange-500 hover:bg-slate-100 peer-checked:hover:bg-orange-600 shadow-sm">
                                        {{ $attr->value }}
                                    </div>
                                    <i class="fa-solid fa-check absolute top-0 right-0 -mt-2 -mr-2 bg-rose-500 text-white p-1 rounded-full text-[8px] opacity-0 peer-checked:opacity-100 transition-opacity z-10 shadow-sm border-2 border-white"></i>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-slate-700 dark:text-slate-200 font-semibold mb-2">Mô tả Tour</label>
                            <textarea name="description" rows="5" class="w-full bg-slate-50 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-3 text-slate-700 dark:text-slate-200 font-medium focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-colors duration-200">{{ old('description', $tour->description) }}</textarea>
                        </div>
                        
                        <div>
                            <label class="block text-slate-700 dark:text-slate-200 font-semibold mb-2">Trạng thái phát hành</label>
                            <select name="status" class="w-full bg-slate-50 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-3 text-slate-700 dark:text-slate-200 font-medium focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-colors duration-200 cursor-pointer mb-4">
                                <option value="1" {{ old('status', $tour->status) == 1 ? 'selected' : '' }}>Hoạt động (Hiển thị ngay)</option>
                                <option value="0" {{ old('status', $tour->status) == 0 ? 'selected' : '' }}>Ẩn (Bản nháp)</option>
                            </select>
                        </div>
                    </div>
                </section>

                <hr class="border-slate-100 dark:border-slate-800">

                {{-- ACTION BUTTONS --}}
                <div class="flex flex-col sm:flex-row justify-end gap-4 pt-2">
                    <a href="{{ route('admin.tours.index') }}"
                        class="inline-flex justify-center items-center gap-2 bg-slate-100 hover:bg-slate-200 text-slate-700 dark:text-slate-200 px-8 py-3.5 rounded-xl font-bold transition-colors duration-200 text-sm">
                        <i class="fa-solid fa-xmark text-lg"></i> Hủy
                    </a>
                    
                    <button type="submit"
                        class="inline-flex justify-center items-center gap-2 bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-600 hover:to-orange-600 text-white px-8 py-3.5 rounded-xl font-bold shadow-lg shadow-orange-200/50 hover:shadow-xl hover:shadow-orange-300/50 hover:-translate-y-0.5 transition-colors duration-200 text-sm">
                        <i class="fa-solid fa-check text-lg"></i> Lưu thay đổi
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
    function previewMainImage(e) {
        if(e.target.files[0]) {
            document.getElementById('preview-main').src = URL.createObjectURL(e.target.files[0]);
        }
    }

    let editGalleryDT = new DataTransfer();

    function previewGallery(event) {
        const input = document.getElementById('edit-gallery-input');
        if (!input) return;

        for (let i = 0; i < event.target.files.length; i++) {
            editGalleryDT.items.add(event.target.files[i]);
        }
        input.files = editGalleryDT.files;
        renderNewGalleryPreview();
    }

    function removeNewGalleryItem(index) {
        const input = document.getElementById('edit-gallery-input');
        const newDT = new DataTransfer();
        for (let i = 0; i < editGalleryDT.files.length; i++) {
            if (i !== index) {
                newDT.items.add(editGalleryDT.files[i]);
            }
        }
        editGalleryDT = newDT;
        if (input) input.files = editGalleryDT.files;
        renderNewGalleryPreview();
    }

    function renderNewGalleryPreview() {
        const container = document.getElementById('new-gallery-preview');
        if (!container) return;
        container.innerHTML = '';

        if (editGalleryDT.files.length > 0) {
            container.classList.remove('hidden');
            for (let i = 0; i < editGalleryDT.files.length; i++) {
                const file = editGalleryDT.files[i];
                const div = document.createElement('div');
                div.className = 'relative aspect-square rounded-xl overflow-hidden shadow-sm border border-slate-200 dark:border-slate-800 group';
                div.innerHTML = `
                    <img src="${URL.createObjectURL(file)}" class="w-full h-full object-cover">
                    <button type="button" onclick="removeNewGalleryItem(${i})" class="absolute top-1.5 right-1.5 w-6 h-6 bg-rose-600 hover:bg-rose-700 text-white rounded-full flex items-center justify-center text-xs shadow-md transition-colors" title="Bỏ ảnh này">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                `;
                container.appendChild(div);
            }
        } else {
            container.classList.add('hidden');
        }
    }

    function deleteExistingImage(imgId) {
        if (!confirm('Bạn có chắc chắn muốn xóa ảnh phụ này khỏi tour?')) return;

        const csrfToken = '{{ csrf_token() }}';
        const url = '{{ route("admin.tours.deleteImage", ":id") }}'.replace(':id', imgId);

        fetch(url, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const el = document.getElementById('existing-img-' + imgId);
                if (el) el.remove();
            } else {
                alert('Không thể xóa ảnh. Vui lòng thử lại!');
            }
        })
        .catch(err => {
            console.error(err);
            alert('Lỗi kết nối khi xóa ảnh!');
        });
    }
</script>
@endsection
