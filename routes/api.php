<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\RequisicionController;
use App\Http\Controllers\oficiosController;

#region CONTROLLERS BECAS
use App\Http\Controllers\becas\RoleBecasController;
use App\Http\Controllers\becas\UserBecasController;
use App\Http\Controllers\becas\PerimeterBecasController;
use App\Http\Controllers\becas\CityBecasController;
use App\Http\Controllers\becas\ColonyBecasController;
use App\Http\Controllers\becas\LevelBecasController;
use App\Http\Controllers\becas\SchoolBecasController;
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
    Route::get('/', function(){return 'becas' ;});
    Route::post('/login', [UserBecasController::class,'login']);
    Route::post('/signup', [UserBecasController::class,'signup']);
    
    // Route::middleware('auth:sanctum')->group(function () {
        // Route::get('/getUser/{token}', [UserBecasController::class,'getUser']); //cerrar sesión (eliminar los tokens creados)
        Route::delete('/logout/{id}', [UserBecasController::class,'logout']); //cerrar sesión (eliminar los tokens creados)

        Route::controller(UserBecasController::class)->group(function () {
            Route::get('/users','index');
            Route::get('/users/selectIndex','selectIndex');
            Route::get('/users/{id}','show');
            Route::post('/users','create');
            Route::put('/users','update');
            Route::delete('/users/{id}','destroy');
        });

        Route::controller(RoleBecasController::class)->group(function () {
            Route::get('/roles','index');
            Route::get('/roles/selectIndex','selectIndex');
            Route::get('/roles/{id}','show');
            Route::post('/roles','create');
            Route::put('/roles','update');
            Route::delete('/roles/{id}','destroy');
        });

        Route::controller(PerimeterBecasController::class)->group(function () {
            Route::get('/perimeters','index');
            Route::get('/perimeters/selectIndex','selectIndex');
            Route::get('/perimeters/{id}','show');
            Route::post('/perimeters','create');
            Route::put('/perimeters','update');
            Route::delete('/perimeters/{id}','destroy');
        });

        Route::controller(CityBecasController::class)->group(function () {
            Route::get('/cities','index');
            Route::get('/cities/selectIndex','selectIndex');
            Route::get('/cities/{id}','show');
            Route::post('/cities','create');
            Route::put('/cities','update');
            Route::delete('/cities/{id}','destroy');
        });
        
        Route::controller(ColonyBecasController::class)->group(function () {
            Route::get('/colonies','index');
            Route::get('/colonies/selectIndex','selectIndex');
            Route::get('/colonies/{id}','show');
            Route::post('/colonies','create');
            Route::put('/colonies','update');
            Route::delete('/colonies/{id}','destroy');
        });

        Route::controller(LevelBecasController::class)->group(function () {
            Route::get('/levels','index');
            Route::get('/levels/selectIndex','selectIndex');
            Route::get('/levels/{id}','show');
            Route::post('/levels','create');
            Route::put('/levels','update');
            Route::delete('/levels/{id}','destroy');
        });
        
        Route::controller(SchoolBecasController::class)->group(function () {
            Route::get('/schools','index');
            Route::get('/schools/{id}','show');
            Route::post('/schools','create');
            Route::put('/schools','update');
            Route::delete('/schools/{id}','destroy');
        });
        
        
    // });
});