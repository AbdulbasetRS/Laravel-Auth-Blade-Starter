@extends('admin.structure')

@section('title', 'Enable Two-Factor Authentication')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">
                            <i class="bi bi-shield-plus me-2"></i>
                            تفعيل المصادقة الثنائية
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        {{-- Error messages --}}
                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="bi bi-exclamation-triangle me-2"></i>
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        {{-- Instructions --}}
                        <div class="alert alert-info" role="alert">
                            <h6 class="alert-heading">
                                <i class="bi bi-info-circle me-2"></i>
                                خطوات التفعيل:
                            </h6>
                            <ol class="mb-0 ps-4">
                                <li class="mb-2">قم بتنزيل تطبيق <strong>Google Authenticator</strong> على هاتفك المحمول
                                </li>
                                <li class="mb-2">افتح التطبيق واضغط على <strong>"إضافة حساب"</strong></li>
                                <li class="mb-2">اختر <strong>"مسح رمز QR"</strong> وقم بمسح الكود أدناه</li>
                                <li>أدخل الرمز المكون من 6 أرقام الذي يظهر في التطبيق للتحقق</li>
                            </ol>
                        </div>


                        {{-- QR Code --}}
                        <div class="text-center my-4 p-4  rounded">
                            <h6 class="mb-3">امسح رمز QR هذا:</h6>
                            <div class="qr-code-container d-inline-block p-3  rounded shadow-sm">

                                {!! $qrCode !!}

                            </div>
                        </div>

                        {{-- Manual Entry Option --}}
                        <div class="alert alert-secondary" role="alert">
                            <h6 class="mb-2">
                                <i class="bi bi-keyboard me-2"></i>
                                أو أدخل المفتاح يدويًا:
                            </h6>
                            <div class="input">
                                <input type="text" class="form-control font-monospace" value="{{ $secret }}" readonly
                                    id="secretKey">
                                {{-- <button class="btn btn-outline-secondary" type="button" onclick="copySecret()"
                                    title="نسخ">
                                    <i class="bi bi-clipboard"></i>
                                    Copy
                                </button> --}}
                            </div>
                            <small class="text-muted d-block mt-2">
                                استخدم هذا المفتاح إذا لم تتمكن من مسح رمز QR
                            </small>
                        </div>


                        <div>
                            <form action="{{ route('admin.user-settings.two-factor.regenerate') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-warning w-100 btn-lg">
                                    🔄 إعادة توليد رمز جديد
                                </button>
                            </form>
                        </div>

                        {{-- Verification Form --}}
                        <form action="{{ route('admin.two-factor.confirm') }}" method="POST" class="mt-4">
                            @csrf

                            <div class="card border-primary">
                                <div class="card-header bg-primary text-white">
                                    <h6 class="mb-0">
                                        <i class="bi bi-shield-check me-2"></i>
                                        التحقق من الرمز
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <p class="mb-3">
                                        أدخل الرمز المكون من 6 أرقام من تطبيق Google Authenticator:
                                    </p>

                                    <div class="form-floating mb-3">
                                        <input type="text"
                                            class="form-control form-control-lg text-center font-monospace @error('code') is-invalid @enderror"
                                            id="code" name="code" placeholder="000000" maxlength="6" pattern="[0-9]{6}"
                                            autocomplete="off" required autofocus>
                                        <label for="code">رمز التحقق</label>
                                        @error('code')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <button type="submit" class="btn btn-success w-100 btn-lg">
                                        <i class="bi bi-check-circle me-2"></i>
                                        تفعيل المصادقة الثنائية
                                    </button>
                                </div>
                            </div>
                        </form>

                        {{-- Cancel Button --}}
                        <div class="text-center mt-4 pt-3 border-top">
                            <a href="{{ route('admin.user-settings.two-factor.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-x-circle me-2"></i>
                                إلغاء
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function copySecret() {
                const secretInput = document.getElementById('secretKey');
                secretInput.select();
                secretInput.setSelectionRange(0, 99999); // For mobile devices

                try {
                    document.execCommand('copy');
                    // Show feedback
                    const button = event.target.closest('button');
                    const originalHTML = button.innerHTML;
                    button.innerHTML = '<i class="bi bi-check"></i>';
                    setTimeout(() => {
                        button.innerHTML = originalHTML;
                    }, 2000);
                } catch (err) {
                    console.error('Failed to copy:', err);
                }
            }

            // Auto-format code input
            document.getElementById('code').addEventListener('input', function (e) {
                this.value = this.value.replace(/[^0-9]/g, '').substring(0, 6);
            });
        </script>
    @endpush
@endsection