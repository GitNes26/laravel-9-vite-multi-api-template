<?php

namespace App\Http\Controllers\Facturaciones;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use App\Models\Facturacion;

class FactuacionController extends Controller
{
    public function index() {
       try {
        return json_encode(array(
            "status" => true, 
            "message" => "API ONLINE", 
            "log" => NULL
        ));
       } catch (\Exception $e) {
        return json_encode(array(
            "status" => true, 
            "message" => "API ONLINE", 
            "log" => $e
        ));
       }
    }

    public function GetDataFacturacionPOST(Request $receive){
        $result = array(
            "result" => true,
            "message" => "Mensaje Default",
            "log" => NULL,
            "data" => NULL,
            "receive" => NULL
        );
        try {
            $dataSend = json_decode($receive->getContent(), true);
            if (isset($dataSend)) {
                try {
                    $op = $dataSend["op"];
                    $dataRec = $dataSend["data"];
                    if($op === 1){
                        //BUSQUEDA POR FOLIO
                        if(isset($dataRec["folio"])){
                            $dpaFolio = $dataRec["folio"];
                            $data = Facturacion::where("dpa_folio", $dpaFolio)->get();
                            $result["result"] = true;
                            $result["message"] = "Busqueda por folio realizada con exito";
                            $result["data"] = $data;
                            $result["receive"] = $dataSend;
                        }else{
                            $data = NULL;
                            $result["result"] = false;
                            $result["message"] = "No se recibio el folio de busqueda";
                            $result["data"] = $data;
                            $result["receive"] = $dataSend;
                        }
                    }else if($op === 2){
                        //BUSQUEDA POR CLAVE CATASTRAL
                        if(isset($dataRec["claveCat"])){
                            $dpaClave = $dataRec["claveCat"];
                            $data = Facturacion::where("dpa_referencia", $dpaClave)->get();
                            $result["result"] = true;
                            $result["message"] = "Busqueda por Clave Catastral realizada con exito";
                            $result["data"] = $data;
                            $result["receive"] = $dataSend;
                        }else{
                            $data = NULL;
                            $result["result"] = false;
                            $result["message"] = "No se recibio la clave catastral de busqueda";
                            $result["data"] = $data;
                            $result["receive"] = $dataSend;
                        }
                    }else{
                        $data = NULL;
                        $result["result"] = false;
                        $result["message"] = "Opcion introducida Inexistente";
                        $result["data"] = $data;
                        $result["receive"] = $dataSend;
                    }
                } catch (\Exception $ex) {
                    $data = NULL;
                    $result["result"] = false;
                    $result["message"] = "Ocurrio un error durante el procesamiento de la solicitud";
                    $result["data"] = $data;
                    $result["log"] = $ex->getMessage().", ".$ex->getLine().", ".$ex->getFile();
                    $result["receive"] = $dataSend;
                }
            }
            else{
                $data = NULL;
                $result["result"] = false;
                $result["message"] = "No se recivio ningun dato";
                $result["data"] = $data;
                $result["receive"] = $dataSend;
            }
           
        } catch (\Exception $e) {
            $data = NULL;
            $result["result"] = false;
            $result["message"] = "ERROR 500";
            $result["data"] = $data;
            $result["receive"] = $dataSend;
            $resul["log"] =  $e->getMessage().", ".$e->getLine().", ".$e->getFile();
        }
        return json_encode($result);
    }

    public function SetDataFacturacionPOST(){
        return json_encode(array(
            "status" => true, 
            "message" => "Metodo accesible no disponible", 
            "log" => NULL
        ));
    }

    public function ErrorReturn(){
        return json_encode(array(
            "status" => false, 
            "message" => "Funcion Inaccesible por este metodo", 
            "log" => NULL
        ));
    }

}
