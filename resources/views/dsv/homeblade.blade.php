@extends('layouts.app')
@section('content')
    @include('dsvheader')
    @include('navbar.navbar')
    @include('layouts.breadcrumbs')

    <!-- Sidenav with content -->
    <div class="flex overflow-hidden bg-white dark:bg-gray-800 dark:text-white">
        @include('partials.page')
    </div>

    @include('layouts.darktoggler')
@endsection
