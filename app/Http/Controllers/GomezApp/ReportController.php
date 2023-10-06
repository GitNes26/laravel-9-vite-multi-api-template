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

        $response->data = ObjResponse::DefaultResponse();
        $result = [];
        try {
            $imgName = "";
            if ($request->hasFile('imgFile')) {
                $image = $request->file('imgFile');
                $imgName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('GomezApp/reportes'), $imgName);
            }


            if ($request->has('op')) {
                $reports = new Report;
                $reports->fecha_reporte = $request->fecha;
                $reports->folio = 1;
                $reports->id_user = 1;
                $reports->calle = $request->calle;
                $reports->num_ext = $request->num_ext;
                $reports->num_int = $request->num_int;
                $reports->cp = $request->cp;
                $reports->colonia = $request->colonia;
                $reports->localidad = $request->ciudad;
                $reports->municipio = "";
                $reports->estado = $request->estado;
                $reports->id_tipo_reporte = $request->tipoServicio;
                $reports->id_departamento = $request->depart;
                $reports->id_origen = 1;
                $reports->id_estatus = 1;
                $reports->observaciones = $request->observaciones;
                $reports->created_at = now();
                $reports->save();
                $result = $reports;
            } else {
                $reports = new Report;
                $reports->fecha_reporte = $request->fecha_reporte;
                $reports->img_reporte = "GomezApp/reportes/$imgName";
                $reports->folio = $request->folio;
                $reports->latitud = $request->latitud;
                $reports->longitud = $request->longitud;
                $reports->id_user = $request->id_user;
                $reports->id_tipo_reporte = $request->id_tipo_reporte;
                $reports->referencia = $request->referencia;
                $reports->comentario = $request->comentario;
                $reports->created_at = now();
                $reports->save();
                $result = $reports;
            }



            $response->data = ObjResponse::CorrectResponse();
            $response->dara["result"] = $result;
            $response->data["message"] = 'Peticion satisfactoria | Lista de mis reportes.';
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
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
