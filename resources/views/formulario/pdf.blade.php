<!doctype html>
<html >
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/> 
        <style>
            table, td,th{border-collapse:collapse;font-size: 12px;text-align: center;}
            th{background-color: #87CEFA}
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
        <div class="container-fluid">             
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th colspan="4" style="width:550px;">{{"Administração Regional de Saude do Algarve, Folha de Cadastro de Bens Móveis"}}</th>
                    </tr>
                    <tr>
                        <th colspan="3">{{"Aces"}}</th>
                        <th colspan="1">{{"Designação"}}</th>
                    </tr>
                    <tr>
                        <td colspan="3" style="width:330px;"> {{$aces}} </td>
                        <td>{{"Sala Origem"}}</td>
                    </tr>
                    <tr>
                        <th colspan="3">{{"Nome do Edificio"}}</th>
                        <th colspan="1">{{"SIIE edificio Origem"}}</th>
                    </tr>
                    <tr>
                        <td colspan="3" style="width:330px;"> {{$centro}} </td>
                        <td>{{$siie}}</td>
                    </tr>
                    <tr>
                        <th colspan="3">{{"Unidade Funcional"}}</th>
                        <th colspan="1">{{"Codigo Sala Origem"}}</th>
                    </tr>
                    <tr>
                        <td colspan="3" style="width:330px;"> {{$unidade}} </td>
                        <td >{{$sala}}</td>
                    </tr>
                    <tr>
                        <th style="width:260px;">{{"Designação Bem"}}</th>
                        <th>{{"Bem Inventariado"}}</th>
                        <th>{{"Nº Inventario"}}</th>
                        <th>{{"Estado Conservação"}}</th>                    
                    </tr> 
                </thead>                  
                <tbody>
                        @foreach ($inventarios as $inventario )
                    <tr>
                        <td style="text-align: justify;">{{$inventario->categoria->sub_categoria}} {{$inventario->modelo}} {{$inventario->n_serie}}</td>
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
        $pdf->page_text(20, 795, "Elaborado por {{auth()->user()->name}}", "helvetica", 10, array(0,0,0));
        $pdf->page_text(20, 810, "{{date ('d-m-Y')}} ", "helvetica", 10, array(0,0,0));
    }
    </script>
      
    </body>
</html>