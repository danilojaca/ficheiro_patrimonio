<?php
    
namespace App\Http\Controllers;
    
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\RoleUnidades;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use Illuminate\Support\Arr;
    
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {         
        $this->middleware('permission:visualizar-permissao-utilizador', ['only' => ['index']]);
        $this->middleware('permission:criar-permissao-utilizador', ['only' => ['create','store']]);
        $this->middleware('permission:editar-permissao-utilizador', ['only' => ['edit','update']]);
        $this->middleware('permission:excluir-permissao-utilizador', ['only' => ['destroy']]);
        $this->middleware('permission:mostrar-permissao-utilizador', ['only' => ['show']]);
    }
    public function index(Request $request)
    {
        $utilizador = $request->input('search');
        //Supervisor so pode ver usuarios abaixo dele 
        $user = auth()->user()->id;
        $role = DB::table('model_has_roles')->where('model_id',$user)->value('role_id');
        $perfil = Role::find($role);
        //Id Perfil Supervisor é 4
        if ($perfil->id === 4 or $perfil->name == 'Supervisor') {
        //Id Perfil Adminstrativo é 5 e Basico é 6    
         $roles = DB::table('model_has_roles')->whereIn('role_id',[5,6])->pluck('model_id')->toArray();

         $data = User::whereIn('id',$roles)->where('name','like',"%$utilizador%")->orderBy('name','ASC')->paginate(10);

        }else {
            
            $data = User::where('name','like',"%$utilizador%")->orderBy('name','ASC')->paginate(10);

        }

        return view('users.index',compact('data'))
        ->with('i', ($request->input('page', 1) - 1) * 10);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       //
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        $roleunidades = RoleUnidades::where([
            ['user_id',$id]
        ])->get();
        return view('users.show',compact('user','roleunidades'));
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name','name')->all();
        //dd($roles);
    
        return view('users.edit',compact('user','roles','userRole'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [                       
            'roles' => 'required'
        ]);
    
        $input = $request->all();
        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id',$id)->delete();
    
        $user->assignRole($request->input('roles'));
    
        return redirect()->route('users.index')
                        ->with('success','Usuario Atualizado com Sucesso');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}