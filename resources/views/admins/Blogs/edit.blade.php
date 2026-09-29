@extends('admins.master')

@section('title', 'Cập nhật bài viết Blog')

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
                        Cập nhật bài viết
                    </h4>
                    <p class="text-sm text-slate-500 mt-1">Sửa đổi thông tin và nội dung bài viết</p>
                </div>
            </div>

            <a href="{{ route('admin.blogs.index') }}"
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
            
            <form action="{{ route('admin.blogs.update', $blog->id) }}" method="POST" enctype="multipart/form-data" class="relative z-10 p-6 sm:p-10 space-y-8">
                @csrf
                @method('PUT')

                {{-- ===== THÔNG TIN CHUNG ===== --}}
                <section>
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-8 h-8 rounded-lg bg-orange-50 text-orange-500 flex items-center justify-center">
                            <i class="fa-solid fa-circle-info text-sm"></i>
                        </div>
                        <h5 class="text-lg font-bold text-slate-800">Thông tin cơ bản</h5>
                    </div>

                    <div class="grid grid-cols-1 gap-6">
                        
                        {{-- Title --}}
                        <div>
                            <label class="block text-slate-700 font-semibold mb-2">
                                Tiêu đề bài viết <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" name="title" value="{{ old('title', $blog->title) }}" placeholder="Nhập tiêu đề hấp dẫn..." 
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-700 font-bold text-lg focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition-all duration-300 {{ $errors->has('title') ? 'border-rose-300' : '' }}">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- Image Upload --}}
                            <div>
                                <label class="block text-slate-700 font-semibold mb-2">
                                    Thay đổi ảnh đại diện <span class="text-slate-400 text-xs font-normal ml-1">(Bỏ qua nếu giữ nguyên)</span>
                                </label>
                                <label class="flex items-center justify-center w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 cursor-pointer hover:bg-slate-100 hover:border-amber-400 transition-colors group {{ $errors->has('image') ? 'border-rose-300 bg-rose-50' : '' }}">
                                    <div class="flex items-center gap-2">
                                        <i class="fa-solid fa-cloud-arrow-up text-slate-400 group-hover:text-amber-500 transition-colors"></i>
                                        <span class="text-sm font-medium text-slate-600 group-hover:text-amber-600 transition-colors" id="file-name">Tải ảnh mới lên (JPG, PNG)</span>
                                    </div>
                                    <input type="file" name="image" class="hidden" accept="image/*" onchange="previewMainImage(event)">
                                </label>
                            </div>

                            {{-- Status --}}
                            <div>
                                <label class="block text-slate-700 font-semibold mb-2">Trạng thái hiển thị <span class="text-rose-500">*</span></label>
                                <div class="relative">
                                    <i class="fa-solid fa-eye absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                                    <select name="status" class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-10 pr-4 py-3 text-slate-700 font-medium focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 appearance-none transition-all duration-300 cursor-pointer">
                                        <option value="">-- Chọn trạng thái --</option>
                                        <option value="1" {{ old('status', $blog->status) == 1 ? 'selected' : '' }}>Hiển thị (Public)</option>
                                        <option value="0" {{ old('status', $blog->status) == 0 ? 'selected' : '' }}>Ẩn (Draft)</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        {{-- Image Preview Display --}}
                        <div class="flex justify-center mt-2 group relative rounded-2xl overflow-hidden shadow-sm inline-block mx-auto">
                            <img id="preview-main" src="{{ $blog->image ? asset($blog->image) : '' }}" class="{{ $blog->image ? '' : 'hidden' }} w-full md:w-[600px] h-48 md:h-64 object-cover border border-slate-200">
                            <div class="absolute inset-0 bg-slate-900/10 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center pointer-events-none">
                                <span class="bg-black/60 text-white text-xs font-semibold px-3 py-1.5 rounded-lg border border-white/20 backdrop-blur-md">Ảnh hiện tại</span>
                            </div>
                        </div>

                    </div>
                </section>
                
                <hr class="border-slate-100">

                {{-- ===== NỘI DUNG CKEDITOR ===== --}}
                <section>
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-8 h-8 rounded-lg bg-pink-50 text-pink-500 flex items-center justify-center">
                            <i class="fa-solid fa-paragraph text-sm"></i>
                        </div>
                        <h5 class="text-lg font-bold text-slate-800">Nội dung chi tiết</h5>
                    </div>

                    <div>
                        <textarea name="content" id="editor" rows="10" placeholder="Viết nội dung bài blog..."
                            class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition-all duration-300 {{ $errors->has('content') ? 'border-rose-300' : '' }}">{{ old('content', $blog->content) }}</textarea>
                        {{-- Chèn CSS tùy chỉnh CKEditor để ôm style Tailwind --}}
                        <style>
                            .ck-editor__editable_inline {
                                min-height: 400px;
                                border-radius: 0 0 0.75rem 0.75rem !important;
                                padding: 1rem 1.5rem !important;
                            }
                            .ck-toolbar {
                                border-radius: 0.75rem 0.75rem 0 0 !important;
                                background-color: #f8fafc !important;
                                border-bottom: 1px solid #e2e8f0 !important;
                            }
                        </style>
                    </div>
                </section>

                <hr class="border-slate-100">

                {{-- SUBMIT --}}
                <div class="flex flex-col sm:flex-row justify-end gap-4 pt-2">
                    <button type="submit"
                        class="inline-flex justify-center items-center gap-2 bg-gradient-to-r from-amber-500 to-orange-600 hover:from-amber-600 hover:to-orange-700 text-white px-8 py-3.5 rounded-xl font-bold shadow-lg shadow-orange-200/50 hover:shadow-xl hover:shadow-orange-300/50 hover:-translate-y-0.5 transition-all duration-300 text-sm">
                        <i class="fa-solid fa-floppy-disk text-lg"></i> Lưu thay đổi
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
    function previewMainImage(event) {
        const img = document.getElementById('preview-main');
        const file = event.target.files[0];
        const fileNameLabel = document.getElementById('file-name');

        if (file) {
            fileNameLabel.textContent = file.name;
            img.src = URL.createObjectURL(file);
            img.classList.remove('hidden');
        }
    }
</script>

{{-- CKEditor --}}
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

<script>
    ClassicEditor
        .create(document.querySelector('#editor'), {
            ckfinder: {
                uploadUrl: "{{ route('admin.upload.image', [], false) }}"
            }
        })
        .then(editor => {
            editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
                return {
                    upload: () => {
                        return loader.file.then(file => {
                            return new Promise((resolve, reject) => {
                                let formData = new FormData();
                                formData.append('upload', file);
                                formData.append('_token', "{{ csrf_token() }}");

                                fetch("{{ route('admin.upload.image', [], false) }}", {
                                        method: "POST",
                                        body: formData
                                    })
                                    .then(res => res.json())
                                    .then(data => resolve({ default: data.url }))
                                    .catch(err => reject(err));
                            });
                        });
                    }
                };
            };
        })
        .catch(error => {
            console.error(error);
        });
</script>
@endsection
