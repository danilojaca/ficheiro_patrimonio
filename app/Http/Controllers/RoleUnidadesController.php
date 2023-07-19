<?php

namespace App\Http\Controllers;

use App\Models\RoleUnidades;
use App\Models\Unidades;
use App\Models\User;
use Illuminate\Http\Request;
use DB;

class RoleUnidadesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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
    public function update(Request $request, $id,RoleUnidades $roleUnidades)    {
        
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
                        ->with('success','Role updated successfully');
    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RoleUnidades $roleUnidades)
    {
        //
    }
}