@extends('admin.structure')

@section('title', 'Admin Settings')

@section('content')
<div class="container">
    <h1 class="mb-4">Settings</h1>

    {{-- Alerts --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('info'))
        <div class="alert alert-info">{{ session('info') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.settings.update') }}">
        @csrf

        <div class="card mb-4">
            <div class="card-header">
                Two-Factor Authentication
            </div>
            <div class="card-body">
                <p class="text-muted">Enable or disable two-factor authentication globally for admin users.</p>

                <div class="form-check form-switch d-flex align-items-center">
                    <input
                        class="form-check-input"
                        type="checkbox"
                        role="switch"
                        id="twoFactorSwitch"
                        name="two_factor"
                        value="1"
                        {{ old('two_factor', $twoFactor ?? false) ? 'checked' : '' }}>
                    <label class="form-check-label ms-2" for="twoFactorSwitch">
                        Two-Factor Authentication
                    </label>
                </div>
            </div>
            <div class="card-footer text-end">
                <button type="submit" class="btn btn-primary">Save Settings</button>
            </div>
        </div>
    </form>

    {{-- You can add more settings sections here --}}
</div>
@endsection
