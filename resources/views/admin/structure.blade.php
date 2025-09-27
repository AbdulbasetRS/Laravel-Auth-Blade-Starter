<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}" class="h-100">

<head>
    <!-- Meta Data -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ env('APP_NAME') }} @if(trim($__env->yieldContent('title'))) | @yield('title') @endif</title>
    @yield('meta')
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('general/images/cpanel-logo.png') }}">

    <!-- Fonts -->
    <link rel="stylesheet" href="{{ asset('general/fonts/fonts.css') }}">
    <link rel="stylesheet" href="{{ asset('general/fontawesome/fontawesome-free-6.4.2-web/css/all.css') }}">
    <!-- Site Stylesheet -->
    <link rel="stylesheet" href="{{ asset('general/libraries/bootstrap/bootstrap-v5.3.8/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('general/libraries/sweetAlert2/v11.17.2/sweetalert2.min.css') }}">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @yield('main.style')

</head>

<body class="font-default" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
    <div class="d-flex flex-column min-vh-100">

        @yield('navbar')

        <main class="flex-grow-1">
            @yield('content')
        </main>

        @yield('footer')

    </div>

    <!-- Site Scripts -->
    @yield('main.script')
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('general/libraries/bootstrap/bootstrap-v5.3.8/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('general/libraries/jquery/jquery-3.7.1/minified.jquery-3.7.1.js') }}"></script>
    <script src="{{ asset('general/libraries/chart.js/chart-v4.5.0.js') }}"></script>
    <script src="{{ asset('general/libraries/sweetAlert2/v11.17.2/sweetalert2.min.js') }}"></script>
</body>

</html>