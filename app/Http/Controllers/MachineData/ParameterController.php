<?php

namespace App\Http\Controllers\MachineData;

use App\Http\Controllers\Controller;
use App\Parameter;
use Illuminate\Http\Request;

class ParameterController extends Controller
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
    public function validateparameter(Request $request)
    {
        $request->validate([
            'id_parameter' => 'required',
            'name_parameter' => 'required|max:255',
        ]);
        Parameter::create($request->all());
        return redirect()->route("#")->withSuccess('Machine added successfully.');
    }

    protected function createparameter(array $data)
    {
        return Parameter::create([
            'id_parameter' => $data ['id_parameter'],
            'name_parameter' => $data ['name_parameter']
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
     * @param  \App\Machine  $machine
     * @return \Illuminate\Http\Response
     */
    public function show(Parameter $parameter)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Machine  $machine
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $request->validate([
            'id_parameter' => 'required',
            'name_parameter' => 'required|max:255',
        ]);
        $Parameters = Parameter::find($id);
        $Parameters->update($request->all());
        return redirect()->route("#")->withSuccess('Items updated successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Machine  $machine
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Parameter $parameter)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Machine  $machine
     * @return \Illuminate\Http\Response
     */
    public function destroy(Parameter $parameter)
    {
        //
    }
}
