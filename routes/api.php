<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\RequisicionController;
use App\Http\Controllers\oficiosController;
use App\Http\Controllers\CodigoPostalController;

use App\Http\Controllers\EstadosController;



#region CONTROLLERS INGRESOS
use App\Http\Controllers\Ingresos\SiditController;

#endregion CONTROLLERS INGRESOS


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

Route::get('cp/{id}', [CodigoPostalController::class,'index']);
Route::get('cp/colonia/{id}', [CodigoPostalController::class,'colonia']);


Route::get('estados',[EstadosController::class,'index']);
Route::get('estados/{id}',[EstadosController::class,'estadosFind']);



Route::prefix('becas')->group(function () {
    Route::get('/', function () {
        return 'becas';
    });
    include_once "becas.routes.php";
});

Route::prefix('sidit/tramites')->group(function () {
    Route::get('/',[SiditController::class,'index']);
    Route::post('/',[SiditController::class,'create']);
});

Route::prefix('gpCenter')->group(function () {
    Route::get('/', function () {
        return 'API GPCenter';
    });
    include_once "gpcenter.routes.php";
});

Route::prefix('gomezapp')->group(function () {
    Route::get('/', function () {
        return 'API GomezApp';
    });
    include_once "gomezapp.routes.php";
});
