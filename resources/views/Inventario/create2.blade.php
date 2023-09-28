@extends("layouts.app")

@section("content")
<div class="container pt-5">
    <nav class="navbar navbar-expand-sm bg-light">
        <div class="container-fluid">               
            <div class="container navbar-nav justify-content-center  ">
                <h2>{{" Bens Imóveis e Património"}}</h2>
            </div>
            <ul class="navbar-nav">      
                <li class="nav-item">
                @can("role-create")
                    <a class="btn btn-primary" href="{{ route("inventario.index") }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Voltar"><i class="bi bi-reply-fill"></i></a>
                @endcan
                </li>            
            </ul>
        </div>
    </nav>
</div>
<div class="container mt-">
        <form  action="{{route("inventariomultiplos.store")}}" method="POST" >
              @csrf 
            <div class="row g-3">  
                <div class="col-md-1">
                </div>
                <div class="col-md-7">                
                  <label  class="form-label">{{"Centro de Saude"}}</label>    
                  <select  class="form-select @error("unidade_id") is-invalid @enderror" name="unidade_id"  aria-label="Default select example">
                    <option  disabled selected value="{{NULL}}">{{"Selecione a Unidade"}}</option>
                    @foreach ($roleunidades as $roleunidade)
                    <option value="{{$roleunidade->unidade_id}}">{{$roleunidade->unidade->unidade}} | {{$roleunidade->unidade->edificio->edificio}}</option>
                    @endforeach 
                  </select>               
                  @error("unidade_id")
                    <span class="invalid-feedback" role="alert">
                       <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
                <div class="col-md-1">              
                  <label  class="form-label ">{{"Sala"}}</label>
                  <input  type="text" name="sala" class="form-control @error("sala") is-invalid @enderror"  value="{{ old("sala")}}">
                  @error("sala")
                    <span class="invalid-feedback" role="alert">
                       <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
                <div class="col-md-2 pt-4 mt-4">
                  <button type="submit" class="btn btn-primary">{{"Cadastrar"}}</button>     
                </div>
                <div class="col-md-1 pt-4 mt-4">              
                  <button type="button" class="btn btn-primary" id="adicionar" name="adicionar"><i class="bi bi-plus-lg"></i></button>     
             </div>
            </div>
              <hr>
            <div id="form">
            <div class="row g-3" >
              <div class="col-md-2"> 
                  <label  class="form-label">{{"Categoria"}}</label>   
                  <select  class="form-select @error("categoria_id") is-invalid @enderror" name="categoria_id[]" aria-label="Default select example">
                    <option disabled selected value="{{NULL}}">{{"Selecione a Categoria"}}</option>
                      @foreach ($categorias as $categoria)
                        <optgroup label="{{$categoria}}">
                          @foreach ($bens as $ben)
                            @if ($ben->categoria === $categoria)
                              <option value="{{$ben->id}}">{{$ben->sub_categoria}}</option>
                            @endif 
                          @endforeach
                        </optgroup>
                      @endforeach                     
                  </select>
                  @error("categoria_id")
                    <span class="invalid-feedback" role="alert">
                       <strong>{{ $message }}</strong>
                    </span>
                  @enderror
              </div>
              <div class="col-md-2">
                  <label  class="form-label">{{"Modelo"}}</label>
                  <input  type="text" name="modelo[]" placeholder="Apenas Itens Informaticos" class="form-control @error("modelo[]") is-invalid @enderror" value="{{ old("modelo")}}" >
                   @error("modelo")
                    <span class="invalid-feedback" role="alert">
                       <strong>{{ $message }}</strong>
                    </span>
                  @enderror
              </div>
              <div class="col-md-1">
                  <label class="form-label">{{"Nº Inventario"}}</label>
                  <input  type="text" name="n_inventario[]" class="form-control @error("n_inventario") is-invalid @enderror" value="{{ old("n_inventario")}}" >
                   @error("n_inventario")
                    <span class="invalid-feedback" role="alert">
                       <strong>{{ $message }}</strong>
                    </span>
                  @enderror
              </div>
              <div class="col-md-2">
                  <label class="form-label">{{"Nº Serie"}}</label>
                  <input  type="text" name="n_serie[]" placeholder="Apenas Itens Informaticos" class="form-control @error("n_serie") is-invalid @enderror" value="{{ old("n_serie")}}" >
                   @error("n_serie")
                    <span class="invalid-feedback" role="alert">
                       <strong>{{ $message }}</strong>
                    </span>
                  @enderror
              </div> 
              <div class="col-md-2"> 
                  <label  class="form-label">{{"Bem Inventariado"}}</label>   
                  <select  class="form-select @error("bem_inventariado") is-invalid @enderror" name="bem_inventariado[]" aria-label="Default select example">
                    <option disabled selected value="{{NULL}}">{{"Selecione uma Opção"}}</option>
                    <option value="Sim">{{"Sim"}}</option>
                    <option value="Nao">{{"Não"}}</option>
                  </select>
                   @error("bem_inventariado[]")
                    <span class="invalid-feedback" role="alert">
                       <strong>{{ $message }}</strong>
                    </span>
                  @enderror
              </div>
              <div class="col-md-2"> 
                  <label  class="form-label">{{"Conservação"}}</label>   
                  <select  class="form-select @error("conservacao") is-invalid @enderror" name="conservacao[]" aria-label="Default select example">
                    <option  disabled selected value="{{NULL}}">{{"Selecione Conservação"}}</option>
                    @foreach ( $conservacao as $conservar )
                      <option value="{{$conservar}}">{{$conservar}}</option>  
                    @endforeach
                          
                  </select>
                   @error("conservacao")
                    <span class="invalid-feedback" role="alert">
                       <strong>{{ $message }}</strong>
                    </span>
                  @enderror
              </div>              
            </div>
        </div>
                                     
        </form>
       
</div>
<script>             
                $( "#adicionar" ).on( "click", function() {                
                  
                  var numbers = $("div.campo_novo").length;
                 
                  if(numbers < 8) {  
                  $( "#form" ).append('<div class ="row g-3 campo_novo"><div class="col-md-2"><label  class="form-label">Categoria</label><select class="form-select @error("categoria_id") is-invalid @enderror" name="categoria_id[]" aria-label="Floating label select example" data-live-search="true" ><option data-default disabled selected>Selecione a Categoria</option> @foreach ($categorias as $categoria)<optgroup label="{{$categoria}}"> @foreach ($bens as $ben) @if ($ben->categoria === $categoria)<option value="{{$ben->id}}">{{$ben->sub_categoria}}</option>@endif @endforeach</optgroup> @endforeach</select>@error("categoria_id")<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror</div><div class="col-md-2"><label  class="form-label">Modelo</label><input type="text" name="modelo[]" placeholder="Apenas Itens Informaticos" class="form-control @error("modelo") is-invalid @enderror" value="{{ old("modelo")}}" >@error("modelo")<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror</div><div class="col-md-1"><label class="form-label">Nº Inventario</label><input type="text" name="n_inventario[]" class="form-control @error("n_inventario") is-invalid @enderror" value="{{ old("n_inventario")}}" > @error("n_inventario") <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror </div><div class="col-md-2"><label class="form-label">Nº Serie</label><input type="text" name="n_serie[]" placeholder="Apenas Itens Informaticos" class="form-control @error("n_serie") is-invalid @enderror" value="{{ old("n_serie")}}" > @error("n_serie")<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror</div><div class="col-md-2"><label  class="form-label">Bem Inventariado</label><select class="form-select @error("bem_inventariado") is-invalid @enderror" name="bem_inventariado[]" id="floatingSelectGrid" aria-label="Floating label select example" data-live-search="true" ><option data-default disabled selected>Selecione uma Opção</option><option value="Sim">Sim</option><option value="Nao">Não</option></select>@error("bem_inventariado")<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror</div><div class="col-md-2"><label  class="form-label">Conservação</label><select  class="form-select @error("conservacao") is-invalid @enderror" name="conservacao[]" aria-label="Default select example"> <option  disabled selected value="{{NULL}}">{{"Selecione Conservação"}}</option>@foreach ( $conservacao as $conservar )<option value="{{$conservar}}">{{$conservar}}</option> @endforeach</select>@error("conservacao")<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror</div><div class="col-md-1 pt-4 mt-4" id="teste"><button type="button" class="btn btn-primary remover" id="deletar" name="deletar"><i class="bi bi-dash"></i></button></div></div>');
                 }
                 } ); 
                $(document).on("click", "button.remover", function() {
                    $(this).closest("div.campo_novo").remove();
                    });
                  
              </script>
@endsection
