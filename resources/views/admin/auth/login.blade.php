@extends('admin.structure')

@section('title', 'Login')

@section('navbar')
    {{-- <x-admin.navbar /> --}}
@endsection

@section('footer')
    {{-- <x-admin.footer /> --}}
@endsection

@section('content')
    <div class="container">
        <form action="{{ route('admin.login') }}" method="POST">
            @csrf

            {{-- Session status / error messages --}}
            @if (session('status'))
                <div class="status">{{ session('status') }}</div>
            @endif
            @if (session('error'))
                <div class="error">{{ session('error') }}</div>
            @endif

            {{-- General validation errors (non field-specific) --}}
            @if ($errors->any())
                <div class="error">
                    <ul>
                        @foreach ($errors->all() as $message)
                            <li>{{ $message }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <input type="text" name="identifier" placeholder="Identifier" value="{{ old('identifier') }}" required>
            @error('identifier')
                <div class="error">{{ $message }}</div>
            @enderror

            <input type="password" name="password" placeholder="Password" required>
            @error('password')
                <div class="error">{{ $message }}</div>
            @enderror

            <button type="submit">Login</button>
        </form>
    </div>
@endsection