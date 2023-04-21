@extends('layouts.app')

@section('content')
<div class="container  ">
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
<div class="container mt-3">             
  <table class="table table-bordered">
    <thead>
            <th>Categoria</th>
            <th>Sub Categoria</th>
            <th colspan='2'></th> 
        </thead>
        <tbody>

        @foreach ($bens as $ben )
        <tr>
         <td>{{$ben->categoria}}</td>
         <td>{{$ben->sub_categoria}}</td>
         <td>
            <form  method="post" action="{{route('bens.destroy', ['ben' => $ben->id])}}">
            @method('DELETE')
            @csrf
            <button class="btn btn-outline-light text-dark" onclick="window.location.href='{{route('bens.destroy', ['ben' => $ben->id])}}';">Excluir</button>           
            </form>
            </td>
            <td><button class="btn btn-outline-light text-dark" onclick="window.location.href='{{route('bens.edit', ['ben' => $ben->id])}}';">Editar</button> </td> 
            </tr>  
        @endforeach        
        </tbody>
  </table>
    <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item">
                <a class="page-link" href="{{ $bens->previousPageUrl() }}" aria-label="Previous">
                  <span aria-hidden="true">&laquo;</span>
                </a>
                </li>
                 @for($i = 1; $i <= $bens->lastPage(); $i++)
                <li class="page-item {{ $bens->currentPage() == $i ? 'active' : '' }}">
                <a class="page-link" href="{{ $bens->url($i) }}">{{ $i }}</a>
                </li>
                 @endfor
                <a class="page-link" href="{{ $bens->nextPageUrl() }}" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
                </a>
                </li>
              </ul>
          </nav>     
     Exibindo {{$bens->count()}} Bens de {{$bens->total()}}
</div>
@endsection
