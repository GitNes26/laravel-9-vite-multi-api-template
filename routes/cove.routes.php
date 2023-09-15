<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

#region CONTROLLERS
use App\Http\Controllers\Cove\UserController;
use App\Http\Controllers\Cove\RoleController;
use App\Http\Controllers\Cove\DepartmentController;
use App\Http\Controllers\Cove\BrandController;
use App\Http\Controllers\Cove\ModelController;

#endregion CONTROLLERS

Route::post('/login', [UserController::class, 'login']);
Route::post('/signup', [UserController::class, 'signup']);

// Route::middleware('auth:sanctum')->group(function () {
// Route::get('/getUser/{token}', [UserController::class,'getUser']); //cerrar sesión (eliminar los tokens creados)
Route::delete('/logout/{id}', [UserController::class, 'logout']); //cerrar sesión (eliminar los tokens creados)

Route::controller(UserController::class)->group(function () {
   Route::get('/users', 'index');
   Route::get('/users/selectIndex', 'selectIndex');
   Route::get('/users/{id}', 'show');
   Route::post('/users', 'create');
   Route::put('/users/{id?}', 'update');
   Route::delete('/users/{id}', 'destroy');
});

Route::controller(RoleController::class)->group(function () {
   Route::get('/roles', 'index');
   Route::get('/roles/selectIndex', 'selectIndex');
   Route::get('/roles/{id}', 'show');
   Route::post('/roles', 'create');
   Route::put('/roles/{id?}', 'update');
   Route::delete('/roles/{id}', 'destroy');
});

Route::controller(DepartmentController::class)->group(function () {
   Route::get('/departments', 'index');
   Route::get('/departments/selectIndex', 'selectIndex');
   Route::get('/departments/{id}', 'show');
   Route::post('/departments', 'create');
   Route::put('/departments/{id?}', 'update');
   Route::delete('/departments/{id}', 'destroy');
});

Route::controller(BrandController::class)->group(function () {
   Route::get('/brands', 'index');
   Route::get('/brands/selectIndex', 'selectIndex');
   Route::get('/brands/{id}', 'show');
   Route::post('/brands', 'create');
   Route::put('/brands/{id?}', 'update');
   Route::delete('/brands/{id}', 'destroy');
});

Route::controller(ModelController::class)->group(function () {
   Route::get('/models', 'index');
   Route::get('/models/brand/{brand_id}', 'selectIndex');
   Route::get('/models/{id}', 'show');
   Route::post('/models', 'create');
   Route::put('/models/{id?}', 'update');
   Route::delete('/models/{id}', 'destroy');
});

// Route::controller(LevelBecasController::class)->group(function () {
//    Route::get('/levels', 'index');
//    Route::get('/levels/selectIndex', 'selectIndex');
//    Route::get('/levels/{id}', 'show');
//    Route::post('/levels', 'create');
//    Route::put('/levels/{id?}', 'update');
//    Route::delete('/levels/{id}', 'destroy');
// });

// Route::controller(SchoolBecasController::class)->group(function () {
//    Route::get('/schools', 'index');
//    Route::get('/schools/{id}', 'show');
//    Route::post('/schools', 'create');
//    Route::put('/schools/{id?}', 'update');
//    Route::delete('/schools/{id}', 'destroy');
// });


// });