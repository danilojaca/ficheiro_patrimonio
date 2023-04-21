<?php

namespace App\Http\Controllers;

use App\Models\Edificio;
use Illuminate\Http\Request;

class EdificioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $edificios = Edificio::paginate(10);         

        return view('Edificio\index', ['edificios' => $edificios, 'request' => $request->all()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Edificio\create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if($request->input('_token') != ''){
            $regras = [
                'id_spms' => 'required|unique:edificios',
                'id_siie' => 'required|unique:edificios',
                'edificio' => 'required',
                'concelho' => 'required',
                'unidade' => 'required',
            ];
            $feedback = [            
                'unique' => ':attribute ja existe',
                'required'=>'Campo :attribute Obrigatorio',    
            ];
    
        $request->validate($regras,$feedback);
        Edificio::create($request->all());  
        }
    
            return redirect()->route('edificio.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Edificio $edificio)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Edificio $edificio)
    {
        return view('Edificio\create', ['edificio' => $edificio]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Edificio $edificio)
    {
        $edificio->update($request->all());
        return redirect()->route('edificio.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Edificio $edificio)
    {
        $edificio->delete();
       return redirect()->route('edifico.index');
    }
}
