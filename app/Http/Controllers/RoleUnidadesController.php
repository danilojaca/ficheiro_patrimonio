<?php

namespace App\Http\Controllers;

use App\Models\RoleUnidades;
use App\Models\Unidades;
use App\Models\User;
use App\Models\Sala;
use App\Models\RoleClass;
use Spatie\Permission\Models\Role;
use App\Models\Inventario;
use Illuminate\Http\Request;
use DB;

class RoleUnidadesController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    function __construct(){

        $this->middleware("permission:salas-permissao-utilizador", ["only" => ["roleclass","roleclassupdate"]]);
        $this->middleware("permission:unidades-permissao-utilizador", ["only" => ["edit","update"]]);
    }
    public function index(Request $request)
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
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
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $users = User::find($id);
        $user = $users->name;        

        $unidades = Unidades::all();

        $roleunidades = RoleUnidades::where('user_id',$id)->pluck('unidade_id')->toArray();
        
        return view('roleunidades.edit',compact('user','unidades','users','roleunidades'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id, RoleUnidades $roleUnidades)  
    {
        
        //Excluir Permissões de Unidades 
        $roleUnidades->where([
            ['user_id',$id],        
            ])->delete(); 
        //

        //dd($request->unidade_id);
        if (isset($request->unidade_id)) {

            $unidades = $request->unidade_id;
            
        }else {
            $unidades  = array();
        }
        
        //Excluir Permissões de Salas Das Unidades Retiradas
        RoleClass::where('user_id',$id)->whereNotIn('unidade_id', $unidades)->delete(); 
        //
        foreach ($unidades as $unidade) {
            //Criar Permissões de Unidades    
            $roleUnidades->create([
                'unidade_id' => $unidade,
                'user_id' => $id,
            ]);
            //

            //Criar Permissões de Salas para Unidades Selecionadas
            $unidade_id = RoleClass::where([
                ['user_id',$id],
                ['unidade_id',$unidade]
            ])->pluck('unidade_id')->toArray();

            $unidade_id = array_count_values($unidade_id);

            $unidade_id = array_key_first($unidade_id);

                if (!$unidade_id == $unidade) { 
                    $salas = Sala::where('unidade_id',$unidade)->pluck('sala')->toArray();
                    foreach ($salas as $sala) {      
                        RoleClass::create([
                            'user_id' => $id,
                            'unidade_id' => $unidade,
                            'sala' => $sala,
                        ]);
                    }
                }
            
        }    
     
    
        return redirect()->route('users.index')
                        ->with('success','Regra Atualizada com Sucesso');
    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RoleUnidades $roleUnidades)
    {
        //
    }

    public function roleclass(Request $request,$user)

    {   
        $salas = array();
        $id_unidade = $request->input('unidade_id');
        $utilizador = User::where('id',$user)->value('name');
        $unidades =  RoleUnidades::where('user_id',$user)->get();
        

        if (isset($id_unidade)) {            
            $salas = Sala::where('unidade_id',$id_unidade)->orderBy('sala')->pluck('sala')->toArray();
            $salas = array_count_values($salas);
        } 
        
        $salasexist = RoleClass::where([['user_id',$user],['unidade_id',$id_unidade]])->pluck("sala")->toArray();
                
        return view('roleunidades.roleclass',compact('unidades','id_unidade','salas','salasexist','utilizador','user'));        

    }

    public function roleclassupdate(Request $request, RoleClass $roleclass){

        $salas = $request->salas;
        $unidade = $request->input('unidade');
        $user = $request->input('user');

        $roleclass->where([['user_id',$user],['unidade_id',$unidade]])->delete();

        if (isset($salas)) {
            
        foreach ($salas as $sala) {
            $roleclass->create([
                'user_id' => $user,
                'unidade_id' => $unidade,
                'sala' => $sala,
            ]);
        }
        }
        return redirect()->back();
    }
}
