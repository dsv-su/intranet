@extends('layouts.app')
@section('content')
    @nocache('dsvheader')
<!-- PP header -->
@include('pp.partials.header')
    
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
                    {{$breadcrumb}}
                </li>
            </ol>
            <!-- End Breadcrumb -->
        </div>
    </div>
    <!-- End Breadcrumb -->
</div>
    <!-- Flash message -->
    @if (session('success'))
        <div class="mx-auto max-w-screen-xl mt-4 px-4 lg:px-12">
            @include('pp.partials.flash_submitted')
        </div>

    @endif
<!-- Content -->
<div class="w-full">
    <div class="p-4 sm:p-6 space-y-4 sm:space-y-6">
        <livewire:pp.project-proposal-home />
        @switch ($page)
            @case ('my')
                <livewire:pp.my-project-proposal-search />
            @break
            @case ('awaiting')
                <livewire:pp.awaiting-project-proposal />
            @break
            @case ('all')
                <livewire:pp.all-project-proposal-search />
            @break
        @endswitch
        {{--}}
        <livewire:project-proposal />
        {{--}}
    </div>
</div>
<!-- End Content -->
    @nocache('layouts.darktoggler')
@endsection
