@extends("layouts.app")

@section("content")

<div class="container pt-5">
    <nav class="navbar navbar-expand-sm bg-light">
        <div class="container-fluid">               
            <div class="container navbar-nav justify-content-center  ">
                <h2>{{"Salas"}}</h2>
            </div>
            <ul class="navbar-nav">      
                <li class="nav-item">
                    <a class="btn btn-primary" href="{{ route("edificio.index") }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Voltar"><i class="bi bi-reply-fill"></i></a>
                </li>            
            </ul>
        </div>
    </nav>
</div>
 @if ($message = Session::get("success"))
    <div class="alert alert-success alert-dismissible fade show">
        <p>{{ $message }}</p>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    @if ($message = Session::get("danger"))
    <div class="alert alert-danger alert-dismissible fade show">
        <p>{{ $message }}</p>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
<div class="container" >          
        <div class="col-md-12 offset-md-4">        
            <h4>{{$centro}}</h4>
        </div>
    <div class="container">    
      <form method="POST" class="row g-2" action="{{route('edificio.salaupdate')}}">
        @csrf
        <div class="col-md-2">
            <strong>Sala</strong>
            <input class="form-control @error("sala") is-invalid @enderror" type="text" name="sala" id="sala" value="{{old("sala")}}"> 
            @error("sala")
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            <input class="form-control" type="hidden" name="edificio_id" id="edificio_id" value="{{$edificio_id}}">                   
        </div>
        <div class="col-md-1 pt-4">
            <button class="btn btn-primary" type="submit" data-bs-toggle="tooltip" data-bs-placement="top" title="Cadastrar"><i class="bi bi-plus-lg"></i></button>
        </div>
      </form>  
    </div>
    <div class="container pt-5">
        <span>Para Excluir uma sala, click a sala e confirme a exclusão</span><br>
        <strong>{{'Salas'}}</strong>
        <div class="col-md-12">
            <div class="input-group" >
                @foreach($salas as $sala)
                    <form method="post" action="{{route("edificio.saladelete", ["sala" => $sala->id])}}">
                        @method("DELETE")
                        @csrf 
                            <input type="submit" class="btn btn-outline-secondary" id="sala"name="sala"  autocomplete="off" value="{{ $sala->sala}}" onclick="return confirm('Excluir a Sala {{$sala->sala}} do Edificio {{$centro}} ?')"  data-bs-toggle="tooltip" data-bs-placement="top" title="Excluir Sala">
                    </form>                 
                @endforeach
            </div>    
        </div>            
    </div>
</div>
@endsection
