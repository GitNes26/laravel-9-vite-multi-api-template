<?php

use App\Http\Controllers\GomezApp\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

#region CONTROLLERS




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

// Route::controller(RoleController::class)->group(function () {
//    Route::get('/roles', 'index');
//    Route::get('/roles/selectIndex', 'selectIndex');
//    Route::get('/roles/{id}', 'show');
//    Route::post('/roles', 'create');
//    Route::put('/roles/{id?}', 'update');
//    Route::delete('/roles/{id}', 'destroy');
// });

// Route::controller(DepartmentController::class)->group(function () {
//    Route::get('/departments', 'index');
//    Route::get('/departments/selectIndex', 'selectIndex');
//    Route::get('/departments/{id}', 'show');
//    Route::post('/departments', 'create');
//    Route::put('/departments/{id?}', 'update');
//    Route::delete('/departments/{id}', 'destroy');
// });





// });
