<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Machines;
use App\Queue;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MachinesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [];
        try {
            $listMachine = Machines::all();
            foreach ($listMachine as $item) {
                $data[] = ['id' => $item->id, 'name' => $item->name];
            }
        } catch (QueryException $e) {
            Log::error($e->getMessage());
        }

        return response()->json(['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $machine = Machines::find($id);

        $data = [];

        foreach ($machine->queue as $item) {
            $data[] = ['queue_id' => $item->id, 'name' => $item->workers->name];
        }
        return response()->json(['data' => $data]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function getActiveList()
    {
        $machines = new Machines();
        $data = [];
        foreach ($machines->getCanUseMachines() as $canUseMachine) {
            $data[$canUseMachine->id] = $canUseMachine->name;
        }

        return response()->json(['data' => $data]);
    }
}
