<div wire:poll.keep-alive>
    @foreach($user_requests as $user_request)
        <a href="{{route('travel-request-show', $user_request->id)}}" class="flex py-3 px-4 border-b hover:bg-gray-100 dark:hover:bg-gray-600 dark:border-gray-600">
            <div class="flex-shrink-0 mt-4">
                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                    <path stroke="currentColor" stroke-linejoin="round" stroke-width="1" d="M8 8v1h4V8m4 7H4a1 1 0 0 1-1-1V5h14v9a1 1 0 0 1-1 1ZM2 1h16a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1Z"/>
                </svg>
            </div>
            <div class="pl-3 w-full">
                <div class="text-gray-900 dark:text-white font-semibold text-sm mb-1.5 ">[{{$user_request->id}}] {{$user_request->name}}</div>
                <div class="text-xs font-medium text-primary-700 dark:text-white">
                    @if($user_request->status == 'unread')
                        <span class="bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-green-400 border border-green-400">
                              @else
                                <span class="bg-gray-100 text-gray-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-400 border border-gray-500">
                              @endif
                                    {{__("Sent")}}
                                  </span>
                                {{Carbon\Carbon::createFromTimestamp($user_request->created)->toDateString()}}
                                | Status:
                                @if($user_request->state == 'manager_denied' or $user_request->state == 'fo_denied' or $user_request->state == 'head_denied')
                                    <span class="bg-red-100 text-red-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-red-400 border border-red-400">
                              @elseif ($user_request->state == 'manager_returned' or $user_request->state == 'fo_returned' or $user_request->state == 'head_returned')
                                            <span class="bg-blue-100 text-blue-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-blue-400 border border-blue-400">
                              @else
                                                    <span class="bg-yellow-100 text-yellow-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-yellow-300 border border-yellow-300">
                              @endif
                                                        @switch($user_request->state)
                                                            @case('submitted')
                                                            {{__("Submitted")}}
                                                            @break
                                                            @case('manager_approved')
                                                            {{__("Processing")}}
                                                            @break
                                                            @case('manager_denied')
                                                            {{__("Denied")}}
                                                            @break
                                                            @case('manager_returned')
                                                            {{__("Returned")}}
                                                            @break
                                                            @case('head_approved')
                                                            {{__("Processing")}}
                                                            @break
                                                            @case('fo_denied')
                                                            {{__("Denied")}}
                                                            @break
                                                            @case('fo_returned')
                                                            {{__("Returned")}}
                                                            @break
                                                            @case('fo_approved')
                                                            {{__("Approved")}}
                                                            @break
                                                            @case('head_denied')
                                                            {{__("Denied")}}
                                                            @break
                                                            @case('head_returned')
                                                            {{__("Returned")}}
                                                            @break
                                                        @endswitch
                                </span>

                </div>
            </div>
        </a>
    @endforeach
</div>
