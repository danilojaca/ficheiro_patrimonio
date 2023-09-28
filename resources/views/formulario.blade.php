@extends("layouts.app")

@section("content")
<div class="container pt-5">
    <nav class="navbar navbar-expand-sm bg-light">
        <div class="container-fluid">               
            <div class="container navbar-nav justify-content-center">
                <h2>{{"Ficha de Cadastro"}}</h2> 
            </div>           
        </div>
    </nav>
</div>
<div class="container">
        <div class="col-md-12 row g-2  ">
            <div class="col-md-12 offset-md-2 ">
                <h6>{{'Para criar a Ficha de Cadastro selecione primeiro a Unidade de Saude e a seguir um das salas disponiveis'}}</h6> 
            </div>                   
            <div class="col-md-7">
                <form action="/formulario" method="GET" id="unidade_id_form">
                    <div class="form-floating">                   
                        <select class="form-select @error("unidade") is-invalid @enderror " name="unidade" id="unidade" aria-label="Default select example" >
                                <option data-default disabled selected>{{"Selecione o Unidade"}}</option>
                            @foreach ($roleunidades as $roleunidade)
                                <option value="{{$roleunidade->unidade_id}}" {{$roleunidade->unidade_id == $search ? "selected" :  ""}}>{{$roleunidade->unidade->unidade}} | {{$roleunidade->unidade->edificio->edificio}}</option>
                            @endforeach 
                        </select>
                        <label for="unidade">{{"Unidade de Saude"}}</label>                        
                             @error("unidade")
                                 <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                    </div>
                </form>    
            </div>
                 
<script>
$("#unidade").change(function(){
    $("#unidade_id_form").submit();     
});
</script>
                
            <div class="col-md-4">
                <form action="/formulario" method="GET" id="sala_id_form" class="row g-2">
                    @csrf
                    <div class="col-md-6">
                        <div class="form-floating">
                        @if (!empty($salas))                    
                            <select  class="form-select" name="sala" id="sala" aria-label="Default select example">
                                    <option data-default disabled selected>{{"Selecione a Sala"}}</option>
                                @foreach ($salas as $key => $value)
                                    <option value="{{$key}}" {{$key == $search1 ? "selected" : ""}}>{{$key}} </option>
                                @endforeach 
                            </select>
                        @else
                            <input class=" form-control btn-danger @error("sala") is-invalid @enderror "  id="sala" value="Salas Indisponiveis" readonly>
                        @endif    
                            <label for="sala">{{"Sala"}}</label>
                            <input type="hidden" value="{{$search}}" name="unidade">
                                @error("sala")
                                 <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror                        
                        </div>
                    </div> 
                    <div class="col-md-6 pt-2">       
                        <button type="submit" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Pesquisar"><i class="bi bi-search"></i></button>
                        <a href="{{ route("formulario.index") }}" class="btn btn-primary" data-bs-toggle="tooltip"  title="Limpar Pesquisa"><i class="bi bi-arrow-clockwise"></i></a>                
                        @can("imprimir") 
                        @if ($centro != "")
                            <a href="{{ route("formulario.exportar", ["unidade_id" => $search, "sala" => $search1 , "centro" => $centro, "siie" => $siie]) }}" class="btn btn-primary"><i class="bi bi-filetype-pdf"></i></a>      
                        @endif
                        @endcan
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
            <th>{{"SIIE edificio Origem"}}</th>
            <td>{{$siie}}</td>
            <td rowspan="2" colspan="2">{{$unidade}} {{$centro !== "" ? "|" : ""}} {{$centro}} </td>
        </tr>
        <tr>
            <th >{{"Codigo Sala Origem"}}</th>
            <td >{{$sala}}</td>
        </tr>                                                              
        <tr>
            <th colspan="6">{{"Contagem de Nº Ordem"}}</td>
        </tr>
        <tr>
            <th>{{"Designação Bem"}}</th>
            <th>{{"Bem Inventariado"}}</th>
            <th>{{"Nº Inventario"}}</th>
            <th>{{"Estado Conservação"}}</th>                    
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
   
    
</div>


@endsection
