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
                                  placeholder="{{__("Short description")}}" required>{{ old('objective') ? old('objective'): $proposal->objective ?? '' }}</textarea>
                        @error('objective')
                        <p class="mt-3 text-sm leading-6 text-red-600" x-init="$el.closest('form').scrollIntoView()">{{__("This is a required input")}}</p>
                        @enderror
                    </div>
                    <!-- Principal Investigator-->
                    <div class="w-full">
                        <label for="principal_investigator" class="font-sans block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __("Principal Investigator") }}<span class="text-red-600"> *</span>
                            <button id="principal_investigator-button" data-modal-toggle="principal_investigator-modal" class="inline" type="button">
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
                            <button id="principal_investigator_email-button" data-modal-toggle="principal_investigator_email-modal" class="inline" type="button">
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
                    <div>
                        <label for="research_area" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __("Research area") }}<span class="text-red-600"> *</span>
                            <button id="research_area-button" data-modal-toggle="research_area-modal" class="inline" type="button">
                                <svg class="w-[16px] h-[16px] inline text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M8 9h2v5m-2 0h4M9.408 5.5h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                </svg>
                            </button>
                        </label>
                        <select id="research_area" name="research_area"
                                class="font-mono bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-200 dark:focus:ring-primary-500 dark:focus:border-primary-500">
                            @foreach($research_areas as $research_area)
                                <option value="{{$research_area->id}}">{{$research_area->name}}</option>
                            @endforeach
                        </select>
                        @error('research_area')
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
                    <livewire:pp.dsv-coordination />

                    <livewire:pp.eu-wallenberg-project />

                    <!-- Funding organization -->
                    <livewire:select2.Org-select2 />

                    <!-- Program call -->
                    <div class="w-full sm:col-span-2">
                        <label for="program" class="font-sans block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __("Program/Call/Target (add link to the call if any)") }}
                            <button id="program-button" data-modal-toggle="program-modal" class="inline" type="button">
                                <svg class="w-[16px] h-[16px] inline text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M8 9h2v5m-2 0h4M9.408 5.5h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                </svg>
                            </button>
                        </label>
                        <input type="text" name="program" id="program"
                               class="font-mono bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600
                                        block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-200 dark:focus:ring-primary-500 dark:focus:border-primary-500"
                               value="{{ old('program') ? old('program'): $proposal->program ??  '' }}" placeholder="Link">
                    </div>
                    <!--Decision expected-->
                    <div class="flex flex-col w-full">
                        <label for="decision_exp" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-200">
                            {{ __("Decision expected") }}
                            <button id="decision_exp-button" data-modal-toggle="decision_exp-modal" class="inline" type="button">
                                <svg class="w-[16px] h-[16px] inline text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M8 9h2v5m-2 0h4M9.408 5.5h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                </svg>
                            </button>
                        </label>
                        <div class="flex flex-col sm:flex-row items-center w-full">
                            <div class="relative w-full">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-blue-700 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                                    </svg>
                                </div>
                                @error('decision_exp')
                                <p class="mt-3 text-sm leading-6 text-red-600">{{__("This is a required input")}}</p>
                                @enderror
                                <input datepicker datepicker-format="dd/mm/yyyy"
                                       name="decision_exp"
                                       @if($type == 'resume')
                                       value="{{ \Carbon\Carbon::createFromTimestamp($proposal->decision_exp)->format('d/m/Y') }}"
                                       @endif
                                       id="startInput" type="text"
                                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5
                                              dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:placeholder:text-gray-200 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                       placeholder="{{__("Select date")}}">
                            </div>
                        </div>
                    </div>
                    <!-- Start date -->
                    <div class="flex flex-col w-full">
                        <label for="start_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-200">
                            {{ __("Start date expected") }}<span class="text-red-600"> *</span>
                            <button id="start_date-button" data-modal-toggle="start_date-modal" class="inline" type="button">
                                <svg class="w-[16px] h-[16px] inline text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M8 9h2v5m-2 0h4M9.408 5.5h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                </svg>
                            </button>
                        </label>
                        <div class="flex flex-col sm:flex-row items-center w-full">
                            <div class="relative w-full">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-blue-700 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                                    </svg>
                                </div>
                                @error('start_date')
                                <p class="mt-3 text-sm leading-6 text-red-600">{{__("This is a required input")}}</p>
                                @enderror
                                <input datepicker datepicker-format="dd/mm/yyyy"
                                        name="start_date"
                                       @if($type == 'resume')
                                       value="{{ \Carbon\Carbon::createFromTimestamp($proposal->start_date)->format('d/m/Y') }}"
                                       @endif id="endInput" type="text"
                                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5
                                              dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:placeholder:text-gray-200 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                       placeholder="{{__("Select date")}}" required>
                            </div>
                        </div>
                    </div>
                    <!-- Submission deadline -->
                    <div class="flex flex-col w-full">
                        <label for="submission" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-200">
                            {{ __("Submission deadline") }}<span class="text-red-600"> *</span>
                            <button id="submission-button" data-modal-toggle="submission-modal" class="inline" type="button">
                                <svg class="w-[16px] h-[16px] inline text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M8 9h2v5m-2 0h4M9.408 5.5h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                </svg>
                            </button>
                        </label>
                        <div class="flex flex-col sm:flex-row items-center w-full">
                            <div class="relative w-full">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-blue-700 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                                    </svg>
                                </div>
                                @error('submission')
                                <p class="mt-3 text-sm leading-6 text-red-600">{{__("This is a required input")}}</p>
                                @enderror
                                <input datepicker datepicker-format="dd/mm/yyyy"
                                       name="submission"
                                       @if($type == 'resume')
                                       value="{{ \Carbon\Carbon::createFromTimestamp($proposal->submission)->format('d/m/Y') }}"
                                       @endif
                                       id="startInput" type="text"
                                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5
                                              dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:placeholder:text-gray-200 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                       placeholder="{{__("Select date")}}" required>
                            </div>
                        </div>
                    </div>
                    <!-- Project duration -->
                    <div class="w-full">
                        <label for="duration" class="font-sans block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __("Project duration") }}<span class="text-red-600"> *</span>
                            <button id="duration-button" data-modal-toggle="duration-modal" class="inline" type="button">
                                <svg class="w-[16px] h-[16px] inline text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M8 9h2v5m-2 0h4M9.408 5.5h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                </svg>
                            </button>
                        </label>
                        <input type="text" name="duration" id="duration"
                               class="font-mono bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600
                                        block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-200 dark:focus:ring-primary-500 dark:focus:border-primary-500"
                               value="{{ old('duration') ? old('duration'): $proposal->duration ??  '' }}" placeholder="Duration" required>
                    </div>
                    <!-- Budget for complete project -->
                    <div class="w-full">
                        <label for="budget_project" class="font-sans block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __("Budget for complete project") }}<span class="text-red-600"> *</span>
                            <button id="budget_project-button" data-modal-toggle="budget_project-modal" class="inline" type="button">
                                <svg class="w-[16px] h-[16px] inline text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M8 9h2v5m-2 0h4M9.408 5.5h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                </svg>
                            </button>
                        </label>
                        <input type="number" name="budget_project" id="budget_project"
                               class="font-mono bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600
                                        block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-200 dark:focus:ring-primary-500 dark:focus:border-primary-500"
                               value="{{ old('budget_project') ? old('budget_project'): $proposal->budget_project ??  '' }}" placeholder="Project budget" required>
                    </div>
                    <!-- Budget for DSV -->
                    <div class="w-full">
                        <label for="budget_dsv" class="font-sans block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __("Budget for DSV") }}<span class="text-red-600"> *</span>
                            <button id="budget_dsv-button" data-modal-toggle="budget_dsv-modal" class="inline" type="button">
                                <svg class="w-[16px] h-[16px] inline text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M8 9h2v5m-2 0h4M9.408 5.5h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                </svg>
                            </button>
                        </label>
                        <input type="number" name="budget_dsv" id="budget_dsv"
                               class="font-mono bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600
                                        block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-200 dark:focus:ring-primary-500 dark:focus:border-primary-500"
                               value="{{ old('budget_dsv') ? old('budget_dsv'): $proposal->budget_dsv ??  '' }}" placeholder="DSV budget" required>
                    </div>
                    <!-- Currency -->
                    <div class="w-full sm:col-span-2">
                        <label for="currency"
                               class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __("Currency") }}<span class="text-red-600"> *</span>
                            <button id="currency-button" data-modal-toggle="currency-modal" class="inline" type="button">
                                <svg class="w-[16px] h-[16px] inline text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M8 9h2v5m-2 0h4M9.408 5.5h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                </svg>
                            </button>
                        </label>
                        <div class="grid grid-cols-3 gap-2">
                            <label for="currency" class="flex p-2 w-full bg-white border border-gray-300 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
                                <input type="radio" name="currency" value="sek"
                                       class="shrink-0 mt-0.5 border-gray-200 rounded text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800"
                                       id="currency" checked="" required>
                                <span class="text-sm text-gray-500 ms-3 dark:text-neutral-400">SEK</span>
                            </label>

                            <label for="hs-checkbox-checked-in-form" class="flex p-2 w-full bg-white border border-gray-300 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
                                <input type="radio" name="currency" value="us"
                                       class="shrink-0 mt-0.5 border-gray-200 rounded text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800"
                                       id="currency" required>
                                <span class="text-sm text-gray-500 ms-3 dark:text-neutral-400">$</span>
                            </label>

                            <label for="hs-checkbox-checked-in-form" class="flex p-2 w-full bg-white border border-gray-300 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
                                <input type="radio" name="currency" value="euro"
                                       class="shrink-0 mt-0.5 border-gray-200 rounded text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800"
                                       id="currency" required>
                                <span class="text-sm text-gray-500 ms-3 dark:text-neutral-400">€</span>
                            </label>
                        </div>
                    </div>
                    <!-- Co-financing -->
                    <livewire:pp.cofinancing />
                    <!-- Percent OH-costs -->
                    <div class="w-full">
                        <label for="oh_cost" class="font-sans block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            {{ __("Percent OH cost covered") }}
                            <span class="text-red-600"> *</span>
                            <button id="oh_cost-button" data-modal-toggle="oh_cost-modal" class="inline" type="button">
                                <svg class="w-[16px] h-[16px] inline text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M8 9h2v5m-2 0h4M9.408 5.5h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                </svg>
                            </button>
                        </label>
                        <div class="flex items-center">
                            <input type="number" name="oh_cost" id="oh_cost"
                                   class="font-mono bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600
                                            block w-[calc(100%-32px)] p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-200 dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                   value="{{ old('oh_cost') ? old('boh_cost'): $proposal->oh_cost ??  '' }}" placeholder="OH cost" required>
                            <span class="inline-block ml-2 text-gray-900 dark:text-gray-200">%</span>
                        </div>
                    </div>
                    <!-- Initial comments -->
                    <div class="sm:col-span-2">
                        <label for="user_comments" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __("Comments") }}
                            <button id="user_comments-button" data-modal-toggle="user_comments-modal" class="inline" type="button">
                                <svg class="w-[16px] h-[16px] inline text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M8 9h2v5m-2 0h4M9.408 5.5h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                </svg>
                            </button>
                        </label>
                        <textarea id="user_comments" rows="4" name="user_comments"
                                  class="font-mono block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300
                                  focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:placeholder:text-gray-200 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                  placeholder="{{__("Your comments")}}">{{ old('user_comments') ? old('user_comments'): $proposal->user_comments ?? '' }}</textarea>
                    </div>



                </div> <!-- end form -->

                <!-- Submit buttons -->
                <div class="flex flex-col sm:flex-row gap-3">
                    <a type="button" href="{{ url()->previous() }}"
                            class="py-2.5 px-3 w-full inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm
                            hover:bg-gray-50 focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none
                            dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-300
                            dark:hover:bg-neutral-800 dark:focus:bg-neutral-800">
                        {{__("Cancel")}}
                    </a>

                    <div class="border-t sm:border-t-0 sm:border-s border-gray-200 dark:border-neutral-700"></div>

                    <button type="submit"
                            class="py-2.5 px-3 w-full inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-lg border border-blue-700 bg-white hover:bg-blue-800
                            text-blue-700 hover:text-white shadow-sm focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none
                            dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-300
                            dark:hover:bg-neutral-800 dark:focus:bg-neutral-800">
                        {{__("Submit proposal")}}
                    </button>
                </div>



            </form>
        </div>
    </section>

    <!-- Modals -->
    @include('pp.modals.pp_help')

    @if($type == 'resume')
        <script>

        </script>
    @endif


    @include('layouts.darktoggler')
@endsection
