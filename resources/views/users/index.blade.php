@extends('layouts.app')

@section('content')
<div class="container pt-5">
    <nav class="navbar navbar-expand-sm bg-light">
        <div class="container-fluid">              
            <div class="container navbar-nav justify-content-center  ">
                <h1>{{'Gestão de Utilizador'}}</h1>
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
                    <a class="btn btn-outline-light text-dark" href="{{ route('users.show',$user->id) }}"><i class="bi bi-clipboard"></i></a>
                    <a class="btn btn-outline-light text-dark" href="{{ route('users.edit',$user->id) }}"><i class="bi bi-pencil-square"></i></a>
                    <a class="btn btn-outline-light text-dark" href="{{ route('roleunidades.edit',$user->id) }}"><i class="bi bi-house-gear"></i></a>                
                </td>
            </tr>
        @endforeach
    </table>
    {!! $data->withQueryString()->links("pagination::bootstrap-5") !!}
</div>



@endsection