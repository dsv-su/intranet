<!-- Review Co investigators-->
<div class="w-full sm:col-span-2">
    <label for="coinvestigators" class="font-sans block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __("Co-investigators") }}
        <button id="coinvestigators" data-modal-toggle="coinvestigators-modal" class="inline" type="button">
            <svg class="w-[16px] h-[16px] inline text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M8 9h2v5m-2 0h4M9.408 5.5h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
            </svg>
        </button>
    </label>
</div>
@foreach($proposal['pp']['co_investigator_name'] as $coname)
    <div class="w-full">
        <div class="font-mono bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600
                                        block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-200 dark:focus:ring-primary-500 dark:focus:border-primary-500">
            {{$coname}}
        </div>
    </div>
    <div class="w-full">
        <div class="font-mono bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600
                                        block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-200 dark:focus:ring-primary-500 dark:focus:border-primary-500">
            {{$proposal['pp']['co_investigator_email'][$loop->index] ?? 'Email is missing'}}
        </div>
    </div>
@endforeach
