@extends('layouts.app')


@section('content')
<div class="container pt-5">
    <nav class="navbar navbar-expand-sm bg-light">
        <div class="container-fluid">               
            <div class="container navbar-nav justify-content-center  ">
                <h1>{{'Gerencia de Unidades'}}</h1>
            </div>
            <ul class="navbar-nav">      
                <li class="nav-item">
                    <a class="btn btn-primary" href="{{ route('roleclass') }}"><i class="bi bi-arrow-clockwise"></i></a>
                </li>            
            </ul>
        </div>
    </nav>
</div>
@if (count($errors) > 0)
    <div class="alert alert-danger alert-dismissible fade show">
        <strong>Whoops!</strong> There were some problems with your input.<br><br>
        <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<form method="GET" action="/registro/roles_salas" id="unidade_id_form">
<div class="row-col-1">
    <div class="col-md-7 offset-md-2">
        <select class="form-select @error('unidade_id') is-invalid @enderror" name="unidade_id" id="unidade_id"  aria-label="Default select example" >
            <option data-default disabled selected >{{"Selecione o Unidade"}}</option>
            @foreach ($unidades as $unidade)
                <option value="{{$unidade->unidade_id}}" {{$unidade->unidade_id == $id_unidade ? 'selected' : ''}}>{{$unidade->unidade->unidade}} | {{$unidade->unidade->edificio->edificio}}</option>
             @endforeach 
        </select> 
    </div>
<script>
$("#unidade_id").change(function(){
     $("#unidade_id_form").submit();
    
});
</script>
   <div id="cvs" class="col-md-7 pt-3 offset-md-2">
        <select class="form-select @error("unidade_id") is-invalid @enderror" name="user" id="user"  aria-label="Default select example" {{!empty($users) ? "" : "disabled"}} >
            <option data-default disabled selected >{{"Selecione o Usuario"}}</option> 
        @foreach ($users as $user)
            <option value="{{$user->user->id}}" >{{$user->user->name}}</option>
        @endforeach
        </select>
   </div>
</form>
<script>
$("#user").change(function(){
     $("#unidade_id_form").submit();
     
});
</script>
<form method="POST" action="{{route('roleclassupdate')}}">
 @csrf
    <div class="col-md-2 pt-3">
    @php
    use App\Models\User;

    $operador = User::where('id',$usuario)->pluck('name')->toArray();
    $operador = implode(",",$operador);

    @endphp
    <strong>Operador</strong>
            <input  type="text" class="form-control" value="{{$operador}}"  readonly>
    </div>
    <div class="col-md-6 pt-1">
        <strong>Salas</strong>
            <div class="form-check">
                @foreach ($salas as $key => $value)
                <input class="form-check-input" type="checkbox" value="{{$key}}" {{(in_array($key, $salasexist)) ? 'checked' : ''}} id="flexCheckDefault" name="salas[]">
                <label class="form-check-label" for="flexCheckDefault">{{$key}}</label>
                <br>
                @endforeach    
            </div>
            <input type="hidden" value="{{$id_unidade}}" name="unidade">
            <input type="hidden" value="{{$usuario}}" name="user">
    </div>
    <div class="col-md-12 text-center">
        <button type="submit" class="btn btn-primary">{{"Salvar"}}</button>
    </div>
</div>
</form>
@endsection