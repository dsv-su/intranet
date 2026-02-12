{{--}}
10% → Submitted
20% → Complete
40% → UHApproval
60% → Budget Review
80% → Final Approval
100% → Sent
{{--}}
@switch((string) $proposal->dashboard?->state ?? '')
    @case('submitted')
        @php
            $progress = 10;
            $message = 'Upload files';
            $color = 'bg-yellow-400';
        @endphp
        @break
    @case('complete')
        @php
            $progress = 30;
            $message = 'Processing';
            $color = 'bg-purple-600';
        @endphp
        @break
    @case('head_approved')
        @php
            $progress = 55;
            $message = 'Processing';
            $color = 'bg-blue-600';
        @endphp
        @break
    @case('fo_approved')
        @php
            $progress = 65;
            $message = 'Processing';
            $color = 'bg-blue-600';
        @endphp
        @break
    @case('final_approved')
        @php
            $progress = 85;
            $message = 'Ready to send';
            $color = 'bg-blue-600';
        @endphp
        @break
    @case('sent')
    @case('granted')
        @php
            $progress = 100;
            $message = '';
            $color = 'bg-blue-600';
        @endphp
        @break
    @case('head_denied')
    @case('vice_denied')
    @case('fo_denied')
        @php
            $progress = 0;
            $message = '';
            $color = 'bg-red-600';
        @endphp
        @break
    @case('head_returned')
        @php
            $progress = 20;
            $message = '';
            $color = 'bg-yellow-200';
        @endphp
        @break
    @case('vice_returned')
        @php
            $progress = 15;
            $message = '';
            $color = 'bg-yellow-200';
        @endphp
        @break
    @case('fo_returned')
        @php
            $progress = 40;
            $message = '';
            $color = 'bg-yellow-200';
        @endphp
        @break
    @case('final_returned')
        @php
            $progress = 60;
            $message = '';
            $color = 'bg-yellow-200';
        @endphp
        @break
    @case('denied')
        @php
            $progress = 100;
            $message = '';
            $color = 'bg-red-600';
        @endphp
        @break
    @default
        @php
            $progress = 0;
            $message = 'Pending';
            $color = 'bg-yellow-200';
        @endphp
        @break
@endswitch

<div class="w-full">
    {{-- mobile: stacked list, md+: original timeline --}}
    <div class="grid w-full overflow-hidden bg-transparent">

        {{-- MOBILE --}}
        <div class="md:hidden px-4 pb-4">
            <div class="rounded-md border border-gray-200 dark:border-neutral-700 bg-white/0 p-3">
                <div class="flex items-center justify-between gap-3">
                    <div class="text-xs font-semibold text-gray-800 dark:text-neutral-200">
                        Progress: {{ $progress }}%
                    </div>
                    @if($message)
                        <div class="text-xs font-semibold text-blue-500">
                            {{ $message }}
                        </div>
                    @endif
                </div>

                <div class="mt-2 h-2 w-full rounded-full bg-gray-300 dark:bg-neutral-700 overflow-hidden">
                    <div class="h-full {{ $color }} transition-all duration-500" style="width: {{ $progress }}%"></div>
                </div>

                <div class="mt-3 grid grid-cols-2 gap-2 text-[0.7rem] text-gray-600 dark:text-neutral-400">
                    <div class="flex items-center gap-2">
                        <span class="h-2 w-2 rounded-full {{ $progress >= 0 ? $color : 'bg-gray-500' }}"></span>
                        <span>Draft</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="h-2 w-2 rounded-full {{ $progress >= 20 ? $color : 'bg-gray-500' }}"></span>
                        <span>Complete</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="h-2 w-2 rounded-full {{ $progress >= 40 ? $color : 'bg-gray-500' }}"></span>
                        <span>UH Approval</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="h-2 w-2 rounded-full {{ $progress >= 60 ? $color : 'bg-gray-500' }}"></span>
                        <span>Budget Review</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="h-2 w-2 rounded-full {{ $progress >= 80 ? $color : 'bg-gray-500' }}"></span>
                        <span>Final Approval</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="h-2 w-2 rounded-full {{ $progress >= 100 ? $color : 'bg-gray-500' }}"></span>
                        <span>Sent</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- DESKTOP / TABLET --}}
        <div class="hidden md:block relative h-20 place-items-center">
            <div class="w-full px-4 pb-4 sm:px-10">
                <div class="relative flex items-center justify-between w-full">

                    <!-- Gray Line -->
                    <div class="absolute left-0 top-2/4 h-1 w-full -translate-y-2/4 bg-gray-400"></div>

                    <!-- Color Progress Line -->
                    <div class="absolute left-0 top-2/4 h-1 -translate-y-2/4 {{ $color }} transition-all duration-500"
                         style="width: {{ $progress }}%"></div>

                    <!-- Progress Message -->
                    @if($message)
                        <div class="absolute -top-4 text-xs font-semibold text-blue-500 transition-all duration-500 whitespace-nowrap"
                             style="left: calc({{ $progress }}% - 10px);">
                            {{ $message }}
                        </div>
                    @endif

                    <!-- Step 1 -->
                    <div class="relative z-10 grid h-3 w-3 cursor-pointer place-items-center rounded-full
                      {{ $progress >= 0 ? $color : 'bg-gray-500' }} transition-all duration-300">
                        <div class="absolute -bottom-[1.8rem] w-max text-center text-xs">
                            <h6 class="uppercase font-sans text-[0.65rem] antialiased font-semibold leading-relaxed tracking-normal
                         {{ $progress >= 0 ? 'text-blue-500' : 'text-gray-500' }}">
                                Draft
                            </h6>
                        </div>
                    </div>

                    <!-- Step 2 -->
                    <div class="relative z-10 grid h-3 w-3 cursor-pointer place-items-center rounded-full
                      {{ $progress >= 20 ? $color : 'bg-gray-500' }} transition-all duration-300">
                        <div class="absolute -bottom-[1.8rem] w-max text-center text-xs">
                            <h6 class="uppercase font-sans text-[0.65rem] antialiased font-semibold leading-relaxed tracking-normal
                         {{ $progress >= 20 ? 'text-blue-500' : 'text-gray-500' }}">
                                Complete
                            </h6>
                        </div>
                    </div>

                    <!-- Step 3 -->
                    <div class="relative z-10 grid h-3 w-3 cursor-pointer place-items-center rounded-full
                      {{ $progress >= 40 ? $color : 'bg-gray-500' }} transition-all duration-300">
                        <div class="absolute -bottom-[1.8rem] w-max text-center text-xs">
                            <h6 class="uppercase font-sans text-[0.65rem] antialiased font-semibold leading-relaxed tracking-normal
                         {{ $progress >= 40 ? 'text-blue-500' : 'text-gray-500' }}">
                                UH Approval
                            </h6>
                        </div>
                    </div>

                    <!-- Step 4 -->
                    <div class="relative z-10 grid h-3 w-3 cursor-pointer place-items-center rounded-full
                      {{ $progress >= 60 ? $color : 'bg-gray-500' }} transition-all duration-300">
                        <div class="absolute -bottom-[1.8rem] w-max text-center text-xs">
                            <h6 class="uppercase font-sans text-[0.65rem] antialiased font-semibold leading-relaxed tracking-normal
                         {{ $progress >= 60 ? 'text-blue-500' : 'text-gray-500' }}">
                                Budget Review
                            </h6>
                        </div>
                    </div>

                    <!-- Step 5 -->
                    <div class="relative z-10 grid h-3 w-3 cursor-pointer place-items-center rounded-full
                      {{ $progress >= 80 ? $color : 'bg-gray-500' }} transition-all duration-300">
                        <div class="absolute -bottom-[1.8rem] w-max text-center text-xs">
                            <h6 class="uppercase font-sans text-[0.65rem] antialiased font-semibold leading-relaxed tracking-normal
                         {{ $progress >= 80 ? 'text-blue-500' : 'text-gray-500' }}">
                                Final Approval
                            </h6>
                        </div>
                    </div>

                    <!-- Step 6 -->
                    <div class="relative z-10 grid h-3 w-3 cursor-pointer place-items-center rounded-full
                      {{ $progress >= 100 ? $color : 'bg-gray-500' }} transition-all duration-300">
                        <div class="absolute -bottom-[1.8rem] w-max text-center text-xs">
                            <h6 class="uppercase font-sans text-[0.65rem] antialiased font-semibold leading-relaxed tracking-normal
                         {{ $progress >= 100 ? 'text-blue-500' : 'text-gray-500' }}">
                                Sent
                            </h6>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>

