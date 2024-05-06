<div wire:poll.visible>
    @if(count($dashboard) > 0)
        <span class="md:hidden relative flex h-3 w-3 -mr-3">
            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
            <span class="relative inline-flex rounded-full h-3 w-3 bg-blue-500"></span>
        </span>
    @endif
</div>
