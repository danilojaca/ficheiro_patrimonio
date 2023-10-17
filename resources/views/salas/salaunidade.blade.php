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
                    <a class="btn btn-primary" href="{{ route("unidade.index") }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Voltar"><i class="bi bi-reply-fill"></i></a>
                </li>            
            </ul>
        </div>
    </nav>
</div>
<div class="container">
@php

use App\Models\Unidades;

$name = Unidades::where('id',$unidade)->pluck('unidade');
$nameunidade = $name->first();

@endphp
<span>Selecione as salas que pretencem a unidade <strong>{{$nameunidade}}</strong></span>
</div>
<div class="container pt-3" >
    <form method="POST" action={{route('unidade.salasupdate',['unidade' => $unidade , 'edificio_id' => $edificio ])}} id="sala_form">
        @method('PATCH')
        @csrf
    @foreach($salas as $sala)
            <input type="checkbox" class="btn-check" id="{{$sala}}" name="salas[]" {{(in_array($sala, $salasativas,true)) ? 'checked' : ''}} autocomplete="off" value="{{ $sala }}" onchange="document.getElementById('sala_form').submit()">
            <label class="btn btn-outline-secondary mb-1" for="{{$sala}}">{{ $sala }}</label> 
    @endforeach 
</div>
</form> 
<script>
$(document).ready(function(){
    $("#sala_form").on("change", "input:checkbox", function(){
        $("#sala_form").submit();
    });
});
</script>
@endsection
