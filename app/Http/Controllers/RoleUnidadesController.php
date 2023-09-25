<?php

namespace App\Http\Controllers;

use App\Models\RoleUnidades;
use App\Models\Unidades;
use App\Models\User;
use App\Models\RoleClass;
use App\Models\Inventario;
use Illuminate\Http\Request;
use DB;

class RoleUnidadesController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    function __construct(){

        $this->middleware("permission:role-class", ["only" => ["roleclass","roleclassupdate"]]);
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
    public function update(Request $request, $id, RoleUnidades $roleUnidades)    {
        
    $unidades = $request->input('edificio_id');

    $roleUnidades->where([
        ['user_id',$id],        
        ])->delete(); 

    foreach ($unidades as $unidade) {
    $roleUnidades->create([
        'unidade_id' => $unidade,
        'user_id' => $id,
    ]);
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

    public function roleclass(Request $request)

    {   
        $salas = array();
        $id_unidade = "";
        $users = array();
        $user_id = auth()->user()->id;
        $unidades =  RoleUnidades::where('user_id',$user_id)->get();
        if ($request->input('unidade_id') != ""){
        $id_unidade = $request->input('unidade_id');
        $users = RoleUnidades::where("unidade_id",$id_unidade)->get();
        }
        $usuario = $request->input('user');
        if (isset($usuario)) {            
            $salas = Inventario::where('unidade_id',$id_unidade)->pluck('sala')->toArray();
            $salas = array_count_values($salas);
        } 
        
        $salasexist = RoleClass::where([['user_id',$usuario],['unidade_id',$id_unidade]])->pluck("sala")->toArray();
                
        return view('roleunidades.roleclass',compact('unidades','users','id_unidade','usuario','salas','salasexist'));        

    }

    public function roleclassupdate(Request $request, RoleClass $roleclass){

        $salas = $request->salas;
        $unidade = $request->input('unidade');
        $user = $request->input('user');

        $roleclass->where([['user_id',$user],['unidade_id',$unidade]])->delete();

        foreach ($salas as $sala) {
            $roleclass->create([
                'user_id' => $user,
                'unidade_id' => $unidade,
                'sala' => $sala,
            ]);
        }

        return redirect()->back();
    }
}
