@extends('layouts.app')
@include('dsvheader')
@include('navbar.navbar')
<section class="bg-white dark:bg-gray-900">
    <div class="max-w-2xl px-4 py-8 mx-auto lg:py-16">
        {{--}}
        <div class="relative w-fit-content">
            <div class="absolute top-0 right-0 w-32">
                <span class="bg-blue-100 text-blue-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-blue-400 border border-blue-400">DSVTR-231025-1</span>
            </div>
        </div>
        {{--}}
        <h2 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">{{ __("Duty Travel Request") }}</h2>
        <form method="post" action="{{route('travel-submit')}}">
            @csrf
            <div class="grid gap-4 mb-4 sm:grid-cols-2 sm:gap-6 sm:mb-5">
                <!--Name-->
                <div class="w-full">
                    <label for="name" class="font-sans block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __("You may change this name") }}<span class="text-red-600"> *</span>
                        <button id="name-button" data-modal-toggle="name-modal" class="inline" type="button">
                            <svg class="w-[16px] h-[16px] inline text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M8 9h2v5m-2 0h4M9.408 5.5h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                            </svg>
                        </button>
                    </label>
                    <input type="text" name="name" id="project" class="font-mono bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                           value="{{ old('name') ? old('name'): $name ??  'Travelrequest for '. auth()->user()->name  }}" placeholder="Name" required="">
                    @error('name')
                    <p class="mt-3 text-sm leading-6 text-red-600" x-init="$el.closest('form').scrollIntoView()">{{__("This is a required input")}} </p>
                    @enderror
                </div>

                <!-- Purpose-->
                <div class="sm:col-span-2">
                    <label for="purpose" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __("Purpose of the mission with the web address of the conference") }}
                        <button id="purpose-button" data-modal-toggle="purpose-modal" class="inline" type="button">
                            <svg class="w-[16px] h-[16px] inline text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M8 9h2v5m-2 0h4M9.408 5.5h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                            </svg>
                        </button>
                    </label>
                    <textarea id="purpose" rows="4" name="purpose"
                              class="@error('purpose') border-red-500 @enderror font-mono block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300
                              focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                              placeholder="{{__("Describe the purpose of your mission")}}">{{ old('purpose') ? old('purpose'): $purpose ?? '' }}</textarea>
                    @error('purpose')
                        <p class="mt-3 text-sm leading-6 text-red-600" x-init="$el.closest('form').scrollIntoView()">{{__("This is a required input")}}</p>
                    @enderror
                </div>

                <!--Paper accepted -->
                <div class="w-full">
                    <label for="paper" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __("Paper accepted") }}
                        <button id="paper-button" data-modal-toggle="paper-modal" class="inline" type="button">
                            <svg class="w-[16px] h-[16px] inline text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M8 9h2v5m-2 0h4M9.408 5.5h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                            </svg>
                        </button>
                    </label>
                    <select id="paper" name="paper"
                            class="font-mono bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                        <option selected="" value="0">{{__("No")}}</option>
                        <option value="1">{{__("Yes")}}</option>
                    </select>
                </div>
                <br>
                <!-- Project -->
                <livewire:select2.project-select2 />

                <!--Country-->
                <livewire:select2.country-select2 />
                <!--end -->

                <!-- Projectleader -->
                <div>
                    <label for="project_leader" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __("Project leader") }}<span class="text-red-600"> *</span>
                        <button id="projectleader-button" data-modal-toggle="projectleader-modal" class="inline" type="button">
                            <svg class="w-[16px] h-[16px] inline text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M8 9h2v5m-2 0h4M9.408 5.5h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                            </svg>
                        </button>
                    </label>
                    <select id="project_leader" name="project_leader"
                            class="font-mono bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                        @foreach($projectleaders as $projectleader)
                            <option value="{{$projectleader->id}}">{{$projectleader->name}}</option>
                        @endforeach
                    </select>
                </div>
                <!--Unithead-->
                <div>
                    <label for="unit_head" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __("Unit Head") }}<span class="text-red-600"> *</span>
                        <button id="unithead-button" data-modal-toggle="unithead-modal" class="inline" type="button">
                            <svg class="w-[16px] h-[16px] inline text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M8 9h2v5m-2 0h4M9.408 5.5h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                            </svg>
                        </button>
                    </label>
                    <select id="unit_head" name="unit_head"
                            class="font-mono bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                        @foreach($unitheads as $unithead)
                            <option value="{{$unithead->id}}">{{$unithead->name}}</option>
                        @endforeach
                    </select>
                    @error('unit_head')
                    <p class="mt-3 text-sm leading-6 text-red-600">{{__("This is a required input")}}</p>
                    @enderror
                </div>
                {{--}}
                <!--Contribution -->
                <div class="w-full">
                    <label for="brand" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __("I have requested contribution from") }}
                        <button id="contribution-button" data-modal-toggle="contribution-modal" class="inline" type="button">
                            <svg class="w-[16px] h-[16px] inline text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M8 9h2v5m-2 0h4M9.408 5.5h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                            </svg>
                        </button>
                    </label>
                    <input type="text" id="contribution" name="contribution"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block
                                w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                           value="{{ old('contribution') ? old('contribution'): $contribution ?? '' }}"
                           placeholder="{{ __("Contribution") }}">
                </div>

                <!--Other reason-->
                <div class="sm:col-span-2">
                    <label for="purpose" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __("Other reason. Justify") }}
                        <button id="other-button" data-modal-toggle="other-modal" class="inline" type="button">
                            <svg class="w-[16px] h-[16px] inline text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M8 9h2v5m-2 0h4M9.408 5.5h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                            </svg>
                        </button>
                    </label>
                    <textarea id="reason" rows="2"  name="reason"
                              class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500
                                    dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                              placeholder="Justify other reason">{{ old('reason') ? old('reason'): $reason ?? '' }}</textarea>
                </div>
                {{--}}
                <!--Departure return-->
                <div date-rangepicker datepicker-format="dd/mm/yyyy" class="sm:col-span-2 inline-flex items-center">
                    <span class="mx-4 text-gray-500">{{__("From")}}</span>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg style="fill:blue" class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                            </svg>
                        </div>
                        @error('start')
                        <p class="mt-3 text-sm leading-6 text-red-600">{{__("This is a required input")}}</p>
                        @enderror
                        <input name="start" id="startInput" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Select date start">
                    </div>

                    <span class="mx-4 text-gray-500">{{__("To")}}</span>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg style="fill:blue" class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                            </svg>
                        </div>
                        @error('end')
                        <p class="mt-3 text-sm leading-6 text-red-600">{{__("This is a required input")}}</p>
                        @enderror
                        <input name="end" id="endInput" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Select date end">
                    </div>
                </div>


                <!--Expenses-->
                <label for="expenses" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __("Expenses") }}</label>
                <livewire:travel-request-expenses />
                <!--end -->

            </div>
            <div class="mt-6 flex items-center justify-end gap-x-6">
                <a type="button" href="{{ url()->previous() }}" class="text-sm bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded">{{__("Cancel")}}</a>
                <div class="py-3 px-6 border border-blue-500 rounded">
                    <button type="submit" class="text-sm bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded">{{__("Send in request")}}</button>
                </div>

            </div>
        </form>
    </div>
</section>

<!-- Modals -->
@include('requests.travel.modals.travel_help')
<script>
    document.getElementById("startInput").addEventListener("changeDate", function (e){
        Livewire.emit('changeStartDate', e.detail.datepicker.inputField.value)
    });
    document.getElementById("endInput").addEventListener("changeDate", function (e){
        Livewire.emit('changeEndDate', e.detail.datepicker.inputField.value)
    });
    document.addEventListener("DOMContentLoaded", function(event) {
        document.getElementById('name-button').click();
    });
    document.addEventListener("DOMContentLoaded", function(event) {
        document.getElementById('purpose-button').click();
    });
    document.addEventListener("DOMContentLoaded", function(event) {
        document.getElementById('project-button').click();
    });
    document.addEventListener("DOMContentLoaded", function(event) {
        document.getElementById('country-button').click();
    });
    document.addEventListener("DOMContentLoaded", function(event) {
        document.getElementById('projectleader-button').click();
    });
    document.addEventListener("DOMContentLoaded", function(event) {
        document.getElementById('unithead-button').click();
    });
    document.addEventListener("DOMContentLoaded", function(event) {
        document.getElementById('paper-button').click();
    });
    document.addEventListener("DOMContentLoaded", function(event) {
        document.getElementById('contribution-button').click();
    });
    document.addEventListener("DOMContentLoaded", function(event) {
        document.getElementById('other-button').click();
    });
</script>
@include('layouts.darktoggler')
