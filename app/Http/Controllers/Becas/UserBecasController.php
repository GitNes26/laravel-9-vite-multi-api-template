<?php

namespace App\Http\Controllers\becas;

use App\Http\Controllers\Controller;
use App\Models\ObjResponse;
use App\Models\becas\User;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserBecasController extends Controller
{   
    
    /**
     * Metodo para validar credenciales e
     * inicar sesión
     * @param Request $request
     * @return \Illuminate\Http\Response $response
     */
    public function login(Request $request, Response $response)
    {
        $field = 'username';
        $value = $request->username;        
        if ($request->email) {
            $field = 'email';
            $value = $request->email;
        } 

        $request->validate([
            $field=>'required',
            'password'=>'required'
        ]);
        $user = User::where("$field", "$value")->first();
        

        if(!$user || !Hash::check($request->password, $user->password)) {

            throw ValidationException::withMessages([
                'message'=>'Credenciales incorrectas',
                'alert_title'=>'Credenciales incorrectas',
                'alert_text'=>'Credenciales incorrectas',
                'alert_icon'=>'error',
            ]);
        }
        $token = $user->createToken($user->email, ['user'])->plainTextToken;
        $response->data = ObjResponse::CorrectResponse();
        $response->data["message"] = 'peticion satisfactoria | usuario logeado.';
        $response->data["result"]["token"] = $token;
        $response->data["result"]["user"]["id"] = $user->id;
        return response()->json($response, $response->data["status_code"]);
    }

    /**
     * Metodo para cerrar sesión.
     * @param int $id
     * @return \Illuminate\Http\Response $response
     */
    public function logout(int $id, Response $response)
    {
        try {
            DB::connection('mysql_becas')->table('personal_access_tokens')->where('tokenable_id', $id)->delete();
            
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'peticion satisfactoria | sesión cerrada.';
            $response->data["alert_title"] = "Bye!";
            
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }

    /**
     * Reegistrarse como jugador.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response $response
     */
    public function signup(Request $request, Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {

            // if (!$this->validateAvailability('username',$request->username)->status) return;
            
            $new_user = User::create([
                'email' => $request->email,
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'role_id' => 3,  //usuario normal
            ]);
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'peticion satisfactoria | usuario registrado.';
            $response->data["alert_text"] = "¡Felicidades! ya eres parte de la familia";

        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }


    /**
     * Mostrar lista de todos los usuarios activos del
     * uniendo con roles.
     *
     * @return \Illuminate\Http\Response $response
     */
    public function index(Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            // $list = DB::select('SELECT * FROM users where active = 1');
            // User::on('mysql_becas')->get();
            $list = User::where('users.active', true)
            ->join('roles', 'users.role_id', '=', 'roles.id')
            ->select('users.*','roles.role')
            ->get();
            
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'peticion satisfactoria | lista de usuarios.';
            $response->data["alert_text"] = "usuarios encontrados";
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
            $list = User::where('active', true)
            ->select('users.id as value', 'users.username as text')
            ->orderBy('users.username', 'asc')->get();
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'peticion satisfactoria | lista de usuarios.';
            $response->data["alert_text"] = "usuarios encontrados";
            $response->data["result"] = $list;
            $response->data["toast"] = false;
        }
        catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }

    /**
     * Crear un nuevo usuario.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response $response
     */
    public function create(Request $request, Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $token = $request->bearerToken();
        
            $new_user = User::create([
                // 'name' => $request->name,
                // 'last_name' => $request->last_name,
                'email' => $request->email,
                'username' => $request->username,
                'password' => Hash::make($request->password),
                // 'phone' => $request->phone,
                'role_id' => $request->role_id,
            ]);
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'peticion satisfactoria | usuario registrado.';
            $response->data["alert_text"] = "Usuario registrado";

        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }

    /**
     * Mostrar un usuario especifico.
     *
     * @param   int $id
     * @return \Illuminate\Http\Response $response
     */
    public function show(int $id, Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $user = User::where('users.id', $id)
            ->join('roles', 'users.role_id', '=', 'roles.id')
            ->select('users.*','roles.role')
            ->first();
            
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'peticion satisfactoria | usuario encontrado.';
            $response->data["alert_text"] = "Usuario encontrado";
            $response->data["result"] = $user;

        } catch (\Exception $ex) {
            $response = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }
    
    /**
     * Actualizar un usuario especifico.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response $response
     */
    public function update(Request $request, Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $user = User::where('id', $request->id)
            ->update([
                // 'name' => $request->name,
                // 'last_name' => $request->last_name,
                'email' => $request->email,
                'username' => $request->username,
                'password' => Hash::make($request->password),
                // 'phone' => $request->phone,
                'role_id' => $request->role_id,
            ]);

            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'peticion satisfactoria | usuario actualizado.';
            $response->data["alert_text"] = "Usuario actualizado";

        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }        
        return response()->json($response, $response->data["status_code"]);
    }

    /**
     * "Eliminar" (cambiar estado activo=false) un usuario especidifco.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response $response
     */
    public function destroy(int $id, Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            User::where('id', $id)
            ->update([
                'active' => false,
                'deleted_at' => date('Y-m-d H:i:s'),
            ]);
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'peticion satisfactoria | usuario eliminado.';
            $response->data["alert_text"] = "Usuario eliminado";

        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }



    private function validateAvailability(string $prop, int $value, string $message_error)
    {
        $response->data = ObjResponse::DefaultResponse();
        data_set($response,'alert_text',$message_error);
        try {
            $exist = User::where($prop, $value)->count();

            if ($exist > 0) $response = ObjResponse::CorrectResponse();

        } catch (\Exception $ex) {
            $response = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response,$response["status_code"]);
    }
}