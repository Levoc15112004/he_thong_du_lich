@extends('admins.master')

@section('title', 'Cập nhật Banner')

@section('home')
<div class="min-h-screen bg-slate-50 px-4 sm:px-6 lg:px-8 py-8">
    <div class="max-w-5xl mx-auto space-y-8">

        {{-- HEADER --}}
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-amber-400 to-orange-500 flex items-center justify-center text-white shadow-lg shadow-amber-200">
                    <i class="fa-solid fa-pen-to-square text-lg"></i>
                </div>
                <div>
                    <h4 class="text-2xl sm:text-3xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-amber-600 to-orange-500">
                        Cập nhật Banner
                    </h4>
                    <p class="text-sm text-slate-500 mt-1">Sửa đổi thông tin và hình ảnh hiển thị</p>
                </div>
            </div>

            <a href="{{ route('admin.banners.index') }}"
               class="inline-flex items-center gap-2 px-5 py-2.5 bg-white border border-slate-200 hover:border-slate-300 hover:bg-slate-50 text-slate-700 text-sm font-semibold rounded-xl transition-all duration-300 shadow-sm group">
                <i class="fa-solid fa-arrow-left group-hover:-translate-x-1 transition-transform"></i>
                <span>Quay lại danh sách</span>
            </a>
        </div>

        {{-- ALERTS --}}
        @if ($errors->any())
            <div class="rounded-2xl border border-rose-200 bg-rose-50/50 p-5 backdrop-blur-sm">
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
            
            <form action="{{ route('admin.banners.update', $banner->id) }}" method="POST" enctype="multipart/form-data" class="relative z-10 p-6 sm:p-10 space-y-8" novalidate>
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">

                    {{-- Left Column: Form Fields --}}
                    <div class="space-y-6">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-8 h-8 rounded-lg bg-orange-50 text-orange-500 flex items-center justify-center">
                                <i class="fa-solid fa-rectangle-list text-sm"></i>
                            </div>
                            <h5 class="text-lg font-bold text-slate-800">Thông tin Banner</h5>
                        </div>

                        {{-- Name --}}
                        <div>
                            <label class="block text-slate-700 font-semibold mb-2">
                                Tên Banner / Tiêu đề <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" name="name" value="{{ old('name', $banner->name) }}" required
                                oninvalid="this.setCustomValidity('Vui lòng nhập tên banner')"
                                oninput="this.setCustomValidity('')"
                                placeholder="Nhập tên banner..."
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-700 font-medium focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition-all duration-300 {{ $errors->has('name') ? 'border-rose-300' : '' }}">
                        </div>

                        {{-- Image Upload --}}
                        <div>
                            <label class="block text-slate-700 font-semibold mb-2">
                                Thay đổi ảnh <span class="text-slate-400 text-xs font-normal ml-1">(Bỏ qua nếu không sửa)</span>
                            </label>
                            <label class="flex flex-col items-center justify-center w-full bg-slate-50 border-2 border-dashed border-slate-300 rounded-xl px-4 py-8 cursor-pointer hover:bg-slate-100 hover:border-amber-400 transition-colors group {{ $errors->has('image') ? 'border-rose-300 bg-rose-50' : '' }}">
                                <div class="w-12 h-12 rounded-full bg-white shadow-sm flex items-center justify-center mb-3">
                                    <i class="fa-solid fa-cloud-arrow-up text-xl text-amber-500 group-hover:scale-110 transition-transform"></i>
                                </div>
                                <span class="text-sm font-bold text-slate-700 mb-1" id="file-name">Nhấn để chọn hoặc kéo thả ảnh mới</span>
                                <span class="text-xs text-slate-500">Định dạng JPG, PNG. Tối đa 5MB.</span>
                                <input type="file" name="image" class="hidden" accept="image/*" onchange="previewImage(event)" 
                                    oninvalid="this.setCustomValidity('Vui lòng chọn đúng định dạng ảnh')" oninput="this.setCustomValidity('')">
                            </label>
                        </div>

                        {{-- Link URL --}}
                        <div>
                            <label class="block text-slate-700 font-semibold mb-2">
                                Liên kết quảng cáo <span class="text-slate-400 text-xs font-normal ml-1">(Tuỳ chọn)</span>
                            </label>
                            <div class="relative">
                                <i class="fa-solid fa-link absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                                <input type="url" name="link" value="{{ old('link', $banner->link) }}"
                                    oninvalid="this.setCustomValidity('Vui lòng nhập đúng định dạng URL liên kết (https://...)')"
                                    oninput="this.setCustomValidity('')"
                                    placeholder="VD: https://hethongdulich.com/tour-khuyen-mai"
                                    class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-10 pr-4 py-3 text-slate-700 font-medium focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition-all duration-300">
                            </div>
                        </div>
                    </div>

                    {{-- Right Column: Preview --}}
                    <div>
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-8 h-8 rounded-lg bg-pink-50 text-pink-500 flex items-center justify-center">
                                <i class="fa-solid fa-eye text-sm"></i>
                            </div>
                            <h5 class="text-lg font-bold text-slate-800">Hiển thị hiện tại</h5>
                        </div>

                        <div class="w-full aspect-[21/9] bg-slate-100 rounded-2xl border border-slate-200 shadow-inner flex flex-col items-center justify-center overflow-hidden relative group">
                            <img id="preview" src="{{ $banner->image ? asset($banner->image) : '' }}" class="{{ $banner->image ? '' : 'hidden' }} w-full h-full object-cover relative z-10 transition-transform duration-[2s] group-hover:scale-105">
                            
                            <div id="previewPlaceholder" class="{{ $banner->image ? 'hidden' : 'flex' }} flex-col items-center justify-center text-slate-400 p-6 text-center absolute inset-0 z-0">
                                <i class="fa-regular fa-image text-5xl mb-3 opacity-50"></i>
                                <p class="text-sm font-medium">Bản xem trước của banner sẽ hiển thị tại đây.</p>
                            </div>
                        </div>
                    </div>

                </div>
                
                <hr class="border-slate-100">

                {{-- SUBMIT --}}
                <div class="flex justify-end pt-2">
                    <button type="submit"
                        class="w-full sm:w-auto inline-flex justify-center items-center gap-2 bg-gradient-to-r from-amber-500 to-orange-600 hover:from-amber-600 hover:to-orange-700 text-white px-8 py-3.5 rounded-xl font-bold shadow-lg shadow-orange-200/50 hover:shadow-xl hover:shadow-orange-300/50 hover:-translate-y-0.5 transition-all duration-300 text-sm">
                        <i class="fa-solid fa-floppy-disk text-lg"></i> Lưu thay đổi Banner
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
    function previewImage(event) {
        const file = event.target.files[0];
        const fileNameLabel = document.getElementById('file-name');
        const preview = document.getElementById('preview');
        const placeholder = document.getElementById('previewPlaceholder');
        
        if (file) {
            fileNameLabel.textContent = file.name;
            const reader = new FileReader();
            reader.onload = (e) => {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                placeholder.classList.add('hidden');
            };
            reader.readAsDataURL(file);
        }
    }
</script>
@endsection
