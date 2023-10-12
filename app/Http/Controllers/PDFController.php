<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Formulario;
use App\Models\Unidades;
use App\Models\Edificio;
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
        $aces = Edificio::where('id',$unidades->id)->first();
        $aces = $aces->aces;
        $pdf = PDF::loadView('formulario.pdf',[
        'inventarios' => $inventarios,
        'siie' => $siie,
        'centro' => $centro,
        'unidade_id' => $unidade_id,
        'sala' => $sala,
        'unidade' => $unidade,
        'aces' => $aces
        ]);
        $pdf->setPaper('a4', 'portrait');
        $pdf->render();
        $pdf->getDomPDF()->set_option("enable_php", true);         
                   
        return   $pdf->download("Ficheiro de Patrimonio $centro Sala: $sala.pdf");
       
    }
    
}
