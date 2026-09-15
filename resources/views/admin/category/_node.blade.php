<li class="dd-item" data-id="{{ $node->id }}" x-data="{ open: false }">

    <!-- Hộp danh mục -->
    <div @click="open = !open"
        class="flex flex-col sm:flex-row sm:items-center sm:justify-between
               bg-white p-3 sm:p-4 rounded-xl border border-gray-100
               shadow-sm hover:shadow transition cursor-pointer gap-3 mb-2 mx-1 mt-1">

        <!-- Left: Toggle + Name -->
        <div class="flex items-center gap-3 min-w-0">

            <!-- Icon toggle -->
            @if ($node->children->count())
                <span class="text-gray-500 text-sm transition-transform shrink-0"
                      :class="open ? 'rotate-180' : ''">
                    ▼
                </span>
            @else
                <span class="text-gray-300 shrink-0">•</span>
            @endif

            <!-- Tên danh mục -->
            <span class="text-gray-800 text-base sm:text-lg font-bold break-words">
                {{ $node->name }}
            </span>
            <span class="text-xs font-mono bg-gray-100 px-2 py-1 rounded">{{ $node->link ?? 'N/A' }}</span>
        </div>

        <!-- Right: Action buttons -->
        <div class="flex items-center gap-2 sm:gap-3 sm:justify-end"
             @click.stop>

            <a href="{{ route('categories.edit', $node->id) }}"
                class="px-3 py-1.5 text-sky-600 hover:text-sky-800
                       rounded-lg border border-sky-200 hover:bg-sky-50
                       transition text-sm bg-sky-50/50">
                <i class="fa-solid fa-pen"></i>
            </a>

            <form action="{{ route('categories.destroy', $node->id) }}"
                  method="POST"
                  class="inline-block"
                  onsubmit="return confirm('Bạn có chắc chắn muốn xóa?');">
                @csrf
                @method('DELETE')

                <button type="submit"
                    class="px-3 py-1.5 text-red-600 hover:text-red-800
                           rounded-lg border border-red-200 hover:bg-red-50
                           transition text-sm bg-red-50/50">
                    <i class="fa-solid fa-trash"></i>
                </button>
            </form>

        </div>
    </div>

    <!-- Danh mục con -->
    @if ($node->children->count())
        <ol class="dd-list ml-6 sm:ml-8 mt-2 space-y-2 border-l-2 border-dashed border-gray-200 pl-4 py-2"
            x-show="open"
            x-transition>
            @foreach ($node->children as $child)
                @include('admin.category._node', ['node' => $child])
            @endforeach
        </ol>
    @endif

</li>
