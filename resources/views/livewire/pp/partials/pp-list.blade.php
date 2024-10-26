<div x-data="{
        activeAccordion: '',
        setActiveAccordion(id) {
            this.activeAccordion = (this.activeAccordion == id) ? '' : id
        }
    }" class="relative w-full mx-auto overflow-hidden text-sm font-normal bg-white border border-gray-200 divide-y divide-gray-200 rounded-md">
    @forelse($proposals as $proposal)
        <div wire:key="{{$proposal->id}}">
            <div x-data="{ id: $id('accordion') }" class="cursor-pointer group">
                <button @click="setActiveAccordion(id)" class="flex items-center justify-between w-full p-2 text-left select-none">
                    <!-- Flex container with responsive adjustments and smaller md sizes -->
                    <div class="flex flex-wrap justify-between items-center w-full">
                        <!-- Left side content (Main Researcher and Title) -->
                        <div class="w-full md:w-auto mb-2 md:mb-0">
                            <!-- Title of the Proposal -->
                            <p class="text-sm md:text-base font-normal text-gray-900 dark:text-white leading-tight">
                                {{ $proposal->pp['title'] }}
                            </p>
                            <!-- Progress -->
                            @include('livewire.pp.partials.progress')
                            <!-- End Progress -->
                            <!-- Main Researcher and other details -->
                            <h4 class="text-xs font-medium text-gray-800 dark:text-neutral-200 tracking-wide">
                                <span class="font-medium">Main researcher:</span> {{ $proposal->pp['principal_investigator'] }} &nbsp; | &nbsp;
                                <span class="font-medium">Submission deadline:</span> {{ $proposal->pp['submission_deadline'] }} &nbsp; | &nbsp;
                                <span class="font-medium">Project duration:</span> {{ $proposal->pp['project_duration'] }} &nbsp; | &nbsp;
                                <span class="font-medium">Economy owner:</span> [N/A]
                            </h4>
                        </div>
                        <!-- Right side (State label) -->
                        <div class="w-full md:w-auto flex-shrink-0 ml-auto">
                            <!--TODO-->

                            @include('livewire.pp.partials.state')

                            @if($proposal->pp['status'] ?? false)
                                <span class="bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-blue-400 border border-blue-400">
                                    {{ $proposal->pp['status'] }}
                                </span>
                            @endif
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
                                    @if($proposal->pp['co_investigator_name'])
                                        @foreach($proposal->pp['co_investigator_name'] as $co)
                                            {{$co}}@if(!$loop->last), @endif
                                        @endforeach
                                    @endif

                                </p>
                                <!-- Program/Call/Target -->
                                <p class="text-xs text-gray-600 dark:text-neutral-400">
                                    <span class="font-semibold">Program/Call/Target:</span><br>
                                    {{$proposal->pp['program']}}
                                </p>
                                <!-- Co-financing -->
                                <p class="text-xs text-gray-600 dark:text-neutral-400">
                                    <span class="font-semibold">Co-financing needed:</span><br>
                                    {{$proposal->pp['other_cofinancing']}}
                                </p>
                                <!-- OH -->
                                <p class="text-xs text-gray-600 dark:text-neutral-400">
                                    <span class="font-semibold">OH cost covered:</span><br>
                                    {{$proposal->pp['oh_cost']}} %
                                </p>
                                <!-- Funding organization -->
                                <p class="text-xs text-gray-600 dark:text-neutral-400">
                                    <span class="font-semibold">Funding organization:</span><br>
                                    {{$proposal->pp['funding_organization']}}
                                </p>
                                <!-- Budget -->
                                <p class="text-xs text-gray-600 dark:text-neutral-400">
                                    <span class="font-semibold">Budget for project:</span><br>
                                    {{$proposal->pp['budget_project']}}
                                </p>
                                <!-- Budget DSV -->
                                <p class="text-xs text-gray-600 dark:text-neutral-400">
                                    <span class="font-semibold">Budget for DSV:</span><br>
                                    {{$proposal->pp['budget_dsv']}}
                                </p>

                                <!-- Button group with spacing and rounded corners -->
                                <div class="inline-flex space-x-2 rounded-md shadow-sm" role="group">
                                    @if($review ?? false)
                                        <a type="button"
                                           href="{{route('pp-review', $proposal->id)}}"
                                           class="inline-flex items-center px-2 py-1 text-xs font-medium text-gray-900 bg-transparent border border-gray-900 hover:bg-gray-900 hover:text-white focus:z-10 focus:ring-2 focus:ring-gray-500 focus:bg-gray-900 focus:text-white dark:border-white dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:bg-gray-700 rounded-md">
                                            <svg class="w-3 h-3 me-2 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 11.917 9.724 16.5 19 7.5"/>
                                            </svg>
                                            Review
                                        </a>
                                    @endif
                                    <button type="button" class="inline-flex items-center px-2 py-1 text-xs font-medium text-gray-900 bg-transparent border border-gray-900 hover:bg-gray-900 hover:text-white focus:z-10 focus:ring-2 focus:ring-gray-500 focus:bg-gray-900 focus:text-white dark:border-white dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:bg-gray-700 rounded-md">
                                        <svg class="w-3 h-3 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 12.25V1m0 11.25a2.25 2.25 0 0 0 0 4.5m0-4.5a2.25 2.25 0 0 1 0 4.5M4 19v-2.25m6-13.5V1m0 2.25a2.25 2.25 0 0 0 0 4.5m0-4.5a2.25 2.25 0 0 1 0 4.5M10 19V7.75m6 4.5V1m0 11.25a2.25 2.25 0 1 0 0 4.5 2.25 2.25 0 0 0 0-4.5ZM16 19v-2"/>
                                        </svg>
                                        Edit
                                    </button>

                                    <button type="button" class="inline-flex items-center px-2 py-1 text-xs font-medium text-gray-900 bg-transparent border border-gray-900 hover:bg-gray-900 hover:text-white focus:z-10 focus:ring-2 focus:ring-gray-500 focus:bg-gray-900 focus:text-white dark:border-white dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:bg-gray-700 rounded-md">
                                        <svg class="w-3 h-3 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M14.707 7.793a1 1 0 0 0-1.414 0L11 10.086V1.5a1 1 0 0 0-2 0v8.586L6.707 7.793a1 1 0 1 0-1.414 1.414l4 4a1 1 0 0 0 1.416 0l4-4a1 1 0 0 0-.002-1.414Z"/>
                                            <path d="M18 12h-2.55l-2.975 2.975a3.5 3.5 0 0 1-4.95 0L4.55 12H2a2 2 0 0 0-2 2v4a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-4a2 2 0 0 0-2-2Zm-3 5a1 1 0 1 1 0-2 1 1 0 0 1 0 2Z"/>
                                        </svg>
                                        Download
                                    </button>
                                </div>
                                <!-- End button group -->

                            </div>

                            <!-- Right aligned content -->
                            <div class="flex flex-col items-end mt-4 md:mt-0">
                                <!-- OK from UH -->
                                <p class="text-xs text-gray-600 dark:text-neutral-400 text-right">
                                    <span class="font-semibold">Unit head:</span> [N/A]
                                </p>
                                <!-- OK from DSV economy -->
                                <p class="text-xs text-gray-600 dark:text-neutral-400 text-right">
                                    <span class="font-semibold">Economy:</span> [N/A]
                                </p>
                                <!-- OK from vice head -->
                                <p class="text-xs text-gray-600 dark:text-neutral-400 text-right">
                                    <span class="font-semibold">Vice head:</span> [N/A]
                                </p>
                                <!-- Final submission -->
                                <p class="text-xs text-gray-600 dark:text-neutral-400 text-right">
                                    <span class="font-semibold">Final submisson:</span> [N/A]
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="px-6 py-4 text-sm">
            No Proposals were found.
        </div>
    @endforelse
</div>
