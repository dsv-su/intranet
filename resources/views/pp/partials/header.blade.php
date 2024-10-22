<header class="sticky top-0 inset-x-0 flex flex-wrap md:flex-nowrap z-[48] w-full bg-white border-b text-sm py-2.5 dark:bg-neutral-800 dark:border-neutral-700">
    <nav class="px-4 sm:px-6 flex w-full items-center">
        <div class="me-5">
            <!-- Logo -->
            <a href="{{ config('app.url') }}" class="flex items-center mr-4">
                <span class="flex opacity-90 items-center h-full px-0.5 py-px ml-2 text-xl leading-none border-[2px] border-suprimary rounded dark:text-white dark:border-white">
                    DSV
                </span>
                <span class="hidden md:block font-sudepartment ml-1 mb-1 text-xl font whitespace-nowrap dark:text-white">
                    {{ __("ProjectProposals") }}
                </span>
                @if(config('app.name') == 'ProjectProposalsDev')
                    <span class="hidden md:block font-rock text-lg whitespace-nowrap dark:text-white">
                        Dev
                    </span>
                @endif
            </a>
            <!-- End Logo -->
        </div>

        <div class="flex w-full items-center justify-end ms-auto md:justify-between gap-x-1 md:gap-x-3">
            <div class="hidden md:block">
                <!-- Search block -->
            </div>

            <div class="flex flex-row items-center justify-end gap-1">
                <button type="button" class="md:hidden size-[38px] relative inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-full border border-transparent text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-neutral-700 dark:focus:bg-neutral-700">
                    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                    <span class="sr-only">Search</span>
                </button>

                <button type="button" class="size-[38px] relative inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-full border border-transparent text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-neutral-700 dark:focus:bg-neutral-700">
                    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/></svg>
                    <span class="sr-only">Notifications</span>
                </button>

                <a type="button"
                   href="{{route('create-project')}}"
                   class="size-[38px] relative inline-flex justify-center items-center gap-x-2 text-sm font-semibold
                        rounded-full border border-transparent text-gray-800 hover:bg-gray-100 focus:outline-none
                        focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white
                        dark:hover:bg-neutral-700 dark:focus:bg-neutral-700">

                    {{--}}
                    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                         viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                         stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 12h-4l-3 9L9 3l-3 9H2"/>
                    </svg>
                    {{--}}
                    <svg class="shrink-0 size-4 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 7.757v8.486M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                    </svg>

                    <span class="sr-only">Activity</span>
                </a>

            </div>
        </div>
    </nav>
</header>
