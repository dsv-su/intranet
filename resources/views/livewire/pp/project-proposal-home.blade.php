<div wire:poll.visible.keep-alive.15s>
    <div class="px-1 py-1 mx-auto sm:max-w-xl md:max-w-full lg:max-w-screen-xl md:px-12 lg:px-2 lg:py-1">
        <div class="grid grid-cols-2 gap-2 {{ $awaiting ? 'md:grid-cols-4' : 'md:grid-cols-3' }} gap-2 md:gap-1 {{--}}md:divide-x md:divide-susecondary{{--}}">
            @if($awaiting )
                <a href="{{ route('pp', 'awaiting') }}"
                   class="group block text-center rounded-lg border border-susecondary/40 bg-white px-3 py-3 shadow-sm
                          transition duration-200 ease-out
                          hover:-translate-y-0.5 hover:shadow-md hover:border-susecondary/70
                          active:translate-y-0 active:shadow-sm
                          focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2
                          dark:bg-gray-900 dark:border-susecondary/40 dark:focus-visible:ring-offset-gray-900">
                    <h6 class="text-sm font-bold lg:text-base dark:text-gray-200 group-hover:text-blue-600 dark:group-hover:text-blue-300">
                        {{ $awaiting ?? 0 }}
                    </h6>
                    <p class="text-xs font-medium tracking-wide text-gray-700 dark:text-gray-200 uppercase lg:text-xs">
                        Awaiting review
                    </p>
                </a>
            @endif
            <a href="{{route('pp', 'my')}}"
               class="group block text-center rounded-lg border border-susecondary/40 bg-white px-3 py-3 shadow-sm
                          transition duration-200 ease-out
                          hover:-translate-y-0.5 hover:shadow-md hover:border-susecondary/70
                          active:translate-y-0 active:shadow-sm
                          focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2
                          dark:bg-gray-900 dark:border-susecondary/40 dark:focus-visible:ring-offset-gray-900">
                <h6 class="text-sm font-bold lg:text-base dark:text-gray-200 group-hover:text-blue-600 dark:group-hover:text-blue-300">
                    {{$myCount}}
                </h6>
                <p class="text-xs font-medium tracking-wide text-gray-700 dark:text-gray-200 uppercase lg:text-xs">
                    My Proposals
                </p>
            </a>
            <a href="{{route('pp', 'all')}}"
               class="group block text-center rounded-lg border border-susecondary/40 bg-white px-3 py-3 shadow-sm
                          transition duration-200 ease-out
                          hover:-translate-y-0.5 hover:shadow-md hover:border-susecondary/70
                          active:translate-y-0 active:shadow-sm
                          focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2
                          dark:bg-gray-900 dark:border-susecondary/40 dark:focus-visible:ring-offset-gray-900">
                <h6 class="text-sm font-bold lg:text-base dark:text-gray-200 group-hover:text-blue-600 dark:group-hover:text-blue-300">
                    {{$allCount}}
                </h6>
                <p class="text-xs font-medium tracking-wide text-gray-700 dark:text-gray-200 uppercase lg:text-xs">
                    Proposals
                </p>
            </a>
            <div class="group block text-center rounded-lg px-3 py-3
                          dark:bg-gray-900 dark:border-susecondary/40 dark:focus-visible:ring-offset-gray-900">
                <h6 class="text-sm font-bold lg:text-base dark:text-gray-200">
                    {{$sent ?? 0}}
                </h6>
                <p class="text-xs font-medium tracking-wide text-gray-700 dark:text-gray-200 uppercase lg:text-xs">
                    Sent applications
                </p>
            </div>
        </div>
    </div>
</div>
