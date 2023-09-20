<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\CodigoPostal;
use App\Models\ObjResponse;
use Illuminate\Support\Facades\DB;

class CodigoPostalController extends Controller
{
    public function index(Response $response,$id){
        try {
            $res = ObjResponse::DefaultResponse();
            $list = CodigoPostal::where('codigopostal', $id)->get();
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'Peticion satisfactoria | Lista de comunidades.';
            $response->data["result"] = $list;
        
        }catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }

    public function colonia(Response $response, $id){
        try {
            $res = ObjResponse::DefaultResponse();
            $list = CodigoPostal::where('id', $id)->first();
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'Peticion satisfactoria | Comunidad encontrada.';
            $response->data["result"] = $list;
        
        }catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }
}
