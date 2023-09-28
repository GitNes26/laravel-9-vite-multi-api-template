<?php

namespace App\Http\Controllers\imm;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ObjResponse;
use App\Models\imm\UserProceedings;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class UserProceedingsImmController extends Controller
{
    public function create(Request $request, Response $response,int $latestId,int $id = null)
    {
        if($id){
                $userProceeding =UserProceedings::where("user_datageneral_id",$id)->first();
                $userProceeding->procceding = $request->procceding;
                $userProceeding->dateingress = Carbon::createFromFormat('d/m/Y', $request->dateingress)->format('Y-m-d');
                $userProceeding->timeingress = $request->timeingress;
                $userProceeding->save();
             }
             else{
                 $userProceeding = new UserProceedings();
                 $userProceeding->procceding = $request->procceding;
                 $userProceeding->dateingress = Carbon::createFromFormat('d/m/Y', $request->dateingress)->format('Y-m-d');
                  $userProceeding->timeingress = Carbon::createFromFormat('h:i:s A', $request->timeingress)->format('H:i:s');
                 $userProceeding->user_datageneral_id = $latestId;
 
                 $userProceeding->save();
             }

     
    }
    public function index( Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $latestId = UserProceedings::latest()->value('id');
            $latestId = intval($latestId);
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'Peticion satisfactoria | Numero de expendiente.';
            $response->data["result"] = $latestId;
        }
        catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
           

     
    }
}
