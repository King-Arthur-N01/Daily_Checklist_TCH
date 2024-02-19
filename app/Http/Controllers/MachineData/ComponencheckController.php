<?php

namespace App\Http\Controllers\MachineData;

use App\Http\Controllers\Controller;
use App\Componencheck;
use Illuminate\Http\Request;

class ComponencheckController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function validatecomponen(Request $request)
    {
        $request->validate([
            'id_componencheck' => 'required',
            'name_componencheck' => 'required|max:255'
        ]);
        Componencheck::create($request->all());
        return redirect()->route("#")->withSuccess('Machine added successfully.');
    }

    protected function createcomponen(array $data)
    {
        return Componencheck::create([
            'id_componencheck' => $data ['id_componencheck'],
            'name_componencheck' => $data ['name_componencheck']
        ]);
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
     * @param  \App\Componencheck  $componencheck
     * @return \Illuminate\Http\Response
     */
    public function show(Componencheck $componencheck)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Componencheck  $componencheck
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $request->validate([
            'id_componencheck' => 'required',
            'name_componencheck' => 'required|max:255'
        ]);
        $Componenchecks = Componencheck::find($id);
        $Componenchecks->update($request->all());
        return redirect()->route("#")->withSuccess('Items updated successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Componencheck  $componencheck
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Componencheck $componencheck)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Componencheck  $componencheck
     * @return \Illuminate\Http\Response
     */
    public function destroy(Componencheck $componencheck)
    {
        //
    }
}
