<div class="w-full">
    <label for="budget_project" class="font-sans block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __("Budget for complete project") }}<span class="text-red-600"> *</span>
        <button id="budget_project-button" data-modal-toggle="budget_project-modal" class="inline" type="button">
            <svg class="w-[16px] h-[16px] inline text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M8 9h2v5m-2 0h4M9.408 5.5h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
            </svg>
        </button>
    </label>
    <input type="number" name="budget_project" id="budget_project"
           class="font-mono bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600
                                                block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-200 dark:focus:ring-primary-500 dark:focus:border-primary-500"
           value="{{ old('budget_project') ? old('budget_project'): $proposal->pp['budget_project'] ??  '' }}"
           placeholder="Project budget" @if($type == 'complete' or $type == 'edit' or $type == 'resume') required @else readonly @endif>
</div>
