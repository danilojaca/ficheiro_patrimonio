@extends("layouts.app")

@section("content")
<div class="container pt-5">
    <nav class="navbar navbar-expand-sm bg-light">
        <div class="container-fluid">               
            <div class="container navbar-nav justify-content-center  ">
                <h2>{{"Categorias"}}</h2>
            </div>
            <ul class="navbar-nav">      
                <li class="nav-item">
                @can("role-create")
                    <a class="btn btn-primary" href="{{ route("bens.create") }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Cadastrar"><i class="bi bi-plus-lg"></i></a>
                @endcan
                </li>            
            </ul>
        </div>
    </nav>
</div> @if ($message = Session::get("success"))
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
    <div class="row g-2"> 
    <form class="row g-2" action="/registro/bens" method="GET" id="myForm">
       <div class="col-md-3">  
            <input  type="text" name="search" id="search" class="form-control" placeholder="Pesquisar Sub Categoria">
        </div>
        <div class="col-md-4">
        <button type="submit" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Pesquisar"><i class="bi bi-search"></i></button>  
         <a class="btn btn-primary" href="{{ route("bens.index") }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Limpar Pesquisa"><i class="bi bi-arrow-clockwise"></i></a>
        </div>    
    </form>
    </div>
 </div>     
<div class="container">             
  <table class="table table-bordered">
    <thead>
            <th>{{"Categoria"}}</th>
            <th>{{"Sub Categoria"}}</th>
            <th ></th> 
        </thead>
        <tbody>

        @foreach ($bens as $ben )
        <tr>
         <td>{{$ben->categoria}}</td>
         <td>{{$ben->sub_categoria}}</td>
         <td><div class="btn-group">             
            <button class="btn btn-outline-light text-dark" onclick="window.location.href='{{route('bens.edit', ['ben' => $ben->id])}}';" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar"><i class="bi bi-pencil-square"></i></button>
            <form  method="post" action="{{route("bens.destroy", ["ben" => $ben->id])}}">
            @method("DELETE")
            @csrf
            <button class="btn btn-outline-light text-dark" onclick="window.location.href='{{route('bens.destroy', ['ben' => $ben->id])}}';" data-bs-toggle="tooltip" data-bs-placement="top" title="Excluir"><i class="bi bi-trash"></i></button>           
            </form>
            </div> </td> 
            </tr>  
        @endforeach        
        </tbody>
  </table>
     {!! $bens->withQueryString()->links("pagination::bootstrap-5") !!}
</div>
@endsection
