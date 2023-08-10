<?php

namespace App\Http\Controllers;

use App\Models\ObjResponse;
use App\Models\becas\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    /**
     * Mostrar lista de todos los roles activos.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $response = ObjResponse::DefaultResponse();
        try {
            $list = Role::where('active', true)
            ->select('roles.id','roles.role', 'roles.active')
            ->orderBy('roles.role', 'asc')->get();
            $response = ObjResponse::CorrectResponse();
            data_set($response, 'message', 'Peticion satisfactoria. Lista de roles:');
            data_set($response, 'data', $list);
        }
        catch (\Exception $ex) {
            $response = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response["status_code"]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function create(Request $request)
    // {
        
    // }

    /**
     * Crear un nuevo rol.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $response = ObjResponse::DefaultResponse();
        try {
            $new_role = Role::create([
                'name' => $request->name,
                'active' => $request->active,
            ]);
            $response = ObjResponse::CorrectResponse();
            data_set($response,'message','peticion satisfactoria | rol registrado.');
            data_set($response,'alert_text','rol registrada');
        }
        catch (\Exception $ex) {
            $response = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response["status_code"]);
    }

    /**
     * Mostrar un rol especifico.
     *
     * @param  \App\Models\Role  $role
     * @param  \Illuminate\Http\Request  $request
     * @param   int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role, int $id)
    {
        $response = ObjResponse::DefaultResponse();
        try{
            $role = Role::where('id', $id)
            ->select('roles.id','roles.role','roles.active')
            ->get();
            
            $response = ObjResponse::CorrectResponse();
            data_set($response,'message','peticion satisfactoria | rol encontrado.');
            data_set($response,'data',$role);
        }
        catch (\Exception $ex) {
            $response = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response,$response["status_code"]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function edit(Request $request)
    // {
    //     //
    // }

    /**
     * Actualizar un rol especifico.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $response = ObjResponse::DefaultResponse();
        try {
            $role = Role::where('id', $request->id)
            ->update([
                'name' => $request->name,
            ]);

            $response = ObjResponse::CorrectResponse();
            data_set($response,'message','peticion satisfactoria | rol actualizado.');
            data_set($response,'alert_text','Rol actualizado');

        } catch (\Exception $ex) {
            $response = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response,$response["status_code"]);
    }

    /**
     * Eliminar (cambiar estado activo=false) un rol especidifco.
     *
     * @param  \App\Models\Role  $role
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $response = ObjResponse::DefaultResponse();
        try {
            Role::where('id', $id)
            ->update([
                'active' => false,
                'deleted_at' => date('Y-m-d H:i:s'),
            ]);
            $response = ObjResponse::CorrectResponse();
            data_set($response,'message','peticion satisfactoria | rol eliminado.');
            data_set($response,'alert_text','Rol eliminado');

        } catch (\Exception $ex) {
            $response = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response,$response["status_code"]);
    }
}