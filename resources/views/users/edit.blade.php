@extends('layouts.app')

@section('content')
<div class="container pt-5">
    <nav class="navbar navbar-expand-sm bg-light">
        <div class="container-fluid">               
            <div class="container navbar-nav justify-content-center  ">
                <h2>{{'Gestão de Utilizador'}}</h2>
            </div>
            <ul class="navbar-nav">      
                <li class="nav-item">
                    <a class="btn btn-primary" href="{{ route('users.index') }}"><i class="bi bi-reply-fill"></i></a>
                </li>            
            </ul>
        </div>
    </nav>
</div>

@if (count($errors) > 0)
    <div class="alert alert-danger">
        <strong>oops!</strong> Houve alguns problemas.<br><br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif



<form method="POST" action={{route('users.update',['user' => $user->id])}} id="perfil_form">
@method('PATCH')
@csrf
<div class="row g-2">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>{{"Nome:"}}</strong>            
            {{$user->name}}
        </div>
    </div>    
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>{{"Funções:"}}</strong>
                @foreach($roles as $key => $role)
                    <input type="checkbox" class="btn-check" name="roles[]" id="{{$key}}" value="{{$role}}" {{(in_array($role, $userRole)) ? 'checked' : ''}} onchange="document.getElementById('sala_form').submit()">
                    <label class="btn btn-outline-secondary mb-1" for="{{$key}}" >{{$role}}</label>
                @endforeach   
        </div>
    </div>    
</div>
</form>
<script>
$(document).ready(function(){
    $("#perfil_form").on("change", "input:checkbox", function(){
        $("#perfil_form").submit();
    });
});
</script>


@endsection