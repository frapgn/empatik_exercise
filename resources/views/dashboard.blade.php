@extends('layouts.app')

@section('content')
<div class="container mb-3 mt-3">
    <form class="empatik-form" action="{{route('dashboard.store')}}" method="POST" autocomplete="off">
        @method("POST")
        @csrf
        <div class="input-container" id="project-input-container">
            <input type="text" name="project" id="project-input" placeholder="project" value="{{old('project')}}">
            <div id="projectList"></div>
        </div>
        @error('project')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror

        <div class="input-container">
            <input type="text" name="service" placeholder="service" value="{{old('service')}}">
        </div>
        @error('service')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror

        <div class="input-container">
            <input type="text" name="username" placeholder="username" value="{{old('username')}}">
        </div>
        @error('username')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror

        <div class="input-container">
            <input type="password" name="password" placeholder="password">
        </div>
        @error('password')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror

        <input type="submit" value="Inserisci">
    </form>

    <table id="myTable" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>Project</th>
                <th>Service</th>
                <th>Username</th>
                <th>Password</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($login_credentials as $key => $login_credential)
                <tr>
                    <td class="td-id"> {{$login_credential->id}} </td>
                    <td> {{$login_credential->project->name}} </td>
                    <td> {{$login_credential->service->name}} </td>
                    <td> {{$login_credential->username}} </td>
                    <td class="td-password"> <span class="password">&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;</span> </td>
                    <td> <button class="decrypt-password" type="button">View Password</button> </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th>ID</th>
                <th>Project</th>
                <th>Service</th>
                <th>Username</th>
                <th>Password</th>
                <th></th>
            </tr>
        </tfoot>
    </table>

</div>
@endsection
