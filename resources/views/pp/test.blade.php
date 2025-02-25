@extends('layouts.app')
@section('content')
    @nocache('dsvheader')
    @include('pp.partials.header')
    <section class="bg-white dark:bg-gray-900">
        <div class="max-w-4xl px-4 py-8 mx-auto lg:py-16">
            <div class="flex">
                <!-- Left Column: Form Stepper -->
                <div class="w-1/3 pr-4">
                    <!-- Your stepper content here -->
                    @include('pp.partials.stepper_test')
                </div>
                <div class="w-2/3 pl-4">
                    <h2 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">
                        @if($type == 'review')
                            {{ __("Review:") }} {{$proposal['name']}}
                        @elseif($type == 'view')
                            {{ __("View:") }} {{$proposal['name']}}
                        @elseif($type == 'edit')
                            {{ __("Edit:") }} {{$proposal['name']}}
                        @else
                            {{ __("New Project proposal") }}
                        @endif
                    </h2>
                    <form method="post" action="{{route('pp-submit')}}">
                        @csrf

                        @if($type == 'edit' or $type == 'resume')
                            <input type="hidden" name="id" value="{{$proposal->id}}">
                        @endif

                        <input type="hidden" name="type" value="{{$type}}">

                        <div class="grid gap-4 mb-4 sm:grid-cols-2 sm:gap-6 sm:mb-5">
                        {{--}}
                        <div class="w-full sm:col-span-2 py-3 flex items-center text-xs text-blue-500 uppercase
                                    before:flex-1 before:border-t before:border-gray-200 before:me-6 after:flex-1 after:border-t after:border-gray-200 after:ms-6
                                    dark:text-blue-400 dark:before:border-neutral-600 dark:after:border-neutral-600">
                            Project Proposal Outline
                        </div>
                        {{--}}
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
                                       value="{{ old('title') ? old('title'): $proposal['pp']['title'] ??  '' }}" placeholder="Title" @if($type == 'create' or $type == 'edit' or $type == 'resume') required=""  @else readonly @endif>
                                @error('name')
                                <p class="mt-3 text-sm leading-6 text-red-600" x-init="$el.closest('form').scrollIntoView()">{{__("This is a required input")}} </p>
                                @enderror
                            </div>
                            <!-- Objective description-->
                            <div class="sm:col-span-2">
                                <label for="objective" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __("Outline of the Proposal. Write a short summary of the goals of the research") }}<span class="text-red-600"> *</span>
                                    <button id="objective-button" data-modal-toggle="objective-modal" class="inline" type="button">
                                        <svg class="w-[16px] h-[16px] inline text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M8 9h2v5m-2 0h4M9.408 5.5h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                        </svg>
                                    </button>
                                </label>
                                <textarea id="objective" rows="4" name="objective"
                                          class="@error('objective') border-red-500 @enderror font-mono block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300
                                  focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:placeholder:text-gray-200 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                          placeholder="{{__("Short description")}}" @if($type == 'create' or $type == 'edit' or $type == 'resume') required="" @else readonly @endif>{{ old('objective') ? old('objective'): $proposal['pp']['objective'] ?? '' }}</textarea>
                                @error('objective')
                                <p class="mt-3 text-sm leading-6 text-red-600" x-init="$el.closest('form').scrollIntoView()">{{__("This is a required input")}}</p>
                                @enderror
                            </div>
                            <div class="w-full sm:col-span-2 py-3 flex items-center text-xs text-blue-500 uppercase
                                before:flex-1 before:border-t before:border-gray-200 before:me-6 after:flex-1 after:border-t after:border-gray-200 after:ms-6
                                dark:text-blue-400 dark:before:border-neutral-600 dark:after:border-neutral-600">
                                Research collaborators
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
                                       value="{{ old('principal_investigator') ? old('principal_investigator'): $proposal['pp']['principal_investigator'] ??  auth()->user()->name  }}" placeholder="Title" required="">
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
                                       value="{{ old('principal_investigator_email') ? old('principal_investigator_email'): $proposal['pp']['principal_investigator_email'] ??  auth()->user()->email  }}" placeholder="Title" required="">
                            </div>
                            <!-- Co Investigators -->
                            @if($type == 'create')
                                <livewire:select2.Coinvestigators-select2 proposal=""/>
                            @elseif( $type == 'edit' or $type == 'resume')
                                <livewire:select2.Coinvestigators-select2 :proposal="$proposal" />
                            @else
                                @include('pp.partials.review.co_investigators')
                            @endif

                            <div class="w-full sm:col-span-2 py-3 flex items-center text-xs text-blue-500 uppercase
                                before:flex-1 before:border-t before:border-gray-200 before:me-6 after:flex-1 after:border-t after:border-gray-200 after:ms-6
                                dark:text-blue-400 dark:before:border-neutral-600 dark:after:border-neutral-600">
                                Research area
                            </div>
                            <!--Research area-->
                            <div>
                                <label for="research_area" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __("Research area") }}<span class="text-red-600"> *</span>
                                    <button id="research_area-button" data-modal-toggle="research_area-modal" class="inline" type="button">
                                        <svg class="w-[16px] h-[16px] inline text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M8 9h2v5m-2 0h4M9.408 5.5h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                        </svg>
                                    </button>
                                </label>
                                @if($type == 'create' or $type == 'edit' or $type == 'resume')
                                    <select id="research_area" name="research_area"
                                            class="font-mono bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-200 dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                        @foreach($research_areas as $research_area)
                                            @if($type == 'edit' or $type == 'resume')
                                                <option value="{{$research_area->name}}" @if($proposal->pp['research_area'] == $research_area->name) selected="" @endif >{{$research_area->name}}</option>
                                            @else
                                                <option value="{{$research_area->name}}">{{$research_area->name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    @error('research_area')
                                    <p class="mt-3 text-sm leading-6 text-red-600">{{__("This is a required input")}}</p>
                                    @enderror
                                @else
                                    @include('pp.partials.review.research_area')
                                @endif
                            </div>

                            <!--Unithead-->

                            <div>
                                <label for="unit_head" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    {{ __("Unit Head to approve by") }}<span class="text-red-600"> *</span>
                                    <button id="unithead-button" data-modal-toggle="unithead-modal" type="button" class="inline">
                                        <svg class="w-[16px] h-[16px] inline text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6"
                                                  d="M8 9h2v5m-2 0h4M9.408 5.5h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                        </svg>
                                    </button>
                                </label>

                                @if(in_array($type, ['create', 'edit', 'resume']))
                                    <div id="unithead-container">
                                    @php
                                        $selectedUnitHeads = $type == 'create' ? [] : ($proposal['pp']['unit_head'] ?? []);
                                    @endphp

                                    @if(count($selectedUnitHeads) > 1)
                                        <!-- Multiple Unit Heads -->
                                            @foreach($selectedUnitHeads as $selectedUnitHead)
                                                <select name="unit_head[]" class="mb-2 font-mono bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-200 dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                                    @foreach($unitheads as $unithead)
                                                        <option value="{{ $unithead->id }}" {{ $unithead->id == $selectedUnitHead ? 'selected' : '' }}>
                                                            {{ $unithead->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            @endforeach
                                        @else
                                        <!-- Single Unit Head -->
                                            <select id="unit_head" name="unit_head[]" class="font-mono bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-200 dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                                @foreach($unitheads as $unithead)
                                                    <option value="{{ $unithead->id }}" {{ $unithead->id == ($dashboard->head_id ?? null) ? 'selected' : '' }}>
                                                        {{ $unithead->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        @endif

                                        @error('unit_head')
                                        <p class="mt-3 text-sm leading-6 text-red-600">{{ __("This is a required input") }}</p>
                                        @enderror
                                    </div>
                                @else
                                    @include('pp.partials.review.unithead')
                                @endif
                            </div>

                            <!-- Add Unit Head-->
                            <div>
                                <label for="unit_head" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    {{ __("Add a Unit Head to approve by") }}
                                    <button id="add-unithead-button"
                                            class="inline py-1 px-2 inline-flex items-center gap-x-1 text-xs font-medium rounded-lg border border-blue-600 text-blue-600 hover:border-blue-500 hover:text-blue-500 focus:outline-none focus:border-blue-500 focus:text-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:border-blue-500 dark:text-blue-500 dark:hover:text-blue-400 dark:hover:border-blue-400"
                                            type="button">
                                        Add+
                                    </button>
                                </label>
                            </div>

                            <!-- Project Oraganization-->
                            <div class="w-full sm:col-span-2 py-3 flex items-center text-xs text-blue-500 uppercase
                                before:flex-1 before:border-t before:border-gray-200 before:me-6 after:flex-1 after:border-t after:border-gray-200 after:ms-6
                                dark:text-blue-400 dark:before:border-neutral-600 dark:after:border-neutral-600">
                                Project organization
                            </div>
                            <!--DSV coordinating -->
                            @if($type == 'create')
                                <livewire:pp.dsv-coordination proposal="" />
                            @elseif ($type == 'edit' or $type == 'resume')
                                <livewire:pp.dsv-coordination :proposal="$proposal" />
                            @else
                                @include('pp.partials.review.dsvcoordination')
                            @endif

                        <!-- Eu Wallengenberg project -->
                            @if($type == 'create')
                                <livewire:pp.eu-wallenberg-project proposal="" />
                            @elseif ($type == 'edit' or $type == 'resume')
                                <livewire:pp.eu-wallenberg-project :proposal="$proposal" />
                            @else
                                @include('pp.partials.review.eu_wallenberg')
                            @endif

                        <!-- Funding organization -->
                            @if($type == 'create')
                                <livewire:select2.Org-select2 proposal="" />
                            @elseif ($type == 'edit' or $type == 'resume')
                                <livewire:select2.Org-select2 :proposal="$proposal" />
                            @else
                                @include('pp.partials.review.funding_org')
                            @endif

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
                                       value="{{ old('program') ? old('program'): $proposal->pp['program'] ??  '' }}" placeholder="Link" @if($type == 'review' or $type == 'view') readonly @endif>
                            </div>

                            <div class="w-full sm:col-span-2 py-3 flex items-center text-xs text-blue-500 uppercase
                                before:flex-1 before:border-t before:border-gray-200 before:me-6 after:flex-1 after:border-t after:border-gray-200 after:ms-6
                                dark:text-blue-400 dark:before:border-neutral-600 dark:after:border-neutral-600">
                                Project budget
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
                                       value="{{ old('budget_project') ? old('budget_project'): $proposal->pp['budget_project'] ??  '' }}"
                                       placeholder="Project budget" @if($type == 'create' or $type == 'edit' or $type == 'resume') required @else readonly @endif>
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
                                       value="{{ old('budget_dsv') ? old('budget_dsv'): $proposal->pp['budget_dsv'] ??  '' }}"
                                       placeholder="DSV budget" @if($type == 'create' or $type == 'edit' or $type == 'resume') required @else readonly @endif>
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
                                               id="currency"
                                               @if($type == 'create' or $type == 'edit' or $type == 'resume')
                                               checked="" required
                                               @else
                                               disabled
                                               @endif
                                               @if($type == 'review' or $type == 'view')
                                               @if($proposal['pp']['currency'] == 'sek') checked="" @endif
                                            @endif >
                                        <span class="text-sm text-gray-500 ms-3 dark:text-neutral-400">SEK</span>
                                    </label>

                                    <label for="hs-checkbox-checked-in-form" class="flex p-2 w-full bg-white border border-gray-300 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
                                        <input type="radio" name="currency" value="us"
                                               class="shrink-0 mt-0.5 border-gray-200 rounded text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800"
                                               id="currency"
                                               @if($type == 'create' or $type == 'edit' or $type == 'resume')
                                               required @else disabled @endif
                                               @if($type == 'review' or $type == 'view')
                                               @if($proposal['pp']['currency'] == 'us') checked="" @endif
                                            @endif >
                                        <span class="text-sm text-gray-500 ms-3 dark:text-neutral-400">$</span>
                                    </label>

                                    <label for="hs-checkbox-checked-in-form" class="flex p-2 w-full bg-white border border-gray-300 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
                                        <input type="radio" name="currency" value="euro"
                                               class="shrink-0 mt-0.5 border-gray-200 rounded text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800"
                                               id="currency"
                                               @if($type == 'create' or $type == 'edit' or $type == 'resume')
                                               required @else disabled @endif
                                               @if($type == 'review' or $type == 'view')
                                               @if($proposal['pp']['currency'] == 'euro') checked="" @endif
                                            @endif >
                                        <span class="text-sm text-gray-500 ms-3 dark:text-neutral-400">€</span>
                                    </label>
                                </div>
                            </div>
                            <!-- Co-financing -->
                            @if($type == 'create')
                                <livewire:pp.cofinancing proposal="" />
                            @elseif ($type == 'edit' or $type == 'resume')
                                <livewire:pp.cofinancing :proposal="$proposal"/>
                            @else
                                @include('pp.partials.review.cofinancing')
                            @endif

                        <!-- Percent OH-costs -->
                            <livewire:pp.ohcost :type="$type" :proposal="$proposal ?? null"/>
                            {{--}}
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
                                           value="{{ old('oh_cost') ? old('boh_cost'): $proposal->pp['oh_cost'] ??  '' }}"
                                           placeholder="OH cost"
                                           @if($type == 'create' or $type == 'edit' or $type == 'resume')
                                           required
                                           @else
                                           readonly
                                           @endif >
                                    <span class="inline-block ml-2 text-gray-900 dark:text-gray-200">%</span>
                                </div>
                            </div>
                            {{--}}

                        <!-- Project Dates -->
                            <div class="w-full sm:col-span-2 py-3 flex items-center text-xs text-blue-500 uppercase
                                before:flex-1 before:border-t before:border-gray-200 before:me-6 after:flex-1 after:border-t after:border-gray-200 after:ms-6
                                dark:text-blue-400 dark:before:border-neutral-600 dark:after:border-neutral-600">
                                Project dates
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
                                @if($type == 'create' or $type == 'edit' or $type == 'resume')
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
                                                   @if($type == 'edit' or $type == 'resume')
                                                   value="{{ $proposal['pp']['decision_exp'] }}"
                                                   @endif
                                                   id="startInput" type="text"
                                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5
                                                  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:placeholder:text-gray-200 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                   placeholder="{{__("Select date")}}">
                                        </div>
                                    </div>
                                @else
                                    @include('pp.partials.review.decision_exp')
                                @endif
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
                                @if($type == 'create' or $type == 'edit' or $type == 'resume')
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
                                                   @if($type == 'edit' or $type == 'resume')
                                                   value="{{ $proposal['pp']['start_date'] }}"
                                                   @endif id="endInput" type="text"
                                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5
                                                  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:placeholder:text-gray-200 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                   placeholder="{{__("Select date")}}" required>
                                        </div>
                                    </div>
                                @else
                                    @include('pp.partials.review.start_date')
                                @endif
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
                                @if($type == 'create' or $type == 'edit' or $type == 'resume')
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
                                                   name="submission_deadline"
                                                   @if($type == 'edit' or $type == 'resume')
                                                   value="{{ $proposal['pp']['submission_deadline'] }}"
                                                   @endif
                                                   id="startInput" type="text"
                                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5
                                                  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:placeholder:text-gray-200 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                   placeholder="{{__("Select date")}}" required>
                                        </div>
                                    </div>
                                @else
                                    @include('pp.partials.review.submission')
                                @endif
                            </div>
                            <!-- Project duration -->
                            <div class="w-full">
                                <label for="duration" class="font-sans block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __("Project duration in months") }}<span class="text-red-600"> *</span>
                                    <button id="duration-button" data-modal-toggle="duration-modal" class="inline" type="button">
                                        <svg class="w-[16px] h-[16px] inline text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M8 9h2v5m-2 0h4M9.408 5.5h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                        </svg>
                                    </button>
                                </label>
                                <input type="number" name="project_duration" id="duration"
                                       class="font-mono bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600
                                        block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-200 dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                       value="{{ old('duration') ? old('duration'): $proposal->pp['project_duration'] ??  '' }}"
                                       placeholder="Duration" @if($type == 'create' or $type == 'edit' or $type == 'resume') required @else readonly @endif>
                            </div>

                            <!-- Comments -->
                            <div class="w-full sm:col-span-2 py-3 flex items-center text-xs text-blue-500 uppercase
                                before:flex-1 before:border-t before:border-gray-200 before:me-6 after:flex-1 after:border-t after:border-gray-200 after:ms-6
                                dark:text-blue-400 dark:before:border-neutral-600 dark:after:border-neutral-600">
                                Comments
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
                                          placeholder="{{__("Your comments")}}" @if($type == 'review' or $type == 'edit' or $type == 'view') readonly @endif>{{ old('user_comments') ? old('user_comments'): $proposal->pp['user_comments'] ?? '' }}</textarea>
                            </div>
                            <!-- Message notice -->
                            @if(!in_array($proposal->status_stage1 ?? '', ['vice_approved', 'fo_approved']))
                                <div class="w-full sm:col-span-2 mb-4 space-y-4">
                                    <div class="pointer-events-auto rounded-lg bg-white p-4 text-[0.8125rem]/5 shadow-xl shadow-black/5 hover:bg-slate-50 ring-1 ring-blue-500">
                                        <div class="lg:flex lg:items-center lg:justify-between">
                                    <span class="block text-sm/6 font-medium text-gray-900">
                                        The submission paper and budget can only be uploaded once the pre-approval process has been successfully completed.
                                    </span>

                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if($type == 'edit' or $type == 'resume')
                            <!-- Edited comments -->
                                <div class="sm:col-span-2">
                                    <label for="edit_comments" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __("Edit Comments") }}
                                        <button id="edit_comments-button" data-modal-toggle="edit_comments-modal" class="inline" type="button">
                                            <svg class="w-[16px] h-[16px] inline text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M8 9h2v5m-2 0h4M9.408 5.5h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                            </svg>
                                        </button>
                                    </label>
                                    <textarea id="edit_comments" rows="4" name="edit_comments"
                                              class="font-mono block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300
                                    focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:placeholder:text-gray-200 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                              placeholder="{{__("Your comments")}}">{{ old('edit_comments') ? old('edit_comments'): $proposal->pp['edit_comments'] ?? '' }}</textarea>
                                </div>
                            @endif
                        </div>

                        <!-- Upload component -->
                        @if($type == 'review' or $type == 'view' or $type == 'resume')
                            <div id="proposal-attachments" class="sm:col-span-2">
                                <label for="upload" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __("Proposal attachments") }}
                                    <button id="upload-button" data-modal-toggle="upload-modal" class="inline" type="button">
                                        <svg class="w-[16px] h-[16px] inline text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M8 9h2v5m-2 0h4M9.408 5.5h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                        </svg>
                                    </button>
                                </label>
                            </div>
                            <livewire:pp.proposal-uploader  :proposal="$proposal" />
                        @endif

                        @if($type == 'create' or $type == 'edit' or $type == 'resume')
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

                                <button type="submit"  @if($type == 'edit') disabled @endif
                                class="py-2.5 px-3 w-full inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-lg border border-blue-700 bg-white hover:bg-blue-800
                                text-blue-700 hover:text-white shadow-sm focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none
                                dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-300
                                dark:hover:bg-neutral-800 dark:focus:bg-neutral-800">
                                    @if($type == 'edit')
                                        {{__("Edit proposal - disabled")}}
                                    @else
                                        {{__("Submit proposal")}}
                                    @endif

                                </button>
                            </div>
                        @elseif($type == 'view')
                            <div class="mt-4 flex flex-col sm:flex-row gap-3">
                                <a type="button" href="{{ url()->previous() }}"
                                   class="py-2.5 px-3 w-full inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-lg border border-susecondary bg-white text-gray-800 shadow-sm
                                hover:bg-gray-50 focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none
                                dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-300
                                dark:hover:bg-neutral-800 dark:focus:bg-neutral-800">
                                    {{__("Return")}}
                                </a>
                            </div>
                        @endif
                    </form> <!-- end form -->

                @if($type == 'review')
                    @include('pp.partials.review.bar')
                @endif<!-- Your form container here -->
                </div>
            </div>


        </div>
    </section>

    <script>
        /* Textarea autosize */
        document.addEventListener('DOMContentLoaded', function() {
            const textarea = document.getElementById('user_comments');

            const autoResize = () => {
                textarea.style.height = 'auto'; // Reset the height to auto to calculate the new height
                textarea.style.height = `${textarea.scrollHeight}px`; // Set the height to the scroll height
            };

            textarea.addEventListener('input', autoResize);
            autoResize(); // Call once on page load to set the initial height
        });

        /* Add unit head */
        document.getElementById('add-unithead-button').addEventListener('click', function () {
            // Get the container where the new selects will be added
            const container = document.getElementById('unithead-container');

            // Find the existing select dropdown to clone
            const existingSelect = document.querySelector('#unithead-container select');

            // Clone the select element
            const newSelect = existingSelect.cloneNode(true);

            // Clear selection in the new dropdown
            newSelect.selectedIndex = -1;

            // Create a wrapper div with spacing
            const wrapperDiv = document.createElement('div');
            wrapperDiv.className = 'mt-4'; // Add margin-top

            // Append the new select to the wrapper div
            wrapperDiv.appendChild(newSelect);

            // Append the wrapper div to the container
            container.appendChild(wrapperDiv);
        });
    </script>

        </div>
    </section>
    @include('layouts.darktoggler')
@endsection
