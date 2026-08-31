@if ($paginator->hasPages())
<nav role="navigation" aria-label="Pagination Navigation" class="flex justify-center my-6">
    <ul class="inline-flex items-center gap-1.5 p-1.5 rounded-2xl bg-white border border-slate-200/80 shadow-sm text-sm font-semibold">

        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
        <li class="px-3.5 py-1.5 rounded-xl bg-slate-100 text-slate-400 cursor-not-allowed">
            <i class="fas fa-chevron-left text-xs mr-1"></i> Prev
        </li>
        @else
        <li>
            <a href="{{ $paginator->previousPageUrl() }}"
                class="px-3.5 py-1.5 rounded-xl bg-slate-100 text-slate-700 hover:bg-purple-600 hover:text-white transition duration-200 flex items-center">
                <i class="fas fa-chevron-left text-xs mr-1"></i> Prev
            </a>
        </li>
        @endif

        {{-- Page Numbers --}}
        @foreach ($elements as $element)
        @if (is_string($element))
        <li class="px-3 py-1.5 text-slate-400">{{ $element }}</li>
        @endif

        @if (is_array($element))
        @foreach ($element as $page => $url)
        @if ($page == $paginator->currentPage())
        <li class="w-9 h-9 rounded-xl gradient-btn text-white flex items-center justify-center font-bold shadow-md">
            {{ $page }}
        </li>
        @else
        <li>
            <a href="{{ $url }}"
                class="w-9 h-9 rounded-xl text-slate-700 hover:bg-purple-100 hover:text-purple-700 flex items-center justify-center transition duration-200">
                {{ $page }}
            </a>
        </li>
        @endif
        @endforeach
        @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
        <li>
            <a href="{{ $paginator->nextPageUrl() }}"
                class="px-3.5 py-1.5 rounded-xl bg-purple-600 text-white hover:bg-purple-700 shadow-sm transition duration-200 flex items-center">
                Next <i class="fas fa-chevron-right text-xs ml-1"></i>
            </a>
        </li>
        @else
        <li class="px-3.5 py-1.5 rounded-xl bg-slate-100 text-slate-400 cursor-not-allowed">
            Next <i class="fas fa-chevron-right text-xs ml-1"></i>
        </li>
        @endif

    </ul>
</nav>
@endif