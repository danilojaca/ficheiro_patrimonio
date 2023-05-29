@extends('layouts.app')

@section('content')
<div class="container pt-5">
    <nav class="navbar navbar-expand-sm bg-light">
        <div class="container-fluid">               
            <div class="container navbar-nav justify-content-center  ">
                <h1>{{'EDIFICIOS'}}</h1>
            </div>
            <ul class="navbar-nav">      
                <li class="nav-item">
                @can('role-create')
                    <a class="btn btn-primary" href="{{ route('edificio.create') }}">Novo</a>
                @endcan
                </li>            
            </ul>
        </div>
    </nav>
</div>
<div class="container">             
  <table class="table table-bordered">
    <thead>
                <th>ID SPMS</th>
                <th>ID SIIE</th>
                <th>Edificio</th>
                <th>Concelho</th>
                <th>Unidade</th>
                <th colspan='2'></th>   
            </thead>
            <tbody>
            @foreach ($edificios as $edificio )
                <tr>
                <td>{{$edificio->id_spms}}</td>
                <td>{{$edificio->id_siie}}</td>
                <td>{{$edificio->edificio}}</td>
                <td>{{$edificio->concelho}}</td>
                <td>{{$edificio->unidade}}</td>
                <td>
                <div class="btn-group">  
                <button class="btn btn-outline-light text-dark" onclick="window.location.href='{{route('edificio.edit', ['edificio' => $edificio->id])}}';"><i class="bi bi-pencil-square"></i></button>

                <form method="post" action="{{route('edificio.destroy', ['edificio' => $edificio->id])}}">
                @method('DELETE')
                @csrf
                <button class="btn btn-outline-light text-dark" onclick="window.location.href='{{route('edificio.destroy', ['edificio' => $edificio->id])}}';"><i class="bi bi-trash"></i></button>           
                </form>
                 </div></td> 
                </tr>  
            @endforeach
            </tbody>
  </table>
  <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item">
                <a class="page-link" href="{{ $edificios->previousPageUrl() }}" aria-label="Previous">
                  <span aria-hidden="true">&laquo;</span>
                </a>
                </li>
                 @for($i = 1; $i <= $edificios->lastPage(); $i++)
                <li class="page-item {{ $edificios->currentPage() == $i ? 'active' : '' }}">
                <a class="page-link" href="{{ $edificios->url($i) }}">{{ $i }}</a>
                </li>
                 @endfor
                <a class="page-link" href="{{ $edificios->nextPageUrl() }}" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
                </a>
                </li>
              </ul>
          </nav>     
     Exibindo {{$edificios->count()}} Bens de {{$edificios->total()}}
</div>
@endsection