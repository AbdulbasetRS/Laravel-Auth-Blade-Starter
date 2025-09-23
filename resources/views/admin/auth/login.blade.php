@extends('admin.structure')

@section('title', 'Login')

@section('navbar')
    {{-- <x-admin.navbar /> --}}
@endsection

@section('footer')
    {{-- <x-admin.footer /> --}}
@endsection

@section('content')
    <div class="container min-vh-100 d-flex align-items-center justify-content-center py-5">
        <div class="row w-100 justify-content-center">
            <div class="col-12 col-sm-10 col-md-8 col-lg-5 col-xl-4">
                <div class="card shadow-sm">
                    <div class="card-body p-4">
                        <h1 class="h4 text-center mb-4">تسجيل الدخول</h1>

                        {{-- Session status / error messages --}}
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">{{ session('status') }}</div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger" role="alert">{{ session('error') }}</div>
                        @endif

                        {{-- General validation errors (non field-specific) --}}
                        @if ($errors->any())
                            <div class="alert alert-danger" role="alert">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $message)
                                        <li>{{ $message }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('admin.login') }}" method="POST" novalidate>
                            @csrf

                            <div class="form-floating mb-3">
                                <input
                                    type="text"
                                    class="form-control @error('identifier') is-invalid @enderror"
                                    id="identifier"
                                    name="identifier"
                                    placeholder="name@example.com"
                                    value="{{ old('identifier') }}"
                                    required>
                                <label for="identifier">البريد الإلكتروني أو اسم المستخدم</label>
                                @error('identifier')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-floating mb-3">
                                <input
                                    type="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    id="password"
                                    name="password"
                                    placeholder="••••••••"
                                    required>
                                <label for="password">كلمة المرور</label>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="1" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember">
                                        تذكرني
                                    </label>
                                </div>
                                @if (Route::has('admin.forgot-password'))
                                    <a class="small text-decoration-none" href="{{ route('admin.forgot-password') }}">نسيت كلمة المرور؟</a>
                                @endif
                            </div>

                            <button type="submit" class="btn btn-primary w-100">تسجيل الدخول</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection