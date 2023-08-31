<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\RequisicionController;
use App\Http\Controllers\oficiosController;





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

Route::prefix('becas')->group(function () {
    Route::get('/', function () {
        return 'becas';
        });
<<<<<<< HEAD

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


Route::prefix('sidit/tramites')->group(function () {
    Route::get('/',[SiditController::class,'index']);
    Route::post('/',[SiditController::class,'create']);
   
=======
    include_once "becas.routes.php";
>>>>>>> 33ae47745445adb32d02cd25ae5de4616b82945a
});