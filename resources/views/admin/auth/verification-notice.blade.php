@extends('admin.structure')

@section('title', 'Email Verification Required')

@section('footer')
    <x-admin.footer />
@endsection

@section('content')
    <div class="container min-vh-100 d-flex align-items-center justify-content-center py-5">
        <div class="row w-100 justify-content-center">
            <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5">
                <div class="card shadow-sm">
                    <div class="card-body p-4 text-center">
                        <h1 class="h4 mb-3">تفعيل البريد الإلكتروني مطلوب</h1>
                        <p class="text-muted">حسابك غير مفعل. رجاءً تحقق من بريدك الإلكتروني لتفعيل الحساب.</p>

                        @if (session('status'))
                            <div class="alert alert-success" role="alert">{{ session('status') }}</div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger" role="alert">{{ session('error') }}</div>
                        @endif

                        <form action="{{ route('admin.verification-notification.submit') }}" method="POST" class="d-inline-block">
                            @csrf
                            <button type="submit" class="btn btn-primary">إعادة إرسال رسالة التحقق</button>
                        </form>

                        <div class="mt-3">
                            <a class="small text-decoration-none" href="{{ route('admin.login') }}">العودة لتسجيل الدخول</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

