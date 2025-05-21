<div class="w-full overflow-x-hidden">
    <div class="mb-4 space-y-4 rounded-lg p-4 sm:p-6 dark:bg-gray-900 text-black dark:text-white max-w-screen-lg w-full mx-auto">
        <div class="pointer-events-auto rounded-lg bg-white p-4 text-sm shadow-xl shadow-black/5 hover:bg-slate-50 ring-1 ring-blue-500 dark:bg-gray-900 text-black dark:text-white w-full">

            <!-- Section: Labels Row -->
            <div class="space-y-3 sm:space-y-0 sm:flex sm:flex-wrap sm:items-center sm:gap-4 w-full">
                <div class="flex items-center gap-2 flex-wrap break-words">
                    <h2 class="text-xs font-semibold text-gray-900 dark:text-white">Research Area:</h2>
                    <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium
                        bg-blue-50 text-blue-700 ring-1 ring-inset ring-blue-700/10
                        dark:bg-blue-900 dark:text-blue-200 dark:ring-blue-300/20 break-words max-w-full">
                        {{$proposal->pp['research_area']}}
                    </span>
                </div>

                <div class="flex items-center gap-2 flex-wrap break-words">
                    <h2 class="text-xs font-semibold text-gray-900 dark:text-white">Reviewer:</h2>
                    <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium
                        bg-transparent text-blue-700 ring-1 ring-inset ring-blue-700/10
                        dark:bg-transparent dark:text-blue-200 dark:ring-blue-300/20 break-words max-w-full">
                        {{$reviewer->name}}
                    </span>
                </div>
                <div class="flex items-center gap-2 flex-wrap break-words">
                    <h2 class="text-xs font-semibold text-gray-900 dark:text-white">Role:</h2>
                    <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium
                        bg-transparent text-blue-700 ring-1 ring-inset ring-blue-700/10
                        dark:bg-transparent dark:text-blue-200 dark:ring-blue-300/20 break-words max-w-full">
                        N/A
                    </span>
                </div>

                <div class="flex items-center gap-2 flex-wrap break-words">
                    <h2 class="text-xs font-semibold text-gray-900 dark:text-white">State:</h2>
                    <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium
                        bg-transparent text-blue-700 ring-1 ring-inset ring-blue-700/10
                        dark:bg-transparent dark:text-blue-200 dark:ring-blue-300/20 break-words max-w-full">
                        @switch($dashboard->state)
                            @case('complete')
                            User has completed proposal
                            @break
                            @case('head_approved')
                            Approved by vice head and unit head
                            @break
                            @case('fo_approved')
                            Approved by Economy
                            @break
                            @default
                            {{$dashboard->state}}
                            @break
                        @endswitch
                    </span>
                </div>
            </div>

            <!-- Budget Grid -->
            <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 w-full">
                <div class="break-words">
                    <h2 class="text-xs font-semibold text-gray-900 dark:text-white mb-1">Total preapproved</h2>
                    <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium
                        bg-blue-50 text-blue-700 ring-1 ring-inset ring-blue-700/10
                        dark:bg-blue-900 dark:text-blue-200 dark:ring-blue-300/20 break-words max-w-full">
                        {{ $budget->research_area[$proposal->pp['research_area']]['preapproved'] }}
                    </span>
                </div>

                <div class="break-words">
                    <h2 class="text-xs font-semibold text-gray-900 dark:text-white mb-1">Accumulated committed</h2>
                    <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium
                        bg-gray-50 text-gray-700 ring-1 ring-inset ring-gray-600/20
                        dark:bg-gray-800 dark:text-gray-300 dark:ring-gray-500/30 break-words max-w-full">
                        {{ $budget->research_area[$proposal->pp['research_area']]['budget'] }}
                    </span>
                </div>

                <div class="break-words">
                    <h2 class="text-xs font-semibold text-gray-900 dark:text-white mb-1">Total Budget DSV</h2>
                    <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium
                        bg-green-50 text-green-700 ring-1 ring-inset ring-green-600/20
                        dark:bg-green-900 dark:text-green-200 dark:ring-green-400/30 break-words max-w-full">
                        {{ $budget->budget_dsv_total }}
                    </span>
                </div>

                <div class="break-words">
                    <h2 class="text-xs font-semibold text-gray-900 dark:text-white mb-1">Days until submission</h2>
                    @if($proposal->pp['submission_deadline'] ?? false)
                        @php
                            $deadline = \Carbon\Carbon::createFromFormat('d/m/Y', $proposal->pp['submission_deadline']);
                            $daysLeft = now()->diffInDays($deadline, false);
                        @endphp

                        @if ($daysLeft > 0)
                            <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium
                                bg-blue-50 text-blue-700 ring-1 ring-inset ring-blue-700/10
                                dark:bg-blue-900 dark:text-blue-200 dark:ring-blue-400/30">
                                {{ $daysLeft }} days left
                            </span>
                        @elseif ($daysLeft === 0)
                            <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium
                                bg-yellow-50 text-yellow-800 ring-1 ring-inset ring-yellow-600/20
                                dark:bg-yellow-900 dark:text-yellow-200 dark:ring-yellow-400/30">
                                Deadline is today!
                            </span>
                        @else
                            <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium
                                bg-red-50 text-red-700 ring-1 ring-inset ring-red-600/10
                                dark:bg-red-900 dark:text-red-200 dark:ring-red-400/30">
                                Deadline passed {{ abs($daysLeft) }} days ago
                            </span>
                        @endif
                    @else
                        <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium
                            bg-blue-50 text-blue-700 ring-1 ring-inset ring-blue-700/10
                            dark:bg-blue-900 dark:text-blue-200 dark:ring-blue-400/30">
                            N/A
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>


