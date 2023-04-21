@extends('layouts.app')

@section('content')
<div class="container ">
<nav class="navbar navbar-expand-sm bg-light ">
  <div class="container-fluid">
    <ul class="navbar-nav">      
      <li class="nav-item">
        <a class="nav-link active" href="{{ route('bens.create') }}">Novo</a>
      </li>
      <li class="nav-item">
        <a class="nav-link active" href="{{ route('bens.index') }}">Consultar</a>
      </li>      
    </ul>
    <div class="container navbar-nav justify-content-center ">
    <h1>Categorias</h1>
    </div>
  </div>
</nav>
</div>

<div class="container mt-4">
@if (isset($ben->id))
        <form  class="row g-3" action={{route('bens.update', ['ben' => $ben->id])}} method='POST' >
        @method('PUT')
         @csrf 
    @else
         <form class="row g-3" action="{{route('bens.store')}}" method='POST' >
        @csrf
    @endif
    <div class="col-md-4">    
    
  </div>
  <div class="col-md-3">    
    <label  class="form-label">Categoria</label>
    <input type="text" name='categoria' class="form-control @error('categoria') is-invalid @enderror" value="{{$ben->categoria ?? old('categoria')}}" >
    @error('categoria')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
  </div>
  <div class="col-md-3">
    <label  class="form-label">Sub Categoria</label>
    <input type="text" name='sub_categoria' class="form-control @error('sub_categoria') is-invalid @enderror"  value="{{$ben->sub_categoria ?? old('sub_categoria')}}" >
    @error('sub_categoria')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
  </div>
  <div class="col-md-4">    
    
  </div>
  <div class="col-7">
     @if (isset($ben->id))
    <button type="submit" class="btn btn-primary">Editar</button>
    @else
    <button type="submit" class="btn btn-primary">Cadastrar</button>
     @endif
  </div>
</form>
 </div>
@endsection
