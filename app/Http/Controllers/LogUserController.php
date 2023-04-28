<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LogUser;

class LogUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    { 
        $data = $request->input('data');
        $user = $request->input('username');
        $ip = $request->input('ip_remoto');      
            
        $log_users = LogUser::all();

        if ($request->input('_token') != '') {
                    
        $log_users = LogUser::where([                    
            ['created_at','like',"$data%"]
            
        ])->Where([                    
            ['user',$user]
            
        ])->orWhere([                    
            ['ip_remoto',$ip]
            
        ])->get();
    }
    
        return view('loguser', ['log_users' => $log_users]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
