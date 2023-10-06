<?php

namespace App\Http\Controllers\GPCenter;

use App\Http\Controllers\Controller;
use App\Models\GPCenter\Brand;
use App\Models\ObjResponse;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class BrandController extends Controller
{
    /**
     * Mostrar lista de marcas activas.
     *
     * @return \Illuminate\Http\Response $response
     */
    public function index(Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $list = Brand::where('active', true)
                ->select('brands.*')
                ->orderBy('brands.id', 'asc')->get();
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'Peticion satisfactoria | Lista de marcas.';
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
            $list = Brand::where('active', true)
                ->select('brands.id as id', 'brands.brand as label')
                ->orderBy('brands.brand', 'asc')->get();
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'Peticion satisfactoria | Lista de marcas';
            $response->data["result"] = $list;
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }

    /**
     * Crear marca.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response $response
     */
    public function create(Request $request, Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $duplicate = $this->validateAvailableData($request->username, $request->email, $request->id);
            if ($duplicate["result"] == true) {
                $response->data = $duplicate;
                return response()->json($response);
            }

            $imgName = "";
            if ($request->hasFile('imgFile')) {
                $image = $request->file('imgFile');
                $imgName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('GPCenter/brands'), $imgName);
            }
            $new_brand = Brand::create([
                'brand' => $request->brand,
                'img_path' => "GPCenter/brands/$imgName"
            ]);
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'peticion satisfactoria | marca registrada.';
            $response->data["alert_text"] = 'Marca registrado';
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }

    /**
     * Mostrar marca.
     *
     * @param   int $id
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response $response
     */
    public function show(Request $request, Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $brand = Brand::find($request->id);

            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'peticion satisfactoria | marca encontrada.';
            $response->data["result"] = $brand;
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }

    /**
     * Actualizar marca.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response $response
     */
    public function update(Request $request, Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $imgName = "";
            if ($request->hasFile('imgFile')) {
                $image = $request->file('imgFile');
                $imgName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('GPCenter/brands'), $imgName);
            }
            if ($imgName != "") {
                $brand = Brand::find($request->id)
                    ->update([
                        'brand' => $request->brand,
                        'img_path' => "GPCenter/brands/$imgName"
                    ]);
            } else {
                $brand = Brand::find($request->id)
                    ->update([
                        'brand' => $request->brand,
                    ]);
            }

            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'peticion satisfactoria | marca actualizada.';
            $response->data["alert_text"] = 'Marca actualizado';
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }

    /**
     * Eliminar (cambiar estado activo=false) marca.
     *
     * @param  int $id
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response $response
     */
    public function destroy(Request $request, Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            Brand::find($request->id)
                ->update([
                    'active' => false,
                    'deleted_at' => date('Y-m-d H:i:s'),
                ]);
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'peticion satisfactoria | marca eliminada.';
            $response->data["alert_text"] = 'Marca eliminada';
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }


    private function validateAvailableData($level, $id)
    {
        #este codigo se pone en las funciones de registro y edicion
        // $duplicate = $this->validateAvailableData($request->username, $request->email, $request->id);
        // if ($duplicate["result"] == true) {
        //     $response->data = $duplicate;
        //     return response()->json($response);
        // }
        $checkAvailable = new UserBecasController();
        // #VALIDACION DE DATOS REPETIDOS
        $duplicate = $checkAvailable->checkAvailableData('levels', 'level', $level, 'El nivel', 'level', $id, null);
        if ($duplicate["result"] == true) return $duplicate;
        return array("result" => false);
    }
}
