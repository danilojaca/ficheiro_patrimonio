@extends('layouts.app')

@section('content')
<div class="container pt-5">
    <nav class="navbar navbar-expand-sm bg-light">
        <div class="container-fluid">               
            <div class="container navbar-nav justify-content-center  ">
                <h1>{{'UNIDADES'}}</h1>
            </div>
            <ul class="navbar-nav">      
                <li class="nav-item">
                @can('role-create')
                    <a class="btn btn-primary" href="{{ route('unidade.create') }}">Novo</a>
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
                <th>Edificio</th>
                <th>Unidade</th>                
                <th colspan='2'></th>   
            </thead>
            <tbody>
            @foreach ($unidade as $uni )
                <tr>
                <td>{{$uni->edificio->edificio}}</td>
                <td>{{$uni->unidade}}</td>                
                <td>
                <div class="btn-group">  
                <button class="btn btn-outline-light text-dark" onclick="window.location.href='{{route('unidade.edit', ['unidade'=> $uni->id])}}';"><i class="bi bi-pencil-square"></i></button>
                <form  method="post" action="{{route('unidade.destroy', ['unidade' => $uni->id])}}">
                    @method('DELETE')
                    @csrf
                    <button class="btn btn-outline-light text-dark" type="submit"><i class="bi bi-trash"></i></button>           
                </form>
                 </div></td> 
                </tr>  
            @endforeach
            </tbody>
  </table>
  <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item">
                <a class="page-link" href="{{ $unidade->previousPageUrl() }}" aria-label="Previous">
                  <span aria-hidden="true">&laquo;</span>
                </a>
                </li>
                 @for($i = 1; $i <= $unidade->lastPage(); $i++)
                <li class="page-item {{ $unidade->currentPage() == $i ? 'active' : '' }}">
                <a class="page-link" href="{{ $unidade->url($i) }}">{{ $i }}</a>
                </li>
                 @endfor
                <a class="page-link" href="{{ $unidade->nextPageUrl() }}" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
                </a>
                </li>
              </ul>
          </nav>     
     Exibindo {{$unidade->count()}} Bens de {{$unidade->total()}}
</div>
@endsection