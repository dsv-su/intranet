<div class="relative">
    <div class="pointer-events-none absolute inset-y-0 left-0 pl-3 flex items-center">
        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
             <svg class="w-5 h-5 text-gray-400" viewBox="0 0 24 24" fill="none">
                <path d="M21 21L15 15M17 10C17 13.866 13.866 17 10 17C6.13401 17 3 13.866 3 10C3 6.13401 6.13401 3 10 3C13.866 3 17 6.13401 17 10Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
             </svg>
        </span>
    </div>
    <input wire:model="q" id="search" name="search" class="w-full py-2 pl-10 pr-4 text-black bg-white border border-gray-200 focus:outline-none focus:ring focus:ring-opacity-40 focus:ring-blue-500
                    sm:text-sm rounded-xl placeholder:text-gray-400 focus:border-blue-500 dark:bg-gray-900 dark:text-white" placeholder="Search" type="search">

    @if ($q)
        <div class="origin-top-right absolute right-0 mt-2 z-20 w-64 rounded-md shadow-lg bg-white dark:bg-gray-800 dark:text-white ring-1 ring-black ring-opacity-5">
            <div class="py-1 text-sm text-gray-700 dark:text-white">
                @forelse($results as $result)
                    <a href="{{ $result['url'] }}" class="block px-4 py-2 hover:bg-gray-100 hover:text-gray-900">{{ $result['title'] }}</a>
                @empty
                    <div class="block px-4 py-2">No results found</div>
                @endforelse
            </div>
        </div>
    @endif
</div>
