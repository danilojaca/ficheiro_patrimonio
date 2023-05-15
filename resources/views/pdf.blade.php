<!doctype html>
<html >
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/> 
        <style>
            table, td,th{border-collapse:collapse;font-size: 12px;text-align: center;}
            .table{border-collapse:collapse;margin-left: auto;margin-right: auto;}
            .table-bordered td,.table-bordered th{border:2px solid black}
            .container{padding: 50px 0px 0px 0px;display: flex;flex-direction: row;justify-content: center;align-items: center;}
            .container-top{padding: 0px 0px 0px 0px;height: 120px;width: 700px;}
            img {max-width: 100%;max-height: 100%}
            
        </style>
    </head>
    <body>
    
        <div class="container-top">
            <img src="img/sns-ars.png" >
        </div>
        <div class="container">             
            <table class="table table-bordered">
                <thead> 
                    <tr>
                        <th colspan="3" style="border:0px solid black;" ></th>
                        <th style="border:0px solid black; text-align: right">Data: {{date ('d-m-Y')}}</th>
                    </tr> 
                    <tr>
                        <th>SIIE edificio Origem</th>
                        <td>{{$siie}}</td>
                        <td rowspan="2" colspan="2" style="width:330px;">{{$centro}}</td>
                    </tr>
                    <tr>
                        <th  >Codigo Sala Origem</th>
                        <td >{{$sala}}</td>
                    </tr>                                                              
                    <tr>
                        <th colspan="4">Contagem de Nº Ordem</th>
                    </tr>
                    <tr>
                        <th style="width:260px;">Designação Bem</th>
                        <th>Bem Inventariado</th>
                        <th>Nº Inventario</th>
                        <th>Estado Conservação</th>                    
                    </tr> 
                </thead>                  
                <tbody>
                        @foreach ($inventarios as $inventario )
                    <tr>
                        <td style="text-align: justify;">{{$inventario->categoria}} {{$inventario->modelo}} {{$inventario->n_serie}}</td>
                        <td>{{$inventario->bem_inventariado}}</td>
                        <td>{{$inventario->n_inventario}}</td>
                        <td>{{$inventario->conservacao}}</td>                    
                    </tr>
                        @endforeach    
                </tbody>
            </table>
        </div>
    <script type="text/php">
    if ( isset($pdf) ) {
        $pdf->page_text(270, 810, "Pagina: {PAGE_NUM} de {PAGE_COUNT}", "helvetica", 10, array(0,0,0));
    }
</script>
      
    </body>
</html>