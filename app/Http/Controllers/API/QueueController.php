<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Queue;
use Illuminate\Http\Request;

class QueueController extends Controller
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
        $req = $request->except('_token');
        $status = 1;

        $queue = Queue::where([
            ['worker_id', '=', 1],
            ['machine_id', '=', 1],
            ['status', '=', Queue::STATUS_ACTIVE]
        ])->get();

        if(count($queue) <= 1) {
            (new Queue([
                'worker_id' => $req['worker_id'],
                'machine_id' => $req['machines_id'],
                'status' => Queue::STATUS_ACTIVE
            ]))->save();
        } else {
            $status = 0;
        }

        return response()->json(['status' => $status]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $queue = Queue::find($id);
        $queue->status = Queue::STATUS_REMOVE;
        $queue->save();

        return response()->json(['status' => 1]);
    }

    public function machineHistory($id, Request $req)
    {
        
        $offset = $req->start;
        $length = $req->length;

        $queue = new Queue();
        $queue
            ->setPaginationLimit($length)
            ->setPaginationOffset($offset);
        
        $data = $queue->getPageData($queue->getHistoryMachine($id));

        $total = $queue->getPaginationRowTotal();

        $response = [
            "recordsTotal" => $total,
            "recordsFiltered" => $total,
            "data" => $data
        ];

       if (isset($req->draw)) {
           $response['draw'] = $req->draw;
       }

        return response()->json($response);
    }

    public function workerHistory($id, Request $req)
    {
        
        $offset = $req->start;
        $length = $req->length;

        $queue = new Queue();
        $queue
            ->setPaginationLimit($length)
            ->setPaginationOffset($offset);

        $data = $queue->getPageData($queue->getHistoryWorker($id));
        
        $total = $queue->getPaginationRowTotal();

        $response = [
            "recordsTotal" => $total,
            "recordsFiltered" => $total,
            "data" => $data
        ];

       if (isset($req->draw)) {
           $response['draw'] = $req->draw;
       }

        return response()->json($response);
    }
}
