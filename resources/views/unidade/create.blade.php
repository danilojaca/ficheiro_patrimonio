@extends('layouts.app')

@section('content')
<div class="container pt-5">
    <nav class="navbar navbar-expand-sm bg-light">
        <div class="container-fluid">               
            <div class="container navbar-nav justify-content-center  ">
                <h2>{{'Unidades'}}</h2>
            </div>
            <ul class="navbar-nav">      
                <li class="nav-item">
                    <a class="btn btn-primary" href="{{ route('unidade.index') }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Voltar"><i class="bi bi-reply-fill"></i></a>
                </li>            
            </ul>
        </div>
    </nav>
</div>
<div class="container">
    <form class="row g-3" action="{{route('unidade.store')}}" method='POST' >
            @csrf
        <div class="col-md-6 offset-md-1">    
                <label  class="form-label">{{"Edificio"}}</label>
                <select class="form-select @error('edificio_id') is-invalid @enderror" name="edificio_id" data-placeholder="Selecione o Edificio" id="edificio_id">
                        <option data-default disabled selected></option>
                    @foreach ($edificios as $edificio )
                        <option value="{{$edificio->id}}" {{ old('edificio_id') ? 'selected':''}}>{{$edificio->edificio}}</option> 
                    @endforeach
                </select>
            @error('edificio_id')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="col-md-3">
                <label  class="form-label">{{"Unidade"}}</label>
                <input type="text" name='unidade' class="form-control bg-white @error('unidade') is-invalid @enderror" value="{{ old('unidade')}}" >
            @error('unidade')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="col-md-1 pt-4 mt-4">
            <button type="submit" class="btn btn-primary">{{"Cadastrar"}}</button>
        </div>
    </form>
</div>
<script>
$( '#edificio_id' ).select2( {
    theme: 'bootstrap-5'
} );
</script>
@endsection
