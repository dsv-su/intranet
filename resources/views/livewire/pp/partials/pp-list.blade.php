<div x-data="{
        activeAccordion: '',
        setActiveAccordion(id) {
            this.activeAccordion = (this.activeAccordion == id) ? '' : id
        }
    }" class="relative w-full mx-auto overflow-hidden text-sm font-normal bg-white border border-gray-200 divide-y divide-gray-200 rounded-md">
    @forelse($proposals as $proposal)
        <div wire:key="{{$proposal->id}}">
            <div x-data="{ id: $id('accordion') }" class="cursor-pointer group">
                <button @click="setActiveAccordion(id)" class="flex items-center justify-between w-full p-4 text-left select-none">
                    <!-- Flex container with responsive adjustments and smaller md sizes -->
                    <div class="flex flex-wrap justify-between items-center w-full">
                        <!-- Left side content (Main Researcher and Title) -->
                        <div class="w-full md:w-auto mb-4 md:mb-0">
                            <!-- Title of the Proposal -->
                            <p class="text-base md:text-lg font-normal text-gray-900 dark:text-white leading-tight">
                                {{ $proposal->pp['title'] }}
                            </p>
                            <!-- Progress -->
                            @include('livewire.pp.partials.progress')
                            <!-- End Progress -->
                            <!-- Main Researcher and other details -->
                            <h4 class="text-xs md:text-sm font-medium text-gray-800 dark:text-neutral-200 tracking-wide">
                                <span class="font-medium">Main researcher:</span> {{ $proposal->pp['main_researcher'] }} &nbsp; | &nbsp;
                                <span class="font-medium">Submission deadline:</span> [N/A] &nbsp; | &nbsp;
                                <span class="font-medium">Project duration:</span> [N/A] &nbsp; | &nbsp;
                                <span class="font-medium">Economy owner:</span> [N/A]
                            </h4>
                        </div>
                        <!-- Right side (State label) -->
                        <div class="w-full md:w-auto flex-shrink-0 md:ml-auto">
                            <!--TODO-->
                            @if($proposal->pp['status'] ?? false)
                                <span class="bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-blue-400 border border-blue-400">
                                    {{ $proposal->pp['status'] }}
                                </span>
                            @endif

                            @include('livewire.pp.partials.state')
                        </div>
                    </div>


                    <svg class="w-4 h-4 duration-200 ease-out" :class="{ 'rotate-180': activeAccordion==id }" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                </button>
                <div x-show="activeAccordion==id" x-collapse x-cloak>
                    <div class="p-4 pt-0 opacity-70">
                        <!-- Proposal Details (Responsive Grid) -->
                        <div class="flex flex-col md:flex-row justify-between items-start w-full mt-4">
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 w-full">
                                <!-- DSV coordination -->
                                <p class="text-xs text-gray-600 dark:text-neutral-400">
                                    <span class="font-semibold">Is DSV coordinating:</span><br>
                                    [N/A]
                                </p>
                                <!-- Other coordination -->
                                <p class="text-xs text-gray-600 dark:text-neutral-400">
                                    <span class="font-semibold">Other coordinator:</span><br>
                                    [N/A]
                                </p>
                                <!-- Co-Applicants -->
                                <p class="text-xs text-gray-600 dark:text-neutral-400">
                                    <span class="font-semibold">Co-applicants:</span><br>
                                    {{ $proposal->pp['co_applicants'] }}
                                </p>
                                <!-- Program/Call/Target -->
                                <p class="text-xs text-gray-600 dark:text-neutral-400">
                                    <span class="font-semibold">Program/Call/Target:</span><br>
                                    [N/A]
                                </p>
                                <!-- Co-financing -->
                                <p class="text-xs text-gray-600 dark:text-neutral-400">
                                    <span class="font-semibold">Co-financing needed:</span><br>
                                    [N/A]
                                </p>
                                <!-- OH -->
                                <p class="text-xs text-gray-600 dark:text-neutral-400">
                                    <span class="font-semibold">Percent OH cost covered:</span><br>
                                    [N/A]
                                </p>
                                <!-- Funding organization -->
                                <p class="text-xs text-gray-600 dark:text-neutral-400">
                                    <span class="font-semibold">Funding organization:</span><br>
                                    [N/A]
                                </p>
                                <!-- Budget -->
                                <p class="text-xs text-gray-600 dark:text-neutral-400">
                                    <span class="font-semibold">Budget for project:</span><br>
                                    [N/A]
                                </p>
                                <!-- Budget DSV -->
                                <p class="text-xs text-gray-600 dark:text-neutral-400">
                                    <span class="font-semibold">Budget for DSV:</span><br>
                                    [N/A]
                                </p>
                            </div>

                            <!-- Right aligned content -->
                            <div class="flex flex-col items-end mt-4 md:mt-0">
                                <!-- OK from UH -->
                                <p class="text-xs text-gray-600 dark:text-neutral-400 text-right">
                                    <span class="font-semibold">Unit head:</span> [N/A]
                                </p>
                                <!-- OK from DSV economy -->
                                <p class="text-xs text-gray-600 dark:text-neutral-400 text-right">
                                    <span class="font-semibold">DSV economy:</span> [N/A]
                                </p>
                                <!-- OK from vice head -->
                                <p class="text-xs text-gray-600 dark:text-neutral-400 text-right">
                                    <span class="font-semibold">OK from Vice head:</span> [N/A]
                                </p>
                                <!-- Final submission -->
                                <p class="text-xs text-gray-600 dark:text-neutral-400 text-right">
                                    <span class="font-semibold">Final submission:</span> [N/A]
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
