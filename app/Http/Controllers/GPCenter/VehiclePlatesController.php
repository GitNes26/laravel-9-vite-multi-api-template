<?php

namespace App\Http\Controllers\GPCenter;

use App\Http\Controllers\Controller;
use App\Models\GPCenter\VehiclePlate;
use App\Models\ObjResponse;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class VehiclePlatesController extends Controller
{
    /**
     * Mostrar lista de placas de vehiculo activas.
     *
     * @return \Illuminate\Http\Response $response
     */
    public function index(Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $list = VehiclePlate::where('active', true)
                ->select('vehicle_plates.*')
                ->orderBy('vehicle_plates.id', 'desc')->get();
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'Peticion satisfactoria | Lista de placas de vehiculo.';
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
            $list = VehiclePlate::where('active', true)
                ->select('vehicle_plates.id as value', 'vehicle_plates.vehicle_plates as text')
                ->orderBy('vehicle_plates.vehicle_plates', 'asc')->get();
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'Peticion satisfactoria | Lista de placas de vehiculo';
            $response->data["result"] = $list;
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }

    /**
     * Mostrar lista de placas de vehiculo correspondiente.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response $response
     */
    public function platesByVehicleId(Request $request, Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $list = VehiclePlate::where('active', true)->where('vehicle_id', $request->vehicle_id)
                ->select('vehicle_plates.*')
                ->orderBy('vehicle_plates.id', 'desc')->get();
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'Peticion satisfactoria | Lista de placas de vehiculo.';
            $response->data["result"] = $list;
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }

    /**
     * Crear placas.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response $response
     */
    public function create(Request $request, Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {

            $this->FailedPlates($request);

            $new_plates = VehiclePlate::create([
                'vehicle_id' => $request->vehicle_id,
                'plates' => $request->plates,
                'initial_date' => $request->initial_date,
                'due_date' => $request->due_date,
                // 'expired' => $request->expired,
            ]);
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'peticion satisfactoria | placas registradas.';
            $response->data["alert_text"] = 'Placas registradas';
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }

    /**
     * Mostrar placas.
     *
     * @param   int $id
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response $response
     */
    public function show(Request $request, Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $plates = VehiclePlate::find($request->id);

            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'peticion satisfactoria | placas encontradas.';
            $response->data["result"] = $plates;
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }

    /**
     * Actualizar placas.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response $response
     */
    public function update(Request $request, Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $plates = VehiclePlate::find($request->id)
                ->update([
                    'vehicle_id' => $request->vehicle_id,
                    'plates' => $request->plates,
                    'initial_date' => $request->initial_date,
                    'due_date' => $request->due_date,
                    'expired' => $request->expired,
                ]);

            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'peticion satisfactoria | placas actualizada.';
            $response->data["alert_text"] = 'Placas actualizadas';
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }

    /**
     * Dar de baja las placas.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response $response
     */
    private function failedPlates(Request $request)
    {
        try {
            $plates_id = VehiclePlate::where("vehicle_id", $request->vehicle_id)->where("expired", 0)->where("active", 1)->select('id')->orderBy("id", "desc")->first();

            if ($plates_id < 1) return 0;

            VehiclePlate::find($plates_id)
                ->update([
                    'expired' => true,
                ]);
            return 1;
        } catch (\Exception $ex) {
            echo "Ocurrio un error al intentar dar de baja la placa $ex";
            return 0;
        }
    }

    /**
     * Eliminar (cambiar estado activo=false) placas.
     *
     * @param  int $id
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response $response
     */
    public function destroy(Request $request, Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            VehiclePlate::find($request->id)
                ->update([
                    'active' => false,
                    'deleted_at' => date('Y-m-d H:i:s'),
                ]);
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'peticion satisfactoria | placas eliminadas.';
            $response->data["alert_text"] = 'Placas eliminadas';
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }
}
