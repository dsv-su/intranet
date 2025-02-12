<header class="sticky top-0 inset-x-0 flex flex-wrap md:flex-nowrap w-full bg-white border-b text-sm py-2.5 dark:bg-neutral-800 dark:border-neutral-700">
    <nav class="px-4 sm:px-6 flex w-full items-center">
        <div class="me-5">
            <!-- Logo -->
            <a href="{{ route('pp', 'my') }}" class="flex items-center mr-4">
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
                {{--}}
                <button type="button" class="md:hidden size-[38px] relative inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-full border border-transparent text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-neutral-700 dark:focus:bg-neutral-700">
                    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                    <span class="sr-only">Search</span>
                </button>
                {{--}}
                <a type="button"
                   data-tooltip-target="return-intranet-tooltip"
                   href="/"
                   class="size-[38px] relative inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-full border border-transparent text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-neutral-700 dark:focus:bg-neutral-700">
                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H8m12 0-4 4m4-4-4-4M9 4H7a3 3 0 0 0-3 3v10a3 3 0 0 0 3 3h2"/>
                    </svg>
                    <span class="sr-only">Intranet</span>
                </a>
                @can('vice_head')
                    <a type="button"
                       data-tooltip-target="stats-tooltip"
                       href="#">
                        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                             stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 12h-4l-3 9L9 3l-3 9H2"/>
                        </svg>
                    </a>
                @endcan
                @can('vice_head')
                <a type="button"
                    data-tooltip-target="vice-settings-tooltip"
                   href="{{route('vice_settings')}}">
                    {{--}}
                    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                         viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                         stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 12h-4l-3 9L9 3l-3 9H2"/>
                    </svg>
                    {{--}}
                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13v-2a1 1 0 0 0-1-1h-.757l-.707-1.707.535-.536a1 1 0 0 0 0-1.414l-1.414-1.414a1 1 0 0 0-1.414 0l-.536.535L14 4.757V4a1 1 0 0 0-1-1h-2a1 1 0 0 0-1 1v.757l-1.707.707-.536-.535a1 1 0 0 0-1.414 0L4.929 6.343a1 1 0 0 0 0 1.414l.536.536L4.757 10H4a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1h.757l.707 1.707-.535.536a1 1 0 0 0 0 1.414l1.414 1.414a1 1 0 0 0 1.414 0l.536-.535 1.707.707V20a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1v-.757l1.707-.708.536.536a1 1 0 0 0 1.414 0l1.414-1.414a1 1 0 0 0 0-1.414l-.535-.536.707-1.707H20a1 1 0 0 0 1-1Z"/>
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"/>
                    </svg>

                </a>
                @endcan

                <a type="button"
                   data-tooltip-target="add-proposal-tooltip"
                   href="{{route('create-project')}}"
                   class="size-[38px] relative inline-flex justify-center items-center gap-x-2 text-sm font-semibold
                        rounded-full border border-transparent text-gray-800 hover:bg-gray-100 focus:outline-none
                        focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white
                        dark:hover:bg-neutral-700 dark:focus:bg-neutral-700">



                    <svg class="shrink-0 size-6 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 7.757v8.486M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                    </svg>

                    <span class="sr-only">Activity</span>
                </a>

            </div>
        </div>
    </nav>
</header>
<!-- Tooltipsa -->
<div id="add-proposal-tooltip" role="tooltip"
     class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700"
     style="position: absolute; inset: auto auto 0px 0px; margin: 0px; transform: translate(1443px, 692px);" data-popper-placement="top">Add new proposal
    <div class="tooltip-arrow" data-popper-arrow></div>
</div>
<div id="return-intranet-tooltip" role="tooltip"
     class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700"
     style="position: absolute; inset: auto auto 0px 0px; margin: 0px; transform: translate(1443px, 692px);" data-popper-placement="top">Return to Intranet
    <div class="tooltip-arrow" data-popper-arrow></div>
</div>
<div id="vice-settings-tooltip" role="tooltip"
     class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700"
     style="position: absolute; inset: auto auto 0px 0px; margin: 0px; transform: translate(1443px, 692px);" data-popper-placement="top">Settings for ViceH
    <div class="tooltip-arrow" data-popper-arrow></div>
</div>
<div id="stats-tooltip" role="tooltip"
     class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700"
     style="position: absolute; inset: auto auto 0px 0px; margin: 0px; transform: translate(1443px, 692px);" data-popper-placement="top">Stats (..in progress)
    <div class="tooltip-arrow" data-popper-arrow></div>
</div>
