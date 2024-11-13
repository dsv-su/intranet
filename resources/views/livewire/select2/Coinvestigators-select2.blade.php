<div class="w-full sm:col-span-2">
    <!-- Co investigators label -->
    <label for="coinvestigators" class="font-sans block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __("Co-investigators") }}
        <button id="coinvestigators" data-modal-toggle="coinvestigators-modal" class="inline" type="button">
            <svg class="w-[16px] h-[16px] inline text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M8 9h2v5m-2 0h4M9.408 5.5h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
            </svg>
        </button>
    </label>
    <!-- Edit or resume -->
    @if(count($coinv) > 0)
        @foreach($coinv as $key => $coinvestigator)
        <div class="flex flex-col md:flex-row gap-4 mb-4 items-center">
            <!-- Name -->
            <div class="font-mono bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600
                    w-full md:w-1/2 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-200 dark:focus:ring-primary-500 dark:focus:border-primary-500">
                {{$coinvestigator['name'] ?? 'Name is missing'}}
            </div>
            <!-- Email -->

            <div class="font-mono bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600
                    w-full md:w-1/2 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-200 dark:focus:ring-primary-500 dark:focus:border-primary-500">
                {{$coinvestigator['email'] ?? 'Email is missing'}}
            </div>

            <!-- Icon -->
            <div class="flex items-center">
                <button type="button" wire:click="Editremove({{$key}})">
                    <svg class="shrink-0 size-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12h4M4 18v-1a3 3 0 0 1 3-3h4a3 3 0 0 1 3 3v1a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1Zm8-10a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                    </svg>
                </button>

            </div>
        </div>
            <input type="hidden" name="co_investigator_name[]" value="{{$coinvestigator['name'] ?? ''}}">
            <input type="hidden" name="co_investigator_email[]" value="{{$coinvestigator['email'] ?? ''}}">
        @endforeach

    @endif
    <!-- SUKAT Co investigators -->
    @if(count($coinvestigators) > 0 )
        @foreach($coinvestigators as $key => $co)
            <div class="flex flex-col md:flex-row gap-4 mb-4 items-center">
                <!-- Name -->
                <div class="font-mono bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600
                    w-full md:w-1/2 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-200 dark:focus:ring-primary-500 dark:focus:border-primary-500">
                    {{$co['displayname'][0] ?? 'Name is missing'}}
                </div>
                <!-- Email -->

                <div class="font-mono bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600
                    w-full md:w-1/2 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-200 dark:focus:ring-primary-500 dark:focus:border-primary-500">
                    {{$co['mail'][0] ?? 'Email is missing'}}
                </div>
                <!-- Icon -->
                <div class="flex items-center">
                    <button type="button" wire:click="remove({{$key}})">
                        <svg class="shrink-0 size-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12h4M4 18v-1a3 3 0 0 1 3-3h4a3 3 0 0 1 3 3v1a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1Zm8-10a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                        </svg>
                    </button>

                </div>
            </div>

            <input type="hidden" name="co_investigator_name[]" value="{{$co['displayname'][0] ?? ''}}">
            <input type="hidden" name="co_investigator_email[]" value="{{$co['mail'][0] ?? ''}}">
        @endforeach
    @endif
    <!-- External Co investigators -->
    <div class=" {{$external}} flex flex-col md:flex-row gap-4 mt-4 mb-4 items-center">

        <!-- Name -->
        <input type="text" wire:model="external_coinvestigators_name"
               class="font-mono bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600
                        w-full md:w-1/2 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-200 dark:focus:ring-primary-500 dark:focus:border-primary-500"
               placeholder="{{__("Type Name")}}">
        <!-- Email -->
        <input type="email" wire:model="external_coinvestigators_email"
               class="font-mono bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600
                        w-full md:w-1/2 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-200 dark:focus:ring-primary-500 dark:focus:border-primary-500"
               placeholder="{{__("Type Email")}}">
        <!-- Add -->
        <div class="flex items-center">
            <button type="button" wire:click="add_external()"
                    class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50
                    focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-white
                    dark:hover:bg-neutral-700 dark:focus:bg-neutral-700">
                Add
                <svg class="shrink-0 size-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 21a9 9 0 1 1 0-18c1.052 0 2.062.18 3 .512M7 9.577l3.923 3.923 8.5-8.5M17 14v6m-3-3h6"/>
                </svg>

            </button>
        </div>
    </div>
    <!-- Input autocomplete type -->
    <div class="relative grow w-full mr-2 md:order-none">
        <div class="relative flex items-center">
            <div class="pointer-events-none absolute inset-y-0 left-0 pl-3 flex items-center">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                <svg class="shrink-0 size-4  text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                  <path stroke="currentColor"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2" d="M16 12h4m-2 2v-4M4 18v-1a3 3 0 0 1 3-3h4a3 3 0 0 1 3 3v1a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1Zm8-10a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                </svg>
            </span>
            </div>
            <input wire:model.live="query"
                   wire:keydown.escape="resetData"
                   wire:keydown.tab="resetData"
                   wire:keydown.arrow-up="decrementHighlight"
                   wire:keydown.arrow-down="incrementHighlight"
                   wire:keydown.enter="selectUser"
                   id="search"
                   class="w-full py-2 pl-10 pr-4 text-gray-900 bg-white border border-susecondary focus:outline-none focus:ring focus:ring-opacity-40 focus:ring-blue-500
                    sm:text-sm rounded-lg placeholder:text-gray-900 focus:border-blue-500 dark:bg-gray-900 dark:text-gray-200 dark:placeholder:text-gray-200"
                   placeholder="{{__("Type to add a SUKAT user")}}"
                   type="search">

            <div wire:loading class="animate-spin inline-block size-6 border-[3px] border-current border-t-transparent text-blue-600 rounded-full dark:text-gray-200"
                 role="status"
                 aria-label="loading">
                <span class="sr-only">Searching...</span>
            </div>
        </div>
        <!-- SUKAT dropdown -->
        @if(!empty($query))
            <div class="fixed top-0 bottom-0 left-0 right-0" wire:click="resetData"></div>
            <div class="origin-top-right absolute md:left-0 mt-2 z-20 w-72 w-full rounded-md shadow-lg bg-white dark:bg-gray-800 dark:text-white ring-1 ring-black ring-opacity-5 text-left">
                <div class="py-1 text-sm text-gray-700 dark:text-white text-left">
                    @if(!empty($sukatusers))
                        @foreach($sukatusers as $i => $users)
                            @if($users['edupersonaffiliation'] ?? null)
                                @if(is_array($users['edupersonaffiliation']))
                                    <a wire:click="selectUser({{$i}})" class="block py-2 hover:bg-gray-100 hover:text-gray-900 {{ $highlightIndex === $i ? 'dark:text-black bg-gray-100 dark:bg-gray-300' : 'dark:text-gray-200' }}
                                        dark:hover:bg-gray-300 dark:hover:text-black">
                                        <span class="px-4">{{ $users['cn'][0] }}</span>
                                        @if(in_array('employee', $users['edupersonaffiliation']))
                                            <div class="inline-block px-3 py-1 text-gray-900 font-normal bg-blue rounded-full text-xs">
                                            <span class="inline-flex items-center gap-x-1.5 py-0.5 px-3 rounded-full text-xs border border-gray-800 text-gray-800 dark:border-neutral-200 dark:text-white">
                                                STAFF
                                            </span>
                                            </div>
                                        @endif
                                        @if(in_array('alum', $users['edupersonaffiliation']))
                                            <div class="inline-block px-3 py-1 text-gray-900 font-normal bg-blue rounded-full text-xs">
                                            <span class="inline-flex items-center gap-x-1.5 py-0.5 px-3 rounded-full text-xs border border-gray-800 text-gray-800 dark:border-neutral-200 dark:text-white">
                                                ALUMN
                                            </span>
                                            </div>
                                        @endif
                                        @if(in_array('other', $users['edupersonaffiliation']))
                                            <div class="inline-block px-3 py-1 text-gray-900 font-normal bg-blue rounded-full text-xs">
                                            <span class="inline-flex items-center gap-x-1.5 py-0.5 px-3 rounded-full text-xs border border-gray-800 text-gray-800 dark:border-neutral-200 dark:text-white">
                                                OTHER
                                            </span>
                                            </div>
                                        @endif
                                        @if(is_array($users['ou'] ?? null))
                                            <div class="py-1 px-4 text-gray-900 font-bold bg-blue rounded-full text-xs">
                                            <span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-lg text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-800/30 dark:text-blue-500">
                                                {{$users['ou'][0]}}
                                            </span>
                                            </div>
                                        @endif
                                    </a>
                                @endif
                            @endif
                        @endforeach
                    @endif
                </div>
            </div>
        @endif
    </div>

    <!-- External button -->
    <div class="relative flex items-center mt-4">
        <button type="button"
                wire:click="addExternal"
                class="w-full py-2 pl-3 pr-10 text-gray-900 bg-white border border-susecondary focus:outline-none focus:ring focus:ring-opacity-40 focus:ring-blue-500
                sm:text-sm rounded-lg placeholder:text-gray-900 focus:border-blue-500 dark:bg-gray-900 dark:text-gray-200 dark:placeholder:text-gray-200 inline-flex items-center">
            <svg class="shrink-0 size-4 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2" d="M16 12h4m-2 2v-4M4 18v-1a3 3 0 0 1 3-3h4a3 3 0 0 1 3 3v1a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1Zm8-10a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
            </svg>
            <div class="ml-3 text-gray-900">
                Add external
            </div>

        </button>
    </div>
</div>
