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
    public function exportar($arrayrelatorio){                          
        
        $arrayrelatorio = explode("|",$arrayrelatorio); 

            $aces = explode(",",$arrayrelatorio[0]);            
            $edificio = explode(",",$arrayrelatorio[1]);   
            $unidade = $arrayrelatorio[2];
            $categoria = $arrayrelatorio[3]; 
            
            

            $relatorios = Inventario::whereIn("unidade_id",$edificio)->orWhere("unidade_id",$unidade)->orWhere("categoria_id",$categoria)->orWhereIn("unidade_id",$aces)->get();

            

          if ($aces[0] != "") {            
            $n = 0;
            
          }elseif ($edificio[0] != "") {
            $n = 1;
          }
          elseif ($unidade != "") {
            $n = 2;
          }
          elseif ($categoria != "") {
            $n = 3;
          }     

         $categorias = Ben::all();
         $pdf = PDF::loadView('relatorio.pdf',[
         'relatorios' => $relatorios,
         'categorias' => $categorias,
         'n' => $n,
         ]);
         $pdf->setPaper('a4', 'portrait');
         $pdf->render();
         $pdf->getDomPDF()->set_option("enable_php", true);   
             
         return  $pdf->download("Relatorio.pdf");
        
     }
}
