@extends('admins.master')

@section('title', 'Quản lý danh mục')

@section('home')
<div class="min-h-screen bg-slate-50 px-4 sm:px-6 lg:px-8 py-8">
    <div class="max-w-[120rem] mx-auto">

        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-8">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-teal-400 to-emerald-500 flex items-center justify-center text-white shadow-lg shadow-teal-200">
                    <i class="fa-solid fa-list-ul text-lg"></i>
                </div>
                <div>
                    <h4 class="text-2xl sm:text-3xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-teal-700 to-emerald-600">
                        Danh sách danh mục
                    </h4>
                    <p class="text-sm text-slate-500 mt-1">Quản lý và sắp xếp cấu trúc danh mục hệ thống</p>
                </div>
            </div>

            <div class="flex items-center gap-3 mt-4 sm:mt-0">
                <a href="{{ route('categories.create') }}"
                   class="flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-teal-500 to-emerald-600 text-white font-semibold rounded-xl shadow-lg shadow-teal-200/50 hover:shadow-xl hover:shadow-teal-300/50 hover:-translate-y-0.5 transition-all duration-300 group">
                    <i class="fa-solid fa-plus group-hover:rotate-90 transition-transform duration-300"></i>
                    <span>Thêm danh mục mới</span>
                </a>
            </div>
        </div>

        <!-- Card -->
        <div class="bg-white/80 backdrop-blur-xl border border-white shadow-2xl shadow-slate-200/50 rounded-3xl p-6 sm:p-8 overflow-hidden">
            @if($tree->isEmpty())
                <div class="flex flex-col items-center justify-center py-12 text-center">
                    <div class="w-24 h-24 mb-4 rounded-full bg-teal-50 flex items-center justify-center text-teal-400">
                        <i class="fa-regular fa-folder-open text-4xl"></i>
                    </div>
                    <h5 class="text-lg font-semibold text-slate-700">Chưa có danh mục nào</h5>
                    <p class="text-slate-500 mt-2">Vui lòng thêm danh mục mới để bắt đầu sử dụng.</p>
                </div>
            @else
                <div class="dd font-sans" id="nestable">
                    <ol class="dd-list space-y-3">
                        @foreach($tree as $node)
                            @include('admins.Categories._node', ['node' => $node])
                        @endforeach
                    </ol>
                </div>
                
                <div class="mt-8 pt-4 border-t border-slate-100 flex justify-end">
                    <button id="save-order" class="px-5 py-2.5 bg-slate-800 hover:bg-slate-900 text-white text-sm font-medium rounded-xl shadow-md transition-colors flex items-center gap-2">
                        <i class="fa-solid fa-sort"></i> Lưu thứ tự
                    </button>
                </div>
            @endif
        </div>

    </div>
</div>

<!-- Nestable Script -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Nestable/2012-10-15/jquery.nestable.min.js"></script>

<style>
/* Tweak nestable drag styling */
.dd-dragel { position: absolute; pointer-events: none; z-index: 9999; }
.dd-dragel > .dd-item .dd-handle { margin-top: 0; }
.dd-dragel .dd-item { 
    opacity: 0.9;
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1); 
    border-radius: 16px;
    list-style: none;
}
.dd-placeholder { 
    display: block; position: relative; margin: 0; padding: 0; min-height: 48px;
    background: #f0fdfa; border: 2px dashed #14b8a6; box-sizing: border-box; 
    border-radius: 16px; margin-bottom: 12px; margin-top: 8px;
}
</style>

<script>
$(document).ready(function() {
    $('#nestable').nestable({
        maxDepth: 5,
    });

    $('#save-order').on('click', function(){
        const btn = $(this);
        const originalContent = btn.html();
        btn.html('<i class="fa-solid fa-spinner fa-spin"></i> Đang lưu...');
        btn.prop('disabled', true);

        const tree = $('#nestable').nestable('serialize');

        $.post("{{ route('categories.reorder') }}", {
            tree: tree,
            _token: "{{ csrf_token() }}"
        }).done(() => {
            location.reload();
        }).fail(() => {
            alert('Có lỗi xảy ra khi lưu thứ tự!');
            btn.html(originalContent);
            btn.prop('disabled', false);
        });
    });
});
</script>

@endsection

