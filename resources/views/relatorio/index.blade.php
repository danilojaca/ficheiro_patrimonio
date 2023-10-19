
@extends("layouts.app")

@section("content")
<div class="container pt-5">
    <nav class="navbar navbar-expand-sm">
        <div class="container-fluid">               
            <div class="container navbar-nav justify-content-center p-0 ">
                <h2>{{"Relatorio"}}</h2>
            </div>
            @if ($_token)    
                        <a class="btn btn-primary" href="{{ route('relatorio.index') }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Voltar"><i class="bi bi-reply-fill"></i></a>
                  
            @endif
        </div>
    </nav>
</div>
<div class="container ">
    @if (!$_token)
        <div class="container offset-md-2 justify-content-center ">
            <h6 > {{'Clique na Opção de Pesquisa desejada e em seguida seleciona um item para a criação do relatorio'}}</h6> 
        </div> 
        <div class="col-md-12 pt-1">
            <form action="/relatorio" method="GET" id="relatorio_form">
            @csrf            
                <div class="col-7 offset-2">
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
                        <select class="form-select select2 @error("unidade") is-invalid @enderror" name="unidade" id="unidade" data-placeholder="Selecione a Unidade">
                                <option data-default disabled selected></option>
                            @foreach ($unidades as $value)
                                <option value="{{$value->id}}" >{{$value->unidade}}</option>              
                            @endforeach 
                        </select>
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
            </div>
            </form> 
        </div>
    @else
        @can("descarregar") 
                <ul class="list-group list-group-horizontal justify-content-center pt-2">
                    <a href="{{ route("relatorio.exportar", ["arrayrelatorio" => $arrayrelatorio]) }}" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Descarregar">{{"Descarregar Relatorio"}} <i class="bi bi-download"></i></a>
                </ul> 
        @endcan                
    @endif
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
