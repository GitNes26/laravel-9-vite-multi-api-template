<?php

use App\Http\Controllers\PagosEnLinea\PagoEnLineaController;
use Illuminate\Support\Facades\Route;

Route::get("/", [PagoEnLineaController::class, function () {
    return 'API PAGOS EN LINEA';
}]);
Route::post('/', [PagoEnLineaController::class, 'index']);
// Route::post('/get', [PagoEnLineaController::class, 'GetDataFacturacionPOST']);
// Route::get('/get', [PagoEnLineaController::class, 'ErrorReturn']);
// Route::post('/set', [PagoEnLineaController::class, 'SetDataFacturacionPOST']);
// Route::get('/set', [PagoEnLineaController::class, 'ErrorReturn']);
