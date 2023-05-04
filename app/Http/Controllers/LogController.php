<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Log;

use App\Models\User;

class LogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = $request->input('data');
        $user = $request->input('username');
       
       $username = User::where([
            ['username', $user ]
        ])->get();       
        
        $logs = Log::where([                    
            ['created_at','like',"$data%"]
            
        ])->paginate(10);

        foreach($username as $u){
         if($user != ''){
        $logs = Log::where([                    
            ['created_at','like',"$data%"]
            
        ])->Where([
            ['user_id',$u->id]
        ])->paginate(10);
        }
    
    }       
       return view('log', ['logs' => $logs]);
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
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
