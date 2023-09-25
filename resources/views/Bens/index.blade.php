@extends("layouts.app")

@section("content")
<div class="container pt-5">
    <nav class="navbar navbar-expand-sm bg-light">
        <div class="container-fluid">               
            <div class="container navbar-nav justify-content-center  ">
                <h1>{{"Categorias"}}</h1>
            </div>
            <ul class="navbar-nav">      
                <li class="nav-item">
                @can("role-create")
                    <a class="btn btn-primary" href="{{ route("bens.create") }}"><i class="bi bi-plus-lg"></i></a>
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
            <button class="btn btn-outline-light text-dark" onclick="window.location.href='{{route('bens.edit', ['ben' => $ben->id])}}';"><i class="bi bi-pencil-square"></i></button>
            <form  method="post" action="{{route("bens.destroy", ["ben" => $ben->id])}}">
            @method("DELETE")
            @csrf
            <button class="btn btn-outline-light text-dark" onclick="window.location.href='{{route('bens.destroy', ['ben' => $ben->id])}}';"><i class="bi bi-trash"></i></button>           
            </form>
            </div> </td> 
            </tr>  
        @endforeach        
        </tbody>
  </table>
     {!! $bens->withQueryString()->links("pagination::bootstrap-5") !!}
</div>
@endsection
