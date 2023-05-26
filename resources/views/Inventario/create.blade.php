@extends('layouts.app')

@section('content')
<div class="container pt-5">
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

<div class="container">
        <form class="row g-3" action="{{route('inventario.store')}}" method='POST' >
              @csrf   
              <div class="col-md-7">
              @if (auth()->user()->ou == 'Estagiarios')    
                  <label  class="form-label">Centro de Saude</label>    
                  <select class="form-select @error('edificio_id') is-invalid @enderror" name="edificio_id" id="floatingSelectGrid" aria-label="Floating label select example" data-live-search="true" >
                    <option data-default disabled selected >Selecione o Edificio</option>
                    @foreach ($edificios as $edificio)
                    <option value="{{$edificio->id}}" {{$edificio->id == old('edificio_id') ? 'selected' : ''}}>{{$edificio->edificio}}</option>
                    @endforeach 
                  </select>
              @else

              <input type='hidden' class="form-control @error('edificio_id') is-invalid @enderror" name='edificio_id' id="floatingInputGrid"  value={{$centro_edificio_id}}>
              <span>{{$centro_edificio}}</span>

              @endif
                  @error('edificio_id')
                    <span class="invalid-feedback" role="alert">
                       <strong>{{ $message }}</strong>
                    </span>
                  @enderror
              </div>
              <div class="col-md-4"> 
                  <label  class="form-label">Categoria</label>   
                  <select class="form-select @error('categoria') is-invalid @enderror" name="categoria" id="floatingSelectGrid" aria-label="Floating label select example" data-live-search="true" >
                    <option data-default disabled selected>Selecione a Categoria</option>
                    <optgroup label="Informatica">
                    @foreach ($bens as $ben)
                    @if ($ben->categoria === 'Informatica')
                        <option value="{{$ben->sub_categoria}}">{{$ben->sub_categoria}}</option>
                    @endif 
                    @endforeach
                    </optgroup>
                    <optgroup label="Clinico">
                    @foreach ($bens as $ben)                                          
                    @if ($ben->categoria === 'Clinico')
                      <option value="{{$ben->sub_categoria}}">{{$ben->sub_categoria}}</option>
                    @endif 
                    @endforeach
                    </optgroup>
                    <optgroup label="Mobiliario">
                    @foreach ($bens as $ben)                                          
                      @if ($ben->categoria === 'Mobiliario')
                      <option value="{{$ben->sub_categoria}}">{{$ben->sub_categoria}}</option>
                    @endif 
                    @endforeach
                    </optgroup>
                    <optgroup label="Outros">
                    @foreach ($bens as $ben)                                          
                      @if ($ben->categoria === 'Outros')
                      <option value="{{$ben->sub_categoria}}">{{$ben->sub_categoria}}</option>
                    @endif 
                    @endforeach
                    </optgroup>
                  </select>
                  @error('categoria')
                    <span class="invalid-feedback" role="alert">
                       <strong>{{ $message }}</strong>
                    </span>
                  @enderror
              </div>
              <div class="col-md-1">              
                  <label  class="form-label ">Sala</label>
                  <input type="text" name='sala' class="form-control @error('sala') is-invalid @enderror"  value="{{ old('sala')}}">
                  @error('sala')
                    <span class="invalid-feedback" role="alert">
                       <strong>{{ $message }}</strong>
                    </span>
                  @enderror
              </div>
              <div class="col-md-2">
                  <label  class="form-label">Modelo</label>
                  <input type="text" name='modelo' class="form-control @error('modelo') is-invalid @enderror" value="{{ old('modelo')}}" >
                   @error('modelo')
                    <span class="invalid-feedback" role="alert">
                       <strong>{{ $message }}</strong>
                    </span>
                  @enderror
              </div>
              <div class="col-2">
                  <label class="form-label">Nº Inventariado</label>
                  <input type="text" name='n_inventario' class="form-control @error('n_inventario') is-invalid @enderror" value="{{ old('n_inventario')}}" >
                   @error('n_inventario')
                    <span class="invalid-feedback" role="alert">
                       <strong>{{ $message }}</strong>
                    </span>
                  @enderror
              </div>
              <div class="col-3">
                  <label class="form-label">Nº Serie</label>
                  <input type="text" name='n_serie' class="form-control @error('n_serie') is-invalid @enderror" value="{{ old('n_serie')}}" >
                   @error('n_serie')
                    <span class="invalid-feedback" role="alert">
                       <strong>{{ $message }}</strong>
                    </span>
                  @enderror
              </div> 
              <div class="col-md-2"> 
                  <label  class="form-label">Bem Inventariado</label>   
                  <select class="form-select @error('bem_inventariado') is-invalid @enderror" name="bem_inventariado" id="floatingSelectGrid" aria-label="Floating label select example" data-live-search="true" >
                    <option data-default disabled selected>Selecione uma Opção</option>
                    <option value="Sim">Sim</option>
                    <option value="Nao">Não</option>
                  </select>
                   @error('bem_inventariado')
                    <span class="invalid-feedback" role="alert">
                       <strong>{{ $message }}</strong>
                    </span>
                  @enderror
              </div>
              <div class="col-md-3"> 
                  <label  class="form-label">Estado de Conservação</label>   
                  <select class="form-select @error('conservacao') is-invalid @enderror" name="conservacao" id="floatingSelectGrid" aria-label="Floating label select example" data-live-search="true" >
                    <option data-default disabled selected >Selecione o Estado de Conservação</option>
                    <option value="Muito Bom" >Muito Bom</option>
                    <option value="Bom">Bom</option>
                    <option value="Razoavel">Razoavel</option>
                    <option value="Mau">Mau</option>
                    <option value="Avariado">Avariado</option>
                    <option value="Indefinido">Indefinido</option>
                    <option value="Abatido">Abatido</option>       
                  </select>
                   @error('conservacao')
                    <span class="invalid-feedback" role="alert">
                       <strong>{{ $message }}</strong>
                    </span>
                  @enderror
              </div>  
              <div class="col-12"> 
                  <button type="submit" class="btn btn-primary">Cadastrar</button>     
              </div>
        </form>
</div>
@endsection
