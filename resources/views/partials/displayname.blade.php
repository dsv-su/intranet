<!-- User displayName -->
<div data-tooltip-target="displayName-tooltip" class="flex items-center w-44 h-6 px-3 justify-center text-xs font-small text-white rounded-lg toggle-dark-state-example hover:text-white focus:z-10 focus:ring-2 focus:ring-gray-300 dark:focus:ring-gray-500 focus:outline-none dark:text-gray-200 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
    {{--}}<img class="w-8 h-8 rounded-full mx-2 hidden lg:block" src="{{asset('images/ryan.jpg')}}" alt="user photo">{{--}}
    @guest
        <svg class="w-5 h-5 mx-2 text-white dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 18">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M7 8a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Zm-2 3h4a4 4 0 0 1 4 4v2H1v-2a4 4 0 0 1 4-4Z"/>
        </svg>
    @else
        @if(auth()->user()->avatar)
            <img class="w-6 h-6 rounded-full mx-2 lg:block border-transparent border hover:border-white dark:text-gray-200" src="{{ asset('assets/' . auth()->user()['avatar'] ) }}" alt="{{asset(auth()->user()->name)}}">
        @else
            <svg class="w-5 h-5 mx-2 text-white dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 18">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M7 8a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Zm-2 3h4a4 4 0 0 1 4 4v2H1v-2a4 4 0 0 1 4-4Z"/>
            </svg>
        @endif

    @endguest
    {{auth()->user()->name ?? 'Not logged in'}}
</div>
