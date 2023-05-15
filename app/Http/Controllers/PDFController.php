<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Formulario;
use Carbon\Carbon;
use PDF;

class PDFController extends Controller
{
    public function exportar($unidade, $sala,$centro,$siie){                          
       $inventarios = Formulario::where([  
            ['edificio_id', $unidade]
            ])->where([
            ['sala', $sala]    
            ])->get();
        $pdf = PDF::loadView('pdf',[
        'inventarios' => $inventarios,
        'siie' => $siie,
        'centro' => $centro,
        'unidade' => $unidade,
        'sala' => $sala
        ]);
        $pdf->setPaper('a4', 'portrait');
        $pdf->render();
        $pdf->getDomPDF()->set_option("enable_php", true);   
            
        return  $pdf->download("Ficheiro de Patrimonio $centro Sala: $sala.pdf");
       
    }
    
}
