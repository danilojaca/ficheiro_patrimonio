<?php

namespace App\Http\Controllers;

use App\Models\Inventario;
use App\Models\Ben;
use App\Models\Edificio;
use App\Models\Log;
use App\Models\RoleUnidades;
use App\Models\Unidades;
use Illuminate\Http\Request;
use Spatie\Permission\Contracts\Permission;
use Spatie\Permission\Contracts\Role;
use Spatie\Permission\Middlewares\PermissionMiddleware;
use Spatie\Permission\Middlewares\RoleMiddleware;

class InventarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    function __construct(Inventario $inventario)
    {
         $this->middleware('permission:inventario-list|inventario-create|inventario-edit|inventario-delete', ['only' => ['index','store']]);
         $this->middleware('permission:inventario-create', ['only' => ['create','store']]);
         $this->middleware('permission:inventario-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:inventario-delete', ['only' => ['destroy']]);
        
    }

    public function index(Inventario $inventario)
    {    
        $user_id = auth()->user()->id;

        $unidades = RoleUnidades::where([
            ['user_id',$user_id]
        ])->pluck('unidade_id')->toArray();
        
        $inventarios = Inventario::whereIn('unidade_id',$unidades)->orderBy('unidade_id')->orderBy('sala')->paginate(10); 
         
        return view('Inventario.index', compact('inventarios') );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categorias = array('Informatica','Clinico','Mobiliario','Outros');
        $centro_edificio = '';
        $centro_edificio_id = '';
        $user_id = auth()->user()->id;
        
        $bens = Ben::all();
        $roleunidades = RoleUnidades::where([
            ['user_id',$user_id]
        ])->get();
        return view('Inventario.create1',compact('categorias','bens','roleunidades','centro_edificio_id','centro_edificio'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        if($request->input('_token') != ''){

            $this->validateLogin($request);           

        }  

        $unidades = $request->input('unidade_id')[0];

        $sala = $request->input('sala')[0];        
        
        $count = count($request->categoria_id);
        
        for ($i=0; $i < $count ; $i++) { 

        $inventario =  Inventario::create([
                'unidade_id' => $unidades,                
                'sala' => $sala,
                'modelo' => $request->modelo[$i],
                'n_inventario' => $request->n_inventario[$i],
                'categoria_id' => $request->categoria_id[$i],
                'n_serie' => $request->n_serie[$i],
                'bem_inventariado' => $request->bem_inventariado[$i],
                'conservacao' => $request->conservacao[$i],
            ]);

           //Log de Ação 
        $unidade = Unidades::where('id', $unidades)->first();
         
        Log::create([
            'user_id' => auth()->user()->id,
            'log'=> "Patrimonio de Id: $inventario->id, Unidade: $unidade->unidade, Categoria ID: $inventario->categoria_id, Sala: $sala, Nº Inventario: $inventario->n_inventario, NºSerie: $inventario->n_serie, Bem Inventariado: $inventario->bem_inventariado, Conservação: $inventario->conservacao" ,
            'operacao' => 'create',

        ]);

    }
            return redirect()->route('inventario.index')
                            ->with('success','Ben Criado com Sucesso');
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
    public function edit(Inventario $inventario)
    {
        $categorias = array('Informatica','Clinico','Mobiliario','Outros');
        $user_id = auth()->user()->id;
        $bens = Ben::orderBy('categoria')->get();
        $roleunidades = RoleUnidades::where([
            ['user_id',$user_id]
        ])->get();


        return view('Inventario.edit', compact('categorias','inventario', 'bens', 'roleunidades'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Inventario $inventario)
    {
        
        if($request->input('_token') != ''){

            $this->validateLogin($request);
                
    
            } 
                 
            $inventario->update($request->all());
        

        //Log de Ação
        $unidade = Unidades::where('id', $inventario->unidade_id)->first(); 
        Log::create([
        'user_id' => auth()->user()->id,
        'log'=> "Patrimonio de Id: $inventario->id, Unidade: $unidade->unidade, Categoria: $inventario->categoria_id, Sala: $inventario->sala, Nº Inventario: $inventario->n_inventario, NºSerie: $inventario->n_serie, Bem Inventariado: $inventario->bem_inventariado, Conservação: $inventario->conservacao " ,
        'operacao' => 'edit',
        
                ]);
        return redirect()->route('inventario.index')
                            ->with('success','Ben Atualizado com Sucesso');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Inventario $inventario)
    {
        $inventario->delete();
        //Log de Ação
        $unidade = Unidades::where('id', $inventario->unidade_id)->first(); 
        Log::create([
        'user_id' => auth()->user()->id,
        'log'=> "Patrimonio de Id: $inventario->id, Unidade: $unidade->unidade, Categoria ID: $inventario->categoria_id, Sala: $inventario->sala, Nº Inventario: $inventario->n_inventario, NºSerie: $inventario->n_serie, Bem Inventariado: $inventario->bem_inventariado, Conservação: $inventario->conservacao" ,
        'operacao' => 'delete',
        
                ]);
        return redirect()->route('inventario.index')
                    ->with('success','Ben Excluido com Sucesso');
    }

    protected function validateLogin(Request $request)
    {
        if($request->input('n_serie') != '')  {            

            $regras = [
                'unidade_id' => 'required',            
                'categoria_id' => 'required',
                'sala' => 'required',                
                'bem_inventariado' => 'required',
                'n_serie' => 'unique:inventarios',
                'conservacao' => 'required',
                ];
            }
            elseif ($request->input('n_inventario') != '') {
                $regras = [
                    'unidade_id' => 'required',            
                    'categoria_id' => 'required',
                    'sala' => 'required',                
                    'bem_inventariado' => 'required',
                    'n_inventario' => 'unique:inventarios',
                    'conservacao' => 'required',
                    ];
            }else {
                $regras = [
                    'unidade_id' => 'required',            
                    'categoria_id' => 'required',
                    'sala' => 'required',                
                    'bem_inventariado' => 'required',                    
                    'conservacao' => 'required',
                    ];
            }
            $feedback = [
        
                    'required'=>'Campo :attribute Obrigatorio',
                    'unique'=>'Esse :attribute já existe',
        
                 ];
        
            $request->validate($regras, $feedback);
    }

    
}
