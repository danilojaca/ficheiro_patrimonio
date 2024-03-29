<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\LogUser;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Session;
use App\Models\SessionData;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
   
    public function login(Request $request)
    {    
        $this->validateLogin($request);
        
        // Conectar-se com o Active Directory
        $ldap_host = "ldap://10.11.5.15"; // Endereço do servidor Active Directory
        $ldap_port = "389"; // Porta padrão do LDAP
        $ldap_dn = "dc=arsalgarve,dc=local"; // DN do domínio do AD
        $ldap_dominio = "arsalgarve.local"; //Domínio
        $ldap_user = ldap_escape($request->input('username'), '', LDAP_ESCAPE_FILTER) . "@" . $ldap_dominio; // Nome de user para autenticação no AD
        $ldap_pass = ldap_escape($request->input('password'), '', LDAP_ESCAPE_FILTER); // Senha para autenticação no AD
 
        $ldap_conn = ldap_connect($ldap_host, $ldap_port); // Conecta com o servidor LDAP
        ldap_set_option($ldap_conn, LDAP_OPT_PROTOCOL_VERSION, 3); // Define a versão do protocolo LDAP
        ldap_set_option($ldap_conn, LDAP_OPT_REFERRALS, 0); // Define se deve seguir referências
        
        if (@ldap_bind($ldap_conn, $ldap_user, $ldap_pass)){
            

        $search_filter = "(sAMAccountName=".ldap_escape($request->input('username'), '', LDAP_ESCAPE_FILTER).")"; // Filtro de busca para encontrar o usuário       
        $search = ldap_search($ldap_conn, $ldap_dn, $search_filter); // Busca o usuário em todas as OUs da AD
        $user_info = ldap_get_entries($ldap_conn, $search); // Obtém as informações do usuário encontrado
       
        if ($user_info['count'] > 0) { // Verifica se o usuário foi encontrado
        $user_dn = $user_info[0]['dn']; // Obtém o DN do usuário encontrado
        
        $username = $user_info[0]['samaccountname'][0];// Obtém o username do usuário encontrado
        $name = $user_info[0]['name'][0];// Obtém o Nome  do usuário encontrado
        $password = $request->input('password');
       
        
                   
        //Inserir usuario no DB
        $samaccountname = User::where('username',$username)->get();
          
        //Se usuario ja existe atualizar
        if (isset($samaccountname[0])){ 

        $id = $samaccountname[0]['id'];
        $user = User::find($id);
            $user->update([              
                'name' => $name,
                'username' => $username,
                'password' => Hash::make($password),
                
            ]);
        //Se usuario nao existir criar 
        }else {            
        $user =  User::create([              
                'name' => $name,
                'username' => $username,
                'password' => Hash::make($password),
                
            ]);
        //Vincular Utilizador Criado com o Perfil Basico(id 6)    
        $role = Role::find(6);
        $user->assignRole([$role->id]);
            
        } 
        $accountname = User::where('username',$username)->get();
        $id = $accountname[0]['id'];

        //Derrubar usuarios com acesso simultaneo
        
        $sessiondata = SessionData::where('user_id',$id)->get();
    
                
        if (isset($sessiondata[0])) { 

            session_start();            
            session_destroy();
            SessionData::where([
                ['user_id',$id]
            ])->delete();
       
            //Avisar que o usuario ja esta conectado em outra sessao
            //return redirect()->route('login')->with(['login' => "O Usuario estava Logado em Outro Dispositivo ou Navegador porém ja foi desconectado tente logar novamente"]); 
            
        } 
        //Autenticação 
    $credentials = $request->only('username', 'password');    
    if (Auth::attempt($credentials)) {

    //Log de Acesso 
        LogUser::create([
            'user' => auth()->user()->username,
            'log' => "Autenticação realizada com sucesso",
            'operacao' => 'login',
            'ip_remoto' => $_SERVER['REMOTE_ADDR'],
        ]);

        
        return redirect()->intended('/');
    }         
        }
     }else {

    //Log de Acesso 
        LogUser::create([
            'user' => $request->input('username'),
            'log' => "Tentativa de Autenticação",
            'operacao' => 'login',
            'ip_remoto' => $_SERVER['REMOTE_ADDR'],
        ]);
        
   return redirect()->route('login')->with(['login' => "Usuário não encontrado"]);

}
     
}

protected function validateLogin(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);
    }


    



}
