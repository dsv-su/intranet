<div>
    <!-- Returned Notifications -->
    @foreach($returned as $return)
        <a href="#" class="flex bg-red-200 py-3 px-4 border-b hover:bg-gray-100 dark:hover:bg-gray-600 dark:border-gray-600">
            <div class="flex-shrink-0 mt-4">
                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M5 4a4 4 0 0 1 4 4v6M5 4a4 4 0 0 0-4 4v6h8M5 4h9M9 14h10V8a3.999 3.999 0 0 0-2.066-3.5M9 14v5m0-5h4v5m-9-8h2m8-4V1h2"/>
                </svg>
            </div>
            <div class="pl-3 w-full">
                <div class="text-gray-900 dark:text-white font-semibold text-sm mb-1.5 ">[{{$return->id}}] {{$return->name}}</div>
                <div class="text-xs font-medium text-primary-700 dark:text-white">
                    @if($return->status == 'unread')
                        <span class="bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-green-400 border border-green-400">
                              @else
                                <span class="bg-gray-100 text-gray-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-400 border border-gray-500">
                              @endif
                                    {{__("Sent")}}
                                    </span>
                                {{Carbon\Carbon::createFromTimestamp($return->created)->toDateString()}}
                                | Status:
                                <span class="bg-red-100 text-red-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-red-400 border border-red-400">
                                @switch($return->state)
                                        @case('manager_returned')
                                        {{__("Returned by manager")}}
                                        @break
                                        @case('fo_returned')
                                        {{__("Returned by FO")}}
                                        @break
                                        @case('head_returned')
                                        {{__("Returned by Unit head")}}
                                        @break
                                    @endswitch
                              </span>

                </div>
            </div>
        </a>
    @endforeach
</div>
