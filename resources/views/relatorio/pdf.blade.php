<!doctype html>
<html >
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/> 
        <style>
            table, td{border-collapse:collapse;font-size: 12px;text-align: center;}
            th{border-collapse:collapse;font-size: 12px;text-align: center;}
            .table{border-collapse:collapse;margin-left: auto;margin-right: auto;}
            .table-bordered td,.table-bordered th{border:1px solid black}
            .container{padding: 0px 0px 0px 0px;display: flex;flex-direction: row;justify-content: center;align-items: center;}
            .container-left{float:left;padding: 25px 0px 0px 0px;display: flex;flex-direction: row;justify-content: left;align-items: left;}
            .container-top{padding: 0px 0px 0px 0px;height: 120px;width: 700px;}
            footer {padding: 20px;}
        </style>
    </head>
    <body>
        <div class="container"> 
        <div style="text-align:center;">
            <span style="font-size:180%;">{{"Inventario"}}</span>
        </div>
            <div class="container">            
                <table class="table table-bordered" style="width:700px">
                    <thead>
                        <tr>            
                            <th>{{"Unidade"}}</th>
                            <th>{{"Categoria"}}</th>
                            <th>{{"Sala"}}</th>
                            <th>{{"Modelo"}}</th>  
                            <th style="width:10px;">{{"Nº Inventario"}}</th>  
                            <th>{{"Nº Serie"}}</th>  
                            <th style="width:10px;">{{"Bem Inventariado"}}</th>  
                            <th style="width:10px;">{{"Conservação"}}</th>
                        </tr>    
                    </thead>
                    <tbody>        
                        @foreach ($relatorios as $relatorio )
                        <tr>       
                            <td>{{$relatorio->unidade->unidade}} </td>       
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
@php
    $quantidadeObjetos = $relatorios->pluck("categoria_id")->ToArray();
    $quantidadeObjetos = array_count_values($quantidadeObjetos);

    $quantidadeSalas = $relatorios->pluck("sala")->ToArray();
    $quantidadeSalas = array_count_values($quantidadeSalas);
    $quantidadeSalas = count($quantidadeSalas);

    $edificiosaces = $relatorios->

    $relatorio = $relatorios->first();
    $aces = $relatorio->unidade->edificio->aces;
    $edificio = $relatorio->unidade->edificio->edificio;
    $unidade = $relatorio->unidade->unidade;
    $siie = $relatorio->unidade->edificio->id_siie;
    $spms = $relatorio->unidade->edificio->id_spms;

    $edificiosaces = App\Models\Edificio::where("aces",$aces)->pluck("edificio")->toArray();
    $quantidadeEdificios = array_count_values($edificiosaces);
    $quantidadeEdificios = count($quantidadeEdificios);
@endphp

            <div class="container-left">
                <table class="table table-bordered" >
                    <thead>
                        <tr>            
                            <th colspan="6">{{"Relatorio"}}</th>
                        </tr>
                        @if ($n == 0)
                        <tr>            
                            <th colspan="4">{{"Aces"}}</th>
                            <td colspan="2">{{$aces}}</td>
                        </tr>           
                            <th colspan="2">{{"Salas"}}</th>
                            <td>{{$quantidadeSalas}}</td>
                            <th colspan="2">{{"Edificios"}}</th>
                            <td >{{$quantidadeEdificios}}</td>                            
                        </tr>
                         @endif
                        @if ($n == 1)
                        <tr>            
                            <th colspan="2">{{"SIIE Edificio Origem"}}</th>
                            <td>{{$siie}}</td>
                            <th colspan="2">{{"Site ID Edificio Origem"}}</th>
                            <td>{{$spms}}</td>  
                        </tr>           
                            <th colspan="2">{{"Salas"}}</th>
                            <td>{{$quantidadeSalas}}</td>
                            <th colspan="2">{{"Edificio"}}</th>
                            <td >{{$edificio}}</td>                            
                        </tr>
                         @endif
                         @if ($n == 2)
                        <tr>            
                            <th colspan="2">{{"SIIE Edificio Origem"}}</th>
                            <td>{{$siie}}</td>
                            <th colspan="2">{{"Site ID Edificio Origem"}}</th>
                            <td>{{$spms}}</td>  
                        </tr>           
                            <th colspan="2">{{"Salas"}}</th>
                            <td>{{$quantidadeSalas}}</td>
                            <th colspan="2">{{"Unidade"}}</th>
                            <td >{{$unidade}}</td>                            
                        </tr>
                         @endif
                         @if ($n == 3)
                        <tr>           
                            <th colspan="2">{{"Salas"}}</th>
                            <td>{{$quantidadeSalas}}</td>
                            <th colspan="2">{{"Edificios"}}</th>
                            <td >{{$quantidadeEdificios}}</td>                   
                        </tr>
                         @endif
                        

                        <tr>            
                            <th colspan="3">{{"Objetos"}}</th>
                            <th colspan="3">{{"Quantidade"}}</th>
                        </tr>    
                    </thead>
                    <tbody> 
                        @foreach ( $quantidadeObjetos as  $x => $val)
                            @foreach ( $categorias as $ben)
                                @if ($ben->id == $x)
                                    <tr>       
                                        <td colspan="3">{{$ben->sub_categoria}}</td>
                                        <td colspan="3">{{$val}} </td>
                                    </tr>    
                                @endif    
                            @endforeach
                        @endforeach 
                    </tbody>
                </table>  
            </div>  
        </div>
        <script type="text/php">
            if ( isset($pdf) ) {
                $pdf->page_text(270, 810, "Pagina: {PAGE_NUM} de {PAGE_COUNT}", "helvetica", 10, array(0,0,0));
                $pdf->page_text(15, 795, "Elaborado por {{auth()->user()->name}}", "helvetica", 10, array(0,0,0));
                $pdf->page_text(15, 810, "{{date ('d-m-Y')}} ", "helvetica", 10, array(0,0,0));
            }
        </script>
    </body>
</html>