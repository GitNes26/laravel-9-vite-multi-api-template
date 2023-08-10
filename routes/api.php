<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\RequisicionController;
use App\Http\Controllers\oficiosController;

#region CONTROLLERS BECAS
use App\Http\Controllers\Becas\SchoolController;
#endregion CONTROLLERS BECAS


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::api('usuario',[UsuarioController::class,'index']);

Route::apiResource('usuario',UsuarioController::class);
Route::apiResource('requis',RequisicionController::class);
Route::post('pdf', [ oficiosController::class,'pdf']);
Route::get('pdf', function(){
    return 1 ;
});

Route::prefix('becas')->group(function () {
    // Route::middleware('auth:sanctum')->controller(DifficultController::class)->group(function () {
    Route::controller(SchoolController::class)->group(function () {
        Route::get('/schools','index');
        Route::get('/schools/{id}','show');
        Route::post('/schools','store');
        Route::put('/schools','update');
        Route::delete('/schools/{id}','destroy');
    });
    
    Route::get('/', function(){return 'becas' ;});
    
});