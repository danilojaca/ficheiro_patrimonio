
@extends("layouts.app")

@section("content")
<div class="container pt-5">
    <nav class="navbar navbar-expand-sm ">
        <div class="container-fluid">               
            <div class="container navbar-nav justify-content-center  ">
                <h2>{{"Relatorio"}}</h2>
            </div>
        </div>
    </nav>
</div>
<div class="container-xxl ">
    <div class="row ">
    <div class="col-md-12 offset-md-3 ">
                <h6>{{'Clique na Opção de Pesquisa desejada e em seguida seleciona um item para a criação do relatorio'}}</h6> 
            </div> 
        <div class="col-md-12 p-0">
            <form action="/relatorio" method="GET" id="relatorio_form">
            @csrf            
            <div class="col-7 offset-md-2 row g-2">
                <div class="col-md-12 input-group mb-3 " id="div-aces">
                        <input type="button" class="btn btn-primary remover" value="Aces" id="buttonaces"> 
                        <select class="form-select select2 @error("aces") is-invalid @enderror" name="aces" id="aces" data-placeholder="Selecione o ACES">
                                <option data-default disabled selected></option>
                            @foreach ($allaces as $allaces)
                                <option value="{{$allaces}}" >{{$allaces}}</option> 
                            @endforeach
                        </select>                        
                             @error("aces")
                                 <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                    </div>
                    <div class="col-md-12 input-group mb-3" id="div-edificio">
                        <input type="button" class="btn btn-primary remover" value="Edificio" id="buttonedificio">
                        <select class="form-select select2 @error("edificio") is-invalid @enderror" name="edificio" id="edificio" data-placeholder="Selecione o Edificio"> 
                                <option data-default disabled selected></option>
                            @foreach ($edificios as $value)
                                <option value="{{$value->id}}"> {{$value->edificio}} </option>                   
                            @endforeach
                        </select>
                             @error("edificio")
                                 <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                    </div>
                    <div class="col-md-12 input-group mb-3" id="div-unidade">
                        <input type="button" class="btn btn-primary" value="Unidade" id="buttonunidade">
                        <select class="form-select select2 @error("unidade") is-invalid @enderror" name="unidade" id="unidade" data-placeholder="Selecione a Unidade"><option data-default disabled selected></option> @foreach ($unidades as $value) <option value="{{$value->id}}" >{{$value->unidade}}</option>               @endforeach </select>
                             @error("unidade")
                                 <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                    </div>
                    <div class="col-md-12 input-group mb-3" id="div-categoria">
                        <input type="button" class="btn btn-primary" value="Categoria" id="buttoncategoria">
                        <select class="form-select select2 @error("categoria") is-invalid @enderror" name="categoria" id="categoria" data-placeholder="Selecione a Categoria">
                                <option data-default disabled selected></option> 
                            @foreach ($dcategoria as $descricao)
                                <optgroup label="{{$descricao}}"> 
                                    @foreach ($categorias as $value) 
                                        @if ($value->categoria === $descricao)
                                            <option value="{{$value->id}}" {{$value->id  == old("categoria_id") ? "selected" : ""}}>{{$value->sub_categoria}}</option> 
                                        @endif
                                    @endforeach 
                                </optgroup> 
                            @endforeach 
                        </select>
                             @error("categoria")
                                 <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                    </div>
                </div>
                <div class="col-md-2 pt-4">  
                @can("descarregar")               
                @if ($_token)
                    <a href="{{ route("relatorio.exportar", ["arrayrelatorio" => $arrayrelatorio]) }}" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Descarregar"><i class="bi bi-download"></i></a>      
                @endif
                @endcan
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
  {!! $relatorios->withQueryString()->links("pagination::bootstrap-5") !!}  
</div>
<script>
$( ".select2" ).select2( {
    theme: 'bootstrap-5'
} );
$(".select2").change(function(){
    $("#relatorio_form").submit();     
});

</script>
@endsection
