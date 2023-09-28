@extends("layouts.app")

@section("content")
<div class="container pt-5">
    <nav class="navbar navbar-expand-sm bg-light">
        <div class="container-fluid">               
            <div class="container navbar-nav justify-content-center  ">
                <h2>{{"Edificios"}}</h2>
            </div>
            <ul class="navbar-nav">      
                <li class="nav-item">
                @can("role-create")
                    <a class="btn btn-primary" href="{{ route("edificio.index") }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Voltar"><i class="bi bi-reply-fill"></i></a>
                @endcan
                </li>            
            </ul>
        </div>
    </nav>
</div>
<div class="container">
@if (isset($edificio->id))
        <form  class="row g-3" action={{route("edificio.update", ["edificio" => $edificio->id])}} method="POST" >
        @method("PUT")
         @csrf 
    @else
         <form class="row g-3" action="{{route("edificio.store")}}" method="POST" >
        @csrf
    @endif
  <div class="col-md-1">    
    <label  class="form-label">{{"ID Spms"}}</label>
    <input type="text" name="id_spms" id="id_spms" class="form-control @error("id_spms") is-invalid @enderror" value="{{ $edificio->id_spms ?? old("id_spms")}}">
    @error("id_spms")
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
  </div>
  <div class="col-md-1">
    <label  class="form-label">{{"SIIE Edificio"}}</label>
    <input type="text" name="id_siie" id="id_siie" class="form-control @error("id_siie") is-invalid @enderror" value="{{ $edificio->id_siie ?? old("id_siie")}}" >
    @error("id_siie")
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
  </div>
  <div class="col-md-7">
    <label  class="form-label">{{"Edificio"}}</label>
    <input type="text" name="edificio" id="edificio" class="form-control @error("edificio") is-invalid @enderror" value="{{ $edificio->edificio ?? old("edificio")}}" >
    @error("edificio")
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
  </div>
  <div class="col-md-3">
    <label class="form-label">{{"Concelho"}}</label>
    <input type="text" name="concelho" id="concelho" class="form-control @error("concelho") is-invalid @enderror" value="{{ $edificio->concelho ?? old("concelho")}}" >
    @error("concelho")
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
  </div>
  <div class="col-md-3">
    <label class="form-label">{{"Aces"}}</label>
    <input type="text" name="aces" id="aces" class="form-control @error("aces") is-invalid @enderror" value="{{ $edificio->aces ?? old("aces")}}">
    @error("aces")
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
  </div>
  <div class="col-md-6">
    <label class="form-label">{{"Morada"}}</label>
    <input type="text" name="morada" id="morada" class="form-control @error("morada") is-invalid @enderror" value="{{ $edificio->morada ?? old("morada")}}">
    @error("morada")
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
  </div>
  <div class="col-md-1">
    <label class="form-label">{{"CP"}}</label>
    <input type="text" name="cp" id="cp" class="form-control @error("cp") is-invalid @enderror"value="{{ $edificio->cp ?? old("cp")}}">
    @error("cp")
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
  </div>
  <div class="col-md-2">
    <label class="form-label">{{"Dias Funcionamento"}}</label>
    <input type="text" name="dias_funcionamento" id="dias_funcionamento" class="form-control @error("dias_funcionamento") is-invalid @enderror" value="{{ $edificio->dias_funcionamento ?? old("dias_funcionamento")}}">
    @error("dias_funcionamento")
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
  </div>
  <div class="col-md-3">
    <label class="form-label">{{"Horarios Funcionamento"}}</label>
    <input type="text" name="horarios_funcionamento" id="horarios_funcionamento"  class="form-control @error("horarios_funcionamento") is-invalid @enderror" value="{{ $edificio->horarios_funcionamento ?? old("horarios_funcionamento")}}">
    @error("horarios_funcionamento")
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
  </div>
  <div class="col-md-3">
    <label class="form-label">{{"IP Router"}}</label>
    <input type="text" name="ip_router" class="form-control @error("ip_router") is-invalid @enderror" value="{{ $edificio->ip_router ?? old("ip_router")}}">
    @error("ip_router")
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
  </div>   
 <div class="col-md-5">
 </div>
  <div class="col-md-1 pt-4">
     @if (isset($edificio->id))
    <button type="submit" class="btn btn-primary">{{"Editar"}}</button>
    @else
    <button type="submit" class="btn btn-primary">{{"Cadastrar"}}</button>
     @endif
  </div>
</form>
 </div>
@endsection
