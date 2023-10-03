@extends('layouts.app')


@section('content')
<div class="container pt-5">
    <nav class="navbar navbar-expand-sm bg-light">
        <div class="container-fluid">               
            <div class="container navbar-nav justify-content-center  ">
                <h1>{{'Gestão de Unidades'}}</h1>
            </div>
            <ul class="navbar-nav">      
                <li class="nav-item">
                    <a class="btn btn-primary" href="{{ route('users.index') }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Voltar"><i class="bi bi-reply-fill"></i></a>
                </li>            
            </ul>
        </div>
    </nav>
</div>
<form  action={{route('roleunidades.update', ['roleunidade' => $users->id])}} method='POST' >
        @method('PATCH')
         @csrf
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>{{"Name:"}}</strong>
             <label>{{ $users->name }}</label>             
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>{{"Unidades:"}}</strong>
            <select class="form-select " size="30" multiple aria-label="multiple select example" name="unidade_id[]">
             @foreach($unidades as $unidade)             
            <option value="{{$unidade->id }}" {{(in_array($unidade->id, $roleunidades)) ? 'selected' : ''}}>{{$unidade->unidade}} | {{$unidade->edificio->edificio}}</option>
            @endforeach
            </select>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 text-center p-4">
        <button type="submit" class="btn btn-primary">{{"Salvar"}}</button>
    </div>
</div>
</form>




@endsection
