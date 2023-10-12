<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LogUser;

class LogUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    function __construct()
    {
         $this->middleware('permission:logs');
    }

    public function index(Request $request)
    { 
        $data = $request->input('data');
        $user = $request->input('username'); 
        
        $log_users = LogUser::where('created_at','like',"$data%")->orderBy('created_at','desc')->paginate(15);
                    
        if (isset($user)) {
                    
        $log_users = LogUser::where([                    
            ['created_at','like',"$data%"],                    
            ['user',$user]            
        ])->orderBy('created_at','desc')->paginate(15);
    }
    
        return view('logs.loguser', compact('log_users', 'data','user'));
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
