@extends('admin.structure')

@section('title', 'Create User')

@section('navbar')
    <x-admin.navbar />
@endsection

@section('footer')
    <x-admin.footer />
@endsection

@section('content')
    <div class="container">
        <form action="{{ route('admin.logout') }}" method="POST">
            @csrf
            <button type="submit">Logout</button>
        </form>
    </div>
@endsection