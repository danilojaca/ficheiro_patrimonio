<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventario;
use App\Models\Ben;
use App\Models\Edificio;
use App\Models\Log;
use App\Models\RoleUnidades;
use App\Models\Unidades;


class InventarioMultiplosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    function __construct(Inventario $inventario)
    {
         
         $this->middleware("permission:inventariomultiplos");
        
        
    }
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categorias = array("Informatica","Clinico","Mobiliario","Outros");
        $conservacao = array("MuitoBom","Bom","Razoavel","Mau","Avariado","Indefinido","Abatido");
        $centro_edificio = "";
        $centro_edificio_id = "";
        $user_id = auth()->user()->id;
        
        
        $bens = Ben::all();
        $roleunidades = RoleUnidades::where([
            ["user_id",$user_id]
        ])->get();
        return view("Inventario.create2",compact("conservacao","categorias","bens","roleunidades","centro_edificio_id","centro_edificio"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $unidades = $request->input("unidade_id");
        $sala = $request->input("sala");        
    
        //dd($sala);
        $count = count($request->categoria_id);
        
        for ($i=0; $i < $count ; $i++) {
          
        $inventario =  Inventario::create([
                "unidade_id" => $unidades,                
                "sala" => $sala,
                "modelo" => $request->modelo[$i],
                "n_inventario" => $request->n_inventario[$i],
                "categoria_id" => $request->categoria_id[$i],
                "n_serie" => $request->n_serie[$i],
                "bem_inventariado" => $request->bem_inventariado[$i],
                "conservacao" => $request->conservacao[$i],
            ]);

           //Log de Ação 
        $unidade = Unidades::where("id", $unidades)->first();
         
        Log::create([
            "user_id" => auth()->user()->id,
            "log"=> "Patrimonio de Id: $inventario->id, Unidade: $unidade->unidade, Categoria ID: $inventario->categoria_id, Sala: $sala, Nº Inventario: $inventario->n_inventario, NºSerie: $inventario->n_serie, Bem Inventariado: $inventario->bem_inventariado, Conservação: $inventario->conservacao" ,
            "operacao" => "create",

        ]);

    }

    return redirect()->route("inventario.index")
                            ->with("success","Ben Criado com Sucesso");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
