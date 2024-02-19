<?php

namespace App\Http\Controllers\MachineData;

use App\Http\Controllers\Controller;
use App\Metodecheck;
use Illuminate\Http\Request;

class MetodecheckController extends Controller
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
    public function validatemethod(Request $request)
    {
        $request->validate([
            'id_metodecheck' => 'required',
            'name_metodecheck' => 'required|max:255',
        ]);
        Metodecheck::create($request->all());
        return redirect()->route("#")->withSuccess('Machine added successfully.');
    }

    protected function createmethod(array $data)
    {
        return Metodecheck::create([
            'id_metodecheck' => $data ['id_metodecheck'],
            'name_metodecheck' => $data ['name_metodecheck']
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
     * @param  \App\Metodecheck  $metodecheck
     * @return \Illuminate\Http\Response
     */
    public function show(Metodecheck $metodecheck)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Metodecheck  $metodecheck
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $request->validate([
            'id_metodecheck' => 'required',
            'name_metodecheck' => 'required|max:255',
        ]);
        $Metodechecks = Metodecheck::find($id);
        $Metodechecks->update($request->all());
        return redirect()->route("#")->withSuccess('Items updated successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Metodecheck  $metodecheck
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Metodecheck $metodecheck)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Metodecheck  $metodecheck
     * @return \Illuminate\Http\Response
     */
    public function destroy(Metodecheck $metodecheck)
    {
        //
    }
}
