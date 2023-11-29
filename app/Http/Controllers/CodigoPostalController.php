<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\CodigoPostal;
use App\Models\ObjResponse;
use App\Models\Perimeter;
use Illuminate\Support\Facades\DB;

class CodigoPostalController extends Controller
{
    public function index(Response $response,$id){
        try {
            $response->data = ObjResponse::DefaultResponse();
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
            $response->data = ObjResponse::DefaultResponse();
            $list = CodigoPostal::where('id', $id)->first();
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'Peticion satisfactoria | Comunidad encontrada.';
            $response->data["result"] = $list;
        
        }catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }

    public function perimeters(Response $response, Request $request){
        try {
            $response->data = ObjResponse::DefaultResponse();
            // $list =  Perimeter::all();
            $list = $request->id > 0 ? Perimeter::find($request->id) : Perimeter::all();
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = $request->id > 0 ? 'Peticion satisfactoria | Perimetro encontrado.' : 'Peticion satisfactoria | Perimetros encontrados.';
            $response->data["result"] = $list;
        
        }catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }

    public function createOrUpdatePerimeter(Response $response, Request $request){
        try {
            $response->data = ObjResponse::DefaultResponse();
            $perimeter = Perimeter::where('id', $request->id)->first();
            if (!$perimeter) $perimeter = new Perimeter();

            $perimeter->perimeter = $request->perimeter;
            if ($request->active != "") $perimeter->active = (bool)$request->active; 

            $perimeter->save();
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = $request->id > 0 ? 'Peticion satisfactoria | Perímetro creado.' : 'Peticion satisfactoria | Perímetro actualizdo.';
            $response->data["alert_title"] = $request->id > 0 ? 'Perímetro creado.' : 'Perímetro actualizdo.';
            $response->data["alert_text"] = $request->id > 0 ? 'Perímetro creado.' : 'Perímetro actualizdo.';
            // $response->data["result"] = $perimeter;
            
        }catch (\Exception $ex) {
            $msg =  "Error al crear o actualizar perimetro: " . $ex->getMessage();
            error_log($msg);

            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }

    public function coloniesByPerimeter(Response $response, Int $perimeter_id){
        try {
            $response->data= ObjResponse::DefaultResponse();
            $list = CodigoPostal::where('perimetroId', $perimeter_id)->get();
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'Peticion satisfactoria | Perimetros encontrados.';
            $response->data["result"] = $list;
        
        }catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }
}
