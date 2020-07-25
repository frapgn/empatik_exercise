@extends('layouts.app')

@section('content')
<div class="container">
    <form action="" method="POST">
        @method("POST")
        @csrf
        <input type="text" name="username" placeholder="username" value="">
        <input type="password" name="password" value="">
        <input type="submit" value="Inserisci">
    </form>
</div>
@endsection
