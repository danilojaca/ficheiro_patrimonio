<?php

namespace App\Http\Controllers;

use App\Models\Edificio;
use App\Models\Formulario;
use App\Models\Unidades;
use App\Models\RoleUnidades;
use Illuminate\Http\Request;

class FormularioController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     function __construct(Formulario $formulario)
     {
          $this->middleware('permission:role-create', ['only' => [$formulario->where([['id_spms', '426']])]]);
     }

    public function index(Request $request)
    {
        $centro_edificio = '';
        $centro_edificio_id = '';       
        $user_id = auth()->user()->id;
            
        $roleunidades = RoleUnidades::where([
            ['user_id',$user_id]
        ])->get();

         
        
        if($request->input('_token') != ''){

        $this->validateLogin($request);

        }
        
        $search = $request->input('search');
        $search1 = $request->input('search1');  
        $centro = ''; 
        $siie = '';
        $sala = '';
        $unidade = '';


        $inventarios = Formulario::where([
  
                ['unidade_id', $search]

        ])->where([

                ['sala', $search1]
        
        ])->get();

       

        foreach ($inventarios as $inventario) {
        
        $unidades = Unidades::where('id', $inventario->unidade_id)->first();

        if ($search = $inventario->unidade_id); {
                $centro = $unidades->edificio->edificio;
                $siie =  $unidades->edificio->id_siie;
                $unidade = $unidades->unidade;
                
            
         }
         if ($search1 = $inventario->sala); {
            $sala = $inventario->sala;            
        }
    }
        return view('formulario',compact('unidade','centro_edificio_id','centro_edificio','inventarios','siie','centro','search', 'search1', 'sala','roleunidades')); 
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
    public function show(Formulario $formulario)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Formulario $formulario)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Formulario $formulario)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Formulario $formulario)
    {
        //
    }

    protected function validateLogin(Request $request)
    {
        $regras = [
            'search1' => 'required',
            'search' => 'required',
        ];
        $feedback = [ 
            'search.required'=>'Campo Centro de Saude Obrigatorio',
            'search1.required'=>'Campo Sala Obrigatorio',    
        ];

        $request->validate($regras,$feedback); 
    }

    
        
}
