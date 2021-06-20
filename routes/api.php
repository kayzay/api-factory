<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('workers', "API\\WorkersController")->names('workers');
Route::resource('machines', "API\\MachinesController")->names('machines');
Route::resource('queue', "API\\QueueController")->names('queue');
Route::get('worker-history/{worker_id}', ['uses' => "API\\QueueController@workerHistory", 'as' => 'worker-history']);
Route::get('machine-history/{machine_id}', ['uses' => "API\\QueueController@machineHistory", 'as' => 'machine-history']);
Route::get('machine-active-list', ['uses' => "API\\MachinesController@getActiveList",  'as' => 'getActiveList']);


