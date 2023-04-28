@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row ">
        <div class="col-md-12">
            <form action={{route('logusers.index')}} method='GET'>
            @csrf
        <div class="row g-2">
        <div class="col-md-1">
        </div>
        <div class="col-md-2">
          <div class="form-floating">
                    <input  class="form-control @error('ip_remoto') is-invalid @enderror" name='ip_remoto' id="floatingInputGrid"  value="{{ old('ip_remoto')}}">
                    <label for="floatingInputGrid">IP Remoto</label>
                            @error('ip_remoto')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror                        
            </div>        
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
                <div class="col-md-2">                
                <button type="submit" class="btn btn-primary">Pesquisar</button>
                <a href='{{ route('logusers.index') }}' class="btn btn-primary">Limpar</a>                
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
            <th>IP</th>
            <th>Data e Hora</th>                  
        </tr> 
    </thead>                  
    <tbody>
         @foreach ($log_users as $log )
         <tr>
            <td>{{$log->user}} </td>
            <td>{{$log->log}}</td>
            <td>{{$log->ip_remoto}}</td>
            <td>{{$log->created_at}}</td>                    
        </tr>
        @endforeach 
    </tbody>
  </table>
  <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item">
                <a class="page-link" href="{{ $log_users->previousPageUrl() }}" aria-label="Previous">
                  <span aria-hidden="true">&laquo;</span>
                </a>
                </li>
                 @for($i = 1; $i <= $log_users->lastPage(); $i++)
                <li class="page-item {{ $log_users->currentPage() == $i ? 'active' : '' }}">
                <a class="page-link" href="{{ $log_users->url($i) }}">{{ $i }}</a>
                </li>
                 @endfor
                <a class="page-link" href="{{ $log_users->nextPageUrl() }}" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
                </a>
                </li>
              </ul>
          </nav>     
     Exibindo {{$log_users->count()}} Bens de {{$log_users->total()}}
            
</div>

@endsection
