<?php

namespace App\Http\Controllers;

use App\Models\Estados;
use App\Models\ObjResponse;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class EstadosController extends Controller
{
    public function index(Response $response){
        try {
            $res = ObjResponse::DefaultResponse();
            $list = Estados::all();
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'Peticion satisfactoria | Lista de estados.';
            $response->data["result"] = $list;
        
        }catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }

    public function estadosFind($id){
        try {
            $res = ObjResponse::DefaultResponse();
            $list = Estados::where('value',$id)->first();
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'Peticion satisfactoria | Estado encontrado.';
            $response->data["result"] = $list;
        
        }catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }
}
