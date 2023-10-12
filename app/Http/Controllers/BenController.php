<?php

namespace App\Http\Controllers;

use App\Models\Ben;
use App\Models\Log;
use App\Models\Inventario;
use Illuminate\Http\Request;

class BenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    function __construct()
    {
         $this->middleware('permission:categoria');
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $bens = Ben::where('sub_categoria',"like","%$search%")->orderby('categoria')->paginate(12);         

        return view('Bens.index', compact('bens'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Bens.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if($request->input('_token') != ''){
           
            $this->validateLogin($request);
            
        }
        
        Ben::create($request->all());

            //Log de Ação
        $i = Ben::where([
            ['categoria', $request->input('categoria')]
           ])->where([['sub_categoria', $request->input('sub_categoria')]])->get();
           
        foreach ($i as $e) {
         
        Log::create([
            'user_id' => auth()->user()->id,
            'log'=> "Categoria de Id: $e->id , ID Categoria: $e->categoria ,Sub Categoria: $e->sub_categoria" ,
            'operacao' => 'create',

        ]);}
            
            return redirect()->route('bens.index')
                            ->with('success','Categoria Criada com Sucesso');
       
    }

    /**
     * Display the specified resource.
     */
    public function show(Ben $ben)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ben $ben)
    {
        return view('Bens.create', ['ben' => $ben]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ben $ben)
    {
        
        if($request->input('_token') != ''){
           
        $this->validateLogin($request);
    }

        $ben->update($request->all());

        //Log de Ação
        Log::create([
        'user_id' => auth()->user()->id,
        'log'=> "Categoria de Id: $ben->id , Categoria: $ben->categoria ,Sub Categoria: $ben->sub_categoria " ,
        'operacao' => 'edit',

        ]);       
        return redirect()->route('bens.index')
                        ->with('success','Categoria Atualizada com Sucesso');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ben $ben)
    {

        $inventario = Inventario::where('categoria_id',$ben->id)->pluck('id')->toArray();
       
        if (!empty($inventario)) {    

            return redirect()->route('bens.index')
            ->with('danger','Categoria Possui Bens Vinculados ');
      }else{
        $ben->delete();
        
        //Log de Ação
        Log::create([
        'user_id' => auth()->user()->id,
        'log'=> "Categoria de Id: $ben->id , Categoria: $ben->categoria ,Sub Categoria: $ben->sub_categoria" ,
        'operacao' => 'delete',
    
            ]);  
        return redirect()->route('bens.index')
                            ->with('success','Categoria Excluido com Sucesso');
        }
    }

    protected function validateLogin(Request $request)
    {
        $regras = [
            'categoria' => 'required',
            'sub_categoria' => 'required', 
            ];
    
            $feedback = [
                'required' => 'Campo :attribute Obrigatorio',            
            ];
    
            $request->validate($regras, $feedback); 
    }
}
