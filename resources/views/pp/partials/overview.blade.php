<div class="mb-4 space-y-4">
    <div class="pointer-events-auto rounded-lg bg-white p-4 text-[0.8125rem]/5 shadow-xl shadow-black/5 hover:bg-slate-50 ring-1 ring-blue-500">
        <div class="lg:flex lg:items-center lg:justify-between">
            <!-- First -->
            <div class="min-w-0 flex-1">
                <h2 class="text-xs leading-5 font-semibold text-gray-900">Project Status</h2>
                @switch($proposal->status_stage1)

                    @case('pending')
                    @case('head_returned')
                    @case('vice_returned')
                    @case('fo_returned')
                        <span class="inline-flex uppercase items-center rounded-md bg-yellow-50 px-2 py-1 text-xs font-medium text-yellow-800 ring-1 ring-inset ring-yellow-600/20">
                        @break
                    @case('submitted')
                        <span class="inline-flex uppercase items-center rounded-md bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10">
                        @break
                    @case('head_approved')
                        <span class="inline-flex uppercase items-center rounded-md bg-purple-50 px-2 py-1 text-xs font-medium text-purple-700 ring-1 ring-inset ring-purple-700/10">
                        @break
                    @case('vice_approved')
                        <span class="inline-flex uppercase items-center rounded-md bg-indigo-50 px-2 py-1 text-xs font-medium text-indigo-700 ring-1 ring-inset ring-indigo-700/10">
                        @break
                    @case('fo_approved')
                        <span class="inline-flex uppercase items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">
                        @break
                    @case('head_denied')
                    @case('vice_denied')
                    @case('fo_denied')
                    @case('error')
                        <span class="inline-flex uppercase items-center rounded-md bg-red-50 px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-600/10">
                        @break

                @endswitch
                        {{$proposal->status_stage1}}</span>
            </div>
            <!-- Second -->
            @php
                $budget = $proposal->pp['budget_dsv'];
                $max = 50000;

            @endphp
            <div class="min-w-0 flex-1">
                <h2 class="text-xs leading-5 font-semibold text-gray-900">Total budget DSV</h2>
                <span class="inline-flex uppercase items-center rounded-md bg-gray-50 px-2 py-1 text-xs font-medium text-gray-700 ring-1 ring-inset ring-gray-600/20">{{$max}}
            </div>
            <div class="min-w-0 flex-1">
                <h2 class="text-xs leading-5 font-semibold text-gray-900">Budget DSV</h2>
                @if ($budget > $max)
                    <span class="inline-flex items-center uppercase rounded-md bg-red-50 px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-600/10">
                @else
                            <span class="inline-flex uppercase items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">
                @endif

                        {{$proposal->pp['budget_dsv']}} {{$proposal->pp['currency']}}
                    </span>
            </div>
            <!-- Third -->
            <div class="min-w-0 flex-1">
                <h2 class="text-xs leading-5 font-semibold text-gray-900">Days until submission</h2>
                @php
                    $deadline = \Carbon\Carbon::createFromFormat('d/m/Y', $proposal->pp['submission_deadline']);
                    $daysLeft = now()->diffInDays($deadline, false);
                @endphp

                @if ($daysLeft > 0)
                    <span class="inline-flex items-center rounded-md bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10">
                    {{ $daysLeft }} days left
                @elseif ($daysLeft === 0)
                        <span class="inline-flex items-center rounded-md bg-yellow-50 px-2 py-1 text-xs font-medium text-yellow-800 ring-1 ring-inset ring-yellow-600/20">
                    Deadline is today!
                @else
                    <span class="inline-flex items-center rounded-md bg-red-50 px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-600/10">
                    Deadline passed {{ abs($daysLeft) }} days ago
                @endif
                    </span>

            </div>
        </div>
        @nocache('livewire.pp.partials.progress2')
    </div>
</div>



