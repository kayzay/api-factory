<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('machines', ['uses' => "History\\MachinesController@index",  'as' => 'machines']);
Route::get('workers', ['uses' => "History\\WorkersController@index",  'as' => 'workers']);
Route::get('worker-history/{id}', ['uses' => "History\\WorkersController@history",  'as' => 'wr-history']);
Route::get('machine-history/{id}', ['uses' => "History\\MachinesController@history",  'as' => 'mch-history']);
