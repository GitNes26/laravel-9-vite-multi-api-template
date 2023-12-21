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
    public function index(Request $request, Response $response)
    {
        try {
            $dataSend = json_decode($response->getContent(), true);
            if (isset($dataSend)) {
                $op = $dataSend["op"];
                $dataRec = $dataSend["data"];
                $calveCat = $dataRec["$calveCat"];
                if ($op === 1) {
                    //BUSQUEDA POR CLAVE CATASTRAL
                    $list = PREDIAL_MOVS::where('PMS_CVECAT', $calveCat)->orderBy('PMS_FECULTMOD', 'desc')
                        ->get();
                } else {
                    $list = PREDIAL_MOVS::orderBy('PMS_FECULTMOD', 'desc')
                        ->take(10)
                        ->get();
                }
            }
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
