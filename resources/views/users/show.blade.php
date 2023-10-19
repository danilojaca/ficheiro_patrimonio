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
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>{{"Nome:"}}</strong>
            {{ $user->name }}
        </div>
    </div>    
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>{{"Funções:"}}</strong>
            @if(!empty($user->getRoleNames()))
                @foreach($user->getRoleNames() as $v)
                    {{ $v }}
                @endforeach
            @endif
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>{{"Unidades:"}}</strong>            
                @foreach($roleunidades as $roleunidade)
                    {{ $roleunidade->unidade->unidade }} | {{ $roleunidade->unidade->edificio->edificio }}
                    <br>
                @endforeach            
        </div>
    </div>
</div>
@endsection