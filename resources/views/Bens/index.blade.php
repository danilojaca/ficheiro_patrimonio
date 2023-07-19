@extends('layouts.app')

@section('content')
<div class="container pt-5">
    <nav class="navbar navbar-expand-sm bg-light">
        <div class="container-fluid">               
            <div class="container navbar-nav justify-content-center  ">
                <h1>{{'Categorias'}}</h1>
            </div>
            <ul class="navbar-nav">      
                <li class="nav-item">
                @can('role-create')
                    <a class="btn btn-primary" href="{{ route('bens.create') }}">Novo</a>
                @endcan
                </li>            
            </ul>
        </div>
    </nav>
</div>
@if ($message = Session::get('success'))
    <div class="alert alert-success">
        <p>{{ $message }}</p>
    </div>
    @endif
<div class="container">             
  <table class="table table-bordered">
    <thead>
            <th>Categoria</th>
            <th>Sub Categoria</th>
            <th ></th> 
        </thead>
        <tbody>

        @foreach ($bens as $ben )
        <tr>
         <td>{{$ben->categoria}}</td>
         <td>{{$ben->sub_categoria}}</td>
         <td><div class="btn-group">             
            <button class="btn btn-outline-light text-dark" onclick="window.location.href='{{route('bens.edit', ['ben' => $ben->id])}}';"><i class="bi bi-pencil-square"></i></button>
            <form  method="post" action="{{route('bens.destroy', ['ben' => $ben->id])}}">
            @method('DELETE')
            @csrf
            <button class="btn btn-outline-light text-dark" onclick="window.location.href='{{route('bens.destroy', ['ben' => $ben->id])}}';"><i class="bi bi-trash"></i></button>           
            </form>
            </div> </td> 
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
