<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="{{asset('images/favicon.png')}}">
    <link rel="icon" type="image/x-icon" href="{{asset('images/favicon.ico')}}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>@yield('title') {{ config('app.name') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="#">
    <meta name="keyword" content="#">

    <!-- Shortcut Icon -->
    <link rel="shortcut icon" href="{{asset('images/favicon.png')}}">
    <link rel="icon" type="image/ico" href="{{asset('images/favicon.png')}}" />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @vite(['resources/css/site.css'])
    @vite(['resources/js/site.js'])
    @livewireStyles
    {{--}}@stack('after-styles'){{--}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/datepicker.min.js"></script>

</head>

<body class="dark:bg-gray-800">
    <main>
        @yield('content')
    </main>

    {{--}}
    @include('includes.footer')
    {{--}}
</body>

<!-- Scripts -->
{{--}}@stack('after-scripts'){{--}}
@livewireScripts
@include('footer.footer')
</html>
