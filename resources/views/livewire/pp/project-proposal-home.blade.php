<div wire:poll.visible>
    <div class="px-2 py-2 mx-auto sm:max-w-xl md:max-w-full lg:max-w-screen-xl md:px-24 lg:px-4 lg:py-2">
        <div class="grid grid-cols-2 row-gap-4 md:grid-cols-4">
            <a type="button" href="{{route('pp' ,'awaiting')}}" class="text-center md:border-r border-susecondary">
                <h6 class="text-base font-bold lg:text-lg xl:text-xl">{{$awaiting ?? '00'}}</h6>
                <p class="text-xs font-medium tracking-widest text-gray-800 uppercase lg:text-sm">
                    Awaiting review
                </p>
            </a>
            <a type="button" href="{{route('pp', 'my')}}" class="text-center md:border-r border-susecondary">
                <h6 class="text-base font-bold lg:text-lg xl:text-xl">{{$myproposals->count()}}</h6>
                <p class="text-xs font-medium tracking-widest text-gray-800 uppercase lg:text-sm">
                    MyProposals
                </p>
            </a>
            <a type="button" href="{{route('pp', 'all')}}" class="text-center md:border-r border-susecondary">
                <h6 class="text-base font-bold lg:text-lg xl:text-xl">{{$proposals->count()}}</h6>
                <p class="text-xs font-medium tracking-widest text-gray-800 uppercase lg:text-sm">
                    Proposals
                </p>
            </a>

            <div class="text-center">
                <h6 class="text-base font-bold lg:text-lg xl:text-xl">120</h6>
                <p class="text-xs font-medium tracking-widest text-gray-800 uppercase lg:text-sm">
                    Funding organizations
                </p>
            </div>
        </div>

    </div>
</div>
