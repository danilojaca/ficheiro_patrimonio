<?php

namespace App\Http\Controllers;

use App\Models\Ben;
use Illuminate\Http\Request;

class BenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $bens = Ben::paginate(10);         

        return view('Bens\index', ['bens' => $bens, 'request' => $request->all()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Bens\create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if($request->input('_token') != ''){
            $regras = [
            'categoria' => 'required',
            'sub_categoria' => 'required', 
            ];
    
            $feedback = [
                'required' => 'Campo :attribute Obrigatorio',            
            ];
    
            $request->validate($regras, $feedback);
    
            Ben::create($request->all());
        }
            
            return redirect()->route('bens.index');
       
    }

    /**
     * Display the specified resource.
     */
    public function show(Ben $ben)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ben $ben)
    {
        return view('Bens\create', ['ben' => $ben]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ben $ben)
    {
        $ben->update($request->all());        
        return redirect()->route('bens.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ben $ben)
    {
        $ben->delete();
        return redirect()->route('bens.index');
    }
}
