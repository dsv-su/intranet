<div class="{{$checkbox}} w-full mt-2 sm:col-span-2">
    <!-- Label  -->
    <label for="eu_wallenberg_project" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
        @if($wallenbergOrg)
            {{"Wallenberg project"}}
        @else
        {{ __("Is it an Wallenberg project?") }}
        @endif
            <span class="text-red-600"> *</span>
        <button id="eu_wallenberg-button" data-modal-toggle="eu_wallenberg-modal" class="inline" type="button">
            <svg class="w-[16px] h-[16px] inline text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M8 9h2v5m-2 0h4M9.408 5.5h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
            </svg>
        </button>
    </label>

    <!-- Flex container for radio buttons and the notification label -->
    <div class="flex flex-col sm:flex-row gap-4 w-full">
        <!-- Radio Buttons -->
        <div class="flex gap-2 flex-1">
            <label for="eu_wallenberg_no" class="flex items-center py-2 px-6 w-full bg-white border border-gray-300 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
                <input type="radio" wire:click="no" name="eu_wallenberg" value="no"
                       class="shrink-0 mt-0.5 border-gray-200 rounded text-blue-600 focus:ring-blue-500 disabled:opacity-50
                       disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500
                       dark:checked:border-blue-500 dark:focus:ring-offset-gray-800"
                       @if($proposal->pp['eu_wallenberg'] ?? false)
                           @if($proposal->pp['eu_wallenberg'] === 'no')
                            checked
                           @endif
                       @endif
                        @if($wallenbergOrg)
                            disabled
                        @else
                            required
                        @endif
                        />
                <span class="text-sm text-gray-500 ms-3 dark:text-neutral-400">No</span>
            </label>
            <label for="eu_wallenberg" class="flex items-center py-2 px-6 w-full bg-white border border-gray-300 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
                <input type="radio" wire:click="yes" name="eu_wallenberg" value="yes"
                       class="shrink-0 mt-0.5 border-gray-200 rounded text-blue-600 focus:ring-blue-500 disabled:opacity-50
                       disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500
                       dark:checked:border-blue-500 dark:focus:ring-offset-gray-800"
                       @if($proposal->pp['eu_wallenberg'] ?? false or $wallenbergOrg)
                           @if($proposal->pp['eu_wallenberg'] === 'yes' || $wallenbergOrg)
                            checked
                           @endif
                       @endif
                       required />
                <span class="text-sm text-gray-500 ms-3 dark:text-neutral-400">Yes</span>
            </label>
        </div>

        <!-- Forskningsservice Label -->
        <label for="forskningsservice"
               class="{{$visibility}} flex flex-col p-2 w-full bg-white border border-gray-500 rounded-lg text-sm font-semibold text-gray-900 focus:border-blue-600 focus:ring-blue-600
              dark:bg-neutral-900 dark:border-neutral-600 dark:text-neutral-200 flex-1">
            <span>Approval from Forskningsservice is required! Follow this link for more information:</span>
            <a href="https://medarbetare.su.se/en/research/funding/swedish-research-funders/the-wallenberg-foundations"
               class="text-blue-600 underline mt-1"
               target="_blank"
               rel="noopener noreferrer">
                SU Wallenberg
            </a>
        </label>


    </div>
</div>

