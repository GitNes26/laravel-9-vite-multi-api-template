<?php

namespace App\Http\Controllers\GPCenter;

use App\Http\Controllers\Controller;
use App\Models\GPCenter\Vehicle;
use App\Models\GPCenter\VehiclePlate;
use App\Models\ObjResponse;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class VehicleController extends Controller
{
    /**
     * Mostrar lista de vehículos activos.
     *
     * @return \Illuminate\Http\Response $response
     */
    public function index(Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $list = Vehicle::where('vehicles.active', true)
                ->join('brands', 'vehicles.brand_id', '=', 'brands.id')
                ->join('models', 'vehicles.model_id', '=', 'models.id')
                ->join('vehicle_status', 'vehicles.vehicle_status_id', '=', 'vehicle_status.id')
                ->join('vehicle_plates', function ($join) {
                    $join->on('vehicle_plates.vehicle_id', '=', 'vehicles.id')
                        ->where('vehicle_plates.expired', '=', 0);
                })
                ->select('vehicles.*', 'brands.brand', 'models.model', 'vehicle_status.vehicle_status', 'vehicle_status.bg_color', 'vehicle_status.letter_black', 'plates', 'initial_date', 'due_date')
                ->orderBy('vehicles.id', 'asc')->get();
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'Peticion satisfactoria | Lista de vehículos.';
            $response->data["result"] = $list;
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }

    /**
     * Mostrar listado para un selector.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response $response
     */
    public function selectIndex(Request $request, Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $list = Vehicle::where('vehicles.active', true)->where('vehicles.', $request->brand_id)
                ->select('vehicles.id as value', 'vehicles.model as text')
                ->orderBy('vehicles.model', 'asc')->get();
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'Peticion satisfactoria | Lista de vehículos';
            $response->data["result"] = $list;
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }

    /**
     * Crear vehículo.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response $response
     */
    public function create(Request $request, Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $new_vehicle = Vehicle::create([
                'stock_number' => $request->stock_number,
                'brand_id' => $request->brand_id,
                'model_id' => $request->model_id,
                'year' => $request->year,
                'registration_date' => $request->registration_date,
                'vehicle_status_id' => $request->vehicle_status_id,
                'description' => $request->description,
            ]);

            $vehiclesPlatesController = new VehiclePlatesController();
            $vehiclesPlatesController->createByVehicle($request, $new_vehicle->id);

            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'peticion satisfactoria | vehículo registrado.';
            $response->data["alert_text"] = 'Vehículo registrado';
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }

    /**
     * Mostrar vehiculo buscando por No. Unidad o Placas.
     *
     * @param   int $id
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response $response
     */
    public function showBy(Request $request, String $searchBy, String $value,  Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $vehicle = Vehicle::where($searchBy, $value)
                ->join('brands', 'vehicles.brand_id', '=', 'brands.id')
                ->join('models', 'vehicles.model_id', '=', 'models.id')
                ->join('vehicle_status', 'vehicles.vehicle_status_id', '=', 'vehicle_status.id')
                ->join('vehicle_plates', function ($join) {
                    $join->on('vehicle_plates.vehicle_id', '=', 'vehicles.id')
                        ->where('vehicle_plates.expired', '=', 0);
                })
                ->select('vehicles.*', 'brands.brand', 'models.model', 'vehicle_status.vehicle_status', 'vehicle_status.bg_color', 'vehicle_status.letter_black', 'plates', 'initial_date', 'due_date')
                ->first();

            $response->data = ObjResponse::CorrectResponse();
            if ($vehicle) {
                $response->data["message"] = 'peticion satisfactoria | vehículo encontrado.';
                $response->data["alert_title"] = "Vehículo encontrado";
                $response->data["result"] = $vehicle;
            } else {
                $response->data["message"] = 'peticion satisfactoria | vehículo NO encontrado.';
                $response->data["result"] = [];
                $response->data["alert_icon"] = "information";
                $response->data["alert_title"] = "No se encontro vehículo con esa información";
            }
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }


    /**
     * Mostrar vehículo.
     *
     * @param   int $id
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response $response
     */
    public function show(Request $request, Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $vehicle = Vehicle::where('vehicles.id', $request->id)
                ->join('brands', 'vehicles.brand_id', '=', 'brands.id')
                ->join('models', 'vehicles.model_id', '=', 'models.id')
                ->join('vehicle_status', 'vehicles.vehicle_status_id', '=', 'vehicle_status.id')
                ->join('vehicle_plates', function ($join) {
                    $join->on('vehicle_plates.vehicle_id', '=', 'vehicles.id')
                        ->where('vehicle_plates.expired', '=', 0);
                })
                ->select('vehicles.*', 'brands.brand', 'models.model', 'vehicle_status.vehicle_status', 'vehicle_status.bg_color', 'vehicle_status.letter_black', 'plates', 'initial_date', 'due_date')
                ->first();

            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'peticion satisfactoria | vehículo encontrado.';
            $response->data["result"] = $vehicle;
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }

    /**
     * Actualizar vehículo.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response $response
     */
    public function update(Request $request, Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $vehicle = Vehicle::find($request->id)
                ->update([
                    'stock_number' => $request->stock_number,
                    'brand_id' => $request->brand_id,
                    'model_id' => $request->model_id,
                    'year' => $request->year,
                    'registration_date' => $request->registration_date,
                    'vehicle_status_id' => $request->vehicle_status_id,
                    'description' => $request->description,
                ]);

            if ($response->changePlates) {
                $vehiclesPlatesController = new VehiclePlate();
                $vehiclePlates = $vehiclesPlatesController->create($request);
            }

            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'peticion satisfactoria | vehículo actualizado.';
            $response->data["alert_text"] = 'Vehículo actualizado';
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }

    /**
     * Eliminar (cambiar estado activo=false) vehículo.
     *
     * @param  int $id
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response $response
     */
    public function destroy(Request $request, Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            Vehicle::find($request->id)
                ->update([
                    'active' => false,
                    'deleted_at' => date('Y-m-d H:i:s'),
                ]);
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'peticion satisfactoria | vehículo eliminado.';
            $response->data["alert_text"] = 'Vehículo eliminado';
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }
}