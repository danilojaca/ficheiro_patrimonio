@extends("layouts.app")

@section("content")
<div class="container pt-5">
    <nav class="navbar navbar-expand-sm bg-light">
        <div class="container-fluid">               
            <div class="container navbar-nav justify-content-center  ">
                <h1>{{"RELATORIO"}}</h1>
            </div>
        </div>
    </nav>
</div>
<div class="container-xxl ">
    <div class="row ">
        <div class="col-md-12 p-0">
            <form action="/relatorio" method="GET">
            @csrf            
            <div class="row g-2">
            <div class="col-md-3">
            </div>
                <div class="col-md-5">
                    <label for="search">{{"Centro de Saude"}}</label>
                        <select class="form-select @error("search") is-invalid @enderror" name="search" id="search" aria-label="Default select example" >
                            <option data-default disabled selected>{{"Selecione o Edificio"}}</option>
                                @foreach ($roleunidades as $roleunidade)
                                    <option value="{{$roleunidade->unidade_id}}" >{{$roleunidade->unidade->unidade}} | {{$roleunidade->unidade->edificio->edificio}}</option>
                                @endforeach 
                        </select>
                             @error("search")
                                 <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                </div>
                
                <div class="col-md-2 pt-4">                
                <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i></button>
                <a href="{{ route("relatorio.index") }}" class="btn btn-primary"><i class="bi bi-arrow-clockwise"></i></a>                
                @if ($_token)
                    <a href="{{ route("relatorio.exportar", ["unidade_id" => $search, "categoria_id" => $search1]) }}" class="btn btn-primary"><i class="bi bi-filetype-pdf"></i></a>      
                @endif
                </div> 
                
                <div class="col-md-4">                     
                    
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
            <th>{{"Unidade"}}</th>
            <th>{{"Categoria"}}</th>
            <th>{{"Sala"}}</th>
            <th>{{"Modelo"}}</th>  
            <th>{{"Nº Inventario"}}</th>  
            <th>{{"Nº Serie"}}</th>  
            <th>{{"Bem Inventariado"}}</th>  
            <th>{{"Conservação"}}</th>
            <tr>    
        </thead>
        <tbody>        
        @foreach ($relatorios as $relatorio )
        <tr>       
         <td>{{$relatorio->unidade->unidade}} | {{$relatorio->unidade->edificio->edificio}}</td>       
         <td>{{$relatorio->categoria->sub_categoria}}</td>
         <td>{{$relatorio->sala}}</td>
         <td>{{$relatorio->modelo}}</td>
         <td>{{$relatorio->n_inventario}}</td>
         <td>{{$relatorio->n_serie}}</td>
         <td>{{$relatorio->bem_inventariado}}</td>
         <td>{{$relatorio->conservacao}}</td>         
            </tr>   
        @endforeach
        </tbody>

  </table>   
</div>

@endsection
