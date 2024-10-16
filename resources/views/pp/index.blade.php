@extends('layouts.app')
@section('content')
@include('dsvheader')
<style>
    .container {
        display: flex;
        flex-wrap: wrap;
    }

    .container > div {
        flex: 1;
        max-width: 300px;
    }
</style>

<!-- ========== HEADER ========== -->
<header class="sticky top-0 inset-x-0 flex flex-wrap md:flex-nowrap z-[48] w-full bg-white border-b text-sm py-2.5 dark:bg-neutral-800 dark:border-neutral-700">
    <nav class="px-4 sm:px-6 flex w-full items-center">
        <div class="me-5">
            <!-- Logo -->
            <a href="{{ config('app.url') }}" class="flex items-center mr-4">
                <span class="flex opacity-90 items-center h-full px-0.5 py-px ml-2 text-xl leading-none border-[2px] border-suprimary rounded dark:text-white dark:border-white">
                    DSV
                </span>
                <span class="hidden md:block font-sudepartment ml-1 mb-1 text-xl font whitespace-nowrap dark:text-white">
                    {{ __("ProjectProposals") }}
                </span>
                @if(config('app.name') == 'ProjectProposalsDev')
                    <span class="hidden md:block font-rock text-lg whitespace-nowrap dark:text-white">
                        Dev
                    </span>
                @endif
            </a>
            <!-- End Logo -->
        </div>

        <div class="flex w-full items-center justify-end ms-auto md:justify-between gap-x-1 md:gap-x-3">
            <div class="hidden md:block">
                <!-- Search block -->
            </div>

            <div class="flex flex-row items-center justify-end gap-1">
                <button type="button" class="md:hidden size-[38px] relative inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-full border border-transparent text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-neutral-700 dark:focus:bg-neutral-700">
                    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                    <span class="sr-only">Search</span>
                </button>

                <button type="button" class="size-[38px] relative inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-full border border-transparent text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-neutral-700 dark:focus:bg-neutral-700">
                    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/></svg>
                    <span class="sr-only">Notifications</span>
                </button>

                <button type="button" class="size-[38px] relative inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-full border border-transparent text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-neutral-700 dark:focus:bg-neutral-700">
                    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>
                    <span class="sr-only">Activity</span>
                </button>
            </div>
        </div>
    </nav>
</header>


<!-- ========== END HEADER ========== -->

<!-- ========== MAIN CONTENT ========== -->
<div class="-mt-px">
    <!-- Breadcrumb -->
    <div class="sticky top-0 inset-x-0 z-20 bg-white border-y px-4 sm:px-6 lg:px-8 dark:bg-neutral-800 dark:border-neutral-700">
        <div class="flex items-center py-2">
            <!-- Breadcrumb -->
            <ol class="ms-3 flex items-center whitespace-nowrap">
                <li class="flex items-center text-sm text-gray-800 dark:text-neutral-400">
                    Dashboard
                    <svg class="shrink-0 mx-3 overflow-visible size-2.5 text-gray-400 dark:text-neutral-500" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M5 1L10.6869 7.16086C10.8637 7.35239 10.8637 7.64761 10.6869 7.83914L5 14" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </li>
                <li class="text-sm font-semibold text-gray-800 truncate dark:text-neutral-400" aria-current="page">
                    Mockup
                </li>
            </ol>
            <!-- End Breadcrumb -->
        </div>
    </div>
    <!-- End Breadcrumb -->
</div>

<!-- Content -->
<div class="w-full">
    <div class="p-4 sm:p-6 space-y-4 sm:space-y-6">
        <livewire:pp.project-proposal-home />
        <livewire:pp.project-proposal-search />
        <livewire:project-proposal />
        {{--}}

        {{--}}
    </div>
</div>
<!-- End Content -->
<!-- ========== END MAIN CONTENT ========== -->
@endsection
