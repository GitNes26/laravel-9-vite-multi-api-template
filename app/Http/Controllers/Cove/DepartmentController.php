<?php

namespace App\Http\Controllers\Cove;

use App\Http\Controllers\Controller;
use App\Models\ObjResponse;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class DepartmentController extends Controller
{
    /**
     * Mostrar lista de todas las discapacidades activas.
     *
     * @return \Illuminate\Http\Response $response
     */
    public function index(Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $list = Disability::where('active', true)
                ->select('disabilities.*')
                ->orderBy('disabilities.id', 'asc')->get();
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'Peticion satisfactoria | Lista de discapacidades.';
            $response->data["result"] = $list;
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }

    /**
     * Mostrar listado para un selector.
     *
     * @return \Illuminate\Http\Response $response
     */
    public function selectIndex(Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $list = Disability::where('active', true)
                ->select('disabilities.id as value', 'disabilities.disability as text')
                ->orderBy('disabilities.disability', 'asc')->get();
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'Peticion satisfactoria | Lista de discapacidades';
            $response->data["result"] = $list;
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }

    /**
     * Crear una nueva discapacidad.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response $response
     */
    public function create(Request $request, Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $new_disability = Disability::create([
                'disability' => $request->disability,
                'description' => $request->description,
            ]);
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'peticion satisfactoria | discapacidad registrada.';
            $response->data["alert_text"] = 'Discapacidad registrada';
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }

    /**
     * Mostrar una discapacidad especifica.
     *
     * @param   int $id
     * @return \Illuminate\Http\Response $response
     */
    public function show(int $id, Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $disability = Disability::find($id);

            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'peticion satisfactoria | discapacidad encontrada.';
            $response->data["result"] = $disability;
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }

    /**
     * Actualizar una discapacidad especifica.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response $response
     */
    public function update(Request $request, Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $disability = Disability::find($request->id)
                ->update([
                    'disability' => $request->disability,
                    'description' => $request->description,
                ]);

            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'peticion satisfactoria | discapacidad actualizada.';
            $response->data["alert_text"] = 'Discapacidad actualizada';
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }

    /**
     * Eliminar (cambiar estado activo=false) una discapacidad especidifca.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response $response
     */
    public function destroy(int $id, Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            Disability::find($id)
                ->update([
                    'active' => false,
                    'deleted_at' => date('Y-m-d H:i:s'),
                ]);
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'peticion satisfactoria | discapacidad eliminada.';
            $response->data["alert_text"] = 'Discapacidad eliminada';
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }
}
