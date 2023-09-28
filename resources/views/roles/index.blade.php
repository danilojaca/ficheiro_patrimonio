@extends('layouts.app')

@section('content')

<div class="container pt-5">
    <nav class="navbar navbar-expand-sm bg-light">
        <div class="container-fluid">               
            <div class="container navbar-nav justify-content-center  ">
                <h1>{{'Gestão de Perfil'}}</h1>
            </div>
            <ul class="navbar-nav">      
                <li class="nav-item">
                @can('role-create')
                    <a class="btn btn-primary" href="{{ route('roles.create') }}"><i class="bi bi-plus-lg"></i></a>
                @endcan
                </li>            
            </ul>
        </div>
    </nav>
</div>
@if ($message = Session::get('success'))
    <div class="alert alert-success alert-dismissible fade show">
        <p>{{ $message }}</p>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif


<table class="table table-bordered">
    <tr>
        <th>{{'Nº'}}</th>
        <th>{{'Nome'}}</th>
        <th width="280px">{{'Ação'}}</th>
    </tr>
    
    @foreach ($roles as $key => $role)
    <tr>
        <td>{{ ++$i }}</td>
        <td>{{ $role->name }}</td>
        <td><div class="btn-group"> 
            @can('role-list')
            <a class="btn btn-outline-light text-dark" href="{{ route('roles.show',$role->id) }}"><i class="bi bi-clipboard"></i></a>
            @endcan
            @can('role-edit')
                <a class="btn btn-outline-light text-dark" href="{{ route('roles.edit',$role->id) }}"><i class="bi bi-pencil-square"></i></a>
            @endcan
            @can('role-delete')            
            <form method="post" action="{{route('roles.destroy', ['role' => $role->id])}}">
            @method('DELETE')
            @csrf
            <button class="btn btn-outline-light text-dark" type="submit"><i class="bi bi-trash"></i></button>           
            </form>             
            @endcan
            </div>
        </td>
    </tr>
    @endforeach
</table>


{!! $roles->withQueryString()->links("pagination::bootstrap-5") !!}



@endsection