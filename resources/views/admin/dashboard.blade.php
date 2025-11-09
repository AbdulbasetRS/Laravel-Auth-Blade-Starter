@extends('admin.structure')

@section('title', 'Dashboard')

@section('content')
    <div class="container">
        <h1>Admin Dashboard.</h1>
        <h3>Username is: [ {{ auth()->user()->username }} ]</h3>
        <h3>Type is [{{ auth()->user()->type->value }}]</h3>
    </div>
@endsection