@extends('layouts.app')
@section('content')
    @include('dsvheader')

    <section class="bg-white dark:bg-gray-900">
        <div class="max-w-2xl px-4 py-8 mx-auto lg:py-16">
            <h2 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">{{ __("Create a Project proposal") }}</h2>
            <form method="post" action="{{route('pp-submit')}}">
                @csrf
                @if($type == 'resume')
                    <input type="hidden" name="id" value="{{$tr->id}}">
                @endif

                <div class="grid gap-4 mb-4 sm:grid-cols-2 sm:gap-6 sm:mb-5">

                    <!--Title-->
                    <div class="w-full sm:col-span-2">
                        <label for="title" class="font-sans block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __("Title") }}<span class="text-red-600"> *</span>
                            <button id="title-button" data-modal-toggle="title-modal" class="inline" type="button">
                                <svg class="w-[16px] h-[16px] inline text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M8 9h2v5m-2 0h4M9.408 5.5h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                </svg>
                            </button>
                        </label>
                        <input type="text" name="title" id="project"
                               class="font-mono bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600
                                        block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-200 dark:focus:ring-primary-500 dark:focus:border-primary-500"
                               value="{{ old('title') ? old('title'): $proposal->title ??  '' }}" placeholder="Title" required="">
                        @error('name')
                        <p class="mt-3 text-sm leading-6 text-red-600" x-init="$el.closest('form').scrollIntoView()">{{__("This is a required input")}} </p>
                        @enderror
                    </div>
                    <!-- Objective description-->
                    <div class="sm:col-span-2">
                        <label for="objective" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __("Write a short summary of the goals of the research") }}<span class="text-red-600"> *</span>
                            <button id="objective-button" data-modal-toggle="objective-modal" class="inline" type="button">
                                <svg class="w-[16px] h-[16px] inline text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M8 9h2v5m-2 0h4M9.408 5.5h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                </svg>
                            </button>
                        </label>
                        <textarea id="objective" rows="4" name="objective"
                                  class="@error('objective') border-red-500 @enderror font-mono block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300
                                  focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:placeholder:text-gray-200 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                  placeholder="{{__("Short description")}}">{{ old('objective') ? old('objective'): $proposal->objective ?? '' }}</textarea>
                        @error('objective')
                        <p class="mt-3 text-sm leading-6 text-red-600" x-init="$el.closest('form').scrollIntoView()">{{__("This is a required input")}}</p>
                        @enderror
                    </div>
                    <!-- Principal Investigator-->
                    <div class="w-full">
                        <label for="principal_investigator" class="font-sans block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __("Principal Investigator") }}<span class="text-red-600"> *</span>
                            <button id="title-button" data-modal-toggle="title-modal" class="inline" type="button">
                                <svg class="w-[16px] h-[16px] inline text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M8 9h2v5m-2 0h4M9.408 5.5h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                </svg>
                            </button>
                        </label>
                        <input type="text" name="principal_investigator" id="principal_investigator" readonly
                               class="font-mono bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600
                                        block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-200 dark:focus:ring-primary-500 dark:focus:border-primary-500"
                               value="{{ old('principal_investigator') ? old('principal_investigator'): $proposal->principal_investigator ??  auth()->user()->name  }}" placeholder="Title" required="">
                    </div>
                    <div class="w-full">
                        <label for="principal_investigator_email" class="font-sans block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __("Email") }}<span class="text-red-600"> *</span>
                            <button id="title-button" data-modal-toggle="title-modal" class="inline" type="button">
                                <svg class="w-[16px] h-[16px] inline text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M8 9h2v5m-2 0h4M9.408 5.5h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                </svg>
                            </button>
                        </label>
                        <input type="text" name="principal_investigator_email" id="principal_investigator_email" readonly
                               class="font-mono bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600
                                        block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-200 dark:focus:ring-primary-500 dark:focus:border-primary-500"
                               value="{{ old('principal_investigator_email') ? old('principal_investigator_email'): $proposal->principal_investigator_email ??  auth()->user()->email  }}" placeholder="Title" required="">
                    </div>
                    <!-- Co Investigators -->

                    <livewire:select2.Coinvestigators-select2 />

                    <!--Research area-->
                    <div class="w-full sm:col-span-2">
                        <label for="area" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __("Research area") }}<span class="text-red-600"> *</span>
                            <button id="area-button" data-modal-toggle="area-modal" class="inline" type="button">
                                <svg class="w-[16px] h-[16px] inline text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M8 9h2v5m-2 0h4M9.408 5.5h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                </svg>
                            </button>
                        </label>
                        <select id="area" name="area"
                                class="font-mono bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-200 dark:focus:ring-primary-500 dark:focus:border-primary-500">
                            <option value="Business">Business</option>
                            <option value="Cyber">Cyber</option>
                        </select>
                        @error('area')
                        <p class="mt-3 text-sm leading-6 text-red-600">{{__("This is a required input")}}</p>
                        @enderror
                    </div>
                    <!--Unithead-->
                    <div>
                        <label for="unit_head" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __("Unit Head to approve by") }}<span class="text-red-600"> *</span>
                            <button id="unithead-button" data-modal-toggle="unithead-modal" class="inline" type="button">
                                <svg class="w-[16px] h-[16px] inline text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M8 9h2v5m-2 0h4M9.408 5.5h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                </svg>
                            </button>
                        </label>
                        <select id="unit_head" name="unit_head"
                                class="font-mono bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-200 dark:focus:ring-primary-500 dark:focus:border-primary-500">
                            @foreach($unitheads as $unithead)
                                @if($type == 'resume')
                                    <option @if($unithead->id == $dashboard->head_id) selected="" @endif value="{{$unithead->id}}">{{$unithead->name}}</option>
                                @else
                                    <option value="{{$unithead->id}}">{{$unithead->name}}</option>
                                @endif
                            @endforeach
                        </select>
                        @error('unit_head')
                        <p class="mt-3 text-sm leading-6 text-red-600">{{__("This is a required input")}}</p>
                        @enderror
                    </div>
                    <!--DSV coordinating -->
                    <div class="w-full">
                        <label for="dsvcoordinationg"
                               class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __("Is DSV coordinating") }}
                            <button id="paper-button" data-modal-toggle="paper-modal" class="inline" type="button">
                                <svg class="w-[16px] h-[16px] inline text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M8 9h2v5m-2 0h4M9.408 5.5h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                </svg>
                            </button>
                        </label>
                        <div class="grid sm:grid-cols-2 gap-2">
                            <label for="dsvcoordinating" class="flex p-2 w-full bg-white border border-gray-300 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
                                <input type="radio" name="dsvcoordinating"
                                       class="shrink-0 mt-0.5 border-gray-200 rounded text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800"
                                       id="hs-checkbox-in-form" checked="">
                                <span class="text-sm text-gray-500 ms-3 dark:text-neutral-400">Yes</span>
                            </label>

                            <label for="hs-checkbox-checked-in-form" class="flex p-2 w-full bg-white border border-gray-300 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
                                <input type="radio" name="dsvcoordinating"
                                       class="shrink-0 mt-0.5 border-gray-200 rounded text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800"
                                       id="hs-checkbox-checked-in-form">
                                <span class="text-sm text-gray-500 ms-3 dark:text-neutral-400">No</span>
                            </label>
                        </div>
                    </div>
                    <livewire:pp.eu-wallenberg-project />


                            <!--Departure return-->
                            <div date-rangepicker datepicker-format="dd/mm/yyyy" class="flex flex-col sm:flex-row sm:col-span-2 items-center dark:text-gray-200">
                                <div class="flex flex-col w-full sm:w-1/2">
                                    <label for="departure" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-200">{{ __("From") }}
                                    </label>
                                    <div class="flex flex-col sm:flex-row items-center w-full sm:w-auto">

                                        <div class="relative w-full sm:w-auto">
                                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                                <svg class="w-4 h-4 text-blue-700 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                                                </svg>
                                            </div>
                                            @error('departure')
                                            <p class="mt-3 text-sm leading-6 text-red-600">{{__("This is a required input")}}</p>
                                            @enderror
                                            <input name="departure"
                                                   @if($type == 'resume')
                                                   value="{{ \Carbon\Carbon::createFromTimestamp($tr->departure)->format('d/m/Y') }}"
                                                   @endif
                                                   id="startInput" type="text"
                                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5
                                        dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:placeholder:text-gray-200 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                   placeholder="{{__("Select date start")}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="flex flex-col w-full sm:w-1/2 sm:mt-0 mt-4">
                                    <label for="return" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-200">{{ __("To") }}
                                    </label>
                                    <div class="flex flex-col sm:flex-row items-center w-full sm:w-auto sm:mt-0">

                                        <div class="relative w-full sm:w-auto">
                                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                                <svg class="w-4 h-4 text-blue-700 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                                                </svg>
                                            </div>
                                            @error('return')
                                            <p class="mt-3 text-sm leading-6 text-red-600">{{__("This is a required input")}}</p>
                                            @enderror
                                            <input name="return"
                                                   @if($type == 'resume')
                                                   value="{{ \Carbon\Carbon::createFromTimestamp($tr->return)->format('d/m/Y') }}"
                                                   @endif id="endInput" type="text"
                                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5
                                        dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:placeholder:text-gray-200 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                   placeholder="{{__("Select date end")}}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                </div>
                <div class="mt-6 flex items-center justify-end gap-x-6">
                    <a type="button" href="{{ url()->previous() }}" class="text-sm bg-transparent hover:bg-blue-500 text-blue-700 dark:text-gray-200 font-semibold hover:text-white py-2 px-4 border border-blue-500 dark:border-gray-200 hover:border-transparent rounded">{{__("Cancel")}}</a>
                    <div class="py-3 px-6 border border-blue-500 rounded dark:border-gray-200">
                        <button type="submit" class="text-sm bg-transparent hover:bg-blue-500 text-blue-700 dark:text-gray-200 font-semibold hover:text-white py-2 px-4 border border-blue-500 dark:border-gray-200 hover:border-transparent rounded">{{__("Send in request")}}</button>
                    </div>
                </div>

            </form>
        </div>
    </section>

    <!-- Modals -->
    @include('requests.travel.modals.travel_help')
    @if($type == 'resume')
        <script>

        </script>
    @endif


    @include('layouts.darktoggler')
@endsection
