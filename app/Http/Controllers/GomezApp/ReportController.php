<?php

namespace App\Http\Controllers\GomezApp;

use App\Http\Controllers\Controller;
use App\Models\GomezApp\Report;
use App\Models\GomezApp\InfoCards;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ReportController extends Controller
{
    public function index(Response $response)
    {

        $response = Report::all();
        return response()->json($response);
    }

    public function getCards(Response $response){
        $response = InfoCards::all();
        return response()->json($response);

    }


    public function saveReport(Request $request, Response $response) {
    try {
     
       $reports = new Report;
       $reports->fecha_reporte = $request->fecha_reporte;
       $reports->img_reporte =$request->img_reporte;
       $reports->folio =$request->folio;
       $reports->latitud =$request->latitud;
       $reports->longitud = $request->longitud;
       $reports->id_user =$request->id_user;
       $reports->id_tipo_reporte =$request->id_tipo_reporte;
       $reports->referencia = $request->referencia;
       $reports->comentario = $request->comentario;
       $reports->created_at =now();
       $reports->save();

       $response->data = 1;
          
        } catch (\Exception $ex) {
            $response->data = $ex->getMessage();
        }

        return response()->json($response);
    }
}
