@extends('layouts.app')

@section('content')
<div class="container pt-5">
    <div class="row ">
        <div class="col-md-12">
            <form action={{route('logusers.index')}} method='GET'>
            
        <div class="row g-2">
        <div class="col-md-3">
        </div>
                     
            <div class="col-md-2">
                <div class="form-floating">
                    <input  class="form-control @error('username') is-invalid @enderror" name='username' id="floatingInputGrid"  value="{{ old('username')}}">
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
                        <input type="date" class="form-control @error('data') is-invalid @enderror" name='data' id="floatingInputGrid"  value="{{ old('data')}}">
                        <label for="floatingInputGrid">Data</label>
                            @error('data')
                                 <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror                        
                    </div>
                </div> 
                <div class="col-md-2 pt-2">                
                <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i></button>
                <a href='{{ route('logusers.index') }}' class="btn btn-primary"><i class="bi bi-arrow-clockwise"></i></a>                
                </div>            
            </div>
            </form> 
        </div>
    </div>
</div>

<hr>
<div class="container mt-3">             
  <table class="table table-bordered">
    <thead>
        <tr>
            <th>{{"Utilizador"}}</th>
            <th>{{"Log"}}</th>
            <th>{{"IP"}}</th>
            <th>{{"Data e Hora"}}</th>                  
        </tr> 
    </thead>                  
    <tbody>
         @foreach ($log_users as $log)
         <tr>
            <td>{{$log->user}} </td>
            <td>{{$log->log}}</td>
            <td>{{$log->ip_remoto}}</td>
            <td>{{$log->created_at}}</td>                    
        </tr>
        @endforeach 
    </tbody>
  </table>
 {!! $log_users->withQueryString()->links("pagination::bootstrap-5") !!}
            
</div>

@endsection
