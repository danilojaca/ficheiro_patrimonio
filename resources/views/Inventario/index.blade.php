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
  <table class="table table-bordered">
     <thead>
        <tr>            
            <th >Edificio</th>
            <th>Categoria</th>
            <th>Sala</th>
            <th>Modelo</th>  
            <th>Nº Inventario</th>  
            <th>Nº Serie</th>  
            <th>Bem Inventariado</th>  
            <th>Conservação</th>
            <th colspan="2"></th>
            <tr>    
        </thead>
        <tbody>        
        @foreach ($inventarios as $inventario )
        <tr>       
         <td>{{$inventario->edificio->edificio}}</td>       
         <td>{{$inventario->categoria}}</td>
         <td>{{$inventario->sala}}</td>
         <td>{{$inventario->modelo}}</td>
         <td>{{$inventario->n_inventario}}</td>
         <td>{{$inventario->n_serie}}</td>
         <td>{{$inventario->bem_inventariado}}</td>
         <td>{{$inventario->conservacao}}</td>
         <td>
         <div class="btn-group"> 
         <button class="btn btn-outline-light text-dark" onclick="window.location.href='{{route('inventario.edit', ['inventario' => $inventario->id])}}';"><i class="bi bi-pencil-square"></i></button>
         <form method="post" action="{{route('inventario.destroy', ['inventario' => $inventario->id])}}">
            @method('DELETE')
            @csrf
            <button class="btn btn-outline-light text-dark" onclick="window.location.href='{{route('inventario.destroy', ['inventario' => $inventario->id])}}';"><i class="bi bi-trash"></i></button>           
            </form>
             </div></td> 
            </tr>   
        @endforeach
        </tbody>
  </table>
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item">
                <a class="page-link" href="{{ $inventarios->previousPageUrl() }}" aria-label="Previous">
                  <span aria-hidden="true">&laquo;</span>
                </a>
                </li>
                 @for($i = 1; $i <= $inventarios->lastPage(); $i++)
                <li class="page-item {{ $inventarios->currentPage() == $i ? 'active' : '' }}">
                <a class="page-link" href="{{ $inventarios->url($i) }}">{{ $i }}</a>
                </li>
                 @endfor
                <a class="page-link" href="{{ $inventarios->nextPageUrl() }}" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
                </a>
                </li>
              </ul>
          </nav>     
     Exibindo {{$inventarios->count()}} Bens de {{$inventarios->total()}}
</div>
@endsection