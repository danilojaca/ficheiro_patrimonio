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
        <strong>oops!</strong> Houve alguns problemas.<br><br>
        <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<form method="POST" action="{{route('roles.store')}}">
@csrf
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>{{"Nome:"}}</strong>
            <input type="text" class="form-control" name="name" placeholder="Nome" value="{{old("name")}}">
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>{{"Permissão:"}}</strong>
            <br/>
            @foreach($permission as $value)
            <input type="checkbox" class="btn-check" id="{{$value->id}}" name="permission[]" autocomplete="off" value="{{ $value->id }}">
            <label class="btn btn-outline-secondary mb-1 " for="{{$value->id}}">{{ $value->name }}</label> 
            @endforeach
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <button type="submit" class="btn btn-primary">{{"Salvar"}}</button>
    </div>
</div>
</form>



@endsection