<?php

namespace App\Http\Controllers;

use App\Models\Edificio;
use Illuminate\Http\Request;
use App\Models\Log;

class EdificioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    function __construct()
    {
         $this->middleware('permission:edificio');
    }

    public function index(Request $request)
    {
        $edificios = Edificio::orderby('edificio')->paginate(12);         

        return view('Edificio.index', compact('edificios') );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Edificio.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if($request->input('_token') != ''){
           
        $this->validateLogin($request);
          
        }
        
        Edificio::create($request->all());

        //Log de Ação
        $i = Edificio::where([
            ['id_spms', $request->input('id_spms')],
            ['id_siie', $request->input('id_siie')]
           ])->get();
           
        foreach ($i as $e) {
         
        Log::create([
            'user_id' => auth()->user()->id,
            'log'=> "Edificio de Id: $e->id , ID SPMS: $e->id_spms ,ID SIIE: $e->id_siie ,Edificio: $e->edificio ,Concelho: $e->concelho ,Aces: $e->aces ,Morada: $e->morada ,Ip Router: $e->ip_router " ,
            'operacao' => 'create',

        ]);}
    
            return redirect()->route('edificio.index')
                                ->with('success','Edificio Criado com Sucesso');
    }

    /**
     * Display the specified resource.
     */
    public function show(Edificio $edificio)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Edificio $edificio)
    {
        dd($edificio);
        return view('Edificio.create', compact('edificio') );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Edificio $edificio)
    {
        if($request->input('_token') != ''){
           
            $this->validateLogin($request);
              
            }
        $edificio->update($request->all());

        //Log de Ação
        Log::create([
            'user_id' => auth()->user()->id,
            'log'=> "Edificio de Id: $edificio->id , ID SPMS: $edificio->id_spms ,ID SIIE: $edificio->id_siie ,Edificio: $edificio->edificio ,Concelho: $edificio->concelho ,Aces: $edificio->aces ,Morada: $edificio->morada ,Ip Router: $edificio->ip_router",
            'operacao' => 'edit',

        ]);
        return redirect()->route('edificio.index')
                                ->with('success','Edificio Atualizado com Sucesso');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Edificio $edificio)
    {
        
        $edificio->delete();

        //Log de Ação
        Log::create([
            'user_id' => auth()->user()->id,
            'log'=> "Edificio de Id: $edificio->id , ID SPMS: $edificio->id_spms ,ID SIIE: $edificio->id_siie ,Edificio: $edificio->edificio ,Concelho: $edificio->concelho ,Aces: $edificio->aces ,Morada: $edificio->morada ,Ip Router: $edificio->ip_router",
            'operacao' => 'delete',

        ]);
        return redirect()->route('edificio.index')
                                ->with('success','Edificio Excluido com Sucesso');
    }

    protected function validateLogin(Request $request)
    {
        $regras = [
            'id_spms' => 'required|unique:edificios',
            'id_siie' => 'required|unique:edificios',
            'edificio' => 'required',
            'concelho' => 'required',
            'aces' => 'required',
            'morada' => 'required',
            'ip_router' => 'required',
        ];
        $feedback = [            
            'unique' => ':attribute ja existe',
            'required'=>'Campo :attribute Obrigatorio',    
        ];

    $request->validate($regras,$feedback); 
    }
}
