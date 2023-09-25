@extends("layouts.app")

@section("content")
<div class="container pt-5">
    <nav class="navbar navbar-expand-sm bg-light">
        <div class="container-fluid">               
            <div class="container navbar-nav justify-content-center  ">
                <h1>{{"Bens"}}</h1>
            </div>
            <ul class="navbar-nav g-3">      
                <li class="nav-item">
                @can("inventariomultiplos")
                    <a class="btn btn-primary" href="{{ route("inventariomultiplos.create") }}"><i class="bi bi-plus-circle-dotted"></i></a>
                @endcan
                </li> 
                <li class="nav-item">
                @can("role-create")
                    <a class="btn btn-primary" href="{{ route("inventario.create") }}"><i class="bi bi-plus-lg"></i></a>
                @endcan
                </li>
            </ul>            
        </div>
    </nav>
</div>
    @if ($message = Session::get("success"))
    <div class="alert alert-success alert-dismissible fade show">
        <p>{{ $message }}</p>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    @if ($message = Session::get("danger"))
    <div class="alert alert-danger alert-dismissible fade show">
        <p>{{ $message }}</p>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
<div class="container pb-2">    
    <div class="row g-2" >
        <form  class="row g-2" action="/registro/inventario" method="GET">
        <div class="col-md-4">  
            <input  type="text" autocomplete="off" name="search" id="search" class="form-control" placeholder="Filtrar Unidade , N Inventario ou Categoria">            
            <input type="submit" hidden />           
        </div> 
        <div class="col-md-4">  
         <a class="btn btn-primary" href="{{ route("inventario.index") }}"><i class="bi bi-arrow-clockwise"></i></a>
        </div>      
        </form>    
    </div>
</div>    
<div class="container">        
  <table class="table table-bordered" id="myTable">
     <thead>
        <tr>            
            <th>{{"Unidade"}}</th>
            <th>{{"Categoria"}}</th>
            <th>{{"Sala"}}</th>
            <th>{{"Modelo"}}</th>  
            <th>{{"Nº Inventario"}}</th>  
            <th>{{"Nº Serie"}}</th>  
            <th>{{"Bem Inventariado"}}</th>  
            <th>{{"Conservação"}}</th>
            <th colspan="2"></th>
        <tr>    
     </thead>
     <tbody>        
        @foreach ($inventarios as $inventario )
        <tr>       
            <td>{{$inventario->unidade->unidade}} | {{$inventario->unidade->edificio->edificio}}</td>       
            <td>{{$inventario->categoria->sub_categoria}}</td>
            <td>{{$inventario->sala}}</td>
            <td>{{$inventario->modelo}}</td>
            <td>{{$inventario->n_inventario}}</td>
            <td>{{$inventario->n_serie}}</td>
            <td>{{$inventario->bem_inventariado}}</td>
            <td>{{$inventario->conservacao}}</td>
            <td>
                <div class="btn-group"> 
                    @foreach ( $salas as $sala => $unidade)
                        @if ($inventario->unidade->id == $unidade && $inventario->sala == $sala)
                            @can("inventario-edit")
                                <button class="btn btn-outline-light text-dark" onclick="window.location.href='{{route('inventario.edit', ['inventario' => $inventario->id])}}';"><i class="bi bi-pencil-square"></i></button>
                            @endcan
                            @can("inventario-delete")
                                <form method="post" action="{{route("inventario.destroy", ["inventario" => $inventario->id])}}">
                                @method("DELETE")
                                @csrf
                                    <button class="btn btn-outline-light text-dark" onclick="window.location.href='{{route('inventario.destroy', ['inventario' => $inventario->id])}}';"><i class="bi bi-trash"></i></button>
                                </form>               
                            @endcan
                        @endif
                    @endforeach
                </div>
            </td> 
        </tr>   
        @endforeach
     </tbody>
  </table>
    {!! $inventarios->withQueryString()->links("pagination::bootstrap-5") !!}
</div>

@endsection