<div class="sm:col-span-2">
    {{-- Main label + help modal button --}}
    <div class="flex items-center gap-2 mb-2">
        <label for="user_comments" class="block text-sm font-medium text-gray-900 dark:text-white">
            {{ __("Comments") }}
        </label>

        <button
            id="user_comments-button"
            type="button"
            class="inline-flex items-center"
            data-modal-toggle="user_comments-modal"
            aria-label="{{ __('Help about comments') }}">
            <svg class="w-4 h-4 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M8 9h2v5m-2 0h4M9.408 5.5h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
            </svg>
        </button>
    </div>

    {{-- Preapproval: single editable field --}}
    @if($type === 'preapproval')
        <textarea
            id="user_comments"
            name="user_comments"
            rows="4"
            class="font-mono block w-full p-2.5 text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300
                   focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400
                   dark:placeholder:text-gray-200 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            placeholder="{{ __('Your comments') }}"
        >{{ old('user_comments', $proposal->pp['user_comments'] ?? '') }}</textarea>
    @endif

    {{-- Existing comments (history) --}}
    @if(in_array($type, ['view', 'edit', 'complete', 'resume', 'review'], true))

        {{--}}<span
            class="inline-block bg-yellow-100 text-gray-800 text-sm font-medium px-1 py-0 rounded
                   dark:bg-gray-700 dark:text-blue-400 border border-blue-400 leading-none">
            {{ __("Existing Comments") }}
        </span>{{--}}
        <textarea
            id="user_comments_history"
            rows="8"
            readonly
            class="mt-2 mb-2 font-mono block w-full p-2.5 text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300
                   focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400
                   dark:placeholder:text-gray-200 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            {{ $proposal->pp['user_comments'] ?? '' }}
        </textarea>
    @endif

    {{-- Add new comment --}}
    @if(in_array($type, ['edit', 'complete', 'resume'], true))
        <span
            class="inline-block bg-blue-100 text-gray-800 text-sm font-medium px-1 py-0 rounded
                   dark:bg-gray-700 dark:text-blue-400 border border-blue-400 leading-none">
            {{ __("Add a new comment") }}
        </span>

        <textarea
            id="comment"
            name="comment"
            rows="4"
            class="mt-2 mb-2 font-mono block w-full p-2.5 text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300
                   focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400
                   dark:placeholder:text-gray-200 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            placeholder="{{ __('Add a new comment') }}"
        >{{ old('user_comments_new') }}</textarea>
    @endif
</div>
