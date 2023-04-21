@extends('layouts.app')

@section('content')
<div class="container ">
<nav class="navbar navbar-expand-sm bg-light ">
  <div class="container-fluid">
    <ul class="navbar-nav">      
      <li class="nav-item">
        <a class="nav-link active" href="{{ route('inventario.create') }}">Novo</a>
      </li>
      <li class="nav-item">
        <a class="nav-link active" href="{{ route('inventario.index') }}">Consultar</a>
      </li>      
    </ul>
    <div class="container navbar-nav justify-content-center ">
    <h1>BENS</h1>
    </div>
  </div>
</nav>
</div>

<div class="container mt-4">
@if (isset($inventario->id))
        <form  class="row g-3" action={{route('inventario.update', ['inventario' => $inventario->id])}} method='POST' >
        @method('PUT')
         @csrf 
    @else
         <form class="row g-3" action="{{route('inventario.store')}}" method='POST' >
        @csrf
    @endif
  <div class="col-md-7">
        <label  class="form-label">Centro de Saude</label>    
      <select class="form-select" name="edificio_id" id="floatingSelectGrid" aria-label="Floating label select example" data-live-search="true" >
        <option data-default disabled selected>Selecione o Edificio</option>
        @foreach ($edificios as $edificio)
        <option value="{{$edificio->id}}" {{$edificio->id == $inventario->edificio_id ? 'selected' : ''}}>{{$edificio->edificio}}</option>
        @endforeach 
      </select>
  </div>
  <div class="col-md-4"> 
      <label  class="form-label">Categoria</label>   
      <select class="form-select" name="categoria" id="floatingSelectGrid" aria-label="Floating label select example" data-live-search="true" >
          <option data-default disabled selected>Selecione a Categoria</option>
          <optgroup label="Informatica">
          @foreach ($bens as $ben)
          @if ($ben->categoria === 'Informatica')
          <option value="{{$ben->sub_categoria}}" {{$ben->sub_categoria  == $inventario->categoria ? 'selected' : ''}}>{{$ben->sub_categoria}}</option>
          @endif 
          @endforeach
          </optgroup>
          <optgroup label="Clinico">
          @foreach ($bens as $ben)                                          
          @if ($ben->categoria === 'Clinico')
          <option value="{{$ben->sub_categoria}}" {{$ben->sub_categoria  == $inventario->categoria ? 'selected' : ''}} >{{$ben->sub_categoria}}</option>
          @endif 
          @endforeach
          </optgroup>
          <optgroup label="Mobiliario">
          @foreach ($bens as $ben)                                          
          @if ($ben->categoria === 'Mobiliario')
          <option value="{{$ben->sub_categoria}}" {{$ben->sub_categoria  == $inventario->categoria ? 'selected' : ''}}>{{$ben->sub_categoria}}</option>
          @endif 
          @endforeach
          </optgroup>
      </select>
    </div>
    <div class="col-md-1">
    <label  class="form-label">Sala</label>
    <input type="text" name='sala' class="form-control" value="{{$inventario->sala ?? old('sala')}}" >
  </div>
  <div class="col-md-2">
    <label  class="form-label">Modelo</label>
    <input type="text" name='modelo' class="form-control" value="{{$inventario->modelo ?? old('modelo')}}">
  </div>
  <div class="col-2">
    <label class="form-label">Nº Inventariado</label>
    <input type="text" name='n_inventario' class="form-control" value="{{$inventario->n_inventario ?? old('n_inventario')}}" >
  </div>
  <div class="col-3">
    <label class="form-label">Nº Serie</label>
    <input type="text" name='n_serie' class="form-control"value="{{$inventario->n_serie ?? old('n_serie')}}" >
  </div> 
      <div class="col-md-2"> 
    <label  class="form-label">Bem Inventariado</label>   
      <select class="form-select" name="bem_inventariado" id="floatingSelectGrid" aria-label="Floating label select example" data-live-search="true" >
        <option data-default disabled selected>Selecione uma Opção</option>
        <option value="Sim" {{$inventario->bem_inventariado == "Sim" ? 'selected' : '' }}>Sim</option>
        <option value="Nao" {{$inventario->bem_inventariado == "Nao" ? 'selected' : ''}}>Não</option>        
      </select>
  </div>
      <div class="col-md-3"> 
    <label  class="form-label">Estado de Conservação</label>   
      <select class="form-select" name="conservacao" id="floatingSelectGrid" aria-label="Floating label select example" data-live-search="true" >
        <option data-default disabled selected>Selecione o Estado de Conservação</option>
        <option value="Muito Bom" {{$inventario->conservacao == "Muito Bom" ? 'selected' : ''}}>Muito Bom</option>
        <option value="Bom" {{$inventario->conservacao == "Bom" ? 'selected' : ''}}>Bom</option>
        <option value="Razoavel" {{$inventario->conservacao == "Razoavel" ? 'selected' : ''}}>Razoavel</option>
        <option value="Mau" {{$inventario->conservacao == "Mau" ? 'selected' : ''}}>Mau</option>
        <option value="Avariado" {{$inventario->conservacao == "Avariado" ? 'selected' : ''}}>Avariado</option>
        <option value="Indefinido" {{$inventario->conservacao == "Indefinido" ? 'selected' : ''}}>Indefinido</option>
        <option value="Abatido" {{$inventario->conservacao == "Abatido" ? 'selected' : ''}}>Abatido</option>
       
      </select>
  </div>
 
  
  <div class="col-12">
  @if (isset($inventario->id))
    <button type="submit" class="btn btn-primary">Editar</button>
    @else
    <button type="submit" class="btn btn-primary">Cadastrar</button>
     @endif
  </div>
</form>
 </div>
@endsection
