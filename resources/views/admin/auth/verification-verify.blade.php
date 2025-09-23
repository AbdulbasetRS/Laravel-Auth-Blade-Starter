@extends('admin.structure')

@section('title', 'Email Verified')

@section('footer')
    <x-admin.footer />
@endsection

@section('content')
    <div class="container min-vh-100 d-flex align-items-center justify-content-center py-5">
        <div class="row w-100 justify-content-center">
            <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5">
                <div class="card shadow-sm">
                    <div class="card-body p-4 text-center">
                        <h1 class="h4 mb-3">تم تفعيل بريدك الإلكتروني بنجاح</h1>
                        <p class="text-muted mb-4">يمكنك الآن استخدام كافة خصائص الموقع.</p>

                        @auth
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">الانتقال إلى لوحة التحكم</a>
                        @else
                            <a href="{{ route('admin.login') }}" class="btn btn-primary">تسجيل الدخول</a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

