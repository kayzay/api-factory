<?php

namespace App\Http\Controllers\History;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MachinesController extends Controller
{

    public function index()
    {
        return view('page.machines');
    }
    
    public function history($id)
    {
        return view('page.historyMachine', ['id' => $id]);
    }
}
