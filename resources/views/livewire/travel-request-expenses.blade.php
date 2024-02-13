<div class="sm:col-span-2">
    <div class="grid gap-6 mb-6 md:grid-cols-2">
        <!-- Flight -->
        <div class="w-full">
            <label for="flight" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __("Flight") }}</label>
            <input wire:model="flight" type="text" id="flight" name="flight" value="{{ old('flight') ? old('flight'): $flight ?? '' }}"
                   placeholder="{{ __("SEK") }}"
                   class="font-mono bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block
                    w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">

        </div>
        <!--Hotel-->
        <div class="w-full">
            <label for="hotel" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __("Hotel") }}</label>
            <input wire:model="hotel" type="text" id="hotel" name="hotel" value="{{ old('hotel') ? old('hotel'): $hotel ?? '' }}"
                   placeholder="{{ __("SEK") }}"
                   class="font-mono bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block
                    w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
        </div>
        <!-- Daily allwances -->
        <div class="w-full">
            <label for="daily" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white @if($days) bg-blue-200 @endif">{{ __("Daily subsistence allowances") }} @if($days) x {{$days}} {{__("days")}} @endif</label>
            {{--}}
            <input wire:model="daily" type="text" id="daily" name="daily" value="{{ old('daily') ? old('daily'): $daily ?? '' }}"
                   placeholder="@if(!$daily){{ __("Please select a country destination") }}@endif"
                   @if($daily) readonly @endif
                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block
                    w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
             {{--}}
            <div class="font-mono bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block
                    w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                {{$countryname ?? __("Please select a country destination")}} @if($countryname): {{$daily}} x {{$days}} = {{ $daily*$days }} @endif
            </div>

        </div>
        <!--Conference fee-->
        <div class="w-full">
            <label for="conference" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __("Conference fee") }}</label>
            <input wire:model="conference" type="text" id="conference" name="conference" value="{{ old('conference') ? old('conference'): $conference ?? '' }}"
                   placeholder="{{ __("SEK") }}"
                   class="font-mono bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block
                    w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
        </div>
        <!--Other-->
        <div class="w-full">
            <label for="other" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __("Other, such as taxi, bus, train") }}</label>
            <input wire:model="other" type="text" id="other" name="other" value="{{ old('other') ? old('other'): $other ?? '' }}"
                    placeholder="{{ __("SEK") }}"
                   class="font-mono bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block
                    w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
        </div>
        <!--Total-->
        <div class="w-full">
            <label for="other" class="font-extrabold uppercase block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __("Total") }}</label>
            <input wire:model="total" type="text" id="total" name="total" value="{{ old('total') ? old('total'): $total ?? '' }}"
                    placeholder="{{ __("SEK") }}"
                    class="font-mono font-bold bg-blue-300 border border-gray-300 text-black text-sm font-semibold rounded-lg focus:ring-primary-600 focus:border-primary-600 block
                    w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
        </div>
    </div>
    <input wire:model="daily" name="daily" hidden>
    <input wire:model="days" name="days" hidden>
</div>
