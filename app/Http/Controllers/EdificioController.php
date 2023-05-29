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

        return view('Edificio.index', ['edificios' => $edificios, 'request' => $request->all()]);
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
            ['id_spms', $request->input('id_spms')]
           ])->where([['id_siie', $request->input('id_siie')]
           ])->where([['edificio', $request->input('edificio')]
           ])->where([['concelho', $request->input('concelho')]
           ])->where([['unidade', $request->input('unidade')]])->get();
           
        foreach ($i as $e) {
         
        Log::create([
            'user_id' => auth()->user()->id,
            'log'=> "Edificio de Id: $e->id , ID SPMS: $e->id_spms ,ID SIIE: $e->id_siie ,Edificio: $e->edificio ,Concelho: $e->concelho ,Unidade: $e->unidade " ,
            'operacao' => 'create',

        ]);}
    
            return redirect()->route('edificio.index');
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
        return view('Edificio.create', ['edificio' => $edificio]);
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
            'log'=> "Edificio de Id: $edificio->id , ID SPMS: $edificio->id_spms ,ID SIIE: $edificio->id_siie ,Edificio: $edificio->edificio ,Concelho: $edificio->concelho ,Unidade: $edificio->unidade" ,
            'operacao' => 'edit',

        ]);
        return redirect()->route('edificio.index');
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
            'log'=> "Edificio de Id: $edificio->id , ID SPMS: $edificio->id_spms ,ID SIIE: $edificio->id_siie ,Edificio: $edificio->edificio ,Concelho: $edificio->concelho ,Unidade: $edificio->unidade" ,
            'operacao' => 'delete',

        ]);
        return redirect()->route('edificio.index');
    }

    protected function validateLogin(Request $request)
    {
        $regras = [
            'id_spms' => 'required|unique:edificios',
            'id_siie' => 'required|unique:edificios',
            'edificio' => 'required',
            'concelho' => 'required',
            'unidade' => 'required',
        ];
        $feedback = [            
            'unique' => ':attribute ja existe',
            'required'=>'Campo :attribute Obrigatorio',    
        ];

    $request->validate($regras,$feedback); 
    }
}
