@extends("layouts.app")

@section("content")
<div class="container pt-5">
    <nav class="navbar navbar-expand-sm bg-light">
        <div class="container-fluid">               
            <div class="container navbar-nav justify-content-center  ">
                <h1>{{"EDIFICIOS"}}</h1>
            </div>
            <ul class="navbar-nav">      
                <li class="nav-item">
                @can("role-create")
                    <a class="btn btn-primary" href="{{ route("edificio.create") }}"><i class="bi bi-plus-lg"></i></a>
                @endcan
                </li>            
            </ul>
        </div>
    </nav>
</div>
@if ($message = Session::get("success"))
    <div class="alert alert-success">
        <p>{{ $message }}</p>
    </div>
    @endif
<div class="container pb-2"> 
    <div class="row g-2"> 
    <form class="row g-2" action="/registro/edificio" method="GET" id="myForm">
       <div class="col-md-3">  
            <input  type="text" name="search" id="search" class="form-control" placeholder="Filtrar Edificio">
            <input type="submit" hidden /> 
        </div>
        <div class="col-md-4">  
         <a class="btn btn-primary" href="{{ route("edificio.index") }}"><i class="bi bi-arrow-clockwise"></i></a>
        </div>    
    </form>
    </div>
 </div>    
<div class="container">             
  <table class="table table-bordered">
    <thead>
                <th>{{"ID SPMS"}}</th>
                <th>{{"ID SIIE"}}</th>
                <th>{{"Edificio"}}</th>
                <th>{{"Concelho"}}</th>
                <th>{{"Aces"}}</th>
                <th>{{"Morada"}}</th>
                <th>{{"CP"}}</th>
                <th colspan="2">{{"Horario"}}</th>
                <th>{{"IP Router"}}</th>
                <th colspan="2"></th>   
            </thead>
            <tbody>
            @foreach ($edificios as $edificio )
                <tr>
                <td>{{$edificio->id_spms}}</td>
                <td>{{$edificio->id_siie}}</td>
                <td>{{$edificio->edificio}}</td>
                <td>{{$edificio->concelho}}</td>
                <td>{{$edificio->aces}}</td>
                <td>{{$edificio->morada}}</td>
                <td>{{$edificio->cp}}</td>
                <td>{{$edificio->dias_funcionamento}}</td>
                <td>{{$edificio->horarios_funcionamento}}</td>
                <td>{{$edificio->ip_router}}</td>
                <td>
                <div class="btn-group">  
                <button class="btn btn-outline-light text-dark" onclick="window.location.href='{{route('edificio.edit', ['edificio' => $edificio->id])}}';"><i class="bi bi-pencil-square"></i></button>

                <form method="post" action="{{route("edificio.destroy", ["edificio" => $edificio->id])}}">
                @method("DELETE")
                @csrf
                <button class="btn btn-outline-light text-dark" onclick="window.location.href='{{route('edificio.destroy', ['edificio' => $edificio->id])}}';"><i class="bi bi-trash"></i></button>           
                </form>
                 </div></td> 
                </tr>  
            @endforeach
            </tbody>
  </table>
     {!! $edificios->withQueryString()->links("pagination::bootstrap-5") !!}
</div>
@endsection