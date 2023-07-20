@extends('layouts.app')

@section('content')
<div class="container pt-5">
    <div class="row ">
        <div class="col-md-12">
            <form action='/formulario' method='GET'>
            @csrf            
            <div class="row g-2">
                <div class="col-md-7">
                    <div class="form-floating">
                   
                        <select class="form-select @error('search') is-invalid @enderror" name="search" id="search" aria-label="Floating label select example" data-live-search="true">
                        <option data-default disabled selected>Selecione o Edificio</option>
                        @foreach ($roleunidades as $roleunidade)
                        <option value="{{$roleunidade->unidade_id}}">{{$roleunidade->unidade->unidade}}</option>
                        @endforeach 
                        </select>
                        <label for="search">Centro de Saude</label>
                       
                
                        
                             @error('search')
                                 <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-floating">
                        <input  class="form-control @error('search1') is-invalid @enderror" name='search1' id="search1"  value="{{ old('search1')}}">
                        <label for="search1">Sala</label>
                            @error('search1')
                                 <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror                        
                    </div>
                </div> 
                <div class="col-md-2">                
                <button type="submit" class="btn btn-primary">Pesquisar</button>
                <a href='{{ route('formulario.index') }}' class="btn btn-primary">Limpar</a>                
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
            <th>SIIE edificio Origem</th>
            <td>{{$siie}}</td>
            <td rowspan="2" colspan="2">{{$unidade}}  {{$centro}} </td>
        </tr>
        <tr>
            <th  >Codigo Sala Origem</th>
            <td >{{$sala}}</td>
        </tr>                                                              
        <tr>
            <th colspan="6">Contagem de Nº Ordem</td>
        </tr>
        <tr>
            <th>Designação Bem</th>
            <th>Bem Inventariado</th>
            <th>Nº Inventario</th>
            <th>Estado Conservação</th>                    
        </tr> 
    </thead>                  
    <tbody>
         @foreach ($inventarios as $inventario )
         <tr>
            <td>{{$inventario->categoria->sub_categoria}}  {{$inventario->modelo}}  {{$inventario->n_serie}}</td>
            <td>{{$inventario->bem_inventariado}}</td>
            <td>{{$inventario->n_inventario}}</td>
            <td>{{$inventario->conservacao}}</td>                    
        </tr>
        @endforeach    
    </tbody>
  </table>
  @if ($centro != '')
  <a href='{{ route('formulario.exportar', ['unidade_id' => $search, 'sala' => $search1 , 'centro' => $centro, 'siie' => $siie]) }}' class="btn btn-primary">PDF</a>      
  @endif 
    
</div>

@endsection
