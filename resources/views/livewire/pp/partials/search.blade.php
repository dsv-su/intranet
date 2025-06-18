<div class="mb-4 bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
    <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
        <div class="w-full">
            <form class="flex items-center">
                <label for="simple-search" class="sr-only">Search</label>
                <div class="relative w-full">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <input wire:model.live="searchProposal" type="text" id="simple-search"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500
                                   focus:border-primary-500 block w-full pl-10 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400
                                   dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                           placeholder="Search" required="">
                </div>
                <div class="flex flex-col sm:flex-row sm:space-x-2 space-y-2 sm:space-y-0">
                    <a
                        type="button"
                        href="{{route('budget-template')}}"
                        class="
                          ml-1 mr-1 w-full sm:w-auto
                          inline-flex items-center justify-center gap-x-2
                          h-8 md:h-10
                          px-2 md:px-4
                          text-[10px] md:text-xs
                          font-medium rounded-lg
                          text-blue-600
                          hover:border-blue-500 hover:text-blue-500
                          focus:outline-none focus:border-blue-500 focus:text-blue-500
                          disabled:opacity-50 disabled:pointer-events-none
                          dark:bg-neutral-800 dark:border-neutral-700 dark:text-white
                          dark:hover:bg-neutral-700 dark:focus:bg-neutral-700
                        ">
                        <svg class="shrink-0 size-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 15v2a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3v-2m-8 1V4m0 12-4-4m4 4 4-4"/>
                        </svg>
                        DSV Budget Template
                        <!-- …SVG… -->
                    </a>

                    <a
                        type="button"
                        href="{{route('new-project')}}"
                        class="
                          ml-1 w-full sm:w-auto
                          inline-flex items-center justify-center gap-x-2
                          h-8 md:h-10
                          px-2 md:px-4
                          text-[10px] md:text-xs
                          font-medium rounded-lg
                          border border-blue-600 text-blue-600
                          bg-white shadow-2xs
                          hover:bg-gray-50 focus:outline-none focus:bg-gray-50
                          disabled:opacity-50 disabled:pointer-events-none
                          dark:bg-neutral-800 dark:border-neutral-700 dark:text-white
                          dark:hover:bg-neutral-700 dark:focus:bg-neutral-700
                        ">
                        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                             stroke-linejoin="round">
                            <path d="M5 12h14"></path>
                            <path d="m12 5 7 7-7 7"></path>
                        </svg>
                        New Proposal
                        <!-- …SVG… -->
                    </a>
                </div>

            </form>
        </div>
    </div>
</div>
