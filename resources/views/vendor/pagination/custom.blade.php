@if ($paginator->hasPages())
<nav role="navigation" aria-label="Pagination Navigation" class="flex justify-center mt-8">
    <ul class="inline-flex items-center space-x-2">

        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
        <li class="px-3 py-1 rounded bg-gray-200 text-gray-500">Prev</li>
        @else
        <li>
            <a href="{{ $paginator->previousPageUrl() }}"
                class="px-3 py-1 rounded bg-purple-600 text-white hover:bg-purple-800">
                Prev
            </a>
        </li>
        @endif

        {{-- Page Numbers --}}
        @foreach ($elements as $element)
        @if (is_string($element))
        <li class="px-3 py-1 text-gray-500">{{ $element }}</li>
        @endif

        @if (is_array($element))
        @foreach ($element as $page => $url)
        @if ($page == $paginator->currentPage())
        <li class="px-3 py-1 rounded bg-purple-700 text-white font-bold">{{ $page }}</li>
        @else
        <li>
            <a href="{{ $url }}"
                class="px-3 py-1 rounded bg-gray-100 hover:bg-purple-600 hover:text-white">
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
                class="px-3 py-1 rounded bg-purple-600 text-white hover:bg-purple-800">
                Next
            </a>
        </li>
        @else
        <li class="px-3 py-1 rounded bg-gray-200 text-gray-500">Next</li>
        @endif

    </ul>
</nav>
@endif