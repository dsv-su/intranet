<div>
    <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
    <div class="relative px-36">
        <input type="search" id="request-search" wire:model="searchTerm"
               class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500
                    dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
               placeholder="Filter Name Purpose or ProjectID">
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
            </tr>
            </thead>
            <tbody>
            @foreach($dashboards as $dashboard)

                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">

                    <th scope="row" class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{$dashboard->type}}</th>
                    <td class="px-4 py-3">{{$dashboard->name}}</td>
                    <td class="px-4 py-3">{{$dashboard->request_id}}</td>
                    <td class="px-4 py-3">
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
                                <span class="bg-red-100 text-red-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-red-400 border border-red-400">
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
                                <span class="bg-red-100 text-red-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-red-400 border border-red-400">
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
                                <span class="bg-red-100 text-red-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-red-400 border border-red-400">
                                    {{__("Returned by Unit head")}}
                                </span>
                            @break
                        @endswitch
                    </td>
                    <td class="px-4 py-3">{{\App\Models\User::find($dashboard->user_id)->name}}</td>
                    <td class="px-4 py-3">{{\Carbon\Carbon::createFromTimestamp($dashboard->created)->toDateString()}}</td>
                    <td>
                        <a type="button" href="{{route('fo-request-show', $dashboard->request_id)}}"
                           class="text-green-700 hover:text-white border border-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300
                                font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:border-green-500 dark:text-green-500 dark:hover:text-white dark:hover:bg-green-600 dark:focus:ring-green-800">
                            {{__("Show")}}
                        </a>
                    </td>
                    <td>
                        <a type="button" href="{{route('travel-request-pdf', $dashboard->request_id)}}"
                           class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300
                                        font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-500 dark:focus:ring-blue-800">
                            {{__("Download")}}
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
