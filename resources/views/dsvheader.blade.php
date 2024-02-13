<div class="w-full sm:block sm:w-auto">
    <!-- Small breakpoint -->
    <div class="md:hidden block grid grid-cols-4 border-b-4 border-susecondary">
        <div class="flex items-center justify-center col-span-1 bg-suprimary">
            <!-- mobile logo -->
            <img class="md:hidden block h-12 m-3" src="{{asset('images/su_logo_no_text.svg')}}"  alt="Stockholms universitet">
        </div>
        <div class="items-center inline-flex justify-start col-span-3 sm:flex px-5 bg-sudepartment">
            <span class="self-center text-base font-normal font-sudepartment whitespace-pre-line text-white dark:text-white">{{__("Department of Computer and Systems Sciences")}}</span>
        </div>
    </div>
    <!-- Medium and large breakpoint -->
    <div class="hidden md:block md:grid grid-cols-4 border-b-4 border-susecondary">
        <div class="flex items-center justify-end col-span-1 bg-suprimary">
            <div class="col-span-1 col-span-1 md:opacity-100 opacity-0">
                <img class="w-44 mr-3" src="{{asset('images/su_swe.png')}}" alt="Stockholms universitet">
            </div>
        </div>

        <div class="items-center inline-flex justify-start hidden col-span-2 sm:flex pl-5 bg-sudepartment">
            <span class="self-center text-2xl font-normal font-sudepartment whitespace-pre-line text-white dark:text-white">{{__("Department of Computer and Systems Sciences")}}</span>
        </div>

        <div class="md:opacity-100 opacity-0 flex items-center justify-end col-span-1 bg-sudepartment px-2">
            <!-- User displayName -->
            <div data-tooltip-target="displayName-tooltip" class="flex items-center w-44 h-6 px-3 justify-center text-xs font-small text-white rounded-lg toggle-dark-state-example hover:text-white focus:z-10 focus:ring-2 focus:ring-gray-300 dark:focus:ring-gray-500 focus:outline-none dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                {{--}}<img class="w-8 h-8 rounded-full mx-2 hidden lg:block" src="{{asset('images/ryan.jpg')}}" alt="user photo">{{--}}
                @guest
                    <svg class="w-5 h-5 mx-2 text-white dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 18">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M7 8a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Zm-2 3h4a4 4 0 0 1 4 4v2H1v-2a4 4 0 0 1 4-4Z"/>
                    </svg>
                @else
                    @if(auth()->user()->avatar)
                        <img class="w-6 h-6 rounded-full mx-2 lg:block border-transparent border hover:border-white" src="{{ asset('assets/' . auth()->user()['avatar'] ) }}" alt="{{asset(auth()->user()->name)}}">
                    @else
                        <svg class="w-5 h-5 mx-2 text-white dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 18">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M7 8a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Zm-2 3h4a4 4 0 0 1 4 4v2H1v-2a4 4 0 0 1 4-4Z"/>
                        </svg>
                    @endif

                @endguest
                {{auth()->user()->name ?? 'Not logged in'}}
            </div>
            <!-- Dark mode switcher -->
            <button id="theme-toggle" data-tooltip-target="navbar-dropdown-toggle-dark-mode-tooltip" type="button" data-toggle-dark="light" class="flex items-center w-6 h-6 justify-center text-xs font-small text-white outline outline-offset-2 outline-1 rounded-sm toggle-dark-state-example hover:text-white focus:z-10 focus:ring-2 focus:ring-gray-300 dark:focus:ring-gray-500 focus:outline-none dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                <svg id="theme-toggle-dark-icon" data-toggle-icon="moon" class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20">
                    <path d="M17.8 13.75a1 1 0 0 0-.859-.5A7.488 7.488 0 0 1 10.52 2a1 1 0 0 0 0-.969A1.035 1.035 0 0 0 9.687.5h-.113a9.5 9.5 0 1 0 8.222 14.247 1 1 0 0 0 .004-.997Z"></path>
                </svg>
                <svg id="theme-toggle-light-icon" data-toggle-icon="sun" class="hidden w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 15a5 5 0 1 0 0-10 5 5 0 0 0 0 10Zm0-11a1 1 0 0 0 1-1V1a1 1 0 0 0-2 0v2a1 1 0 0 0 1 1Zm0 12a1 1 0 0 0-1 1v2a1 1 0 1 0 2 0v-2a1 1 0 0 0-1-1ZM4.343 5.757a1 1 0 0 0 1.414-1.414L4.343 2.929a1 1 0 0 0-1.414 1.414l1.414 1.414Zm11.314 8.486a1 1 0 0 0-1.414 1.414l1.414 1.414a1 1 0 0 0 1.414-1.414l-1.414-1.414ZM4 10a1 1 0 0 0-1-1H1a1 1 0 0 0 0 2h2a1 1 0 0 0 1-1Zm15-1h-2a1 1 0 1 0 0 2h2a1 1 0 0 0 0-2ZM4.343 14.243l-1.414 1.414a1 1 0 1 0 1.414 1.414l1.414-1.414a1 1 0 0 0-1.414-1.414ZM14.95 6.05a1 1 0 0 0 .707-.293l1.414-1.414a1 1 0 1 0-1.414-1.414l-1.414 1.414a1 1 0 0 0 .707 1.707Z"></path>
                </svg>
                <span class="sr-only">Toggle dark/light mode</span>
            </button>
            <!-- Language switcher -->
            <button data-tooltip-target="navbar-dropdown-languageswitch-tooltip" type="button" data-dropdown-toggle="language-dropdown-menu" class="md:opacity-100 opacity-0 flex items-center text-xs font-small w-24 h-6 mx-5 {{--}}outline outline-offset-2 outline-1{{--}} rounded justify-center px-4 py-2 text-sm text-white dark:text-white cursor-pointer dark:hover:bg-gray-700 dark:hover:text-white">
                {{--}}@if($site->handle == 'swe'){{--}}
                @if(Illuminate\Support\Facades\App::currentLocale() == 'sv')
                    <img src="{{asset('images/globallinks-lang-sv.gif')}}" class="w-5 h5 mr-2">
                    Svenska
                @else
                    <img src="{{asset('images/globallinks-lang-en.gif')}}" class="w-5 h5 mr-2">
                    English
                @endif
            </button>
            <!-- Dropdown -->
            <div class="md:opacity-100 opacity-0 z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100  shadow dark:bg-gray-700" id="language-dropdown-menu">
                <ul class="py-2 font-medium" role="none">
                    {{--}}@foreach($sites as $lang){{--}}
                    @php
                        $languages = ['en', 'sv'];
                    @endphp
                        @foreach($languages as $lang)
                        {{--}}@if($lang != $site->handle){{--}}
                        @if($lang != Illuminate\Support\Facades\App::currentLocale())
                            <li>
                                <a {{--}}href="{{$lang->url}}"{{--}} href="{{route('language', ['lang' => $lang])}}"
                                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white" role="menuitem">
                                    <div class="inline-flex items-center">
                                        {{--}}@if($lang == 'swe'){{--}}
                                        @if($lang == 'sv')
                                            <img src="{{asset('images/globallinks-lang-sv.gif')}}" class="w-5 h5 mr-2">
                                        Svenska
                                        @else
                                            <img src="{{asset('images/globallinks-lang-en.gif')}}" class="w-5 h5 mr-2">
                                        English
                                        @endif

                                    </div>
                                </a>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>
            <!-- end language switcher -->
            <!-- Dashbord -->
            @can('access cp')
                <a data-tooltip-target="navbar-dashboard-tooltip" href='/cp' class="block px-2 py-1 mr-2 text-sm outline outline-offset-2 outline-1 rounded text-gray-200 hover:bg-orange-600 hover:text-white" role="menuitem">
                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                        <style>svg{fill:#feffff}</style>
                        <path d="M441 58.9L453.1 71c9.4 9.4 9.4 24.6 0 33.9L424 134.1 377.9 88 407 58.9c9.4-9.4 24.6-9.4 33.9 0zM209.8 256.2L344 121.9 390.1 168 255.8 302.2c-2.9 2.9-6.5 5-10.4 6.1l-58.5 16.7 16.7-58.5c1.1-3.9 3.2-7.5 6.1-10.4zM373.1 25L175.8 222.2c-8.7 8.7-15 19.4-18.3 31.1l-28.6 100c-2.4 8.4-.1 17.4 6.1 23.6s15.2 8.5 23.6 6.1l100-28.6c11.8-3.4 22.5-9.7 31.1-18.3L487 138.9c28.1-28.1 28.1-73.7 0-101.8L474.9 25C446.8-3.1 401.2-3.1 373.1 25zM88 64C39.4 64 0 103.4 0 152V424c0 48.6 39.4 88 88 88H360c48.6 0 88-39.4 88-88V312c0-13.3-10.7-24-24-24s-24 10.7-24 24V424c0 22.1-17.9 40-40 40H88c-22.1 0-40-17.9-40-40V152c0-22.1 17.9-40 40-40H200c13.3 0 24-10.7 24-24s-10.7-24-24-24H88z"/>
                    </svg>
                </a>
            @endif

        <!-- Tooltips -->
            <div id="displayName-tooltip" role="tooltip"
                 class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700"
                 style="position: absolute; inset: auto auto 0px 0px; margin: 0px; transform: translate(1443px, 692px);"
                 data-popper-placement="top">Profile settings
                <div class="tooltip-arrow" data-popper-arrow></div>
            </div>
            <div id="navbar-dropdown-toggle-dark-mode-tooltip" role="tooltip"
                 class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700"
                 style="position: absolute; inset: auto auto 0px 0px; margin: 0px; transform: translate(1443px, 692px);" data-popper-placement="top">Toggle dark mode
                <div class="tooltip-arrow" data-popper-arrow></div>
            </div>
            <div id="navbar-dropdown-languageswitch-tooltip" role="tooltip"
                 class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700"
                 style="position: absolute; inset: auto auto 0px 0px; margin: 0px; transform: translate(1443px, 692px);" data-popper-placement="top">Change language
                <div class="tooltip-arrow" data-popper-arrow></div>
            </div>
            <div id="navbar-dashboard-tooltip" role="tooltip"
                 class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700"
                 style="position: absolute; inset: auto auto 0px 0px; margin: 0px; transform: translate(1443px, 692px);" data-popper-placement="top">Dashboard
                <div class="tooltip-arrow" data-popper-arrow></div>
            </div>
        </div>
    </div>
</div>
