@switch((string) $proposal->dashboard?->state ?? '')
    @case('submitted')
    @php
        $progress = 10;
        $color = 'bg-yellow-400';
    @endphp
    @break
    @case('head_approved')
    @php
        $progress = 25;
        $color = 'bg-purple-600';
    @endphp
    @break
    @case('vice_approved')
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
    @case('head_denied')
    @case('vice_denied')
    @case('fo_denied')
    @php
        $progress = 100;
        $color = 'bg-red-600';
    @endphp
    @break
    @case('head_returned')
    @case('vice_returned')
    @case('fo_returned')
    @php
        $progress = 100;
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
                <!-- Submitted (Blue) -->
                <div class="relative z-10 grid h-3 w-3 cursor-pointer place-items-center rounded-full {{ $color }} font-bold text-white ring-0 transition-all duration-300">
                    <div class="absolute -bottom-[1.8rem] w-max text-center text-xs">
                        <h6 class="block uppercase font-sans text-[0.65rem] antialiased font-semibold leading-relaxed tracking-normal text-blue-500">
                            Submitted
                        </h6>
                    </div>
                </div>
                <!-- Preapproval  -->
                <div class="relative z-10 grid h-3 w-3 cursor-pointer place-items-center rounded-full {{ $color }} font-bold text-gray-500 transition-all duration-300">
                    <div class="absolute -bottom-[1.8rem] w-max text-center text-xs">
                        <h6 class="block uppercase font-sans text-[0.65rem] antialiased font-semibold leading-relaxed tracking-normal text-gray-500">
                            PreApproval
                        </h6>
                    </div>
                </div>

                <!-- Submission -->
                <div class="relative z-10 grid h-3 w-3 cursor-pointer place-items-center rounded-full {{ $color }} font-bold text-gray-500 transition-all duration-300">
                    <div class="absolute -bottom-[1.8rem] w-max text-center text-xs">
                        <h6 class="block uppercase font-sans text-[0.65rem] antialiased font-semibold leading-relaxed tracking-normal text-gray-500">
                            Submission
                        </h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
