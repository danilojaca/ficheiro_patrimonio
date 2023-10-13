<?php

namespace App\Http\Controllers;

use App\Models\Unidades;
use App\Models\Edificio;
use App\Models\Inventario;
use App\Models\Sala;
use App\Models\Log;
use App\Models\RoleUnidades;
use Illuminate\Http\Request;

class UnidadesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    function __construct()
    {         
         $this->middleware("permission:visualizar-unidade", ["only" => ["index"]]);
         $this->middleware("permission:criar-unidade", ["only" => ["create","store"]]);
         $this->middleware("permission:editar-unidade", ["only" => ["edit","update"]]);
         $this->middleware("permission:excluir-unidade", ["only" => ["destroy"]]);
         $this->middleware("permission:salas-unidade", ["only" => ["salas","salasupdate"]]);
    }
    public function index(Request $request)
    {
        $search = $request->input('search');

        $edificios = Edificio::where("edificio","like","%$search%")->pluck('id')->toArray();

        $unidade = Unidades::wherein('edificio_id',$edificios)
        ->orwhere('unidade',"like","%$search%")
        ->orderby('edificio_id')->paginate(10);         

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

        $inventario = Inventario::where('unidade_id',$unidade->id)->pluck('id')->toArray();
              
                
        if (!empty($inventario)) {    

            return redirect()->route('unidade.index')
            ->with('danger','Unidade Possui Bens Vinculados ');
      }else{
        
        RoleUnidades::where('unidade_id',$unidade->id)->delete();
       
        $unidade->delete();       

        //Log de Ação
        Log::create([
            'user_id' => auth()->user()->id,
            'log'=> "Edificio de Id: $unidade->id , Edificio_ID: $unidade->edificio_id, Unidade: $unidade->unidade ",
            'operacao' => 'delete',

        ]);
        return redirect()->route('unidade.index')
                                ->with('success','Unidade Excluido com Sucesso');
        
      }

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

    protected function salas($unidade)
    {
        $edificio_id = Unidades::where('id',$unidade)->get();
        $edificio_id = $edificio_id->first();
       
        $edificio = $edificio_id->edificio_id;        
    

        $salas = Sala::where('edificio_id',$edificio_id->edificio_id)->orderBy('sala')->pluck('sala')->toArray();

        $salasativas = Sala::where('unidade_id',$unidade)->pluck('sala')->toArray();


        return view('salas.salaunidade',compact('salas','salasativas','unidade','edificio'));
    }

    protected function salasupdate($unidade,$edificio_id, Request $request,Sala $salas)
    {

     $salas->where('unidade_id',$unidade)->update([
        'unidade_id' => NULL
    ]); 
    
    if(isset($request->salas)){
    $sala = $salas->where('edificio_id',$edificio_id)
        ->whereIn('sala',$request->salas)->get();    

    foreach ($sala as $value) {                     
    $value->update([
            'unidade_id' => $unidade
    ]);
    }

    //Mudar Bens de Unidade correspondente a Sala que pertence.    
    $unidades = Unidades::where('edificio_id',$edificio_id)->pluck('id')->toArray();
    $inventario = Inventario::whereIn('unidade_id',$unidades)->whereIn('sala',$request->salas)->get() ;

    foreach ($inventario as $bens) {
        $bens->update([
            'unidade_id' => $unidade,
        ]);
    }
    }

        return redirect()->back();
    }
}
