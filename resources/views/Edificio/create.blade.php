@extends('layouts.app')

@section('content')
<div class="container pt-5">
<nav class="navbar navbar-expand-sm bg-light ">
  <div class="container-fluid">
    <ul class="navbar-nav">      
      <li class="nav-item">
        <a class="nav-link active" href="{{ route('edificio.create') }}">Novo</a>
      </li>
      <li class="nav-item">
        <a class="nav-link active" href="{{ route('edificio.index') }}">Consultar</a>
      </li>      
    </ul>
    <div class="container navbar-nav justify-content-center ">
    <h1>EDIFICIOS</h1>
    </div>
  </div>
</nav>
</div>

<div class="container">
@if (isset($edificio->id))
        <form  class="row g-3" action={{route('edificio.update', ['edificio' => $edificio->id])}} method='POST' >
        @method('PUT')
         @csrf 
    @else
         <form class="row g-3" action="{{route('edificio.store')}}" method='POST' >
        @csrf
    @endif
  <div class="col-md-3">    
    <label  class="form-label">ID Spms</label>
    <input type="text" name='id_spms' class="form-control @error('id_spms') is-invalid @enderror" value="{{ $edificio->id_spms ?? old('id_spms')}}">
    @error('id_spms')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
  </div>
  <div class="col-md-3">
    <label  class="form-label">SIIE Edificio</label>
    <input type="text" name='id_siie' class="form-control @error('id_siie') is-invalid @enderror" value="{{ $edificio->id_siie ?? old('id_siie')}}" >
    @error('id_siie')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
  </div>
  <div class="col-md-6">
    <label  class="form-label">Edificio</label>
    <input type="text" name='edificio' class="form-control @error('edificio') is-invalid @enderror" value="{{ $edificio->edificio ?? old('edificio')}}" >
    @error('edificio')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
  </div>
  <div class="col-6">
    <label class="form-label">Concelho</label>
    <input type="text" name='concelho' class="form-control @error('concelho') is-invalid @enderror" value="{{ $edificio->concelho ?? old('concelho')}}" >
    @error('concelho')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
  </div>
  <div class="col-6">
    <label class="form-label">Unidade</label>
    <input type="text" name='unidade' class="form-control @error('unidade') is-invalid @enderror" value="{{ $edificio->unidade ?? old('unidade')}}">
    @error('unidade')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
  </div> 
 
  
  <div class="col-12">
     @if (isset($edificio->id))
    <button type="submit" class="btn btn-primary">Editar</button>
    @else
    <button type="submit" class="btn btn-primary">Cadastrar</button>
     @endif
  </div>
</form>
 </div>
@endsection
