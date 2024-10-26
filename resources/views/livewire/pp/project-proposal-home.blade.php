<div wire:poll.visible>
    <div class="px-1 py-1 mx-auto sm:max-w-xl md:max-w-full lg:max-w-screen-xl md:px-12 lg:px-2 lg:py-1">
        <div class="grid grid-cols-2 gap-2 md:grid-cols-4">
            <a href="{{route('pp', 'awaiting')}}" class="text-center md:border-r border-susecondary">
                <h6 class="text-sm font-bold lg:text-base">{{$awaiting ?? '00'}}</h6>
                <p class="text-xs font-medium tracking-wide text-gray-800 uppercase lg:text-xs">
                    Awaiting review
                </p>
            </a>
            <a href="{{route('pp', 'my')}}" class="text-center md:border-r border-susecondary">
                <h6 class="text-sm font-bold lg:text-base">{{$myproposals->count()}}</h6>
                <p class="text-xs font-medium tracking-wide text-gray-800 uppercase lg:text-xs">
                    My Proposals
                </p>
            </a>
            <a href="{{route('pp', 'all')}}" class="text-center md:border-r border-susecondary">
                <h6 class="text-sm font-bold lg:text-base">{{$proposals->count()}}</h6>
                <p class="text-xs font-medium tracking-wide text-gray-800 uppercase lg:text-xs">
                    Proposals
                </p>
            </a>
            <div class="text-center">
                <h6 class="text-sm font-bold lg:text-base">120</h6>
                <p class="text-xs font-medium tracking-wide text-gray-800 uppercase lg:text-xs">
                    Funding organizations
                </p>
            </div>
        </div>
    </div>

</div>
