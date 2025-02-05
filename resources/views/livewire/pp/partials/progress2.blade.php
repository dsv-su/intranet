@switch((string) $proposal->dashboard?->state ?? '')
    @case('submitted')
    @php
        $progress = 25;
        $color = 'bg-yellow-400';
    @endphp
    @break
    @case('head_approved')
    @php
        $progress = 50;
        $color = 'bg-purple-600';
    @endphp
    @break
    @case('vice_approved')
    @php
        $progress = 75;
        $color = 'bg-blue-600';
    @endphp
    @break
    @case('fo_approved')
    @php
        $progress = 100;
        $color = 'bg-green-600';
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

{{--}}
    <!-- Stepper Nav -->
    <ul class="relative flex flex-row gap-x-2">
        <li class="flex items-center gap-x-2 shrink basis-0 flex-1 group">
              <span class="min-w-7 min-h-7 group inline-flex items-center text-xs align-middle">
                    <span class="size-7 flex justify-center items-center shrink-0 bg-gray-100 font-medium text-gray-800 rounded-full group-focus:bg-gray-200 hs-stepper-active:bg-blue-600 hs-stepper-active:text-white hs-stepper-success:bg-blue-600 hs-stepper-success:text-white hs-stepper-completed:bg-teal-500 hs-stepper-completed:group-focus:bg-teal-600 dark:bg-neutral-700 dark:text-white dark:group-focus:bg-gray-600 dark:hs-stepper-active:bg-blue-500 dark:hs-stepper-success:bg-blue-500 dark:hs-stepper-completed:bg-teal-500 dark:hs-stepper-completed:group-focus:bg-teal-600">
                        <span class="hs-stepper-success:hidden hs-stepper-completed:hidden">1</span>
                              <svg class="hidden shrink-0 size-3 hs-stepper-success:block" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="20 6 9 17 4 12"></polyline>
                              </svg>
                        </span>
                    <span class="ms-2 text-sm font-medium text-gray-800 dark:text-neutral-200">
                      Preapproval
                    </span>
              </span>

            {{--}}{{--}}
            <div class="flex w-full h-2 bg-gray-200 rounded-full overflow-hidden dark:bg-neutral-700" role="progressbar" aria-valuenow="{{$progress}}" aria-valuemin="0" aria-valuemax="100">
                <div class="flex flex-col justify-center rounded-full overflow-hidden {{$color}} text-[0.5rem] text-white text-center whitespace-nowrap dark:bg-blue-500 transition duration-500" style="width: {{$progress}}%">{{$progress}}%</div>
            </div>

        </li>

        <li class="flex items-center gap-x-2 shrink basis-0 flex-1 group">
              <span class="min-w-7 min-h-7 group inline-flex items-center text-xs align-middle">
                    <span class="size-7 flex justify-center items-center shrink-0 bg-gray-100 font-medium text-gray-800 rounded-full group-focus:bg-gray-200 hs-stepper-active:bg-blue-600 hs-stepper-active:text-white hs-stepper-success:bg-blue-600 hs-stepper-success:text-white hs-stepper-completed:bg-teal-500 hs-stepper-completed:group-focus:bg-teal-600 dark:bg-neutral-700 dark:text-white dark:group-focus:bg-gray-600 dark:hs-stepper-active:bg-blue-500 dark:hs-stepper-success:bg-blue-500 dark:hs-stepper-completed:bg-teal-500 dark:hs-stepper-completed:group-focus:bg-teal-600">
                        <span class="hs-stepper-success:hidden hs-stepper-completed:hidden">2</span>
                              <svg class="hidden shrink-0 size-3 hs-stepper-success:block" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="20 6 9 17 4 12"></polyline>
                              </svg>
                        </span>
                    <span class="ms-2 text-sm font-medium text-gray-800 dark:text-neutral-200">
                      Approval
                    </span>
              </span>
            <div class="w-full h-px flex-1 bg-gray-200 hs-stepper-success:bg-blue-600 hs-stepper-completed:bg-teal-600 dark:bg-neutral-700 dark:hs-stepper-success:bg-blue-600 dark:hs-stepper-completed:bg-teal-600"></div>
        </li>

        <li class="flex items-center gap-x-2 shrink basis-0 flex-1 group">
              <span class="min-w-7 min-h-7 group inline-flex items-center text-xs align-middle">
                    <span class="size-7 flex justify-center items-center shrink-0 bg-gray-100 font-medium text-gray-800 rounded-full group-focus:bg-gray-200 hs-stepper-active:bg-blue-600 hs-stepper-active:text-white hs-stepper-success:bg-blue-600 hs-stepper-success:text-white hs-stepper-completed:bg-teal-500 hs-stepper-completed:group-focus:bg-teal-600 dark:bg-neutral-700 dark:text-white dark:group-focus:bg-gray-600 dark:hs-stepper-active:bg-blue-500 dark:hs-stepper-success:bg-blue-500 dark:hs-stepper-completed:bg-teal-500 dark:hs-stepper-completed:group-focus:bg-teal-600">
                          <span class="hs-stepper-success:hidden hs-stepper-completed:hidden">3</span>
                              <svg class="hidden shrink-0 size-3 hs-stepper-success:block" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="20 6 9 17 4 12"></polyline>
                              </svg>
                        </span>
                    <span class="ms-2 text-sm font-medium text-gray-800 dark:text-neutral-200">
                      Final submission
                    </span>
              </span>
                <div class="w-full h-px flex-1 bg-gray-200 group-last:hidden hs-stepper-success:bg-blue-600 hs-stepper-completed:bg-teal-600 dark:bg-neutral-700 dark:hs-stepper-success:bg-blue-600 dark:hs-stepper-completed:bg-teal-600"></div>
        </li>
        <!-- End Item -->
    </ul>
    <!-- End Stepper Nav -->
{{--}}
{{--}}
<ul class="relative flex flex-row items-center gap-x-4">
    <li class="flex items-center gap-x-4 shrink basis-0 flex-1 group">
        <span class="flex items-center gap-x-2">
          <span class="size-7 flex justify-center items-center shrink-0 bg-gray-100 font-medium text-gray-800 rounded-full group-focus:bg-gray-200 dark:bg-neutral-700 dark:text-white dark:group-focus:bg-gray-600">
            <span class="">1</span>
            <svg class="hidden shrink-0 size-3" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
              <polyline points="20 6 9 17 4 12"></polyline>
            </svg>
          </span>
          <span class="text-sm font-medium text-gray-800 dark:text-neutral-200">Preapproval</span>
        </span>
        <div class="flex-1 h-4 bg-gray-200 rounded-full overflow-hidden dark:bg-neutral-700" role="progressbar" aria-valuenow="{{$progress}}" aria-valuemin="0" aria-valuemax="100">
            <div class="flex flex-col justify-center rounded-full overflow-hidden {{$color}} text-[0.5rem] text-white text-center whitespace-nowrap dark:bg-blue-500 transition duration-500" style="width: {{$progress}}%">{{$progress}}%</div>
        </div>
    </li>

    <li class="flex items-center gap-x-4 shrink basis-0 flex-1 group">
        <span class="flex items-center gap-x-2">
          <span class="size-7 flex justify-center items-center shrink-0 bg-gray-100 font-medium text-gray-800 rounded-full group-focus:bg-gray-200 dark:bg-neutral-700 dark:text-white dark:group-focus:bg-gray-600">
            <span class="hs-stepper-success:hidden hs-stepper-completed:hidden">2</span>
            <svg class="hidden shrink-0 size-3 hs-stepper-success:block" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
              <polyline points="20 6 9 17 4 12"></polyline>
            </svg>
          </span>
          <span class="text-sm font-medium text-gray-800 dark:text-neutral-200">Approval</span>
        </span>
    </li>
</ul>

{{--}}


<div class="w-full">
    <div class="relative grid w-full h-20 m-0 overflow-hidden place-items-center bg-transparent">
        <div class="w-full px-10 pb-4">
            <div class="relative flex items-center justify-between w-full">
                <!-- Gray Line -->
                <div class="absolute left-0 top-2/4 h-1 w-full -translate-y-2/4 bg-gray-400"></div>
                <!-- Color Progress Line -->
                <div class="absolute left-0 top-2/4 h-1 -translate-y-2/4 {{--}}bg-blue-500{{--}} {{ $color }} transition-all duration-500"
                    style="width: {{ $progress }}%">
                </div>
                <!-- Progress Percentage -->
                <div class="absolute -top-4 text-xs font-semibold text-blue-500 transition-all duration-500"
                    style="left: calc({{ $progress }}% - 10px);">
                    {{ $progress }}%
                </div>
                <!-- Preapproval (Blue) -->
                <div class="relative z-10 grid h-3 w-3 cursor-pointer place-items-center rounded-full {{--}}bg-blue-500{{--}} {{ $color }} font-bold text-white ring-0 transition-all duration-300">
                    <div class="absolute -bottom-[1.8rem] w-max text-center text-xs">
                        <h6 class="block uppercase font-sans text-[0.65rem] antialiased font-semibold leading-relaxed tracking-normal text-blue-500">
                            Submitted
                        </h6>
                    </div>
                </div>
                <!-- Approval -->
                <div class="relative z-10 grid h-3 w-3 cursor-pointer place-items-center rounded-full bg-gray-200 font-bold text-gray-500 transition-all duration-300">
                    <div class="absolute -bottom-[1.8rem] w-max text-center text-xs">
                        <h6 class="block uppercase font-sans text-[0.65rem] antialiased font-semibold leading-relaxed tracking-normal text-gray-500">
                            PreApproval
                        </h6>
                    </div>
                </div>

                <!-- Final Submission -->
                <div class="relative z-10 grid h-3 w-3 cursor-pointer place-items-center rounded-full bg-gray-200 font-bold text-gray-500 transition-all duration-300">
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
