<?php

namespace App\Http\Controllers\PagosEnLinea;

use App\Http\Controllers\Controller;
use App\Models\PagoEnLinea\PREDIAL_MOVS;
use Illuminate\Http\Request;
use \Illuminate\Http\Response;
use Exception;
use App\Models\Facturacion;
use PhpParser\Node\Stmt\Catch_;
use Illuminate\Support\Facades\DB;


class PagoEnLineaController extends Controller
{
    public function index()
    {
        try {
            $list = PREDIAL_MOVS::orderBy('PMS_FECULTMOD', 'desc')
                ->take(10)
                ->get();
            return json_encode(array(
                "status" => true,
                "message" => "API ONLINE",
                "log" => $list
            ));
        } catch (Exception $e) {
            return json_encode(array(
                "status" => true,
                "message" => "API OFFLINE",
                "log" => $e->getMessage()
            ));
        }
    }
}
