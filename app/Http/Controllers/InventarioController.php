<?php

namespace App\Http\Controllers;

use App\Models\Inventario;
use App\Models\Ben;
use App\Models\Edificio;
use App\Models\Log;
use App\Models\RoleUnidades;
use App\Models\Sala;
use App\Models\RoleClass;
use App\Models\Unidades;
use App\Models\Conservacao;
use Illuminate\Http\Request;

class InventarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    function __construct(Inventario $inventario)
    {
         $this->middleware("permission:visualizar-inventario", ["only" => ["index"]]);
         $this->middleware("permission:criar-inventario", ["only" => ["create","store"]]);
         $this->middleware("permission:editar-inventario", ["only" => ["edit","update"]]);
         $this->middleware("permission:excluir-inventario", ["only" => ["destroy"]]);
        
    }

    public function index(Request $request)
    {    

        $user_id = auth()->user()->id;
        $salas = RoleClass::where("user_id",$user_id)->pluck("unidade_id","sala")->toArray();
        
        $search = $request->input("search");
        
        $inventario = Inventario::where("unidade_id","!=",NULL);
                
        if (is_numeric($search)) {

        $inventarios = $inventario->Where("n_inventario","like","%$search%")
        ->orderBy("unidade_id")->orderBy("sala")->paginate(10);

        }elseif(isset($search)){
        $edificios = Edificio::where("edificio", "like", "%$search%")->pluck("id")->toArray();

        $unidades = Unidades::whereIn("edificio_id",$edificios)
            ->orWhere("unidade", "like", "%$search%")->pluck("id")->toArray();
        
        $categorias = Ben::where("sub_categoria","like","%$search%")->pluck("id")->toArray();

        $inventarios = $inventario->WhereIn("unidade_id",$unidades)->orWhereIn("categoria_id",$categorias)
        ->orderBy("unidade_id")->orderBy("sala")->paginate(10);

        }else{

            $inventarios = $inventario->orderBy("unidade_id")->orderBy("sala")->paginate(10);
        }
        return view("Inventario.index", compact("inventarios","salas","search") );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        
        $centro_edificio =NULL;
        $centro_edificio_id = NULL;
        $unidade_id = NULL;
        $salas = NULL;

        //Categorias
        $quantidadecategoria = Ben::pluck("categoria")->ToArray();
        $quantidadecategoria = array_count_values($quantidadecategoria);
        $categorias = array_keys($quantidadecategoria);        
        $conservacao = Conservacao::pluck('conservacao')->toArray();
        

        //Unidade Liberadas para o Utilizador
        $user_id = auth()->user()->id;               
        $bens = Ben::all();
        $roleunidades = RoleUnidades::where([
            ["user_id",$user_id]
        ])->get();

        //Salas da Unidade
        if(!empty($request->input('unidade'))){
        $unidade_id = $request->input('unidade');
        $salas = Sala::where('unidade_id',$unidade_id)->orderBy('sala')->pluck('sala')->toArray();
            
        }

        return view("Inventario.create",compact("conservacao","categorias","bens","roleunidades","centro_edificio_id","centro_edificio","unidade_id","salas"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {     
             
        if($request->input("_token") != ""){

            $this->validateLogin($request);
        } 

        $unidades = $request->input("unidade_id");

        if (empty($request->input("n_inventario"))) { 

            $bem_inventariado = "Nao";
        }else{

            $bem_inventariado = "Sim";
        }

    $inventario =  Inventario::create([        
        "unidade_id" => $request->input("unidade_id") ,
        "categoria_id" => $request->input("categoria_id"),
        "modelo" => $request->input("modelo"),
        "n_inventario" => $request->input("n_inventario"),
        "n_serie" => $request->input("n_serie"),        
        "sala" => $request->input("sala") ,
        "bem_inventariado" =>  $bem_inventariado,
        "conservacao" => $request->input("conservacao") ,
    ]);
    
    //Log de Ação 
        $unidade = Unidades::where("id", $unidades)->first();     
    Log::create([
        "user_id" => auth()->user()->id,
        "log"=> "Patrimonio de Id: $inventario->id, Unidade: $unidade->unidade, Categoria ID: $inventario->categoria_id, Sala: $inventario->sala, Nº Inventario: $inventario->n_inventario, NºSerie: $inventario->n_serie, Bem Inventariado: $inventario->bem_inventariado, Conservação: $inventario->conservacao" ,
        "operacao" => "create",

    ]);


            return redirect()->route("inventario.index")
                            ->with("success","Ben Criado com Sucesso");
    }

    /**
     * Display the specified resource.
     */
    public function show(Inventario $inventario)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Inventario $inventario,Request $request)
    {
        

        $quantidadecategoria = Ben::pluck("categoria")->ToArray();
        $quantidadecategoria = array_count_values($quantidadecategoria);
        $categorias = array_keys($quantidadecategoria);
        $user_id = auth()->user()->id;
        $bens = Ben::orderBy("categoria")->get();
        $roleunidades = RoleUnidades::where([
            ["user_id",$user_id]
        ])->get();

        $conservacao = Conservacao::pluck('conservacao')->toArray();

        //Salas da Unidade
        $unidade_id = $inventario->unidade_id;
        $salas = Sala::where('unidade_id',$unidade_id)->pluck('sala')->toArray();

        if(!empty($request->input('unidade'))){
            $unidade_id = $request->input('unidade');
            $salas = Sala::where('unidade_id',$unidade_id)->pluck('sala')->toArray();
                
            }

        return view("Inventario.edit", compact("conservacao","categorias","inventario", "bens", "roleunidades","unidade_id","salas"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Inventario $inventario)
    {
        
        if($request->input("_token") != ""){
            $regras = [
                "unidade_id" => "required", 
                "sala" => "required",
                "conservacao" => "required",
                ];
                $feedback = [
        
                    "required"=>"Campo :attribute Obrigatorio",
                    "unique"=>"Esse :attribute já existe",
        
                 ];
        
                 $request->validate($regras, $feedback);
         }
            
            $inventario->update([
                "unidade_id" => $request->input("unidade_id") ,
                "sala" => $request->input("sala") ,
                "conservacao" => $request->input("conservacao") ,
            ]);
        

        //Log de Ação
        $unidade = Unidades::where("id", $inventario->unidade_id)->first(); 
        Log::create([
        "user_id" => auth()->user()->id,
        "log"=> "Patrimonio de Id: $inventario->id, Unidade: $unidade->unidade, Categoria: $inventario->categoria_id, Sala: $inventario->sala, Nº Inventario: $inventario->n_inventario, NºSerie: $inventario->n_serie, Bem Inventariado: $inventario->bem_inventariado, Conservação: $inventario->conservacao " ,
        "operacao" => "edit",
        
                ]);
        return redirect()->route("inventario.index")
                            ->with("success","Ben Atualizado com Sucesso");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Inventario $inventario)
    {
        if ($inventario->conservacao !== "Abatido") {
            
            return redirect()->back()
                    ->with("danger","Mudar o Estado de Conservação para Abatido para  Abater o Ben");

        }else{
        $inventario->delete();
        //Log de Ação
        $unidade = Unidades::where("id", $inventario->unidade_id)->first(); 
        Log::create([
        "user_id" => auth()->user()->id,
        "log"=> "Patrimonio de Id: $inventario->id, Unidade: $unidade->unidade, Categoria ID: $inventario->categoria_id, Sala: $inventario->sala, Nº Inventario: $inventario->n_inventario, NºSerie: $inventario->n_serie, Bem Inventariado: $inventario->bem_inventariado, Conservação: $inventario->conservacao" ,
        "operacao" => "delete",
        
                ]);
        return redirect()->route("inventario.index")
                    ->with("success","Ben Abatido com Sucesso");
        }
    }

    protected function validateLogin(Request $request)
    {
        if($request->input("n_serie") != "")  {            

            $regras = [
                "unidade_id" => "required",
                "sala" => "required",             
                "categoria_id" => "required",
                "n_serie" => "unique:inventarios",
                "conservacao" => "required",
                ];
            }
            elseif ($request->input("n_inventario") != "") {
                $regras = [
                    "unidade_id" => "required",
                    "sala" => "required",             
                    "categoria_id" => "required",
                    "n_inventario" => "unique:inventarios|numeric",
                    "conservacao" => "required",
                    ];
            }else {
                $regras = [
                    "unidade_id" => "required",
                    "sala" => "required",             
                    "categoria_id" => "required",                    
                    "conservacao" => "required",
                    ];
            }
            $feedback = [
        
                    "required"=>"Campo :attribute Obrigatorio",
                    "unique"=>"Esse :attribute já existe",
                    "numeric"=>"Esse :attribute precisa ser Numerico",
        
                 ];
        
            $request->validate($regras, $feedback);
    }

    
}
