<div wire:poll.visible>
    <div class="px-1 py-1 mx-auto sm:max-w-xl md:max-w-full lg:max-w-screen-xl md:px-12 lg:px-2 lg:py-1">
        <div class="grid grid-cols-2 gap-2 md:grid-cols-4">
            <a href="{{route('pp', 'awaiting')}}" class="text-center md:border-r border-susecondary transition-transform duration-200 hover:scale-105 hover:text-blue-500 dark:hover:text-blue-300">
                <h6 class="text-sm font-bold lg:text-base dark:text-gray-200">{{$awaiting ?? '00'}}</h6>
                <p class="text-xs font-medium tracking-wide text-gray-800 dark:text-gray-200 uppercase lg:text-xs">
                    Awaiting review
                </p>
            </a>
            <a href="{{route('pp', 'my')}}" class="text-center md:border-r border-susecondary transition-transform duration-200 hover:scale-105 hover:text-blue-500 dark:hover:text-blue-300">
                <h6 class="text-sm font-bold lg:text-base dark:text-gray-200">{{$myproposals->count()}}</h6>
                <p class="text-xs font-medium tracking-wide text-gray-800 dark:text-gray-200 uppercase lg:text-xs">
                    My Proposals
                </p>
            </a>
            <a href="{{route('pp', 'all')}}" class="text-center md:border-r border-susecondary transition-transform duration-200 hover:scale-105 hover:text-blue-500 dark:hover:text-blue-300">
                <h6 class="text-sm font-bold lg:text-base dark:text-gray-200">{{$proposals->count()}}</h6>
                <p class="text-xs font-medium tracking-wide text-gray-800 dark:text-gray-200 uppercase lg:text-xs">
                    Proposals
                </p>
            </a>
            <div class="text-center transition-transform duration-200 hover:scale-105 hover:text-blue-500 dark:hover:text-blue-300">
                <h6 class="text-sm font-bold lg:text-base dark:text-gray-200">{{$funding_organizations}}</h6>
                <p class="text-xs font-medium tracking-wide text-gray-800 dark:text-gray-200 uppercase lg:text-xs">
                    Funding organizations
                </p>
            </div>
        </div>
    </div>



</div>
