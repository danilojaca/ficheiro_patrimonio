<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Formulario;
use App\Models\Unidades;
use Carbon\Carbon;
use PDF;

class PDFController extends Controller
{
    public function exportar($unidade_id, $sala,$centro,$siie){                          
       $inventarios = Formulario::where([  
            ['unidade_id', $unidade_id]
            ])->where([
            ['sala', $sala]    
            ])->get();

        $unidades = Unidades::where('id', $unidade_id)->first();
        $unidade = $unidades->unidade;

        $pdf = PDF::loadView('pdf',[
        'inventarios' => $inventarios,
        'siie' => $siie,
        'centro' => $centro,
        'unidade_id' => $unidade_id,
        'sala' => $sala,
        'unidade' => $unidade,
        ]);
        $pdf->setPaper('a4', 'portrait');
        $pdf->render();
        $pdf->getDomPDF()->set_option("enable_php", true);   
            
        return  $pdf->stream("Ficheiro de Patrimonio $centro Sala: $sala.pdf");
       
    }
    
}
