<li class="dd-item" data-id="{{ $node->id }}" x-data="{ open: false }">

    <!-- Hộp danh mục -->
    <div @click="open = !open"
        class="flex flex-col sm:flex-row sm:items-center sm:justify-between
               bg-white border border-slate-100 p-3 sm:p-4 rounded-2xl
               shadow-[0_2px_10px_-3px_rgba(6,81,237,0.05)] hover:shadow-[0_8px_20px_-6px_rgba(20,184,166,0.15)] hover:border-teal-100 transition-all duration-300 cursor-pointer gap-4 group mt-2">

        <!-- Left: Toggle + Name -->
        <div class="flex items-center gap-4 min-w-0 flex-1">

            <!-- Drag Handle (Thêm biểu tượng drag) -->
            <div class="dd-handle text-slate-300 hover:text-teal-500 cursor-move transition-colors px-1 h-full flex items-center" @click.stop title="Kéo thả để sắp xếp">
                <i class="fa-solid fa-grip-vertical"></i>
            </div>

            <!-- Icon Mở Nút / Cấp độ -->
            @if ($node->children->count())
                <button type="button" class="w-8 h-8 rounded-full bg-teal-50 text-teal-600 flex items-center justify-center shrink-0 hover:bg-teal-100 transition-colors"
                      :class="open ? 'rotate-180' : ''">
                      <i class="fa-solid fa-chevron-down text-xs transition-transform duration-300"></i>
                </button>
            @else
                <div class="w-8 h-8 rounded-full bg-slate-50 text-slate-300 flex items-center justify-center shrink-0 border border-slate-100">
                    <i class="fa-solid fa-minus text-xs"></i>
                </div>
            @endif

            <!-- Tên danh mục -->
            <span class="text-slate-700 text-base font-semibold truncate group-hover:text-teal-700 transition-colors">
                {{ $node->name }}
            </span>
            
            <!-- Hiển thị Link nếu có -->
            @if($node->link)
                <a href="{{ $node->link }}" target="_blank" @click.stop class="text-[11px] font-medium text-blue-500 hover:text-blue-700 truncate max-w-[200px] hidden sm:inline-flex items-center bg-blue-50/50 border border-blue-100 px-2.5 py-1 rounded-lg transition-colors" title="{{ $node->link }}">
                    <i class="fa-solid fa-link mr-1.5 text-[10px]"></i> {{ $node->link }}
                </a>
            @endif
        </div>

        <!-- Right: Action buttons -->
        <div class="flex items-center gap-2 sm:justify-end opacity-100 sm:opacity-0 sm:group-hover:opacity-100 transition-opacity duration-300"
             @click.stop>

            <a href="{{ route('categories.edit', $node->id) }}"
                class="w-9 h-9 flex items-center justify-center text-teal-600 hover:text-white
                       rounded-xl bg-teal-50 hover:bg-teal-500 hover:shadow-lg hover:shadow-teal-200/50
                       transition-all duration-300" title="Chỉnh sửa">
                <i class="fa-solid fa-pen-to-square text-sm"></i>
            </a>

            <form action="{{ route('categories.destroy', $node->id) }}"
                  method="POST"
                  onsubmit="return confirm('Bạn chắc chắn muốn xóa danh mục này? Mọi dữ liệu liên quan có thể bị ảnh hưởng.');">
                @csrf
                @method('DELETE')

                <button type="submit"
                    class="w-9 h-9 flex items-center justify-center text-rose-500 hover:text-white
                           rounded-xl bg-rose-50 hover:bg-rose-500 hover:shadow-lg hover:shadow-rose-200/50
                           transition-all duration-300" title="Xóa">
                    <i class="fa-solid fa-trash-can text-sm"></i>
                </button>
            </form>

        </div>
    </div>

    <!-- Danh mục con -->
    @if ($node->children->count())
        <ol class="dd-list sm:ml-8 mt-1 space-y-1 relative before:hidden sm:before:block before:absolute before:left-[-16px] before:top-4 before:bottom-4 before:w-px before:bg-slate-200/60"
            x-show="open"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 -translate-y-2"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-2">
            @foreach ($node->children as $child)
                @include('admins.Categories._node', ['node' => $child])
            @endforeach
        </ol>
    @endif

</li>

