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
