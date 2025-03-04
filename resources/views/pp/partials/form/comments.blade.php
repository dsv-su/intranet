<div class="sm:col-span-2">
    <label for="user_comments" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __("Comments") }}
        <button id="user_comments-button" data-modal-toggle="user_comments-modal" class="inline" type="button">
            <svg class="w-[16px] h-[16px] inline text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M8 9h2v5m-2 0h4M9.408 5.5h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
            </svg>
        </button>
    </label>
    <textarea id="user_comments" rows="4" name="user_comments"
              class="font-mono block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300
                                    focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:placeholder:text-gray-200 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
              placeholder="{{__("Your comments")}}" @if($type == 'view' or $type == 'review') readonly @endif>{{ old('user_comments') ? old('user_comments'): $proposal->pp['user_comments'] ?? '' }}</textarea>
</div>
