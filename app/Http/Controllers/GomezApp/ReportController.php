<?php

namespace App\Http\Controllers\GomezApp;

use App\Http\Controllers\Controller;
use App\Models\GomezApp\Report;
use App\Models\GomezApp\ReportView;
use App\Models\GomezApp\InfoCards;
use App\Models\GomezApp\ReportAsuntos;
use App\Models\GomezApp\ResponseR;
use App\Models\GomezApp\User;
use App\Models\ObjResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ReportController extends Controller
{
    public function index(Response $response)
    {

        $response = Report::all();
        return response()->json($response);
    }
    public function reportsview(Response $response)
    {
        $response = ReportView::all();
        return response()->json($response);
    }

    public function getCards(Response $response)
    {
        $response = InfoCards::all();
        return response()->json($response);
    }


    public function saveReport(Request $request, Response $response)
    {

        $longitud_cadena = 5;
        $caracteres_alfabeticos = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $caracter_alfabetico = $caracteres_alfabeticos[mt_rand(0, strlen($caracteres_alfabeticos) - 1)];
        $numeros = mt_rand(pow(10, $longitud_cadena - 2), pow(10, $longitud_cadena - 1) - 1);
        $cadena_aleatoria = $caracter_alfabetico . $numeros;

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

                if ($request->op === "1") {
                    $users = new User;
                    $users->email = $request->correo;
                    $users->password = Hash::make('123456');
                    $users->role_id = 3;
                    $users->phone = $request->telefono;
                    $users->name = $request->nombre;
                    $users->paternal_last_name = $request->app;
                    $users->maternal_last_name = $request->apm;
                    $users->curp = $request->curp;
                    $users->sexo = $request->genero;
                    $users->save();


                    $reports = new Report;
                    $reports->fecha_reporte = $request->fecha;
                    $reports->folio =  $cadena_aleatoria;
                    $reports->id_user = $users->id;
                    $reports->calle = $request->calle;
                    $reports->num_ext = $request->num_ext;
                    $reports->num_int = $request->num_int;
                    $reports->cp = $request->cp;
                    $reports->colonia = $request->colonia;
                    $reports->localidad = $request->ciudad;
                    $reports->municipio = "";
                    $reports->estado = $request->estado;
                    $reports->id_departamento = $request->depart;
                    $reports->id_origen = $request->origen;
                    $reports->id_estatus = 1;
                    $reports->community_id = $request->community_id;
                    $reports->created_at = now();
                    $reports->save();



                    $reportsAsunt = new ReportAsuntos();
                    $reportsAsunt->id_reporte = $reports->id;
                    $reportsAsunt->id_servicio = $request->tipoServicio;
                    $reportsAsunt->id_asunto = $request->asunto;
                    $reportsAsunt->observaciones = $request->observaciones;
                    $reportsAsunt->save();


                    $response->data = ObjResponse::CorrectResponse();
                    $response->dara["result"] = $result;
                    $response->data["message"] = 'Peticion satisfactoria | Lista de mis reportes.';
                } else if ($request->op === "2") {
                    $idReport = $request->id;
                    $idUser = $request->idUser;

                    $users = User::find($idUser);
                    $users->email = $request->correo;
                    $users->phone = $request->telefono;
                    $users->name = $request->nombre;
                    $users->paternal_last_name = $request->app;
                    $users->maternal_last_name = $request->apm;
                    $users->curp = $request->curp;
                    $users->sexo = $request->genero;
                    $users->save();

                    $reports = Report::find($request->id);
                    $reports->fecha_reporte = $request->fecha;
                    $reports->calle = $request->calle;
                    $reports->num_ext = $request->num_ext;
                    $reports->num_int = $request->num_int;
                    $reports->cp = $request->cp;
                    $reports->colonia = $request->colonia;
                    $reports->localidad = $request->ciudad;
                    $reports->estado = $request->estado;
                    $reports->id_departamento = $request->depart;
                    $reports->id_origen = $request->origen;
                    $reports->updated_at = now();
                    $reports->save();



                    $reportsAsunt = ReportAsuntos::where("id_reporte", "=", $idReport)
                        ->update([
                            'observaciones' => $request->observaciones,
                            'id_servicio' => $request->tipoServicio,
                            'id_asunto' => $request->asunto
                        ]);


                    $response->data = ObjResponse::CorrectResponse();
                    $response->data["result"] = ["se actualizo correctamente" => $reportsAsunt];
                    $response->data["message"] = 'Peticion satisfactoria | Lista de mis reportes.';
                }
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
            }
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }
    public function destroy(int $id, Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $deleteReport = Report::find($id);
            $deleteReport->active = 0;
            $deleteReport->deleted_at = now();
            $deleteReport->save();

            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'peticion satisfactoria | usuario eliminado.';
            $response->data["alert_text"] = "Usuario eliminado";
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }

    public function saveResponse(Request $request, Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        $id = $request->idReport;
        try {
            $responseR = new ResponseR;
            $responseR->id_reporte = $request->idReport;
            $responseR->respuesta = $request->response;
            $responseR->fecha_respuesta = now();
            $responseR->save();

            $updateEstatus = Report::find($id);
            $updateEstatus->id_estatus = 2;
            $updateEstatus->save();



            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'peticion satisfactoria | usuario eliminado.';
            $response->data["alert_text"] = "Respuesta enviada";
            $response->data["result"] = ["se registro respuesta" =>  $request->idReport];
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
            $list = Report::where('reportes.active', true)->where('reportes.id_user', $request->id_user)
                ->join('tipos_reportes', 'reportes.id_tipo_reporte', '=', 'tipos_reportes.id')
                ->select('reportes.*', 'tipos_reportes.tipo_nombre', 'tipos_reportes.bg_circle', 'tipos_reportes.bg_card', 'tipos_reportes.icono', 'tipos_reportes.letter_black')
                ->orderBy('reportes.id', 'desc')->get();
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'Peticion satisfactoria | Lista de mis reportes.';
            $response->data["result"] = $list;
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }
}
