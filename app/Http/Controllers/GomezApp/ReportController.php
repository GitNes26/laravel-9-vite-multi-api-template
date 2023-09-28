<?php

namespace App\Http\Controllers\GomezApp;

use App\Http\Controllers\Controller;
use App\Models\GomezApp\Report;
use App\Models\GomezApp\InfoCards;
use App\Models\ObjResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class ReportController extends Controller
{
    public function index(Response $response)
    {

        $response = Report::all();
        return response()->json($response);
    }

    public function getCards(Response $response)
    {
        $response = InfoCards::all();
        return response()->json($response);
    }

          
    public function saveReport(Request $request, Response $response)
    {
        try {

            $reports = new Report;
            $reports->fecha_reporte = $request->fecha_reporte;
            $reports->img_reporte = $request->img_reporte;
            $reports->folio = $request->folio;
            $reports->latitud = $request->latitud;
            $reports->longitud = $request->longitud;
            $reports->id_user = $request->id_user;
            $reports->id_tipo_reporte = $request->id_tipo_reporte;
            $reports->referencia = $request->referencia;
            $reports->comentario = $request->comentario;
            $reports->created_at = now();
            $reports->save();

            $response->data = 1;
        } catch (\Exception $ex) {
            $response->data = $ex->getMessage();
        }

        return response()->json($response,200);
    }

    /**
     * Mostrar lista de reportes activos por usuario.
     *
     * @return \Illuminate\Http\Response $response
     */
    public function reportsByUser(Request $request, Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $list = Report::where('reportes_movil.active', true)->where('reportes_movil.id_user', $request->id_user)
                ->join('tipos_reportes', 'reportes_movil.id_tipo_reporte', '=', 'tipos_reportes.id')
                ->select('reportes_movil.*', 'tipos_reportes.tipo_nombre', 'tipos_reportes.bg_circle', 'tipos_reportes.bg_card', 'tipos_reportes.icono', 'tipos_reportes.letter_black')
                ->orderBy('reportes_movil.id', 'desc')->get();
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'Peticion satisfactoria | Lista de mis reportes.';
            $response->data["result"] = $list;
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }
}
