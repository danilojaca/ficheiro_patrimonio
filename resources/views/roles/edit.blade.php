@extends('layouts.app')


@section('content')
<div class="container pt-5">
    <nav class="navbar navbar-expand-sm bg-light">
        <div class="container-fluid">               
            <div class="container navbar-nav justify-content-center  ">
                <h2>{{'Gestão de Perfil'}}</h2>
            </div>
            <ul class="navbar-nav">      
                <li class="nav-item">
                    <a class="btn btn-primary" href="{{ route('roles.index') }}"><i class="bi bi-reply-fill"></i></a>
                </li>            
            </ul>
        </div>
    </nav>
</div>


@if (count($errors) > 0)
    <div class="alert alert-danger alert-dismissible fade show">
        <strong>oops!</strong> Houve alguns problemas com sua entrada.<br><br>
        <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
<form method="POST" action={{route('roles.update',['role' => $role->id])}}>
@method('PATCH')
@csrf
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <strong>{{"Nome:"}}</strong>
            <input type="text" class="form-control" name="name" placeholder="Nome" value="{{$role->name}}" >
        </div>
    </div>
    <div class="col-md-12 pt-2">
        <strong>{{"Permissão:"}}</strong>
            <br/>
        <div class="form-group mb-3 pt-2">
            @foreach($permission as $value)            
            <input type="checkbox" class="btn-check" id="{{$value->id}}" name="permission[]" {{(in_array($value->id, $rolePermissions,true)) ? 'checked' : ''}} autocomplete="off" value="{{ $value->id }}" onchange="document.getElementById('sala_form').submit()">
            <label class="btn btn-outline-secondary mb-1 " for="{{$value->id}}">{{ $value->name }}</label> 
            @endforeach
        </div>
    </div>
    <div class="col-md-12 text-center pt-3">
        <button type="submit" class="btn btn-primary">{{"Salvar"}}</button>
    </div>
</div>
</form>


@endsection
