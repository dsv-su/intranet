{{--}}
10% → Submitted
15% → Complete
20% → Vice Approval
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
        $progress = 15;
        $message = 'Processing';
        $color = 'bg-purple-600';
    @endphp
    @break
    @case('vice_approved')
        @php
            $progress = 25;
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
    @php
        $progress = 100;
        $message = '';
        $color = 'bg-blue-600';
    @endphp
    @break
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
        $progress = 50;
        $message = '';
        $color = 'bg-yellow-200';
    @endphp
    @break
    @case('vice_returned')
    @php
        $progress = 0;
        $message = '';
        $color = 'bg-yellow-200';
    @endphp
    @break
    @case('fo_returned')
        @php
            $progress = 75;
            $message = '';
            $color = 'bg-yellow-200';
        @endphp
        @break
    @case('final_returned')
    @php
        $progress = 80;
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
    <div class="relative grid w-full h-20 m-0 overflow-hidden place-items-center bg-transparent">
        <div class="w-full px-4 pb-4 sm:px-10">
            <div class="relative flex items-center justify-between w-full">
                <!-- Gray Line -->
                <div class="absolute left-0 top-2/4 h-1 w-full -translate-y-2/4 bg-gray-400"></div>

                <!-- Color Progress Line -->
                <div class="absolute left-0 top-2/4 h-1 -translate-y-2/4 {{ $color }} transition-all duration-500"
                     style="width: {{ $progress }}%">
                </div>
                <!-- Progress Percentage -->
                <div class="absolute -top-4 text-xs font-semibold text-blue-500 transition-all duration-500"
                     style="left: calc({{ $progress }}% - 10px);">
                    {{$message}}
                </div>
                <!-- Step 1: Submitted -->
                <div class="relative z-10 grid h-3 w-3 cursor-pointer place-items-center rounded-full
                    {{ $progress >= 0 ? $color : 'bg-gray-500' }} font-bold transition-all duration-300">
                    <div class="absolute -bottom-[1.8rem] w-max text-center text-xs">
                        <h6 class="hidden md:block uppercase font-sans text-[0.65rem] antialiased font-semibold leading-relaxed tracking-normal
                            {{ $progress >= 0 ? 'text-blue-500' : 'text-gray-500' }}">
                            Draft
                        </h6>
                    </div>
                </div>

                <!-- Step 2: Vice Approval -->
                <div class="relative z-10 grid h-3 w-3 cursor-pointer place-items-center rounded-full
                    {{ $progress >= 20 ? $color : 'bg-gray-500' }} font-bold transition-all duration-300">
                    <div class="absolute -bottom-[1.8rem] w-max text-center text-xs">
                        <h6 class="hidden md:block uppercase font-sans text-[0.65rem] antialiased font-semibold leading-relaxed tracking-normal
                            {{ $progress >= 20 ? 'text-blue-500' : 'text-gray-500' }}">
                            Vice Approval
                        </h6>
                    </div>
                </div>

                <!-- Step 3: UH Approval -->
                <div class="relative z-10 grid h-3 w-3 cursor-pointer place-items-center rounded-full
                    {{ $progress >= 40 ? $color : 'bg-gray-500' }} font-bold transition-all duration-300">
                    <div class="absolute -bottom-[1.8rem] w-max text-center text-xs">
                        <h6 class="hidden md:block uppercase font-sans text-[0.65rem] antialiased font-semibold leading-relaxed tracking-normal
                            {{ $progress >= 40 ? 'text-blue-500' : 'text-gray-500' }}">
                            UH Approval
                        </h6>
                    </div>
                </div>

                <!-- Step 4: Budget Review -->
                <div class="relative z-10 grid h-3 w-3 cursor-pointer place-items-center rounded-full
                    {{ $progress >= 60 ? $color : 'bg-gray-500' }} font-bold transition-all duration-300">
                    <div class="absolute -bottom-[1.8rem] w-max text-center text-xs">
                        <h6 class="hidden md:block uppercase font-sans text-[0.65rem] antialiased font-semibold leading-relaxed tracking-normal
                            {{ $progress >= 60 ? 'text-blue-500' : 'text-gray-500' }}">
                            Budget Review
                        </h6>
                    </div>
                </div>

                <!-- Step 5: Final Approval -->
                <div class="relative z-10 grid h-3 w-3 cursor-pointer place-items-center rounded-full
                    {{ $progress >= 80 ? $color : 'bg-gray-500' }} font-bold transition-all duration-300">
                    <div class="absolute -bottom-[1.8rem] w-max text-center text-xs">
                        <h6 class="hidden md:block uppercase font-sans text-[0.65rem] antialiased font-semibold leading-relaxed tracking-normal
                            {{ $progress >= 80 ? 'text-blue-500' : 'text-gray-500' }}">
                            Final Approval
                        </h6>
                    </div>
                </div>

                <!-- Step 6: Sent -->
                <div class="relative z-10 grid h-3 w-3 cursor-pointer place-items-center rounded-full
                    {{ $progress >= 75 ? $color : 'bg-gray-500' }} font-bold transition-all duration-300">
                    <div class="absolute -bottom-[1.8rem] w-max text-center text-xs">
                        <h6 class="hidden md:block uppercase font-sans text-[0.65rem] antialiased font-semibold leading-relaxed tracking-normal
                            {{ $progress >= 75 ? 'text-blue-500' : 'text-gray-500' }}">
                            Sent
                        </h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

