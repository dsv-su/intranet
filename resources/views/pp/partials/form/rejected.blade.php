<!-- Granted -->
@if(in_array($dashboard->state, ['final_approved', 'denied']))
    <div id="rejected" class="w-full sm:col-span-2 py-3 flex items-center text-xs text-blue-500 uppercase
                                before:flex-1 before:border-t before:border-gray-200 before:me-6 after:flex-1 after:border-t after:border-gray-200 after:ms-6
                                dark:text-blue-400 dark:before:border-neutral-600 dark:after:border-neutral-600">
        Rejection
    </div>


    <div class=" mt-2 mb-4 sm:col-span-2">
        <label for="user_comments" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __("Reason for rejection") }}</label>
        <textarea id="rejected_comments" rows="4" name="rejected_comments"
                  class="font-mono block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300
                                    focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:placeholder:text-gray-200 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                  placeholder="{{__("Reason for Rejection (if stated)")}}" @if($type == 'view' or $type == 'review') readonly @endif>{{ old('rejected_comments') ? old('rejected_comments'): $proposal->pp['rejected_comments'] ?? '' }}</textarea>
    </div>
@endif
