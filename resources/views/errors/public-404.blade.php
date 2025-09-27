<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>404 | {{ config('app.name') }}</title>
    <link rel="stylesheet" href="{{ asset('general/libraries/bootstrap/bootstrap-v5.3.8/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="d-flex align-items-center" style="min-height:100vh;">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <div class="display-1 fw-bold text-danger">404</div>
                <h1 class="h3 mt-3 mb-2">{{ app()->getLocale() === 'ar' ? 'الصفحة غير موجودة' : 'Page Not Found' }}</h1>
                <p class="text-muted mb-4">
                    {{ app()->getLocale() === 'ar' ? 'الرابط الذي طلبته غير متاح.' : 'The page you are looking for could not be found.' }}
                </p>
                <div class="d-flex flex-wrap gap-2 justify-content-center">
                    <a href="{{ route('frontend.home') }}" class="btn btn-primary">
                        {{ app()->getLocale() === 'ar' ? 'الصفحة الرئيسية' : 'Home' }}
                    </a>
                    <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
                        {{ app()->getLocale() === 'ar' ? 'عودة للخلف' : 'Go Back' }}
                    </a>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('general/libraries/bootstrap/bootstrap-v5.3.8/dist/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
