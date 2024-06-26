<div>
    <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
    <div class="relative px-36">
        <input type="search" id="request-search" wire:model="searchTerm"
               class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500
                    dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
               placeholder="{{__("Please refine your search by typing to filter ID, User, Purpose, or ProjectID")}}">
    </div>


    <div class="mt-8 relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-4 py-3">{{__("Request type")}}</th>
                <th scope="col" class="px-4 py-3">{{__("Name")}}</th>
                <th scope="col" class="px-4 py-3">{{__("RequestId")}}</th>
                <th scope="col" class="px-4 py-3">{{__("State")}}</th>
                <th scope="col" class="px-4 py-3">{{__("User")}}</th>
                <th scope="col" class="px-4 py-3">{{__("Created")}}</th>
                <th scope="col" class="px-4 py-3">{{__("Action")}}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($dashboards as $dashboard)

                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">

                    <th scope="row" class="px-4 py-3 text-xs text-gray-900 whitespace-nowrap dark:text-white">
                        @if($dashboard->type == 'travelrequest')
                            <span class="bg-blue-100 text-xs mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-700 border border-blue-400">
                                <svg class="inline w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-width="1.5" d="M4.4 7.7c2 .5 2.4 2.8 3.2 3.8 1 1.4 2 1.3 3.2 2.7 1.8 2.3 1.3 5.7 1.3 6.7M20 15h-1a4 4 0 0 0-4 4v1M8.6 4c0 .8.1 1.9 1.5 2.6 1.4.7 3 .3 3 2.3 0 .3 0 2 1.9 2 2 0 2-1.7 2-2 0-.6.5-.9 1.2-.9H20m1 4a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                </svg>
                            {{__("Travelrequest")}}
                            </span>
                        @else
                            {{$dashboard->type}}
                        @endif

                    </th>
                    <td class="px-4 py-3 text-xs">{{$dashboard->name}}</td>
                    <td class="px-4 py-3 text-xs">{{$dashboard->request_id}}</td>
                    <td class="px-4 py-3 text-xs">
                        @switch($dashboard->state)
                            @case('submitted')
                                <span class="bg-blue-100 text-blue-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-blue-400 border border-blue-400">
                                    {{__("Submitted")}}
                                </span>
                            @break
                            @case('manager_approved')
                                <span class="bg-blue-100 text-blue-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-blue-400 border border-blue-400">
                                    {{__("Approved by manager")}}
                                </span>
                            @break
                            @case('manager_denied')
                                <span class="bg-red-100 text-red-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-red-400 border border-red-400">
                                    {{__("Denied by manager")}}
                                </span>
                            @break
                            @case('manager_returned')
                                <span class="bg-gray-100 text-gray-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-400 border border-gray-500">
                                    {{__("Returned by manager")}}
                                </span>
                            @break
                            @case('fo_approved')
                                <span class="bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-green-400 border border-green-400">
                                    {{__("Approved by FO")}}
                                </span>
                            @break
                            @case('fo_denied')
                                <span class="bg-red-100 text-red-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-red-400 border border-red-400">
                                    {{__("Denied by FO")}}
                                </span>
                            @break
                            @case('fo_returned')
                                <span class="bg-gray-100 text-gray-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-400 border border-gray-500">
                                    {{__("Returned by FO")}}
                                </span>
                            @break
                            @case('head_approved')
                                <span class="bg-blue-100 text-blue-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-blue-400 border border-blue-400">
                                    {{__("Approved by Unit head")}}
                                </span>
                            @break
                            @case('head_denied')
                                <span class="bg-red-100 text-red-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-red-400 border border-red-400">
                                    {{__("Denied by Unit head")}}
                                </span>
                            @break
                            @case('head_returned')
                                <span class="bg-gray-100 text-gray-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-400 border border-gray-500">
                                    {{__("Returned by Unit head")}}
                                </span>
                            @break
                        @endswitch
                    </td>
                    <td class="px-4 py-3 text-xs">{{\App\Models\User::find($dashboard->user_id)->name}}</td>
                    <td class="px-4 py-3 text-xs">{{\Carbon\Carbon::createFromTimestamp($dashboard->created)->toDateString()}}</td>
                    <td>
                        <a type="button" href="{{route('fo-request-show', $dashboard->request_id)}}"
                           class="text-green-700 hover:text-white border border-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300
                                rounded-lg text-xs px-3 py-2 text-center me-2 mb-2 dark:border-green-500 dark:text-green-500 dark:hover:text-white dark:hover:bg-green-600 dark:focus:ring-green-800">
                            {{__("Show")}}
                        </a>
                    </td>
                    <td>
                        <a type="button" href="{{route('travel-request-pdf', $dashboard->request_id)}}"
                           class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300
                                        rounded-lg text-xs px-3 py-2 text-center me-2 mb-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-500 dark:focus:ring-blue-800">
                            {{__("Download")}}
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
