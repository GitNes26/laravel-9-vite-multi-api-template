<?php
namespace App\Http\Controllers\imm;
use App\Models\Imm\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Auth;
use App\Models\ObjResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class UserImmController extends Controller
{
   
    // public function login(Request $request)
    // {
    // $input = $request->all();
    // $validation = Validator::make($input,[
    //     'email'=>'required|email',
    //     'password'=>'required',
    // ]);
    // if ($validation->fails()) {
    //     return \response()->json(['error'=>$validation->errors()]);
    // }
    // if (Auth::guard('db_imm')->attempt(['email' => $input['email'], 'password' => $input['password']])) {
    //     $user = Auth::guard('db_imm')->user();
    //     $token =$user->createToken('MyApp',['db_imm'])->plainTextToken;
    //     return response()->json(['id' => $user->id, 'token' => $token]);
    // }    
    // }
    public function emails(Response $response)
    {
        /**
         * Mostrar lista de todos los generos activos.
         *
         * @return \Illuminate\Http\Response $response
         */
        $response->data = ObjResponse::DefaultResponse();
        try {
            $list = User::where('active', true)
            ->select('users.email')
            ->orderBy('users.email', 'asc')->get();
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'Peticion satisfactoria | Lista de correos.';
            $response->data["result"] = $list;
        }
        catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }
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
    public function register(Request $request, Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $token = $request->bearerToken();
            
            $new_user = User::create([
                // 'name' => $request->name,
                // 'last_name' => $request->last_name,
                'name' => $request->name,

                'email' => $request->email,
                'password' => Hash::make($request->password),
                // 'phone' => $request->phone,
                // 'role_id' => $request->role_id,
            ]);
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'peticion satisfactoria | usuario registrado.';
            $response->data["alert_text"] = "Usuario registrado";

        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }
    public function logout(int $id, Response $response)
    {
        try {
            DB::connection('mysql_imm')->table('personal_access_tokens')->where('tokenable_id', $id)->delete();
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'peticion satisfactoria | sesión cerrada.';
            $response->data["alert_title"] = "Bye!";
            
        } catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }
    

}
