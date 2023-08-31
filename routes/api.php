<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\RequisicionController;
use App\Http\Controllers\oficiosController;




Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::api('usuario',[UsuarioController::class,'index']);

Route::apiResource('usuario', UsuarioController::class);
Route::apiResource('requis', RequisicionController::class);
Route::post('pdf', [oficiosController::class, 'pdf']);
Route::get('pdf', function () {
    return 1;
});

Route::prefix('becas')->group(function () {
    Route::get('/', function () {
        return 'becas';
        });
    include_once "becas.routes.php";
});