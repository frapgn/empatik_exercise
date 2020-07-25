@extends('layouts.app')

@section('content')
<div class="container">
    <form action="{{route('dashboard.store')}}" method="POST" autocomplete="off">
        @method("POST")
        @csrf
        <input type="text" name="project" placeholder="project">
        @error('project')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror

        <input type="text" name="service" placeholder="service">
        @error('service')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror

        <input type="text" name="username" placeholder="username">
        @error('username')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror

        <input type="password" name="password" placeholder="password">
        @error('password')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror

        <input type="submit" value="Inserisci">
    </form>

    @foreach ($login_credentials as $key => $login_credential)
        <div> {{$login_credential->username}} <button class="decrypt-password" type="button">View Password</button> </div>
    @endforeach
</div>
@endsection
