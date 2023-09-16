<?php

namespace App\Http\Controllers\GPCenter;

use App\Http\Controllers\Controller;
use App\Models\ObjResponse;
use App\Models\GPCenter\User;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
class UserController extends Controller
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response $response
     */
    public function signup(Request $request, Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {

            // if (!$this->validateAvailability('username',$request->username)->status) return;

            $new_user = User::create([
                'username' => $request->username,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'role_id' => 3, //usuario normal
                    'phone' => $request->phone,
                    'license_number' => $request->license_number,
                    'license_due_date' => $request->license_due_date,
                    'payroll_number' => $request->payroll_number,
                    'department_id' => $request->department_id,
                    'name' => $request->name,
                    'paternal_last_name' => $request->paternal_last_name,
                    'maternal_last_name' => $request->maternal_last_name,
                    'community_id' => $request->community_id,
                    'address' => $request->address,
                    'num_ext' => $request->num_ext,
                    'num_int' => $request->num_int,
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
     * Mostrar lista de usuarios activos del
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
            ->join('departments', 'users.department_id', '=', 'departments.id')
            ->select('users.*','roles.role','departments.department','departments.description as department_description')
            ->orderBy('users.id', 'desc')
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
     * Crear usuario.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response $response
     */
    public function create(Request $request, Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $token = $request->bearerToken();

            if ($request->role_id < 2) {
                $new_user = User::create([
                    'username' => $request->username,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'role_id' => $request->role_id,
                    'department_id' => $request->department_id
                ]);
            } else {
                $new_user = User::create([
                    'username' => $request->username,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'role_id' => $request->role_id,
                    'phone' => $request->phone,
                    'license_number' => $request->license_number,
                    'license_due_date' => $request->license_due_date,
                    'payroll_number' => $request->payroll_number,
                    'department_id' => $request->department_id,
                    'name' => $request->name,
                    'paternal_last_name' => $request->paternal_last_name,
                    'maternal_last_name' => $request->maternal_last_name,
                    'community_id' => $request->community_id,
                    'address' => $request->address,
                    'num_ext' => $request->num_ext,
                    'num_int' => $request->num_int,
                ]);
            }
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'peticion satisfactoria | usuario registrado.';
            $response->data["alert_text"] = "Usuario registrado";

        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }

    /**
     * Mostrar usuario.
     *
     * @param   int $id
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response $response
     */
    public function show(Request $request, Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            // echo "el id: $request->id";
            $user = User::where('users.id',$request->id)
            ->join('roles', 'users.role_id', '=', 'roles.id')
            ->join('departments', 'users.department_id', '=', 'departments.id')
            ->select('users.*','roles.role','departments.department','departments.description as department_description')
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
     * Actualizar usuario.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response $response
     */
    public function update(Request $request, Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            echo "el id: $request->id";
            if ($request->role_id < 2) {
                $user = User::find($request->id)
                ->update([
                    'username' => $request->username,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'role_id' => $request->role_id,
                    'department_id' => $request->department_id
                ]);
            } else {
                $user = User::find($request->id)
                ->update([
                    'username' => $request->username,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'role_id' => $request->role_id,
                    'phone' => $request->phone,
                    'license_number' => $request->license_number,
                    'license_due_date' => $request->license_due_date,
                    'payroll_number' => $request->payroll_number,
                    'department_id' => $request->department_id,
                    'name' => $request->name,
                    'paternal_last_name' => $request->paternal_last_name,
                    'maternal_last_name' => $request->maternal_last_name,
                    'community_id' => $request->community_id,
                    'address' => $request->address,
                    'num_ext' => $request->num_ext,
                    'num_int' => $request->num_int,
                ]);
            }

            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'peticion satisfactoria | usuario actualizado.';
            $response->data["alert_text"] = "Usuario actualizado";

        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }

    /**
     * "Eliminar" (cambiar estado activo=false) usuario.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response $response
     */
    public function destroy(int $id, Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            User::find($id)
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



    // private function validateAvailability(string $prop, int $value, string $message_error)
    // {
    //     $response->data = ObjResponse::DefaultResponse();
    //     data_set($response,'alert_text',$message_error);
    //     try {
    //         $exist = User::where($prop, $value)->count();

    //         if ($exist > 0) $response = ObjResponse::CorrectResponse();

    //     } catch (\Exception $ex) {
    //         $response = ObjResponse::CatchResponse($ex->getMessage());
    //     }
    //     return response()->json($response,$response["status_code"]);
    // }
}

