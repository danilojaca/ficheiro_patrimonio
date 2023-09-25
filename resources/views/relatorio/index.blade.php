
@extends("layouts.app")

@section("content")
<div class="container pt-5">
    <nav class="navbar navbar-expand-sm ">
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
            <div class="col-7 offset-md-2 row g-2">
                <div class="col-md-12 input-group mb-3 " id="div-aces">
                        <input type="button" class="btn btn-primary remover" value="Aces" id="buttonaces"> 
                             @error("aces")
                                 <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                    </div>
                    <div class="col-md-12 input-group mb-3" id="div-edificio">
                        <input type="button" class="btn btn-primary remover" value="Edificio" id="buttonedificio">
                             @error("edificio")
                                 <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                    </div>
                    <div class="col-md-12 input-group mb-3" id="div-unidade">
                        <input type="button" class="btn btn-primary" value="Unidade" id="buttonunidade">
                             @error("unidade")
                                 <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                    </div>
                    <div class="col-md-12 input-group mb-3" id="div-categoria">
                        <input type="button" class="btn btn-primary" value="Categoria" id="buttoncategoria"> 
                             @error("categoria")
                                 <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                    </div>
                </div>
                <div class="col-md-2 pt-4">                
                <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i></button>
                <a href="{{ route("relatorio.index") }}" class="btn btn-primary"><i class="bi bi-arrow-clockwise"></i></a> 
                @can("imprimir")               
                @if ($_token)
                    <a href="{{ route("relatorio.exportar", ["arrayrelatorio" => $arrayrelatorio]) }}" class="btn btn-primary"><i class="bi bi-filetype-pdf"></i></a>      
                @endif
                @endcan
                </div> 
                
                <div class="col-md-3">                     
                    
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
 aces = 0;
$( "#buttonaces" ).on( "click", function() { 
    aces++
   if(aces > 1) { 
    $('#aces').remove();
    aces = 0;
    }    
     if(aces == 1) { 
      $('#edificio').remove();
      edificio = 0;
      $('#unidade').remove();
      unidade = 0;
      $('#categoria').remove();
      categoria = 0;

     $( "#div-aces" ).append('<select class="form-select @error("aces") is-invalid @enderror" name="aces" id="aces" aria-label="Default select example"> <option data-default disabled selected>{{"Selecione o ACES"}}</option> @foreach ($allaces as $allaces)<option value="{{$allaces}}" >{{$allaces}}</option> @endforeach </select>');
     aces++
}}); 
    

 edificio = 0;
$( "#buttonedificio" ).on( "click", function() { 
     edificio++
     if(edificio > 1) { 
    $('#edificio').remove();
    edificio = 0;
    } 
     if(edificio == 1) {  

      $('#aces').remove();
      aces = 0;
      $('#unidade').remove();
      unidade = 0;
      $('#categoria').remove();
      categoria = 0;

     $( "#div-edificio" ).append('<select class="form-select @error("edificio") is-invalid @enderror" name="edificio" id="edificio" aria-label="Default select example"> <option data-default disabled selected>{{"Selecione o Edificio"}}</option>@foreach ($edificios as $value)<option value="{{$value->id}}"> {{$value->edificio}} </option>                   @endforeach </select>');
     edificio++

}}); 
 unidade = 0;
$( "#buttonunidade" ).on( "click", function() { 
    unidade++
     if(unidade > 1) { 
    $('#unidade').remove();
    unidade = 0;
    } 
       if(unidade == 1) { 
      $('#aces').remove();
      aces = 0;
      $('#edificio').remove();
      edificio = 0;
      $('#categoria').remove();
      categoria = 0;

     $( "#div-unidade" ).append('<select class="form-select @error("unidade") is-invalid @enderror" name="unidade" id="unidade" aria-label="Default select example">                           <option data-default disabled selected>{{"Selecione o Unidade"}}</option> @foreach ($unidades as $value) <option value="{{$value->id}}" >{{$value->unidade}}</option>               @endforeach </select>');
}}); 

 categoria= 0;
$( "#buttoncategoria" ).on( "click", function() { 
     categoria++
     if(categoria > 1) { 
    $('#categoria').remove();
    categoria = 0;
    }
     if(categoria == 1) {  

      $('#aces').remove();
      aces = 0;
      $('#edificio').remove();
      edificio = 0;
      $('#unidade').remove();
      unidade = 0;

     $( "#div-categoria" ).append('<select class="form-select @error("categoria") is-invalid @enderror" name="categoria" id="categoria" aria-label="Default select example"> <option data-default disabled selected>{{"Selecione a Categoria"}}</option> @foreach ($dcategoria as $descricao)<optgroup label="{{$descricao}}"> @foreach ($categorias as $value) @if ($value->categoria === $descricao)<option value="{{$value->id}}" {{$value->id  == old("categoria_id") ? "selected" : ""}}>{{$value->sub_categoria}}</option> @endif @endforeach </optgroup> @endforeach </select>');
}}); 



</script>
@endsection
