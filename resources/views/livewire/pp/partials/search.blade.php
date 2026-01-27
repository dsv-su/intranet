<div class="mb-4 bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
    <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
        <div class="w-full">
            <form class="flex items-center gap-2 sm:gap-3">
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

                <div class="flex flex-col sm:flex-row gap-1 sm:gap-2">
                    <a
                        href="{{route('budget-template')}}"
                        class="
                              w-full sm:flex-1
                              inline-flex items-center justify-center gap-x-2
                              h-9 md:h-10
                              px-3 md:px-4
                              text-[8px] sm:text-[9px] md:text-[10px]
                              font-medium rounded-lg
                              text-blue-600 border border-blue-600
                              hover:border-blue-500 hover:text-blue-500 hover:bg-blue-50
                              focus:outline-none focus:ring-2 focus:ring-blue-500/40
                              transition
                              dark:bg-neutral-800 dark:border-neutral-700 dark:text-white
                              dark:hover:bg-neutral-700
                            "
                    >
                        <svg class="size-4 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M4 15v2a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3v-2m-8 1V4m0 12-4-4m4 4 4-4"/>
                        </svg>
                        <span class="text-center leading-tight">DSV Budget Template</span>
                    </a>

                    <a
                        href="{{route('new-project')}}"
                        class="
                              w-full sm:flex-1
                              inline-flex items-center justify-center gap-x-2
                              h-9 md:h-10
                              px-3 md:px-4
                              text-[8px] sm:text-[9px] md:text-xs
                              font-medium rounded-lg
                              border border-blue-600 text-blue-600 bg-white
                              hover:bg-gray-50
                              focus:outline-none focus:ring-2 focus:ring-blue-500/40
                              transition
                              dark:bg-neutral-800 dark:border-neutral-700 dark:text-white
                              dark:hover:bg-neutral-700
                            "
                    >
                        <span class="text-center leading-tight">New Proposal</span>
                    </a>
                </div>

            </form>
        </div>
    </div>
</div>
