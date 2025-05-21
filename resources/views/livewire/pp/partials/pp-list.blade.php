<div x-data="{
        activeAccordion: '',
        setActiveAccordion(id) {
            this.activeAccordion = (this.activeAccordion == id) ? '' : id
        }
    }" class="relative w-full mx-auto overflow-hidden text-sm font-normal bg-white border border-susecondary divide-y divide-susecondary rounded-md dark:bg-gray-800 dark:text-white">
    @forelse($proposals as $proposal)
        <div wire:key="{{$proposal->id}}">
            <div x-data="{ id: $id('accordion') }" class="cursor-pointer group">
                <button @click="setActiveAccordion(id)" class="flex items-center justify-between w-full p-2 text-left select-none">
                    <!-- Flex container with responsive adjustments and smaller md sizes -->
                    <div class="flex flex-wrap justify-between items-center w-full">
                        <!-- Left side content (Main Researcher and Title) -->
                        <div class="w-full md:w-auto mb-2 md:mb-0">
                            <!-- Title of the Proposal -->
                            <p class="text-xs md:text-base font-normal text-gray-900 dark:text-white leading-tight">
                                <strong>
                                    {{ $proposal->pp['title'] }}
                                </strong>

                            </p>
                            <!-- Progress -->
                            {{--}}@nocache('livewire.pp.partials.progress'){{--}}
                            @nocache('livewire.pp.partials.progress3')
                            <!-- End Progress -->
                            <!-- Main Researcher and other details -->
                            <h4 class="text-xs font-medium text-gray-800 dark:text-neutral-200 tracking-wide">
                                <span class="font-medium">Main researcher:</span> {{ $proposal->pp['principal_investigator'] }} &nbsp; | &nbsp;
                                <span class="font-medium">Submission deadline:</span> {{ $proposal->pp['submission_deadline'] ?? '' }} &nbsp; | &nbsp;
                                <span class="font-medium">Project duration:</span> {{ $proposal->pp['project_duration'] ?? '' }} (months) &nbsp; | &nbsp;
                                <span class="font-medium">Economy owner:</span> [N/A]
                            </h4>
                        </div>
                        <!-- Right side (State label) -->
                        <div class="w-full md:w-auto flex-shrink-0 ml-auto">

                            <!-- Stage 1-->
                            @nocache('livewire.pp.partials.state')

                            <!-- Stage 2 -->
                            {{--}}@nocache('livewire.pp.partials.stage2_state'){{--}}

                            <!-- Stage 3 -->
                            {{--}}@nocache('livewire.pp.partials.stage3_state'){{--}}


                        </div>
                    </div>
                    <svg class="w-4 h-4 duration-200 ease-out" :class="{ 'rotate-180': activeAccordion==id }" viewBox="0 0 24 24"
                         xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                </button>

                <div x-show="activeAccordion==id" x-collapse x-cloak>
                    <div class="p-4 pt-0 opacity-70">
                        <!-- Proposal Details (Responsive Grid) -->
                        <div class="flex flex-col md:flex-row justify-between items-start w-full mt-4">
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 w-full">
                                <!-- DSV coordination -->
                                <p class="text-xs text-gray-600 dark:text-neutral-400">
                                    <span class="font-semibold">Is DSV coordinating:</span><br>
                                    @if($proposal->pp['dsvcoordinating'] == 'yes') Yes @else No @endif
                                </p>
                                <!-- Other coordination -->
                                <p class="text-xs text-gray-600 dark:text-neutral-400">
                                    <span class="font-semibold">Other coordinator:</span><br>
                                    {{$proposal->pp['other_coordination'] ?? ''}}
                                </p>
                                <!-- Co-Applicants -->
                                <p class="text-xs text-gray-600 dark:text-neutral-400">
                                    <span class="font-semibold">Co-applicants:</span><br>
                                    @if($proposal->pp['co_investigator_name'] ?? false)
                                        @foreach($proposal->pp['co_investigator_name'] as $co)
                                            {{$co}}@if(!$loop->last), @endif
                                        @endforeach
                                    @endif

                                </p>
                                <!-- Program/Call/Target -->
                                <p class="text-xs text-gray-600 dark:text-neutral-400">
                                    <span class="font-semibold">Program/Call/Target:</span><br>
                                    {{$proposal->pp['program'] ?? ''}}
                                </p>
                                <!-- Co-financing -->
                                <p class="uppercase text-xs text-gray-600 dark:text-neutral-400">
                                    <span class="font-semibold">Co-financing needed:</span><br>
                                    {{$proposal->pp['cofinancing'] ?? 'No'}}
                                </p>
                                <!-- OH -->
                                <p class="text-xs text-gray-600 dark:text-neutral-400">
                                    <span class="font-semibold">OH cost covered:</span><br>
                                    {{$proposal->pp['oh_cost'] ?? 'N/A'}} %
                                </p>
                                <!-- Funding organization -->
                                <p class="text-xs text-gray-600 dark:text-neutral-400">
                                    <span class="font-semibold">Funding organization:</span><br>
                                    {{$proposal->pp['funding_organization'] ?? 'N/A'}}
                                </p>
                                <!-- Budget -->
                                <p class="text-xs text-gray-600 dark:text-neutral-400">
                                    <span class="font-semibold">Budget for project:</span><br>
                                    {{$proposal->pp['budget_project'] ?? 'N/A'}}
                                </p>
                                <!-- Budget DSV -->
                                <p class="text-xs text-gray-600 dark:text-neutral-400">
                                    <span class="font-semibold">Budget for DSV:</span><br>
                                    {{$proposal->pp['budget_dsv'] ?? 'N/A'}}
                                </p>

                                <!-- Button group -->
                                <div class="inline-flex space-x-1 rounded-md shadow-sm " role="group">
                                    @if($review ?? false)
                                        <a type="button"
                                           href="{{route('pp-review', $proposal->id)}}"
                                           class="inline-flex items-center px-1.5 py-1.5 bg-white border border-green-600 text-green-600 rounded-md font-semibold text-[0.5rem]
                                            uppercase tracking-widest hover:bg-green-600 hover:text-white active:bg-green-700 focus:outline-none focus:border-green-800 focus:ring ring-green-300
                                            disabled:opacity-25 transition ease-in-out duration-150">
                                            Review
                                        </a>
                                    @endif
                                    @if($resume ?? false)
                                        <a type="button"
                                            href="{{route('pp-resume', $proposal->id)}}"
                                            class="inline-flex items-center px-1.5 py-1.5 bg-white border border-green-600 text-green-600 rounded-md font-semibold text-[0.5rem]
                                            uppercase tracking-widest hover:bg-green-600 hover:text-white active:bg-green-700 focus:outline-none focus:border-green-800 focus:ring ring-green-300
                                            disabled:opacity-25 transition ease-in-out duration-150">
                                            <svg class="w-3 h-3 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 12.25V1m0 11.25a2.25 2.25 0 0 0 0 4.5m0-4.5a2.25 2.25 0 0 1 0 4.5M4 19v-2.25m6-13.5V1m0 2.25a2.25 2.25 0 0 0 0 4.5m0-4.5a2.25 2.25 0 0 1 0 4.5M10 19V7.75m6 4.5V1m0 11.25a2.25 2.25 0 1 0 0 4.5 2.25 2.25 0 0 0 0-4.5ZM16 19v-2"/>
                                            </svg>
                                            Resume
                                        </a>
                                    @endif
                                        <a type="button"
                                           href="{{route('pp-view', $proposal->id)}}"
                                           class="inline-flex items-center px-1.5 py-1.5 bg-white border border-green-600 text-green-600 rounded-md font-semibold text-[0.5rem]
                                            uppercase tracking-widest hover:bg-green-600 hover:text-white active:bg-green-700 focus:outline-none focus:border-green-800 focus:ring ring-green-300
                                            disabled:opacity-25 transition ease-in-out duration-150">
                                            View
                                        </a>
                                        {{--}}
                                        @if($proposal->allowEdit())
                                        <a type="button"
                                           href="{{route('pp-edit', $proposal->id)}}"
                                           class="inline-flex items-center px-2 py-2 text-xs font-medium text-gray-900 bg-transparent border border-gray-900 hover:bg-gray-900 hover:text-white
                                            focus:z-10 focus:ring-2 focus:ring-gray-500 focus:bg-gray-900 focus:text-white dark:border-white dark:text-white dark:hover:text-white
                                            dark:hover:bg-gray-700 dark:focus:bg-gray-700 rounded-md">
                                            Edit
                                        </a>
                                        @endif
                                        {{--}}
                                    @if($proposal->allowComplete())
                                        <a type="button"
                                           href="{{route('pp-complete', $proposal->id)}}"
                                           class="inline-flex items-center px-1.5 py-1.5 bg-white border border-green-600 text-green-600 rounded-md font-semibold text-[0.5rem]
                                            uppercase tracking-widest hover:bg-green-600 hover:text-white active:bg-green-700 focus:outline-none focus:border-green-800 focus:ring ring-green-300
                                            disabled:opacity-25 transition ease-in-out duration-150">
                                            Complete
                                        </a>
                                    @endif
                                    @if((string)$proposal->dashboard->state == 'complete' ?? false)
                                        <a type="button"
                                           href="{{route('pp-upload', $proposal->id)}}#proposal-attachments"
                                           class="inline-flex items-center px-1.5 py-1.5 bg-white border border-green-600 text-green-600 rounded-md font-semibold text-[0.5rem]
                                            uppercase tracking-widest hover:bg-green-600 hover:text-white active:bg-green-700 focus:outline-none focus:border-green-800 focus:ring ring-green-300
                                            disabled:opacity-25 transition ease-in-out duration-150">
                                            Upload
                                        </a>
                                   @endif
                                    <!-- Sent -->
                                        @if((string)$proposal->dashboard->state == 'final_approved' ?? false)
                                            <a type="button"
                                               href="{{route('pp-sent', $proposal->id)}}#sent"
                                               class="inline-flex items-center px-1.5 py-1 bg-white border border-green-600 text-green-600 rounded-md font-semibold text-[0.5rem]
                                                    uppercase tracking-widest hover:bg-green-600 hover:text-white active:bg-green-700 focus:outline-none focus:border-green-800 focus:ring ring-green-300
                                                    disabled:opacity-25 transition ease-in-out duration-150">
                                                Report: Sent
                                            </a>
                                        @endif
                                    <!-- Granted -->
                                    @if((string)$proposal->dashboard->state == 'sent' ?? false)
                                        <a type="button"
                                           href="{{route('pp-granted', $proposal->id)}}#granted"
                                           class="inline-flex items-center px-1.5 py-1 bg-white border border-green-600 text-green-600 rounded-md font-semibold text-[0.5rem]
                                                    uppercase tracking-widest hover:bg-green-600 hover:text-white active:bg-green-700 focus:outline-none focus:border-green-800 focus:ring ring-green-300
                                                    disabled:opacity-25 transition ease-in-out duration-150">
                                            Report: Granted
                                        </a>
                                    @endif

                                    <!-- Rejected -->
                                    @if((string)$proposal->dashboard->state == 'sent' ?? false)
                                        <a type="button"
                                           href="{{route('pp-rejected', $proposal->id)}}#rejected"
                                           class="inline-flex items-center px-1.5 py-1 bg-white border border-red-600 text-red-600 rounded-md font-semibold text-[0.5rem]
                                                    uppercase tracking-widest hover:bg-red-600 hover:text-white active:bg-red-700 focus:outline-none focus:border-red-800 focus:ring ring-red-300
                                                    disabled:opacity-25 transition ease-in-out duration-150">
                                            Rejected
                                        </a>
                                    @endif

                                    <!-- Resume -->
                                    @if($proposal->allowEdit() and in_array((string) $proposal->status_stage1, ['head_returned', 'vice_returned', 'fo_returned', 'final_returned']))
                                        <a type="button"
                                           href="{{route('pp-resume', $proposal->id)}}"
                                           class="inline-flex items-center px-1.5 py-1 bg-white border border-green-600 text-green-600 rounded-md font-semibold text-[0.5rem]
                                            uppercase tracking-widest hover:bg-green-600 hover:text-white active:bg-green-700 focus:outline-none focus:border-green-800 focus:ring ring-green-300
                                            disabled:opacity-25 transition ease-in-out duration-150">
                                            Resume
                                        </a>
                                    @endif

                                </div>
                                <!-- End button group -->

                            </div>
                            <!-- Right aligned content -->
                            <div class="flex flex-col items-end mt-4 md:mt-0 w-full md:w-1/4">
                                <!-- vice head -->
                                <p class="text-xs text-gray-600 dark:text-neutral-400 text-right">
                                    <span class="font-semibold">Vice head:</span>
                                    @if(in_array((string) $proposal->dashboard?->state, ['vice_approved', 'complete', 'head_approved', 'fo_approved', 'final_approved','sent', 'granted']))
                                        <span class="bg-green-100 text-green-800 text-[0.65rem] font-medium me-1.5 px-2 py-0.5 rounded dark:bg-gray-700 dark:text-green-400 border border-green-400">Approved</span>
                                    @elseif(in_array((string) $proposal->dashboard?->state, ['vice_denied', 'head_denied', 'fo_denied', 'denied']))
                                        <span class="bg-red-100 text-red-800 text-[0.65rem] font-medium me-1.5 px-2 py-0.5 rounded dark:bg-red-700 dark:text-red-400 border border-red-400">Denied</span>
                                    @elseif(in_array((string) $proposal->dashboard?->state, ['head_returned', 'vice_returned', 'fo_returned', 'final_returned']))
                                        <span class="bg-yellow-100 text-yellow-800 text-[0.65rem] font-medium me-1.5 px-2 py-0.5 rounded dark:bg-yellow-700 dark:text-yellow-400 border border-yellow-400">Returned</span>
                                    @elseif(in_array((string) $proposal->dashboard?->state, ['submitted']))
                                        <span class="bg-blue-100 text-blue-800 text-[0.65rem] font-medium me-1.5 px-1 py-0.5 rounded dark:bg-blue-700 dark:text-blue-400 border border-blue-500">Processing</span>
                                    @else
                                        <span class="bg-gray-100 text-gray-800 text-[0.65rem] font-medium me-1.5 px-1 py-0.5 rounded dark:bg-gray-700 dark:text-gray-400 border border-gray-500">Waiting</span>
                                    @endif
                                </p>

                                <!-- Uncomplete proposal -->
                                @if(in_array((string) $proposal->dashboard?->state, ['complete']) && (count($proposal->files ?? []) < 1))
                                    <p class="mt-2 text-xs text-gray-600 dark:text-neutral-400 text-right">
                                        <span class="font-semibold">Upload files:</span>
                                        <span class="bg-yellow-100 text-yellow-800 text-[0.65rem] font-medium me-1.5 px-2 py-0.5 rounded dark:bg-yellow-700 dark:text-yellow-400 border border-yellow-400">Waiting</span>
                                    </p>
                                @endif
                                <!-- UH -->
                                <p class="mt-2 text-xs text-gray-600 dark:text-neutral-400 text-right">

                                    @if(is_array($proposal['pp']['unit_head'] ?? []) && ($UnitHeads = count($proposal['pp']['unit_head'] ?? [])) > 1)
                                        <span class="font-semibold">Unit heads({{$UnitHeads}}):</span>
                                    @else
                                        <span class="font-semibold">Unit head:</span>
                                    @endif


                                @if(in_array((string) $proposal->dashboard?->state, ['head_approved', 'fo_approved', 'final_approved', 'sent', 'granted']))
                                        <span class="bg-green-100 text-green-800 text-[0.65rem] font-medium me-1.5 px-2 py-0.5 rounded dark:bg-gray-700 dark:text-green-400 border border-green-400">Approved</span>
                                    @elseif(in_array((string) $proposal->dashboard?->state, ['head_denied', 'vice_denied', 'fo_denied', 'denied']))
                                        <span class="bg-red-100 text-red-800 text-[0.65rem] font-medium me-1.5 px-2 py-0.5 rounded dark:bg-red-700 dark:text-red-400 border border-red-400">Denied</span>
                                    @elseif(in_array((string) $proposal->dashboard?->state, ['head_returned', 'vice_returned', 'fo_returned', 'final_returned']))
                                        <span class="bg-yellow-100 text-yellow-800 text-[0.65rem] font-medium me-1.5 px-2 py-0.5 rounded dark:bg-yellow-700 dark:text-yellow-400 border border-yellow-400">Returned</span>
                                    @elseif(in_array((string) $proposal->dashboard?->state, ['complete']) && (count($proposal->files ?? []) > 1))
                                        <span class="bg-blue-100 text-blue-800 text-[0.65rem] font-medium me-1.5 px-1 py-0.5 rounded dark:bg-blue-700 dark:text-blue-400 border border-blue-500">Processing</span>
                                    @else
                                        <span class="bg-gray-100 text-gray-800 text-[0.65rem] font-medium me-1.5 px-1 py-0.5 rounded dark:bg-gray-700 dark:text-gray-400 border border-gray-500">Waiting</span>
                                    @endif
                                </p>

                                <!-- DSV economy -->
                                <p class="mt-2 text-xs text-gray-600 dark:text-neutral-400 text-right">
                                    <span class="font-semibold">Economy:</span>
                                    @if(in_array((string) $proposal->dashboard?->state, ['fo_approved', 'final_approved','sent', 'granted']))
                                        <span class="bg-green-100 text-green-800 text-[0.65rem] font-medium me-1.5 px-2 py-0.5 rounded dark:bg-gray-700 dark:text-green-400 border border-green-400">Approved</span>
                                    @elseif(in_array((string) $proposal->dashboard?->state, ['head_denied', 'vice_denied', 'fo_denied', 'denied']))
                                        <span class="bg-red-100 text-red-800 text-[0.65rem] font-medium me-1.5 px-2 py-0.5 rounded dark:bg-red-700 dark:text-red-400 border border-red-400">Denied</span>
                                    @elseif(in_array((string) $proposal->dashboard?->state, ['fo_returned', 'final_returned']))
                                        <span class="bg-yellow-100 text-yellow-800 text-[0.65rem] font-medium me-1.5 px-2 py-0.5 rounded dark:bg-yellow-700 dark:text-yellow-400 border border-yellow-400">Returned</span>
                                    @elseif(in_array((string) $proposal->dashboard?->state, ['head_returned', 'vice_returned']))
                                        <span class="bg-gray-100 text-gray-800 text-[0.65rem] font-medium me-1.5 px-1 py-0.5 rounded dark:bg-gray-700 dark:text-gray-400 border border-gray-500">Pending</span>
                                    @elseif(in_array((string) $proposal->dashboard?->state, ['head_approved']))
                                        <span class="bg-blue-100 text-blue-800 text-[0.65rem] font-medium me-1.5 px-1 py-0.5 rounded dark:bg-blue-700 dark:text-blue-400 border border-blue-500">Processing</span>
                                    @elseif(in_array((string) $proposal->dashboard?->state, ['submitted', 'complete', 'vice_approved']))
                                        <span class="bg-gray-100 text-gray-800 text-[0.65rem] font-medium me-1.5 px-1 py-0.5 rounded dark:bg-gray-700 dark:text-gray-400 border border-gray-500">Waiting</span>
                                    @else
                                        <span class="bg-gray-100 text-gray-800 text-[0.65rem] font-medium me-1.5 px-1 py-0.5 rounded dark:bg-gray-700 dark:text-gray-400 border border-gray-500">Waiting</span>
                                    @endif
                                </p>
                                <!-- Final approval -->
                                <p class="mt-2 text-xs text-gray-600 dark:text-neutral-400 text-right">
                                    <span class="font-semibold">Final approval:</span>
                                    @if(in_array((string) $proposal->dashboard?->state, ['final_approved','sent', 'granted']))
                                        <span class="bg-green-100 text-green-800 text-[0.65rem] font-medium me-1.5 px-2 py-0.5 rounded dark:bg-gray-700 dark:text-green-400 border border-green-400">Approved</span>
                                    @elseif(in_array((string) $proposal->dashboard?->state, ['vice_denied', 'fo_denied', 'denied']))
                                        <span class="bg-red-100 text-red-800 text-[0.65rem] font-medium me-1.5 px-2 py-0.5 rounded dark:bg-red-700 dark:text-red-400 border border-red-400">Denied</span>
                                    @elseif(in_array((string) $proposal->dashboard?->state, ['fo_returned', 'final_returned']))
                                        <span class="bg-yellow-100 text-yellow-800 text-[0.65rem] font-medium me-1.5 px-2 py-0.5 rounded dark:bg-yellow-700 dark:text-yellow-400 border border-yellow-400">Returned</span>
                                    @elseif(in_array((string) $proposal->dashboard?->state, ['head_returned', 'vice_returned']))
                                        <span class="bg-gray-100 text-gray-800 text-[0.65rem] font-medium me-1.5 px-1 py-0.5 rounded dark:bg-gray-700 dark:text-gray-400 border border-gray-500">Pending</span>
                                    @elseif(in_array((string) $proposal->dashboard?->state, ['fo_approved']))
                                        <span class="bg-blue-100 text-blue-800 text-[0.65rem] font-medium me-1.5 px-1 py-0.5 rounded dark:bg-blue-700 dark:text-blue-400 border border-blue-500">Processing</span>
                                    @elseif(in_array((string) $proposal->dashboard?->state, ['submitted', 'complete', 'vice_approved', 'head_approved']))
                                        <span class="bg-gray-100 text-gray-800 text-[0.65rem] font-medium me-1.5 px-1 py-0.5 rounded dark:bg-gray-700 dark:text-gray-400 border border-gray-500">Waiting</span>
                                    @else
                                        <span class="bg-gray-100 text-gray-800 text-[0.65rem] font-medium me-1.5 px-1 py-0.5 rounded dark:bg-gray-700 dark:text-gray-400 border border-gray-500">Waiting</span>
                                    @endif
                                </p>
                                <!-- Final submission -->
                                <p class="mt-2 text-xs text-gray-600 dark:text-neutral-400 text-right">
                                    <span class="font-semibold">Final submission:</span>
                                    @if(in_array((string) $proposal->dashboard?->state, ['sent', 'granted']))
                                        <span class="bg-green-100 text-green-800 text-[0.65rem] font-medium me-1.5 px-2 py-0.5 rounded dark:bg-gray-700 dark:text-green-400 border border-green-400">Sent</span>
                                    @elseif(in_array((string) $proposal->dashboard?->state, ['denied']))
                                        <span class="bg-red-100 text-red-800 text-[0.65rem] font-medium me-1.5 px-2 py-0.5 rounded dark:bg-red-700 dark:text-red-400 border border-red-400">Denied</span>
                                    @else
                                    <span class="bg-gray-100 text-gray-800 text-[0.65rem] font-medium me-1.5 px-1 py-0.5 rounded dark:bg-gray-700 dark:text-gray-400 border border-gray-500">
                                        &nbsp;&nbsp;Not sent&nbsp;&nbsp;
                                    </span>
                                    @endif
                                </p>
                                <!-- Decision expected -->
                                <p class="mt-2 text-xs text-gray-600 dark:text-neutral-400 text-right">
                                    <span class="font-semibold">Decision expected:</span>
                                    <span class="me-1.5 px-1 text-[0.65rem] text-black dark:text-neutral-400">{{$proposal->pp['decision_exp'] ?? 'N/A'}}</span>
                                </p>
                                <!-- Start date expected -->
                                <p class="mt-2 text-xs text-gray-600 dark:text-neutral-400 text-right">
                                    <span class="font-semibold">Start date expected:</span>
                                    <span class="me-1.5 px-1 text-[0.65rem] text-black dark:text-neutral-400">{{$proposal->pp['start_date'] ?? 'N/A'}}</span>
                                </p>
                                <!-- Final funding granted-->
                                <p class="mt-2 text-xs text-gray-600 dark:text-neutral-400 text-right">
                                    <span class="font-semibold">Funding granted:</span>
                                    @if(in_array((string) $proposal->dashboard?->state, ['granted']))
                                        <span class="bg-green-100 text-green-800 text-[0.65rem] font-medium me-1.5 px-2 py-0.5 rounded dark:bg-gray-700 dark:text-green-400 border border-green-400">Yes</span>
                                    @elseif(in_array((string) $proposal->dashboard?->state, ['denied']))
                                        <span class="bg-red-100 text-red-800 text-[0.65rem] font-medium me-1.5 px-2 py-0.5 rounded dark:bg-gray-700 dark:text-red-400 border border-red-400">Denied</span>
                                    @else
                                        <span class="bg-gray-100 text-gray-800 text-[0.65rem] font-medium me-1.5 px-1 py-0.5 rounded dark:bg-gray-700 dark:text-gray-400 border border-gray-500">Not reported</span>
                                    @endif
                                </p>
                                <p class="mt-2 text-xs text-gray-600 dark:text-neutral-400 text-right">
                                    <span class="font-semibold">Uploaded files:</span>
                                    <span class="@if(count($proposal->files ?? []) > 0) bg-blue-100  text-blue-800 border border-blue-500 @else bg-grey-100 text-gray-800 border border-grey-500 @endif
                                                 text-[0.65rem] font-medium me-1.5 px-1 py-0.5 rounded dark:bg-blue-700 dark:text-blue-400">
                                    {{count($proposal->files ?? [])}}
                                    </span>
                                </p>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="px-6 py-4 text-sm dark:bg-gray-800 dark:text-white">
            @if($review ?? false)
                No Awaiting proposals
            @else
                No Proposals were found.
            @endif
        </div>
    @endforelse
</div>
