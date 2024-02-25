<div>
    <div class="p-3 mt-3 flex flex-col rounded-xl ">
        <h3 class="text-left mb-2 text-lg md:text-xl font-semibold text-gray-800 dark:text-gray-200">
            {{__("Teacher information")}}
        </h3>
        <label class="inline-flex items-center cursor-pointer">
            <input wire:click="show_status" type="checkbox" value="" class="sr-only peer" @if($status == true) checked @endif>
            <div class="relative w-9 h-5 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800
                rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white
                after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4
                after:w-4 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600">
            </div>
            <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">{{__("Room Status")}}</span>
        </label>
    </div>
</div>
