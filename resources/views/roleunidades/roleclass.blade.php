@extends('layouts.app')


@section('content')
<div class="container pt-5">
    <nav class="navbar navbar-expand-sm bg-light">
        <div class="container-fluid">               
            <div class="container navbar-nav justify-content-center  ">
                <h1>{{'Gestão de Salas'}}</h1>
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
    <div class="alert alert-danger alert-dismissible fade show">
        <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
<div class="container">
    <form method="GET" action="/registro/roles_salas/{{$user}}/" id="unidade_id_form">
        <div class="col-md-7 offset-2">
            <select class="form-select select2 @error('unidade_id') is-invalid @enderror" name="unidade_id" id="unidade_id"  data-placeholder="Selecione o Unidade" >
                    <option data-default disabled selected ></option>
                @foreach ($unidades as $unidade)
                    <option value="{{$unidade->unidade_id}}" {{$unidade->unidade_id == $id_unidade ? 'selected' : ''}}>{{$unidade->unidade->unidade}} | {{$unidade->unidade->edificio->edificio}}</option>
                @endforeach 
            </select> 
        </div>
    </form>
    <form method="POST" action="{{route('roleclassupdate')}}" id="sala_form">
    @csrf
        <div class="col-md-12 pt-3">
            <strong>{{"Utilizador"}}</strong> : <strong>{{$utilizador}}</strong>    
        </div>
            <span>{{"Selecione as salas Permitidas para o Utilizador"}}</span>
        <div class="container-fluid pt-1">
            <strong>{{"Salas"}}</strong><br>
                @foreach ($salas as $key => $value)
                    <input type="checkbox" class="btn-check" id="{{$key}}" name="salas[]" {{(in_array($key, $salasexist,true)) ? 'checked' : ''}} autocomplete="off" value="{{ $key }}" onchange="document.getElementById('sala_form').submit()">
                    <label class="btn btn-outline-secondary mb-1" for="{{$key}}">{{ $key }}</label>
                @endforeach    
        </div>
            <input type="hidden" value="{{$id_unidade}}" name="unidade">
            <input type="hidden" value="{{$user}}" name="user">
    </form>       
</div>

<script>
$( '.select2' ).select2( {
    theme: 'bootstrap-5'
} );


$("#unidade_id").change(function(){
     $("#unidade_id_form").submit();
    
});

$("#user").change(function(){
     $("#unidade_id_form").submit();
     
});

$(document).ready(function(){
    $("#sala_form").on("change", "input:checkbox", function(){
        $("#sala_form").submit();
    });
});
</script>
@endsection