@extends("layouts.app")

@section("content")
<div class="container-fluid pt-5">
    <nav class="navbar navbar-expand-sm bg-light">
        <div class="container-fluid">               
            <div class="container navbar-nav justify-content-center me-5">
                <h2>{{"Ficha de Cadastro"}}</h2> 
            </div> 
            <ul class="navbar-nav ">      
                <li class="nav-item pt-2">
                @can("inventariomultiplos")
                    <a>{{"Cadastrar Novo Ben"}}</a>
                @endcan
                </li> 
                <li class="nav-item p-1">
                @can("criar-inventario")
                    <a class="btn btn-primary" href="{{ route("inventario.create") }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Cadastrar"><i class="bi bi-plus-lg"></i></a>
                @endcan
                </li>
            </ul>          
        </div>
    </nav>
</div>
<div class="container offset-2">
        <div class="col-md-12 row g-2  ">
            <div class="col-md-12 offset-md-2 ">
                <h6>{{'Para criar a Ficha de Cadastro selecione primeiro a Unidade de Saude e a seguir um das salas disponiveis'}}</h6> 
            </div>                   
            <div class="col-md-7">
                <form action="/formulario" method="GET" id="unidade_id_form">
                    <label  class="form-label pt-3 ">{{"Unidade de Saude"}}</label>                 
                        <select class=" form-select select2 @error("unidade") is-invalid @enderror" name="unidade" id="unidade" aria-label="Default select example" data-placeholder="Selecione a Unidade">
                                <option data-default disabled selected></option>
                            @foreach ($roleunidades as $roleunidade)
                                <option value="{{$roleunidade->unidade_id}}" {{$roleunidade->unidade_id == $search ? "selected" :  ""}}>{{$roleunidade->unidade->unidade}} | {{$roleunidade->unidade->edificio->edificio}}</option>
                            @endforeach 
                        </select>                 
                             @error("unidade")
                                 <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                </form>    
            </div>
            <div class="col-md-4">
                <form action="/formulario" method="GET" id="sala_id_form" class="row g-2">
                    @csrf
                    <div class="col-md-6">
                        @if (!empty($salas))
                        <label  class="form-label pt-3">{{"Salas"}}</label>                    
                            <select  class="form-select select2 @error("sala") is-invalid @enderror" name="sala" id="sala" aria-label="Default select example" data-placeholder="Selecione a Sala">
                                    <option data-default disabled selected></option>
                                @foreach ($salas as $key => $value)
                                    <option value="{{$key}}" {{$key == $search1 ? "selected" : ""}}>{{$key}} </option>
                                @endforeach 
                            </select>
                        @else
                            <label  class="form-label pt-3 ">{{"Salas"}}</label>
                            <input class=" form-control select2 @error("sala") is-invalid @enderror "  id="sala" data-placeholder="Salas Indisponivel" readonly >
                        @endif 
                            <input type="hidden" value="{{$search}}" name="unidade">
                                @error("sala")
                                 <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror 
                    </div> 
                    <div class="col-md-6 pt-5">               
                        @can("imprimir") 
                        @if ($centro != "")
                            <a href="{{ route("formulario.exportar", ["unidade_id" => $search, "sala" => $search1 , "centro" => $centro, "siie" => $siie]) }}" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Descarregar"><i class="bi bi-download"></i></a>      
                        @endif
                        @endcan
                    </div>    
                </form>
            </div>
        </div>
<script>
$( '.select2' ).select2( {
    theme: 'bootstrap-5'
} );
$("#unidade").change(function(){
    $("#unidade_id_form").submit();     
});
$("#sala").change(function(){
    $("#sala_id_form").submit();     
});
</script>       
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
