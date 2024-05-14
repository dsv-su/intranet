<div class="max-w-screen-xl mx-auto px-4 py-6 sm:px-6 lg:px-8 md:pt-8 md:pb-8 overflow-x-hidden">
    <!-- Grid -->
    <div class="grid grid-cols-12 gap-2.5 xl:gap-4">
        <div class="col-span-12 md:col-span-6 md:order-2 lg:col-span-4 grid gap-2.5 xl:gap-4">
            <!-- Card middle-->
            <div class="md:order-1 relative border border-susecondary {{--}}border-gray-200{{--}} dark:border-gray-800 rounded-xl">
                <div class="relative overflow-hidden w-full h-full rounded-xl">
                    <livewire:lecturerooms />
                    <div class="px-6 {{--}}mt-6{{--}} flex flex-col {{--}}justify-center{{--}} {{--}}items-start{{--}} md:min-h-[480px] {{--}}text-center{{--}} rounded-xl dark:border-gray-700">
                        <div id="middleHolder">
                            <div class="flex flex-col border-y dark:border-gray-700">
                                <div class="pb-8">
                                    @nocache('home.partials.teachernews')
                                </div>
                            </div>
                            <div class="mt-6 justify-center items-start text-center">
                                <p class="bg-clip-text bg-gradient-to-l from-purple-400 to-blue-600 text-transparent text-xs font-semibold uppercase">
                                    {{__("Scheduled for launch,")}}
                                </p>
                                <span class="bg-clip-text bg-gradient-to-l from-purple-400 to-blue-600 text-transparent text-7xl font-bold">
                                2024
                            </span>
                                <h3 class="mt-6 text-lg md:text-xl font-semibold text-gray-800 dark:text-gray-200">
                                    DSV Intranet
                                </h3>
                                <p class="mt-2 text-gray-500">
                                    {{__("The DSV Intranet website is under construction.")}}
                                </p>
                            </div>
                            <div class="flex flex-col border-y dark:border-gray-700">
                                <h3 class="pt-8 text-left text-lg md:text-xl font-semibold text-gray-800 dark:text-gray-200">
                                    {{__("PhD information")}}
                                    @can('access cp')
                                        <a href="/cp/collections/phdnews" aria-label="PhD news admin" class="float-right hover:border-blue-600">
                                            <svg class="w-5 h-5 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 18">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4.109 17H1v-2a4 4 0 0 1 4-4h.87M10 4.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0Zm7.95 2.55a2 2 0 0 1 0 2.829l-6.364 6.364-3.536.707.707-3.536 6.364-6.364a2 2 0 0 1 2.829 0Z"/>
                                            </svg>
                                        </a>
                                    @endif
                                </h3>

                                <div class="pb-8">
                                    @nocache('home.partials.phdnews')
                                </div>
                            </div>
                        </div>
                        <div id="lectureroomHolder" style="display: none;">
                            <livewire:roomstatus />
                        </div>


                    </div>

                    <div class="absolute top-0 inset-x-0 -z-[1] w-full h-full">
                        <svg class="w-full h-full" width="411" height="476" viewBox="0 0 411 476" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g filter="url(#filter0_f_6966_190348)">
                                <rect x="281.333" y="498" width="240.294" height="124.936" fill="#DAEAFF" fill-opacity="0.9"></rect>
                            </g>
                            <g filter="url(#filter1_f_6966_190348)">
                                <rect x="233.333" y="-177" width="240.294" height="124.936" fill="#E2CCFF" fill-opacity="0.35"></rect>
                            </g>
                            <g filter="url(#filter2_f_6966_190348)">
                                <rect x="233.333" y="-177" width="240.294" height="124.936" fill="#DAEAFF" fill-opacity="0.5"></rect>
                            </g>
                            <g filter="url(#filter3_f_6966_190348)">
                                <rect x="81.5195" y="194.5" width="240.294" height="124.936" fill="#E2CCFF" fill-opacity="0.35"></rect>
                            </g>
                            <defs>
                                <filter id="filter0_f_6966_190348" x="81.3333" y="298" width="640.294" height="524.936" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                    <feFlood flood-opacity="0" result="BackgroundImageFix"></feFlood>
                                    <feBlend mode="normal" in="SourceGraphic" in2="BackgroundImageFix" result="shape"></feBlend>
                                    <feGaussianBlur stdDeviation="100" result="effect1_foregroundBlur_6966_190348"></feGaussianBlur>
                                </filter>
                                <filter id="filter1_f_6966_190348" x="33.3333" y="-377" width="640.294" height="524.936" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                    <feFlood flood-opacity="0" result="BackgroundImageFix"></feFlood>
                                    <feBlend mode="normal" in="SourceGraphic" in2="BackgroundImageFix" result="shape"></feBlend>
                                    <feGaussianBlur stdDeviation="100" result="effect1_foregroundBlur_6966_190348"></feGaussianBlur>
                                </filter>
                                <filter id="filter2_f_6966_190348" x="33.3333" y="-377" width="640.294" height="524.936" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                    <feFlood flood-opacity="0" result="BackgroundImageFix"></feFlood>
                                    <feBlend mode="normal" in="SourceGraphic" in2="BackgroundImageFix" result="shape"></feBlend>
                                    <feGaussianBlur stdDeviation="100" result="effect1_foregroundBlur_6966_190348"></feGaussianBlur>
                                </filter>
                                <filter id="filter3_f_6966_190348" x="-118.48" y="-5.5" width="640.294" height="524.936" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                    <feFlood flood-opacity="0" result="BackgroundImageFix"></feFlood>
                                    <feBlend mode="normal" in="SourceGraphic" in2="BackgroundImageFix" result="shape"></feBlend>
                                    <feGaussianBlur stdDeviation="100" result="effect1_foregroundBlur_6966_190348"></feGaussianBlur>
                                </filter>
                            </defs>
                        </svg>
                    </div>
                </div>
            </div>
            <!-- End Card -->
        </div>
        <!-- End Col -->

        <div class="col-span-12 md:col-span-6 md:order-1 lg:col-span-4 grid gap-2.5 xl:gap-4">
            <!-- Card left bottom-->
            <div class="md:order-2 text-left relative border border-susecondary {{--}}border-gray-200{{--}} dark:border-gray-800 rounded-xl md:min-h-[230px]">
                <div class="relative overflow-hidden w-full h-full rounded-xl">
                    <div class="p-6 flex flex-col md:min-h-[480px] rounded-xl dark:border-gray-700">
                        <div>
                            @can('access cp')
                                <a href="/cp/collections/news" aria-label="Internal news admin" class="float-right hover:border-blue-600">
                                    <svg class="w-5 h-5 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 18">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4.109 17H1v-2a4 4 0 0 1 4-4h.87M10 4.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0Zm7.95 2.55a2 2 0 0 1 0 2.829l-6.364 6.364-3.536.707.707-3.536 6.364-6.364a2 2 0 0 1 2.829 0Z"/>
                                    </svg>
                                </a>
                            @endif
                            <h3 class="text-left text-lg md:text-xl font-semibold text-gray-800 dark:text-gray-200">
                                {{--}}
                                <svg class="inline-flex mb-1 w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 9H5a1 1 0 0 0-1 1v4c0 .6.4 1 1 1h6m0-6v6m0-6 5.4-3.9A1 1 0 0 1 18 6v12.2a1 1 0 0 1-1.6.8L11 15m7 0a3 3 0 0 0 0-6M6 15h3v5H6v-5Z"/>
                                </svg>
                                {{--}}
                                {{__("Internal information")}}
                            </h3>
                            @nocache('home.partials.internal')
                        </div>
                    </div>

                    <div class="absolute top-0 inset-x-0 -z-[1] w-full h-full">
                        <svg class="w-auto h-full" width="364" height="476" viewBox="0 0 364 476" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g filter="url(#filter0_f_6966_190213)">
                                <rect x="-76.6666" y="193" width="240.294" height="124.936" fill="#E2CCFF" fill-opacity="0.35"></rect>
                            </g>
                            <defs>
                                <filter id="filter0_f_6966_190213" x="-276.667" y="-7" width="640.294" height="524.936" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                    <feFlood flood-opacity="0" result="BackgroundImageFix"></feFlood>
                                    <feBlend mode="normal" in="SourceGraphic" in2="BackgroundImageFix" result="shape"></feBlend>
                                    <feGaussianBlur stdDeviation="100" result="effect1_foregroundBlur_6966_190213"></feGaussianBlur>
                                </filter>
                            </defs>
                        </svg>
                    </div>
                </div>
            </div>
            <!-- End Card -->

            <!-- Card left top -->
            <div class="hidden md:block md:order-1 relative p-6 flex flex-col justify-center items-start {{--}}md:min-h-[230px]{{--}}md:h-fit text-center rounded-xl
                border border-susecondary {{--}}border-gray-200{{--}} dark:border-gray-800">
                <div class="mt-0 text-left">
                    <h3 class="text-lg md:text-xl font-semibold text-gray-800 dark:text-gray-200">
                        DSV Helpdesk
                    </h3>
                    <p class="mt-2 text-gray-500">
                        {{__("Phone")}}: 08-16 1648
                    </p>
                    <p class="mt-2 text-gray-500">
                        {{__("Email")}}: helpdesk@dsv.su.se
                    </p>
                    <p class="mt-2 text-gray-500">
                        SU, tel 08-16 1999
                    </p>

                    <a href="mailto:helpdesk@dsv.su.se" aria-label="Helpdesk email" class="mt-4 inline-flex items-center gap-x-1.5 text-blue-800 font-medium">
                        {{__("Contact")}} DSV Helpdesk
                        <svg class="w-2.5 h-2.5" width="16" height="16" viewBox="0 0 16 16" fill="none">
                            <path d="M5.27921 2L10.9257 7.64645C11.1209 7.84171 11.1209 8.15829 10.9257 8.35355L5.27921 14" stroke="currentColor" stroke-width="2" stroke-linecap="round"></path>
                        </svg>
                    </a>
                    <br>
                    <a href="https://serviceportalen.su.se" aria-label="Serviceportal email" class="mt-4 inline-flex items-center gap-x-1.5 text-blue-800 font-medium">
                        Serviceportalen
                        <svg class="w-2.5 h-2.5" width="16" height="16" viewBox="0 0 16 16" fill="none">
                            <path d="M5.27921 2L10.9257 7.64645C11.1209 7.84171 11.1209 8.15829 10.9257 8.35355L5.27921 14" stroke="currentColor" stroke-width="2" stroke-linecap="round"></path>
                        </svg>
                    </a>
                </div>

            </div>
            <!-- End Card -->

        </div>
        <!-- End Col -->

        <div class="col-span-12 lg:col-span-4 md:order-3 md:grid-cols-2 lg:grid-cols-1 grid gap-2.5 xl:gap-4">

            <!-- Card right bottom-->
            <div class="md:order-2 relative overflow-hidden rounded-xl">
                <div class="relative overflow-hidden p-6 flex flex-col justify-start items-start {{--}}md:min-h-[480px]{{--}}md:h-fit text-center rounded-xl
                    border border-susecondary {{--}}border-gray-200{{--}} dark:border-gray-800">
                    <div class="mt-0 text-left">
                        @can('access cp')
                            <a href="/cp/collections/itnews" aria-label="IT news admin" class="float-right hover:border-blue-600">
                                <svg class="w-5 h-5 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 18">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4.109 17H1v-2a4 4 0 0 1 4-4h.87M10 4.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0Zm7.95 2.55a2 2 0 0 1 0 2.829l-6.364 6.364-3.536.707.707-3.536 6.364-6.364a2 2 0 0 1 2.829 0Z"/>
                                </svg>
                            </a>
                        @endif
                        <h3 class="text-lg md:text-xl font-semibold text-gray-800 dark:text-gray-200">
                            {{__("Information from DSV IT")}}
                        </h3>
                        @nocache('home.partials.itnews')
                    </div>
                </div>
                <div class="absolute top-0 end-0 -z-[1] w-70 h-auto">
                    <svg width="384" height="268" viewBox="0 0 384 268" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g filter="url(#filter0_f_6966_190390)">
                            <rect x="200.667" y="-57" width="240.294" height="124.936" fill="#E2CCFF" fill-opacity="0.35"></rect>
                        </g>
                        <defs>
                            <filter id="filter0_f_6966_190390" x="0.666687" y="-257" width="640.294" height="524.936" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                <feFlood flood-opacity="0" result="BackgroundImageFix"></feFlood>
                                <feBlend mode="normal" in="SourceGraphic" in2="BackgroundImageFix" result="shape"></feBlend>
                                <feGaussianBlur stdDeviation="100" result="effect1_foregroundBlur_6966_190390"></feGaussianBlur>
                            </filter>
                        </defs>
                    </svg>
                </div>
            </div>
            <!-- End Card -->


            <!-- Card right top -->
            <div class="md:order-1 p-6 relative flex flex-col justify-start items-start {{--}}md:min-h-[230px]{{--}}md:h-fit text-center rounded-xl border border-susecondary {{--}}border-gray-200{{--}} dark:border-gray-800">
                <h3 class="text-lg md:text-xl font-semibold text-gray-800 dark:text-gray-200">
                    {{__("Ongoing at DSV")}}
                </h3>
                <p class="text-left text-gray-500">
                    {{__("Be up to date with the latest news and events from the department.")}}
                </p>
                <a href="https://www.su.se/institutionen-for-data-och-systemvetenskap/nyheter" aria-label="News link" class="mt-4 inline-flex items-center gap-x-1.5 text-blue-800 font-medium">
                    {{__("News")}}
                    <svg class="w-2.5 h-2.5" width="16" height="16" viewBox="0 0 16 16" fill="none">
                        <path d="M5.27921 2L10.9257 7.64645C11.1209 7.84171 11.1209 8.15829 10.9257 8.35355L5.27921 14" stroke="currentColor" stroke-width="2" stroke-linecap="round"></path>
                    </svg>
                </a>

                <a href="https://www.su.se/institutionen-for-data-och-systemvetenskap/kalender" aria-label="Calender link" class="mt-4 inline-flex items-center gap-x-1.5 text-blue-800 font-medium">
                    {{__("Calender")}}
                    <svg class="w-2.5 h-2.5" width="16" height="16" viewBox="0 0 16 16" fill="none">
                        <path d="M5.27921 2L10.9257 7.64645C11.1209 7.84171 11.1209 8.15829 10.9257 8.35355L5.27921 14" stroke="currentColor" stroke-width="2" stroke-linecap="round"></path>
                    </svg>
                </a>
            </div>
            <!-- End Card -->

            <!-- Card right bottom -->
            <div class="md:order-3 p-6 relative flex flex-col justify-start items-start md:min-h-fit text-center rounded-xl border border-susecondary {{--}}border-gray-200{{--}} dark:border-gray-800">
                <h3 class="text-lg md:text-xl font-semibold text-gray-800 dark:text-gray-200">
                    {{__("Stockholms University")}}
                </h3>
                <p class="text-left text-gray-500">
                    {{__("Links to Stockholm University")}}
                </p>
                <a href="https://www.su.se/english/news" aria-label="News link" class="mt-4 inline-flex items-center gap-x-1.5 text-blue-800 font-medium">
                    SU {{__("News")}}
                    <svg class="w-2.5 h-2.5" width="16" height="16" viewBox="0 0 16 16" fill="none">
                        <path d="M5.27921 2L10.9257 7.64645C11.1209 7.84171 11.1209 8.15829 10.9257 8.35355L5.27921 14" stroke="currentColor" stroke-width="2" stroke-linecap="round"></path>
                    </svg>
                </a>
                <a href="https://www.su.se/english/about-the-university/contact/press-and-media/newsletter-1.534043" aria-label="Newsletter link" class="mt-4 inline-flex items-center gap-x-1.5 text-blue-800 font-medium">
                    SU {{__("Newsletter")}}
                    <svg class="w-2.5 h-2.5" width="16" height="16" viewBox="0 0 16 16" fill="none">
                        <path d="M5.27921 2L10.9257 7.64645C11.1209 7.84171 11.1209 8.15829 10.9257 8.35355L5.27921 14" stroke="currentColor" stroke-width="2" stroke-linecap="round"></path>
                    </svg>
                </a>
                <a href="https://www.su.se/english/calendar" aria-label="Calendar link" class="mt-4 inline-flex items-center gap-x-1.5 text-blue-800 font-medium">
                    SU {{__("Calender")}}
                    <svg class="w-2.5 h-2.5" width="16" height="16" viewBox="0 0 16 16" fill="none">
                        <path d="M5.27921 2L10.9257 7.64645C11.1209 7.84171 11.1209 8.15829 10.9257 8.35355L5.27921 14" stroke="currentColor" stroke-width="2" stroke-linecap="round"></path>
                    </svg>
                </a>
                <a href="https://www.su.se/staff/" aria-label="Staffpages link" class="mt-4 inline-flex items-center gap-x-1.5 text-blue-800 font-medium">
                    SU {{__("Staff pages")}}
                    <svg class="w-2.5 h-2.5" width="16" height="16" viewBox="0 0 16 16" fill="none">
                        <path d="M5.27921 2L10.9257 7.64645C11.1209 7.84171 11.1209 8.15829 10.9257 8.35355L5.27921 14" stroke="currentColor" stroke-width="2" stroke-linecap="round"></path>
                    </svg>
                </a>
                <a href="https://www.su.se/stockholm-university-library/" aria-label="Library link" class="mt-4 inline-flex items-center gap-x-1.5 text-blue-800 font-medium">
                    SU {{__("Library")}}
                    <svg class="w-2.5 h-2.5" width="16" height="16" viewBox="0 0 16 16" fill="none">
                        <path d="M5.27921 2L10.9257 7.64645C11.1209 7.84171 11.1209 8.15829 10.9257 8.35355L5.27921 14" stroke="currentColor" stroke-width="2" stroke-linecap="round"></path>
                    </svg>
                </a>
            </div>
            <!-- End Card bottom-->

            <!-- DSVSystem -->
            <a href="https://daisy.dsv.su.se" aria-label="Daisy link" class="sm:hidden md:order-4 p-4 relative flex flex-col justify-center items-center md:min-h-fit
                text-center rounded-xl before:absolute before:inset-0 before:z-10 before:border before:border-gray-200 before:rounded-xl
                before:transition before:hover:border-2 before:hover:border-blue-600 before:hover:shadow-lg dark:before:border-gray-800 dark:before:hover:border-blue-500">

                <span class="bg-clip-text bg-gradient-to-l from-purple-400 to-blue-600 text-transparent text-2xl font-bold">
                       Daisy
                </span>
            </a>
            <a href="https://forum.dsv.su.se" aria-label="Forms link" class="sm:hidden md:order-5 p-4 relative flex flex-col justify-center items-center md:min-h-fit
                text-center rounded-xl before:absolute before:inset-0 before:z-10 before:border before:border-gray-200 before:rounded-xl
                 before:transition before:hover:border-2 before:hover:border-blue-600 before:hover:shadow-lg dark:before:border-gray-800 dark:before:hover:border-blue-500">

                <span class="bg-clip-text bg-gradient-to-l from-purple-400 to-blue-600 text-transparent text-2xl font-bold">
                       Forum
                </span>
            </a>
            <a href="https://handledning.dsv.su.se" aria-label="Handledning link" class="sm:hidden md:order-6 p-4 relative flex flex-col justify-center items-center md:min-h-fit
                text-center rounded-xl before:absolute before:inset-0 before:z-10 before:border before:border-gray-200 before:rounded-xl
                 before:transition before:hover:border-2 before:hover:border-blue-600 before:hover:shadow-lg dark:before:border-gray-800 dark:before:hover:border-blue-500">

                <span class="bg-clip-text bg-gradient-to-l from-purple-400 to-blue-600 text-transparent text-2xl font-bold">
                       Handledning
                </span>
            </a>
            <a href="https://ilearn.dsv.su.se" aria-label="iLearn link" class="sm:hidden md:order-7 p-4 relative flex flex-col justify-center items-center md:min-h-fit
                text-center rounded-xl before:absolute before:inset-0 before:z-10 before:border before:border-gray-200 before:rounded-xl
                before:transition before:hover:border-2 before:hover:border-blue-600 before:hover:shadow-lg dark:before:border-gray-800 dark:before:hover:border-blue-500">

                <span class="bg-clip-text bg-gradient-to-l from-purple-400 to-blue-600 text-transparent text-2xl font-bold">
                       ilearn
                </span>
            </a>
            <a href="https://otrs.dsv.su.se" aria-label="Otrs link" class="sm:hidden md:order-8 p-4 relative flex flex-col justify-center items-center md:min-h-fit
                text-center rounded-xl before:absolute before:inset-0 before:z-10 before:border before:border-gray-200 before:rounded-xl
                before:transition before:hover:border-2 before:hover:border-blue-600 before:hover:shadow-lg dark:before:border-gray-800 dark:before:hover:border-blue-500">

                <span class="bg-clip-text bg-gradient-to-l from-purple-400 to-blue-600 text-transparent text-2xl font-bold">
                       OTRS
                </span>
            </a>
            <a href="https://play.dsv.su.se" aria-label="DSVPlay link" class="sm:hidden md:order-9 p-4 relative flex flex-col justify-center items-center md:min-h-fit
                text-center rounded-xl before:absolute before:inset-0 before:z-10 before:border before:border-gray-200 before:rounded-xl
                before:transition before:hover:border-2 before:hover:border-blue-600 before:hover:shadow-lg dark:before:border-gray-800 dark:before:hover:border-blue-500">

                <span class="bg-clip-text bg-gradient-to-l from-purple-400 to-blue-600 text-transparent text-2xl font-bold">
                       Play
                </span>
            </a>
            <a href="https://projectproposals.dsv.su.se" aria-label="Projectproposals link" class="sm:hidden md:order-10 p-4 relative flex flex-col justify-center items-center md:min-h-fit
                text-center rounded-xl before:absolute before:inset-0 before:z-10 before:border before:border-gray-200 before:rounded-xl
                before:transition before:hover:border-2 before:hover:border-blue-600 before:hover:shadow-lg dark:before:border-gray-800 dark:before:hover:border-blue-500">

                <span class="bg-clip-text bg-gradient-to-l from-purple-400 to-blue-600 text-transparent text-2xl font-bold">
                       Project Proposals
                </span>
            </a>
            <!-- end dsvsystem -->

        </div>
        <!-- End Col -->
    </div>
    <!-- End Grid -->
</div>

<script>
    let holder = document.getElementById('middleHolder');
    let holderinfo = document.getElementById('lectureroomHolder');
    window.addEventListener('contentChanged', e => {
        if(e.detail.lecturerooms) {
            holder.style.display = 'none';
            holderinfo.style.display = 'block';
        }
        else {
            holder.style.display = 'block';
            holderinfo.style.display = 'none';
        }

    })
</script>
