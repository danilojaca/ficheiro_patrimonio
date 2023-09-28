@extends("layouts.app")

@section("content")
<div class="container pt-5">
    <nav class="navbar navbar-expand-sm bg-light">
        <div class="container-fluid">               
            <div class="container navbar-nav justify-content-center  ">
                <h2>{{"Unidades"}}</h2>
            </div>
            <ul class="navbar-nav">      
                <li class="nav-item">
                @can("role-create")
                    <a class="btn btn-primary" href="{{ route("unidade.create") }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Cadastrar"><i class="bi bi-plus-lg"></i></a>
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
    <div class="row g-2"> 
    <form  class="row g-2" action="/registro/unidade" method="GET" id="myForm">
             
        <div class="col-md-3">  
            <input  type="text" name="search" id="search" class="form-control" placeholder="Pesquisar Unidade">
             
        </div>
                <div class="col-md-4">
         <button type="submit" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Pesquisar"><i class="bi bi-search"></i></button>         
         <a class="btn btn-primary" href="{{ route("unidade.index") }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Limpar Pesquisa"><i class="bi bi-arrow-clockwise"></i></a>
        </div>
    </form>
    </div>
 </div> 
<div class="container">             
  <table class="table table-bordered">
    <thead>
                <th>{{"Edificio"}}</th>
                <th>{{"Unidade"}}</th>                
                <th colspan="2"></th>   
            </thead>
            <tbody>
            @foreach ($unidade as $uni )
                <tr>
                <td>{{$uni->edificio->edificio}}</td>
                <td>{{$uni->unidade}}</td>                
                <td>
                <div class="btn-group">  
                <button class="btn btn-outline-light text-dark" onclick="window.location.href='{{route('unidade.edit', ['unidade'=> $uni->id])}}';" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar"><i class="bi bi-pencil-square"></i></button>
                <form  method="post" action="{{route("unidade.destroy", ["unidade" => $uni->id])}}">
                    @method("DELETE")
                    @csrf
                    <button class="btn btn-outline-light text-dark" type="submit" data-bs-toggle="tooltip" data-bs-placement="top" title="Excluir"><i class="bi bi-trash"></i></button>           
                </form>
                 </div></td> 
                </tr>  
            @endforeach
            </tbody>
  </table>
     {!! $unidade->withQueryString()->links("pagination::bootstrap-5") !!}
</div>
@endsection