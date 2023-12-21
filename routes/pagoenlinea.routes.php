<?php

use App\Http\Controllers\PagosEnLinea\PagoEnLineaController;
use Illuminate\Support\Facades\Route;

Route::get("/",[PagoEnLineaController::class, 'index']);
Route::get('/index', [PagoEnLineaController::class, 'index']);
// Route::post('/get', [PagoEnLineaController::class, 'GetDataFacturacionPOST']);
// Route::get('/get', [PagoEnLineaController::class, 'ErrorReturn']);
// Route::post('/set', [PagoEnLineaController::class, 'SetDataFacturacionPOST']);
// Route::get('/set', [PagoEnLineaController::class, 'ErrorReturn']);
?>