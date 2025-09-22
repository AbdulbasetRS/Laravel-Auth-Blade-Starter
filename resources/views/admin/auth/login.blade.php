<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <!-- <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" /> -->
</head>

<body>
    <div>
        
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
</body>

</html>