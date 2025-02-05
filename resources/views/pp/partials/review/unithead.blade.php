<div class="w-full">
    @if(is_array($proposal['pp']['unit_head'] ?? []) && ($UnitHeads = count($proposal['pp']['unit_head'])) > 1)
        @foreach($proposal['pp']['unit_head'] as $uh)
            <div class="mb-2 font-mono bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600
                                        block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-200 dark:focus:ring-primary-500 dark:focus:border-primary-500">
            {{ \App\Models\User::find($uh)->name }}
            </div>
        @endforeach
    @else

        <div class="font-mono bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600
                                        block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-200 dark:focus:ring-primary-500 dark:focus:border-primary-500">
        {{--}}
        {{ \App\Models\User::find($proposal['pp']['unit_head'][0])->name }}
        {{--}}
        @if(is_array($proposal['pp']['unit_head'] ?? []) && isset($proposal['pp']['unit_head'][0]))
            {{ \App\Models\User::find($proposal['pp']['unit_head'][0])->name }}
        @else
                {{ \App\Models\User::find($proposal['pp']['unit_head'])->name }}
        @endif

        </div>
    @endif



</div>
