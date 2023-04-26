@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row ">
        <div class="col-md-12">
            <form action={{route('logs.index')}} method='GET'>
            @csrf
        <div class="row g-2">
        <div class="col-md-3">
        
        </div>                     
            <div class="col-md-2">
                <div class="form-floating">
                    <input  class="form-control @error('username') is-invalid @enderror" name='username' id="floatingInputGrid"  value="{{ old('search1')}}">
                    <label for="floatingInputGrid">Usuario</label>
                            @error('username')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror                        
                </div>
            </div>         
                <div class="col-md-2">
                    <div class="form-floating">
                        <input type="date" class="form-control @error('data') is-invalid @enderror" name='data' id="floatingInputGrid"  value="{{ old('search1')}}">
                        <label for="floatingInputGrid">Data</label>
                            @error('data')
                                 <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror                        
                    </div>
                </div> 
                <div class="col-md-2">                
                <button type="submit" class="btn btn-primary">Pesquisar</button>
                <a href='{{ route('logs.index') }}' class="btn btn-primary">Limpar</a>                
                </div>            
            </div>
            </form> 
        </div>
    </div>
</div>

<hr>
<div class="container mt-">             
  <table class="table table-bordered">
    <thead>
        <tr>
            <th>Usuario</th>
            <th>Log</th>
            <th>Ação</th>
            <th>Data e Hora</th>                  
        </tr> 
    </thead>                  
    <tbody>
         @foreach ($logs as $log )
         <tr>
            <td>{{$log->user->username}} </td>
            <td>{{$log->log}}</td>
            <td>{{$log->operacao}}</td>
            <td>{{$log->created_at}}</td>                    
        </tr>
        @endforeach 
    </tbody>
  </table>
            
</div>

@endsection
