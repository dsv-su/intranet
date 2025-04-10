{{--}}
10% → Submitted
25% → Preapproval
40% → Complete
50% → UHApproval
60% → Submission
80% → Budget Review
100% → Final Approval
{{--}}
@switch((string) $proposal->dashboard?->state ?? '')
    @case('submitted')
        @php
            $progress = 10;
            $color = 'bg-yellow-400';
        @endphp
        @break
    @case('vice_approved')
        @php
            $progress = 25;
            $color = 'bg-purple-600';
        @endphp
        @break
    @case('complete')
    @php
        $progress = 40;
        $color = 'bg-blue-600';
    @endphp
    @break
    @case('head_approved')
        @php
            $progress = 50;
            $color = 'bg-blue-600';
        @endphp
        @break
    @case('fo_approved')
        @php
            $progress = 75;
            //$color = 'bg-green-600';
            $color = 'bg-blue-600';
        @endphp
        @break
    @case('final_approved')
    @case('granted')
        @php
            $progress = 100;
            //$color = 'bg-green-600';
            $color = 'bg-blue-600';
        @endphp
        @break
    @case('head_denied')
    @case('vice_denied')
    @case('fo_denied')
        @php
            $progress = 0;
            $color = 'bg-red-600';
        @endphp
        @break
    @case('head_returned')
    @php
        $progress = 40;
        $color = 'bg-yellow-200';
    @endphp
    @break
    @case('vice_returned')
    @php
        $progress = 0;
        $color = 'bg-yellow-200';
    @endphp
    @break
    @case('fo_returned')
        @php
            $progress = 50;
            $color = 'bg-yellow-200';
        @endphp
        @break
    @default
        @php
            $progress = 0;
            $color = 'bg-red-200';
        @endphp
        @break
@endswitch
<div class="w-full">
    <div class="relative grid w-full h-20 m-0 overflow-hidden place-items-center bg-transparent">
        <div class="w-full px-10 pb-4">
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
                    {{ $progress }}%
                </div>

                <!-- Step 1: Submitted -->
                <div class="relative z-10 grid h-3 w-3 cursor-pointer place-items-center rounded-full
                    {{ $progress >= 0 ? $color : 'bg-gray-500' }} font-bold transition-all duration-300">
                    <div class="absolute -bottom-[1.8rem] w-max text-center text-xs">
                        <h6 class="block uppercase font-sans text-[0.65rem] antialiased font-semibold leading-relaxed tracking-normal
                            {{ $progress >= 0 ? 'text-blue-500' : 'text-gray-500' }}">
                            Draft
                        </h6>
                    </div>
                </div>

                <!-- Step 2: PreApproval -->
                <div class="relative z-10 grid h-3 w-3 cursor-pointer place-items-center rounded-full
                    {{ $progress >= 25 ? $color : 'bg-gray-500' }} font-bold transition-all duration-300">
                    <div class="absolute -bottom-[1.8rem] w-max text-center text-xs">
                        <h6 class="block uppercase font-sans text-[0.65rem] antialiased font-semibold leading-relaxed tracking-normal
                            {{ $progress >= 25 ? 'text-blue-500' : 'text-gray-500' }}">
                            PreApproval
                        </h6>
                    </div>
                </div>

                <!-- Step 3: UH Approval -->
                <div class="relative z-10 grid h-3 w-3 cursor-pointer place-items-center rounded-full
                    {{ $progress >= 50 ? $color : 'bg-gray-500' }} font-bold transition-all duration-300">
                    <div class="absolute -bottom-[1.8rem] w-max text-center text-xs">
                        <h6 class="block uppercase font-sans text-[0.65rem] antialiased font-semibold leading-relaxed tracking-normal
                            {{ $progress >= 50 ? 'text-blue-500' : 'text-gray-500' }}">
                            UH Approval
                        </h6>
                    </div>
                </div>

                <!-- Step 4: Budget Review -->
                <div class="relative z-10 grid h-3 w-3 cursor-pointer place-items-center rounded-full
                    {{ $progress >= 75 ? $color : 'bg-gray-500' }} font-bold transition-all duration-300">
                    <div class="absolute -bottom-[1.8rem] w-max text-center text-xs">
                        <h6 class="block uppercase font-sans text-[0.65rem] antialiased font-semibold leading-relaxed tracking-normal
                            {{ $progress >= 75 ? 'text-blue-500' : 'text-gray-500' }}">
                            Budget Review
                        </h6>
                    </div>
                </div>

                <!-- Step 5: Final Approval -->
                <div class="relative z-10 grid h-3 w-3 cursor-pointer place-items-center rounded-full
                    {{ $progress >= 100 ? $color : 'bg-gray-500' }} font-bold transition-all duration-300">
                    <div class="absolute -bottom-[1.8rem] w-max text-center text-xs">
                        <h6 class="block uppercase font-sans text-[0.65rem] antialiased font-semibold leading-relaxed tracking-normal
                            {{ $progress >= 100 ? 'text-blue-500' : 'text-gray-500' }}">
                            Final Approval
                        </h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

