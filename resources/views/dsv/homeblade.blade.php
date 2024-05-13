@extends('layouts.app')
@include('dsvheader')
@include('navbar.navbar')
@include('layouts.breadcrumbs')
<!-- Sidenav with content -->
<div class="flex h-screen overflow-hidden bg-white dark:bg-gray-800 dark:text-white">
    @include('partials.page')
</div>
@include('layouts.darktoggler')
