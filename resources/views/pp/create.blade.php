@extends('layouts.app')
@section('content')
    @nocache('dsvheader')
    @include('pp.partials.header')
    <section class="bg-white dark:bg-gray-900">
        <div class="max-w-2xl px-4 py-8 mx-auto lg:py-16">
            {{--}}
            @if(in_array($type, ['edit', 'review', 'view', 'resume']))
                @include(('pp.partials.overview'))
            @endif
            {{--}}
            <h2 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">
                @php
                    $labels = [
                        'complete' => isset($proposal) ? __("Complete: ") . $proposal['name'] : __("Complete"),
                        'view' => isset($proposal) ? __("View: ") . $proposal['name'] : __("View"),
                        'edit' => isset($proposal) ? __("Edit: ") . $proposal['name'] : __("Edit"),
                    ];
                @endphp
                {{ $labels[$type] ?? __("New Project Proposal") }}
            </h2>

            <!-- Progress stepper stage -->
            @include(('pp.partials.progress_stage'))

            <!-- Instruction -->
            @if(in_array($type, ['preapproval', 'resume']))
                @include('pp.partials.form.help')
            @endif

            <form method="post" action="{{route('new-submit')}}">
                @csrf

                @if(in_array($type, ['complete', 'edit', 'resume', 'granted']))
                    <input type="hidden" name="id" value="{{$proposal->id}}">
                @endif

                <input type="hidden" name="type" value="{{$type}}">
                <div class="grid gap-4 mb-4 sm:grid-cols-2 sm:gap-6 sm:mb-5">
                    {{--}}<div class="w-full sm:col-span-2 border border-blue-500 rounded-lg p-4"></div>{{--}}

                    <!-- Title -->
                    @include('pp.partials.form.title')

                    <!--Research subject-->
                    <div class="w-full sm:col-span-2 py-3 flex items-center text-xs text-blue-500 uppercase
                                before:flex-1 before:border-t before:border-gray-200 before:me-6 after:flex-1 after:border-t after:border-gray-200 after:ms-6
                                dark:text-blue-400 dark:before:border-neutral-600 dark:after:border-neutral-600">
                        Research subject
                    </div>

                    @include('pp.partials.form.research_subject')

                    <!-- Outline (objective)-->
                    @include('pp.partials.form.objective')

                    <div class="w-full sm:col-span-2 py-3 flex items-center text-xs text-blue-500 uppercase
                                before:flex-1 before:border-t before:border-gray-200 before:me-6 after:flex-1 after:border-t after:border-gray-200 after:ms-6
                                dark:text-blue-400 dark:before:border-neutral-600 dark:after:border-neutral-600">
                        Research collaborators
                    </div>

                    <!-- Principal Investigator-->
                    @include('pp.partials.form.principal_investigator')

                    <!-- Co Investigators -->
                    @if($type == 'preapproval')
                        <livewire:select2.Coinvestigators-select2 proposal=""/>
                    @elseif( $type == 'complete' or $type == 'resume')
                        <livewire:select2.Coinvestigators-select2 :proposal="$proposal" />
                    @else
                        @include('pp.partials.review.co_investigators')
                    @endif


                    <!-- Project organization -->
                    <div class="w-full sm:col-span-2 py-3 flex items-center text-xs text-blue-500 uppercase
                                before:flex-1 before:border-t before:border-gray-200 before:me-6 after:flex-1 after:border-t after:border-gray-200 after:ms-6
                                dark:text-blue-400 dark:before:border-neutral-600 dark:after:border-neutral-600">
                        Project organization
                    </div>
                    <!-- Funding organization -->
                    @if($type == 'preapproval')
                        <livewire:select2.Org-select2 proposal="" />
                    @elseif ( $type == 'complete' or $type == 'edit' or $type == 'resume')
                        <livewire:select2.Org-select2 :proposal="$proposal" />
                    @else
                        @include('pp.partials.review.funding_org')
                    @endif

                    <!--DSV coordinating -->
                    @if($type == 'preapproval')
                        <livewire:pp.dsv-coordination proposal="" />
                    @elseif ($type == 'edit' or $type == 'resume')
                        <livewire:pp.dsv-coordination :proposal="$proposal" />
                    @else
                        @include('pp.partials.review.dsvcoordination')
                    @endif

                    <!-- Eu Wallengenberg project -->
                    @if($type == 'preapproval')
                        <livewire:pp.eu-wallenberg-project proposal="" />
                    @elseif ($type == 'edit' or $type == 'resume')
                        <livewire:pp.eu-wallenberg-project :proposal="$proposal" />
                    @else
                        @include('pp.partials.review.eu_wallenberg')
                    @endif

                    <!-- Co-financing -->
                    @if($type == 'preapproval')
                        <livewire:pp.cofinancing proposal="" />
                    @elseif ($type == 'edit' or $type == 'resume')
                        <livewire:pp.cofinancing :proposal="$proposal"/>
                    @else
                        @include('pp.partials.review.cofinancing')
                    @endif

                    <!-- Unit Head -->
                    @if(in_array($type, ['complete', 'review', 'view', 'resume']))
                        <div class="w-full sm:col-span-2 py-3 flex items-center text-xs text-blue-500 uppercase
                                before:flex-1 before:border-t before:border-gray-200 before:me-6 after:flex-1 after:border-t after:border-gray-200 after:ms-6
                                dark:text-blue-400 dark:before:border-neutral-600 dark:after:border-neutral-600">
                            Unit Head
                        </div>
                    <!--Unithead-->
                        @include('pp.partials.form.unit_head')
                    @endif

                    <!-- Project budget -->
                    @if(in_array($type, ['complete', 'review', 'edit', 'resume', 'view']))
                        <div class="w-full sm:col-span-2 py-3 flex items-center text-xs text-blue-500 uppercase
                                    before:flex-1 before:border-t before:border-gray-200 before:me-6 after:flex-1 after:border-t after:border-gray-200 after:ms-6
                                    dark:text-blue-400 dark:before:border-neutral-600 dark:after:border-neutral-600">
                            Project budget
                        </div>
                        <!-- Budget for complete project -->
                        @include('pp.partials.form.budget_project')
                        <!-- Budget for DSV -->
                        @include('pp.partials.form.budget_dsv')
                        <!-- Budget years of PHD -->
                        @include('pp.partials.form.budget_phd')
                        <!-- Currency -->
                        @include('pp.partials.form.currency')
                        <!-- Percent OH-costs -->
                        <livewire:pp.ohcost :type="$type" :proposal="$proposal ?? null"/>
                    @endif

                    <!-- Project dates -->
                    <div class="w-full sm:col-span-2 py-3 flex items-center text-xs text-blue-500 uppercase
                                before:flex-1 before:border-t before:border-gray-200 before:me-6 after:flex-1 after:border-t after:border-gray-200 after:ms-6
                                dark:text-blue-400 dark:before:border-neutral-600 dark:after:border-neutral-600">
                        Project dates
                    </div>
                    @if($type != 'preapproval')
                        <!--Decision expected-->
                        @include('pp.partials.form.date_exp')
                        <!-- Start date -->
                        @include('pp.partials.form.date_start')
                        <!-- Submission deadline -->
                        @include('pp.partials.form.date_deadline')
                    @endif

                    <!-- Project duration -->
                    @include('pp.partials.form.duration')

                    <!-- Comments -->
                    <div class="w-full sm:col-span-2 py-3 flex items-center text-xs text-blue-500 uppercase
                                before:flex-1 before:border-t before:border-gray-200 before:me-6 after:flex-1 after:border-t after:border-gray-200 after:ms-6
                                dark:text-blue-400 dark:before:border-neutral-600 dark:after:border-neutral-600">
                        Comments
                    </div>
                    <!-- Initial comments -->
                    @include('pp.partials.form.comments')
                </div>

                <!-- Upload component -->
                @include('pp.partials.form.upload')

                <!-- Grant section -->
                @if(in_array($type, ['granted', 'view']))
                    @include('pp.partials.form.granted')
                @endif

                <!-- Submit buttons -->
                @include('pp.partials.form.submit_buttons')
            </form> <!-- end form -->

            <!-- Review bar -->
            @include('pp.partials.form.reviewbar')

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
        document.addEventListener('DOMContentLoaded', function() {
            const textarea = document.getElementById('objective');

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

    <!-- Modals -->
    @include('pp.modals.pp_help')
    @include('layouts.darktoggler')
@endsection
