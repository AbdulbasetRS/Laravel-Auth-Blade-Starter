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
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/images/cpanel-logo.png') }}">

    <!-- Fonts -->
    <link rel="stylesheet" href="{{ asset('assets/fonts/fonts.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fontawesome/fontawesome-free-6.4.2-web/css/all.css') }}">
    <!-- Site Stylesheet -->
    <link rel="stylesheet" href="{{ asset('assets/libraries/bootstrap/bootstrap-v5.3.8/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libraries/sweetAlert2/v11.17.2/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">

    <!-- DataTables Scripts -->
    <script src="{{ asset('assets/libraries/jquery/jquery-3.7.1/minified.jquery-3.7.1.js') }}"></script>
    <script src="{{ asset('assets/libraries/dataTables/2.4.2/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/libraries/dataTables/2.4.2/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/libraries/dataTables/2.4.2/pdfmake/0.2.7/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/libraries/dataTables/2.4.2/pdfmake/0.2.7/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/libraries/dataTables/2.4.2/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/libraries/dataTables/2.4.2/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/libraries/dataTables/2.4.2/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/libraries/dataTables/2.4.2/js/buttons.colVis.min.js') }}"></script>
    

    <link href="{{ asset('assets/css/app.css') }}" rel="stylesheet">
    @yield('main.style')

</head>

<body class="font-default" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
    <div class="d-flex flex-column min-vh-100">

        @auth
            @include('components.admin.sidebar')
            {{-- @include('components.admin.navbar') --}}
        @endauth

        <main class="flex-grow-1">
            @yield('content')
        </main>

        @include('components.admin.footer')

    </div>

    <!-- Site Scripts -->
    <script src="{{ asset('assets/libraries/bootstrap/bootstrap-v5.3.8/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libraries/chart.js/chart-v4.5.0.js') }}"></script>
    <script src="{{ asset('assets/libraries/sweetAlert2/v11.17.2/sweetalert2.min.js') }}"></script>
    @yield('main.script')
    <script src="{{ asset('assets/js/app.js') }}"></script>
</body>

</html>