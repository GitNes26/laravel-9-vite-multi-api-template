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
       $reports->fecha_reporte = null;
       $reports->img_reporte =null;
       $reports->folio =11;
       $reports->latitud =null;
       $reports->longitud = null;
       $reports->id_user =1;
       $reports->id_tipo_reporte =1;
       $reports->referencia = "SOY NESTOR";
       $reports->comentario = null;
       $reports->created_at =now();
       $reports->save();

       $response->data = 1;
          
        } catch (\Exception $ex) {
            $response->data = $ex->getMessage();
        }

        return response()->json($response);
    }
}
