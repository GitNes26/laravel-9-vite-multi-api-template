<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

#region CONTROLLERS
use App\Http\Controllers\Cove\UserController;
use App\Http\Controllers\Cove\RoleController;

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

Route::controller(PerimeterBecasController::class)->group(function () {
   Route::get('/perimeters', 'index');
   Route::get('/perimeters/selectIndex', 'selectIndex');
   Route::get('/perimeters/{id}', 'show');
   Route::post('/perimeters', 'create');
   Route::put('/perimeters/{id?}', 'update');
   Route::delete('/perimeters/{id}', 'destroy');
});

Route::controller(CityBecasController::class)->group(function () {
   Route::get('/cities', 'index');
   Route::get('/cities/selectIndex', 'selectIndex');
   Route::get('/cities/{id}', 'show');
   Route::post('/cities', 'create');
   Route::put('/cities/{id?}', 'update');
   Route::delete('/cities/{id}', 'destroy');
});

Route::controller(ColonyBecasController::class)->group(function () {
   Route::get('/colonies', 'index');
   Route::get('/colonies/selectIndex', 'selectIndex');
   Route::get('/colonies/{id}', 'show');
   Route::post('/colonies', 'create');
   Route::put('/colonies/{id?}', 'update');
   Route::delete('/colonies/{id}', 'destroy');
});

Route::controller(LevelBecasController::class)->group(function () {
   Route::get('/levels', 'index');
   Route::get('/levels/selectIndex', 'selectIndex');
   Route::get('/levels/{id}', 'show');
   Route::post('/levels', 'create');
   Route::put('/levels/{id?}', 'update');
   Route::delete('/levels/{id}', 'destroy');
});

Route::controller(SchoolBecasController::class)->group(function () {
   Route::get('/schools', 'index');
   Route::get('/schools/{id}', 'show');
   Route::post('/schools', 'create');
   Route::put('/schools/{id?}', 'update');
   Route::delete('/schools/{id}', 'destroy');
});


// });
