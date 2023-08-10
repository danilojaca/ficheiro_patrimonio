<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventario;
use App\Models\Unidades;
use App\Models\Ben;
use App\Models\RoleUnidades;

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
        $search = 0;
        $search1 = 0;
        $categorias = array("Informatica","Clinico","Mobiliario","Outros");
        $user_id = auth()->user()->id;
            
        $roleunidades = RoleUnidades::where([
            ['user_id',$user_id]
        ])->get();

        $bens = Ben::all();
        $relatorios = Inventario::where("unidade_id",$request->input("search"))->orderBy("categoria_id")->get();
      
       if ($request->search1 != "" && $request->input("search") != "") {
        
        $relatorios = Inventario::whereIn("categoria_id",$request->search1)->where("unidade_id",$request->input("search"))->orderBy("categoria_id")->get();
       }elseif ($request->search1 != "") {

        $relatorios = Inventario::whereIn("categoria_id",$request->search1)->orderBy("categoria_id")->get();
       }
        if ($request->input("_token")) {
            $_token = $relatorios->first();

         if ($request->input("search") != "") {
            $search = $request->input("search");
         } 

        if (isset($request->search1)) {
            
            $search1 = implode(',', $request->search1);            
            
         }   
           
            
        }
        
        return view("relatorio.index",compact("_token","search","search1","request","relatorios","roleunidades","bens","categorias"));
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
