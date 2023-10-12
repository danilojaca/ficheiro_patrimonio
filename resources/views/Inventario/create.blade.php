@extends('layouts.app')

@section('content')
<div class="container pt-5">
    <nav class="navbar navbar-expand-sm bg-light">
        <div class="container-fluid">               
            <div class="container navbar-nav justify-content-center  ">
                <h2>{{' Bens Imóveis e Património'}}</h2>
            </div>
            <ul class="navbar-nav">      
                <li class="nav-item">
                    <a class="btn btn-primary" href="{{ route('inventario.index') }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Voltar"><i class="bi bi-reply-fill"></i></a>
                </li>            
            </ul>
        </div>
    </nav>
</div>
<div class="container">
  <form action="/registro/inventario/create" method="GET" id="unidade_id_form">      
  <div class="col-md-12">   
        <label  class="form-label">{{"Unidade de Saude"}}</label>    
      <select class="form-select @error('unidade') is-invalid @enderror" name="unidade" id="unidade" aria-label="Default select example" data-placeholder="Selecione a Unidade" >
                    <option data-default disabled selected ></option>
                    @foreach ($roleunidades as $roleunidade)
                    <option value="{{$roleunidade->unidade_id}}" {{$roleunidade->unidade_id == $unidade_id ? 'selected' : ''}}>{{$roleunidade->unidade->unidade}} | {{$roleunidade->unidade->edificio->edificio}}</option>
                    @endforeach 
                  </select>              
                  @error('unidade')
        <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
        </span>
      @enderror
  </div>
  </form>
<script>
$( '#unidade' ).select2( {
    theme: 'bootstrap-5'
} );
$("#unidade").change(function(){
    $("#unidade_id_form").submit();     
});
</script>
@if(!empty($unidade_id))
    <form class="row g-3" action="{{route('inventario.store')}}" method='POST' >
      @csrf
    <input type="hidden" name="unidade_id" value="{{$unidade_id}}">  
    <div class="col-md-3">
      <label  class="form-label ">{{"Sala"}}</label>
      <select class="form-select @error('sala') is-invalid @enderror" name="sala" id="sala" data-placeholder="Selecione a Sala"  >
              <option data-default disabled selected ></option>
                    @foreach ($salas as $sala)
                    <option value="{{$sala}}"{{$sala  == old("sala") ? 'selected' : ''}}>{{$sala}}</option>
                    @endforeach 
                  </select>
      @error('sala')
        <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
        </span>
      @enderror
  </div>
  <script>
$( '#sala' ).select2( {
    theme: 'bootstrap-5'
} );
</script>
    <div class="col-md-4"> 
      <label  class="form-label">{{"Categoria"}}</label>   
       <select class="form-select @error('categoria_id') is-invalid @enderror" name="categoria_id" id="categoria_id" data-placeholder="Selecione a Categoria">
                    <option data-default disabled selected></option>
                      @foreach ($categorias as $categoria)
                        <optgroup label="{{$categoria}}">
                          @foreach ($bens as $ben)
                            @if ($ben->categoria === $categoria)
                              <option value="{{$ben->id}}" {{$ben->id  == old("categoria_id") ? 'selected' : ''}}>{{$ben->sub_categoria}}</option>
                            @endif 
                          @endforeach
                        </optgroup>
                      @endforeach                     
                  </select>
      @error('categoria_id')
        <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
        </span>
      @enderror
    </div>
 <script>
$( '#categoria_id' ).select2( {
    theme: 'bootstrap-5'
} );
</script>   
  <div class="col-md-3">
    <label  class="form-label ">{{"Modelo"}}</label>
    <input type="text" name='modelo' class="form-control bg-white @error('modelo') is-invalid @enderror" value="{{ old('modelo')}}" >
      @error('modelo')
        <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
        </span>
      @enderror
  </div>
  <div class="col-md-2">
    <label class="form-label ">{{"Nº Inventario"}}</label>
    <input type="text" name='n_inventario' class="form-control bg-white @error('n_inventario') is-invalid @enderror" value="{{ old('n_inventario')}}" >
      @error('n_inventario')
        <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
        </span>
      @enderror
  </div>
  <div class="col-md-3">
    <label class="form-label ">{{"Nº Serie"}}</label>
    <input type="text" name='n_serie' class="form-control bg-white @error('n_serie') is-invalid @enderror"value="{{ old('n_serie')}}" >
      @error('n_serie')
        <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
        </span>
      @enderror
  </div>
      <div class="col-md-4"> 
    <label  class="form-label">{{"Estado de Conservação"}}</label>   
      <select class="form-select @error('conservacao') is-invalid @enderror" name="conservacao"  data-placeholder="Selecione o Estado de Conservação" id="conservacao">
        <option data-default disabled selected></option>
        @foreach ( $conservacao as $conservar )
            <option value="{{$conservar}}" {{$conservar == old("conservacao") ? 'selected' : ''}}>{{$conservar}}</option>  
        @endforeach
               
      </select>
      @error('conservacao')
        <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
        </span>
      @enderror
  </div>
    <script>
$( '#conservacao' ).select2( {
    theme: 'bootstrap-5'
} );
</script>
  <div class="col-md-11">
    </div>
  <div class="col-md-1">
    <button type="submit" class="btn btn-primary">{{"Cadastrar"}}</button>     
  </div>
</form>
@endif
 </div>
@endsection
