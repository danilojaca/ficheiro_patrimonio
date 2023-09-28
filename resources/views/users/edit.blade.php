@extends('layouts.app')

@section('content')
<div class="container pt-5">
    <nav class="navbar navbar-expand-sm bg-light">
        <div class="container-fluid">               
            <div class="container navbar-nav justify-content-center  ">
                <h1>{{'Gestão de Utilizador'}}</h1>
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
        <strong>oops!</strong> Houve alguns problemas com sua entrada.<br><br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif



<form method="POST" action={{route('users.update',['user' => $user->id])}}>
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
            <select class="form-select " size="10" multiple aria-label="multiple select example" name="roles[]">
             @foreach($roles as $key => $role)             
            <option value="{{$role}}" {{(in_array($role, $userRole)) ? 'selected' : ''}}>{{$role}} </option>
            @endforeach
            </select>
            
        </div>
    </div>
    <div class="col-xl-12 col-xl-12 col-xl-12 text-center p0">
        <button type="submit" class="btn btn-primary">{{"Salvar"}}</button>
    </div>
</div>
</form>



@endsection