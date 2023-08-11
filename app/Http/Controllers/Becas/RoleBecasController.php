<?php

namespace App\Http\Controllers\becas;

use App\Http\Controllers\Controller;
use App\Models\ObjResponse;
use App\Models\becas\Role;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class RoleBecasController extends Controller
{
    /**
     * Mostrar lista de todos los roles activos.
     *
     * @return \Illuminate\Http\Response $response
     */
    public function index(Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $list = Role::where('active', true)
            ->select('roles.id','roles.role', 'roles.active')
            ->orderBy('roles.role', 'asc')->get();
            $response->data = ObjResponse::CorrectResponse();
            data_set($response, 'message', 'Peticion satisfactoria. Lista de roles:');
            data_set($response, 'data', $list);
        }
        catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }

    /**
     * Mostrar listado para un selector.
     *
     * @return \Illuminate\Http\Response $response
     */
    public function selectIndex()
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $list = Role::where('active', true)
            ->select('roles.id as value', 'roles.role as text')
            ->orderBy('roles.role', 'asc')->get();
            $response->data = ObjResponse::CorrectResponse();
            data_set($response, 'message', 'Peticion satisfactoria. Lista de roles:');
            data_set($response, 'data', $list);
        }
        catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }

    /**
     * Crear un nuevo rol.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response $response
     */
    public function create(Request $request)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $new_role = Role::create([
                'role' => $request->role,
            ]);
            $response->data = ObjResponse::CorrectResponse();
            data_set($response,'message','peticion satisfactoria | rol registrado.');
            data_set($response,'alert_text','rol registrada');
        }
        catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }

    /**
     * Mostrar un rol especifico.
     *
     * @param   int $id
     * @return \Illuminate\Http\Response $response
     */
    public function show(int $id)
    {
        $response->data = ObjResponse::DefaultResponse();
        try{
            $role = Role::where('id', $id)
            ->select('roles.id','roles.role','roles.active')
            ->get();
            
            $response->data = ObjResponse::CorrectResponse();
            data_set($response,'message','peticion satisfactoria | rol encontrado.');
            data_set($response,'data',$role);
        }
        catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }

    /**
     * Actualizar un rol especifico.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response $response
     */
    public function update(Request $request)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $role = Role::where('id', $request->id)
            ->update([
                'role' => $request->role,
            ]);

            $response->data = ObjResponse::CorrectResponse();
            data_set($response,'message','peticion satisfactoria | rol actualizado.');
            data_set($response,'alert_text','Rol actualizado');

        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }

    /**
     * Eliminar (cambiar estado activo=false) un rol especidifco.
     *
     * @param  \App\Models\Role  $role
     * @param  int $id
     * @return \Illuminate\Http\Response $response
     */
    public function destroy(int $id)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            Role::where('id', $id)
            ->update([
                'active' => false,
                'deleted_at' => date('Y-m-d H:i:s'),
            ]);
            $response->data = ObjResponse::CorrectResponse();
            data_set($response,'message','peticion satisfactoria | rol eliminado.');
            data_set($response,'alert_text','Rol eliminado');

        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }
}