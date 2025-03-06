@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-center space-x-2">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="px-3 py-1 text-gray-400 bg-gray-200 rounded-md cursor-not-allowed">
                &larr;
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="px-3 py-1 text-white bg-blue-500 hover:bg-blue-700 rounded-md">
                &larr;
            </a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="px-3 py-1 text-gray-500">{{ $element }}</span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="px-3 py-1 text-white bg-gray-800 rounded-md">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="px-3 py-1 text-gray-800 bg-gray-200 hover:bg-gray-300 rounded-md">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="px-3 py-1 text-white bg-blue-500 hover:bg-blue-700 rounded-md">
                &rarr;
            </a>
        @else
            <span class="px-3 py-1 text-gray-400 bg-gray-200 rounded-md cursor-not-allowed">
                &rarr;
            </span>
        @endif
    </nav>
@endif
