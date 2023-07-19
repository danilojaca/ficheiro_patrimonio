@extends('layouts.app')

@section('content')
<div class="container pt-5">
    <nav class="navbar navbar-expand-sm bg-light">
        <div class="container-fluid">               
            <div class="container navbar-nav justify-content-center  ">
                <h1>{{'Unidades'}}</h1>
            </div>
            <ul class="navbar-nav">      
                <li class="nav-item">
                @can('role-create')
                    <a class="btn btn-primary" href="{{ route('unidade.index') }}">Voltar</a>
                @endcan
                </li>            
            </ul>
        </div>
    </nav>
</div>
<div class="container">
        <form  class="row g-3" action={{route('unidade.update', ['unidade' => $unidade->id])}} method='POST' >
        @method('PUT')
         @csrf 
    <div class="col-md-3">
    </div>
  <div class="col-md-3">    
    <label  class="form-label">Edificio</label>
    <select class="form-select" name="edificio_id" aria-label="Default select example">
        <option selected>{{'Selecione o Edificio'}}</option>
        @foreach ($edificios as $edificio )
           <option value="{{$edificio->id}}" {{$edificio->edificio_id == $unidade->edificio_id? 'selected' : ''}}>{{$edificio->edificio}}</option> 
        @endforeach
    </select>
    @error('edificio_id')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
  </div>
  <div class="col-md-3">
    <label  class="form-label">Unidade</label>
    <input type="text" name='unidade' class="form-control @error('unidade') is-invalid @enderror" value="{{ $unidade->unidade ?? old('unidade')}}" >
    @error('unidade')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
  </div>
  
  
  <div class="col-md-1 pt-4 mt-4">
    <button type="submit" class="btn btn-primary">Editar</button>
  </div>
</form>
 </div>
@endsection
