<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventario;
use App\Models\Unidades;
use App\Models\Edificio;
use App\Models\Ben;

class RelatorioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    function __construct()
    {
         $this->middleware('permission:relatorio');
    }
    public function index(Request $request)
    {   $_token = NULL;
        $arrayrelatorio = NULL;

        $unidades =  Unidades::all();
        $edificios =  Edificio::all();
        $categorias =  Ben::all();

        $allaces = $edificios-> pluck("aces")->toArray();
        $allaces = array_count_values($allaces);
        $allaces = array_keys($allaces);
        
        $quantidadecategoria = $categorias->pluck("categoria")->ToArray();
        $quantidadecategoria = array_count_values($quantidadecategoria);
        $dcategoria = array_keys($quantidadecategoria);

        $acs = $edificios->where("aces",$request->input("aces"))->pluck("id")->toArray();
        $acs = $unidades->whereIn("edificio_id",$acs)->pluck("id")->toArray();
        
        $centrosaude = $unidades->where("edificio_id",$request->input("edificio"))->pluck("id")->toArray();

        $relatorios = Inventario::whereIn("unidade_id",$centrosaude)->orWhere("unidade_id",$request->input("unidade"))->orWhere("categoria_id",$request->input("categoria"))->orWhereIn("unidade_id",$acs)->paginate(8);

        if ($request->input("_token")) {
            $_token = $relatorios->first();

            $aces = $acs;
            $aces = implode(",",$aces);            
            $edificio = $centrosaude;            
            $edificio = implode(",",$edificio);
            $unidade = $request->input("unidade");
            $categoria = $request->input("categoria");

            $arrayrelatorio = array($aces,$edificio,$unidade,$categoria);
            $arrayrelatorio = implode("|",$arrayrelatorio);

         }
        
        return view("relatorio.index",compact("_token","unidades","edificios","categorias","dcategoria","relatorios","allaces","arrayrelatorio"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
