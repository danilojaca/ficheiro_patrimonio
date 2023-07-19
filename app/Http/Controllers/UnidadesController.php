<?php

namespace App\Http\Controllers;

use App\Models\Unidades;
use App\Models\Edificio;
use App\Models\Log;
use Illuminate\Http\Request;

class UnidadesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    function __construct()
    {
         $this->middleware('permission:unidade');
    }
    public function index()
    {
        $unidade = Unidades::orderby('unidade')->paginate(12);         

        return view('unidade.index', compact('unidade'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
        $edificios = Edificio::orderby('edificio')->get();
        return view('unidade.create', compact('edificios'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if($request->input('_token') != ''){
           
            $this->validateLogin($request);
              
            }
        Unidades::create($request->all());

        //Log de Ação
        $i = Unidades::where([
            ['edificio_id', $request->input('edificio_id')],
            ['unidade', $request->input('unidade')]
           ])->get();
           
        foreach ($i as $e) {
         
        Log::create([
            'user_id' => auth()->user()->id,
            'log'=> "Unidade de Id: $e->id , Edificio_ID: $e->edificio_id ,Unidade: $e->unidade " ,
            'operacao' => 'create',

        ]);}
        return redirect()->route('unidade.index')
                                ->with('success','Unidade Criado com Sucesso');
    }

    /**
     * Display the specified resource.
     */
    public function show(Unidades $unidade)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Unidades $unidade)
    {
       
        $edificios = Edificio::orderby('edificio')->get();
        return view('unidade.edit', compact('edificios','unidade'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Unidades $unidade)
    {
        if($request->input('_token') != ''){
           
            $this->validateLogin($request);
              
            }
       
        $unidade->update($request->all());

        //Log de Ação
        $i = Unidades::where([
            ['edificio_id', $request->input('edificio_id')],
            ['unidade', $request->input('unidade')]
           ])->get();
           
        foreach ($i as $e) {
         
        Log::create([
            'user_id' => auth()->user()->id,
            'log'=> "Unidade de Id: $e->id , Edificio_ID: $e->edificio_id ,Unidade: $e->unidade " ,
            'operacao' => 'update',

        ]);}
        return redirect()->route('unidade.index')
                                ->with('success','Unidade Criado com Sucesso');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Unidades $unidade)
    {  
       
        $unidade->delete();       

        //Log de Ação
        Log::create([
            'user_id' => auth()->user()->id,
            'log'=> "Edificio de Id: $unidade->id , Edificio_ID: $unidade->edificio_id, Unidade: $unidade->unidade ",
            'operacao' => 'delete',

        ]);
        return redirect()->route('unidade.index')
                                ->with('success','Edificio Excluido com Sucesso');

    }

    protected function validateLogin(Request $request)
    {
        $regras = [
            'edificio_id' => 'required',
            'unidade' => 'required',            
        ];
        $feedback = [            
            'unique' => ':attribute ja existe',
            'required'=>'Campo :attribute Obrigatorio',    
        ];

    $request->validate($regras,$feedback); 
    }
}