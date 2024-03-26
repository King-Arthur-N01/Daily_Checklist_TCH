<?php

namespace App\Http\Controllers;

use App\Historyrecords;
use Illuminate\Http\Request;

class HistoryrecordsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function insertoperatoraction(Request $request)
    {
        $operatoraction = $request->input('operator_action', []);
        $result = $request->input('result', []);

        $storeData = new Historyrecords();
        $storeData->operator_action = implode(',', $operatoraction);
        $storeData->result = implode(',', $result);
        $storeData->save();
        return redirect()->route("indexmachinerecord")->withSuccess('Checklist added successfully.');
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
     * @param  \App\Historyrecords  $historyrecords
     * @return \Illuminate\Http\Response
     */
    public function show(Historyrecords $historyrecords)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Historyrecords  $historyrecords
     * @return \Illuminate\Http\Response
     */
    public function edit(Historyrecords $historyrecords)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Historyrecords  $historyrecords
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Historyrecords $historyrecords)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Historyrecords  $historyrecords
     * @return \Illuminate\Http\Response
     */
    public function destroy(Historyrecords $historyrecords)
    {
        //
    }
}
