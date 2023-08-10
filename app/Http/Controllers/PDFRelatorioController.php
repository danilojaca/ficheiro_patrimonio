<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventario;
use App\Models\Ben;
use App\Models\Edificio;
use App\Models\Unidades;
use PDF;

class PDFRelatorioController extends Controller
{
    public function exportar($unidade_id, $categoria_id){                          
        
        $categoria_id = explode(',', $categoria_id);

        if ($unidade_id != 0 && $categoria_id != 0) {
            $relatorios = Inventario::whereIn('categoria_id', $categoria_id)
            ->where('unidade_id', $unidade_id)
            ->orderBy('unidade_id')->orderBy('categoria_id')->get();
        }

        if ($categoria_id != 0) {
            $relatorios = Inventario::whereIn('categoria_id', $categoria_id)
            ->orderBy('unidade_id')->orderBy('categoria_id')->get();
        }

        if ($unidade_id != 0) {
            $relatorios = Inventario::where('unidade_id', $unidade_id)
            ->orderBy('unidade_id')->orderBy('categoria_id')->get();
           
        }
          

       

        $categoria = Ben::all();
         $pdf = PDF::loadView('relatorio.pdf',[
         'relatorios' => $relatorios,
         'categoria' => $categoria,
         ]);
         $pdf->setPaper('a4', 'portrait');
         $pdf->render();
         $pdf->getDomPDF()->set_option("enable_php", true);   
             
         return  $pdf->stream("Relatorio.pdf");
        
     }
}
