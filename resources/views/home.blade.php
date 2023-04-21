@extends('layouts.app')

@section('content')
    <div class="container-fluid p-5 bg-light text-dark text-center">
        <h1>Ficheiro de Patrimonio</h1>   
    </div>  
    <div class="container ">
        <div class="row "> 
            <div class="d-grid gap-2 col-6 mx-auto">
                 <button type="button"  class="btn btn-outline-primary  btn-lg" onclick="window.location.href='{{ route('formulario.index') }}';" >
                Formulario
                </button> 
            </div>            
            <div class="d-grid gap-2 col-6 mx-auto">
                <button type="button" class="btn btn-outline-primary dropdown-toggle btn-lg " data-bs-toggle="dropdown">
                 Registo
                </button>
                <ul class="dropdown-menu ">
                    <li><a class="dropdown-item" href="{{ route('inventario.index') }}">Bens</a></li>
                    <li><a class="dropdown-item" href="{{ route('edificio.index') }}">Edificio</a></li>
                    <li><a class="dropdown-item" href="{{ route('bens.index') }}">Categoria</a></li>
                </ul>
            </div>                   
        </div>
    </div>

@endsection
