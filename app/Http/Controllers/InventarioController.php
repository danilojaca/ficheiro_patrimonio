<?php

namespace App\Http\Controllers;

use App\Models\Inventario;
use App\Models\Ben;
use App\Models\Edificio;
use App\Models\Log;
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
        $inventarios = $inventario->orderBy('edificio_id')->paginate(10);
        
               
        return view('Inventario.index', ['inventarios' => $inventarios]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
        $centro_edificio = '';
        $centro_edificio_id = '';
        $user_ou = auth()->user()->ou;      

        if (auth()->user()->ou != 'Estagiarios' ){
            
        $unidade = Edificio::where([
            ['edificio', 'like', "%$user_ou%"]
        ])->get();

        foreach ($unidade as $e) {

            $centro_edificio_id = $e->id;
            $centro_edificio = $e->edificio;            
            
        }     
        }

        
        $bens = Ben::all();
        $edificios = Edificio::orderBy('edificio')->get();
        return view('Inventario.create',['bens' => $bens, 'edificios' => $edificios,'centro_edificio_id' => $centro_edificio_id,'centro_edificio' => $centro_edificio]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if($request->input('_token') != ''){

            $this->validateLogin($request);
           

        }

        Inventario::create($request->all());
           //Log de Ação
           $i = Inventario::where([
            ['edificio_id', $request->input('edificio_id')]
           ])->where([['categoria', $request->input('categoria')]
           ])->where([['sala', $request->input('sala')]
           ])->where([['n_inventario', $request->input('n_inventario')]
           ])->where([['n_serie', $request->input('n_serie')]
           ])->where([['bem_inventariado', $request->input('bem_inventariado')]
           ])->where([['conservacao', $request->input('conservacao')]])->get();
           
        foreach ($i as $e) {
        $edificio = Edificio::where('id', $e->edificio_id)->first();    

         
        Log::create([
            'user_id' => auth()->user()->id,
            'log'=> "Patrimonio de Id: $e->id, Edificio: $edificio->edificio, Categoria: $e->categoria, Sala: $e->sala, Nº Inventario: $e->n_inventario, NºSerie: $e->n_serie, Bem Inventariado: $e->bem_inventariado, Conservação: $e->conservacao " ,
            'operacao' => 'create',

        ]);}

            return redirect()->route('inventario.index');
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
        $bens = Ben::orderBy('categoria')->get();
        $edificios = Edificio::orderBy('edificio')->get();


        return view('Inventario.edit', ['inventario' => $inventario , 'bens' => $bens, 'edificios' => $edificios]);
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
        $edificio = Edificio::where('id', $inventario->edificio_id)->first(); 
        Log::create([
        'user_id' => auth()->user()->id,
        'log'=> "Patrimonio de Id: $inventario->id, Edificio: $edificio->edificio, Categoria: $inventario->categoria, Sala: $inventario->sala, Nº Inventario: $inventario->n_inventario, NºSerie: $inventario->n_serie, Bem Inventariado: $inventario->bem_inventariado, Conservação: $inventario->conservacao " ,
        'operacao' => 'edit',
        
                ]);
        return redirect()->route('inventario.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Inventario $inventario)
    {
        $inventario->delete();
        //Log de Ação
        $edificio = Edificio::where('id', $inventario->edificio_id)->first(); 
        Log::create([
        'user_id' => auth()->user()->id,
        'log'=> "Patrimonio de Id: $inventario->id, Edificio: $edificio->edificio, Categoria: $inventario->categoria, Sala: $inventario->sala, Nº Inventario: $inventario->n_inventario, NºSerie: $inventario->n_serie, Bem Inventariado: $inventario->bem_inventariado, Conservação: $inventario->conservacao" ,
        'operacao' => 'delete',
        
                ]);
        return redirect()->route('inventario.index');
    }

    protected function validateLogin(Request $request)
    {
        if($request->input('n_serie') != '')  {            

            $regras = [
                'edificio_id' => 'required',            
                'categoria' => 'required',
                'sala' => 'required',                
                'bem_inventariado' => 'required',
                'n_serie' => 'unique:inventarios',
                'conservacao' => 'required',
                ];
            }
            elseif ($request->input('n_inventario') != '') {
                $regras = [
                    'edificio_id' => 'required',            
                    'categoria' => 'required',
                    'sala' => 'required',                
                    'bem_inventariado' => 'required',
                    'n_inventario' => 'unique:inventarios',
                    'conservacao' => 'required',
                    ];
            }else {
                $regras = [
                    'edificio_id' => 'required',            
                    'categoria' => 'required',
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
