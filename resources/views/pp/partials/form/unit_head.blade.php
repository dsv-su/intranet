<div>
    <label for="unit_head" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
        {{ __("Unit Head for approval") }}<span class="text-red-600"> *</span>
        <button id="unithead-button" data-modal-toggle="unithead-modal" type="button" class="inline">
            <svg class="w-[16px] h-[16px] inline text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6"
                      d="M8 9h2v5m-2 0h4M9.408 5.5h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
            </svg>
        </button>
    </label>

    @if(in_array($type, ['complete', 'edit', 'resume']))
        <div id="unithead-container">
        @php
            $selectedUnitHeads = ($type == 'complete' && empty($proposal['pp']['unit_head']))
                ? []
                : ($proposal['pp']['unit_head'] ?? []);
        @endphp

        @if(count($selectedUnitHeads) > 1)
            <!-- Multiple Unit Heads -->
                @foreach($selectedUnitHeads as $selectedUnitHead)
                    <select name="unit_head[]" class="mb-2 font-mono bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-200 dark:focus:ring-primary-500 dark:focus:border-primary-500">
                        @foreach($unitheads as $unithead)
                            <option value="{{ $unithead->id }}" {{ $unithead->id == $selectedUnitHead ? 'selected' : '' }}>
                                {{ $unithead->name }}
                            </option>
                        @endforeach
                    </select>
                @endforeach
            @else
            <!-- Single Unit Head -->
                <select id="unit_head" name="unit_head[]" class="font-mono bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-200 dark:focus:ring-primary-500 dark:focus:border-primary-500">
                    @foreach($unitheads as $unithead)
                        <option value="{{ $unithead->id }}" {{ $unithead->id == ($selectedUnitHeads[0] ?? null) ? 'selected' : '' }}>
                            {{ $unithead->name }}
                        </option>
                    @endforeach
                </select>
            @endif

            @error('unit_head')
            <p class="mt-3 text-sm leading-6 text-red-600">{{ __("This is a required input") }}</p>
            @enderror
        </div>
    @else
        @include('pp.partials.review.unithead')
    @endif

    @if(in_array($type, ['complete', 'edit', 'resume']))
    <!-- Add Unit Head-->
        <div class="mt-4">
            <label for="unit_head" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                {{ __("Add a Unit Head for approval") }}
                <button id="add-unithead-button"
                        class="inline py-1 px-2 inline-flex items-center gap-x-1 text-xs font-medium rounded-lg border border-blue-600 text-blue-600 hover:border-blue-500 hover:text-blue-500 focus:outline-none focus:border-blue-500 focus:text-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:border-blue-500 dark:text-blue-500 dark:hover:text-blue-400 dark:hover:border-blue-400"
                        type="button">
                    Add+
                </button>
            </label>
        </div>
    @endif
</div>
