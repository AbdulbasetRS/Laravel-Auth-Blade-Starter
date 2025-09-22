@extends('admin.structure')

@section('title', 'Dashboard')

@section('navbar')
    <x-admin.navbar />
@endsection

@section('footer')
    <x-admin.footer />
@endsection

@section('content')
    <div class="container">
        <h1>Admin Dashboard.</h1>
        <form action="{{ route('admin.logout') }}" method="POST">
            @csrf
            <button type="submit">Logout</button>
        </form>
    </div>
@endsection