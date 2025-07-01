<nav role="navigation" aria-label="Pagination Navigation" class="flex justify-center mt-8 select-none">
    <ul class="inline-flex items-center space-x-1 px-4 py-2">
        {{-- First Page Link --}}
        <li>
            <a href="{{ $paginator->url(1) }}"
                class="px-3 py-2 rounded-l-lg border border-gray-300 bg-gray-50 text-gray-600 hover:bg-blue-100 hover:text-blue-700 transition"
                aria-label="First">
                First
            </a>
        </li>
        {{-- Previous Page Link --}}
        <li>
            @if ($paginator->onFirstPage())
                <span class="px-3 py-2 border border-gray-300 bg-gray-100 text-gray-400 rounded transition cursor-not-allowed">&lsaquo;</span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}"
                    class="px-3 py-2 border border-gray-300 bg-gray-50 text-gray-600 hover:bg-blue-100 hover:text-blue-700 rounded transition"
                    aria-label="Previous">&lsaquo;</a>
            @endif
        </li>

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li>
                    <span class="px-3 py-2 border border-gray-300 bg-white text-gray-400 rounded">{{ $element }}</span>
                </li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    <li>
                        @if ($page == $paginator->currentPage())
                            <span class="px-3 py-2 border border-blue-500 bg-blue-50 text-blue-700 font-bold rounded transition">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}"
                                class="px-3 py-2 border border-gray-300 bg-gray-50 text-gray-600 hover:bg-blue-100 hover:text-blue-700 rounded transition"
                                aria-label="Go to page {{ $page }}">{{ $page }}</a>
                        @endif
                    </li>
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        <li>
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}"
                    class="px-3 py-2 border border-gray-300 bg-gray-50 text-gray-600 hover:bg-blue-100 hover:text-blue-700 rounded transition"
                    aria-label="Next">&rsaquo;</a>
            @else
                <span class="px-3 py-2 border border-gray-300 bg-gray-100 text-gray-400 rounded transition cursor-not-allowed">&rsaquo;</span>
            @endif
        </li>
        {{-- Last Page Link --}}
        <li>
            <a href="{{ $paginator->url($paginator->lastPage()) }}"
                class="px-3 py-2 rounded-r-lg border border-gray-300 bg-gray-50 text-gray-600 hover:bg-blue-100 hover:text-blue-700 transition"
                aria-label="Last">
                Last
            </a>
        </li>
    </ul>
</nav>