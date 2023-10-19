@extends('layouts.app')

@section('content')
<div class="container pt-5">
    <nav class="navbar navbar-expand-sm bg-light">
        <div class="container-fluid">              
            <div class="container navbar-nav justify-content-center  ">
                <h2>{{'Gestão de Utilizador'}}</h2>
            </div>
        </div>
    </nav>
</div>
    @if ($message = Session::get('success'))
    <div class="alert alert-success alert-dismissible fade show">
        <p>{{ $message }}</p>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
<div class="container pb-2">    
    <div class="row g-2" >
        <form  class="row g-2" action="/registro/users" method="GET" id="search_form">
        <div class="col-md-4">  
            <input  type="text" autocomplete="off" name="search" id="search" class="form-control" placeholder="Pesquisar Utilizador" >        
        </div> 
        <div class="col-md-4">
            <button type="submit" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Pesquisar"><i class="bi bi-search"></i></button>
         <a class="btn btn-primary" href="{{ route("users.index") }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Limpar Pesquisa"><i class="bi bi-arrow-clockwise"></i></a>
        </div>      
        </form>    
    </div>
</div>    

<div class="container">   
    <table class="table table-bordered">
            <tr>
                <th>{{'Nº'}}</th>
                <th>{{'Nome'}}</th>        
                <th>{{'Funções'}}</th>
                <th width="280px">{{'Ação'}}</th>
            </tr>
        @foreach ($data as $key => $user)
            <tr>
                <td>{{ ++$i }}</td>
                <td>{{ $user->name }}</td>  
                <td>
                    @if(!empty($user->getRoleNames()))
                        @foreach($user->getRoleNames() as $v)
                           {{ $v }} {{count($user->getRoleNames()) > 1 ? " ," : ""}}
                        @endforeach
                    @endif
                </td>
                <td>
                @can('mostrar-permissao-utilizador')
                    <a class="btn btn-outline-light text-dark" href="{{ route('users.show',$user->id) }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Visualizar"><i class="bi bi-clipboard"></i></a>
                @endcan
                @can('editar-permissao-utilizador')    
                    <a class="btn btn-outline-light text-dark" href="{{ route('users.edit',$user->id) }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar"><i class="bi bi-pencil-square"></i></a>
                @endcan
                @can('visualizar-permissao-utilizador')     
                    <a class="btn btn-outline-light text-dark" href="{{ route('roleunidades.edit',$user->id) }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Permissão Unidades"><i class="bi bi-building"></i></a>
                @endcan
                @can('salas-permissao-utilizador')     
                    <a class="btn btn-outline-light text-dark" href="{{ route('roleclass',$user->id) }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Permissão Salas"><i class="bi bi-building-fill-gear"></i></a>
                @endcan
                                
                </td>
            </tr>
        @endforeach
    </table>
    {!! $data->withQueryString()->links("pagination::bootstrap-5") !!}
</div>



@endsection