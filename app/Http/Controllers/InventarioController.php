<?php

namespace App\Http\Controllers;

use App\Models\Inventario;
use App\Models\Ben;
use App\Models\Edificio;
use App\Models\Log;
use Illuminate\Http\Request;

class InventarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request  $request)
    {
        $inventarios = Inventario::paginate(10);
       
        return view('Inventario\index', ['inventarios' => $inventarios,'request' => $request->all()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $bens = Ben::all();
        $edificios = Edificio::orderBy('edificio')->get();
        return view('Inventario\create',['bens' => $bens, 'edificios' => $edificios]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if($request->input('_token') != ''){

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
            Inventario::create($request->all());

        }
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
         
        Log::create([
            'user_id' => auth()->user()->id,
            'log'=> "Patrimonio de Id: $e->id  Adicionado " ,
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
        return view('Inventario\edit', ['inventario' => $inventario , 'bens' => $bens, 'edificios' => $edificios]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Inventario $inventario)
    {
        $inventario->update($request->all());
        return redirect()->route('inventario.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Inventario $inventario)
    {
        $inventario->delete();
        return redirect()->route('inventario.index');
    }
}
