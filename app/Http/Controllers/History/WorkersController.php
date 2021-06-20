<?php

namespace App\Http\Controllers\History;

use App\Http\Controllers\Controller;

class WorkersController extends Controller
{
    public function index()
    {
        return view('page.workers');
    }
    
    public function history($id)
    {
        return view('page.historyWorkers', ['id' => $id]);
    }
}
