<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Admin\MarkerController;
use App\Http\Controllers\Admin\PolygonController;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'admin']], function () {
    Route::resource('/marker', MarkerController::class);
    Route::resource('/polygon', PolygonController::class);
});

Route::group(["prefix"=>"client","middleware"=>"auth"],function (){
    Route::get("/allTrees",[\App\Http\Controllers\Client\ClientController::class,"allTrees"])->name("all-trees");
    Route::get("/growTree/{id}",[\App\Http\Controllers\Client\ClientController::class,"growTree"])->name("grow-tree");
    Route::post("/buyTree",[\App\Http\Controllers\Client\ClientController::class,"buyTree"])->name("buyTree");
    Route::get("/my-tree",[\App\Http\Controllers\Client\ClientController::class,"myTree"])->name("my-tree");
    Route::get("/my-polygon/{id}",[\App\Http\Controllers\Client\ClientController::class,"myPolygon"])->name("my-polygon");
});
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
