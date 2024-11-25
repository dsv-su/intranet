<div wire:poll.visible>
    <div class="bg-gray-50 dark:bg-gray-900 p-3 sm:p-5">
        <div class="mx-auto max-w-screen-xl px-4 lg:px-12">
            <!-- Search Form -->
            @include('livewire.pp.partials.search')
            <!-- Proposal List -->
            <div class="mb-4 bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-2 p-2">
                    @include('livewire.pp.partials.pp-list')
                </div>
            </div>

            <!-- Pagination -->
            @if($proposals->hasPages())
            <div class="mb-4 bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
                    {{$proposals->links()}}
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
