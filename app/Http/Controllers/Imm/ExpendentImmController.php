<?php

namespace App\Http\Controllers\imm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ObjResponse;
use App\Models\imm\Expendent;
use App\Models\imm\ExpendentSessions;
use App\Models\imm\ExpendentProblem;
use App\Models\imm\ExpendentMotiveClosed;
use App\Models\imm\ExpendentTypeViolence;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
class ExpendentImmController extends Controller
{
    public function selectIndexProblem(Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $list = ExpendentProblem::where('active', true)
            ->select('expendent_problems.id as value', 'expendent_problems.problem as text')
            ->orderBy('expendent_problems.id', 'asc')->get();
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'Peticion satisfactoria | Lista de problemas';
            $response->data["result"] = $list;
        }
        catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }
    public function selectIndexMotiveClosed(Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $list = ExpendentMotiveClosed::where('active', true)
            ->select('expendent_motive_closeds.id as value', 'expendent_motive_closeds.motive_closed as text')
            ->orderBy('expendent_motive_closeds.id', 'asc')->get();
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'Peticion satisfactoria | Lista de motivos de cierre';
            $response->data["result"] = $list;
        }
        catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }
    public function selectIndexTypeViolece(Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
            $list = ExpendentTypeViolence::where('active', true)
            ->select('expendent_type_violences.id as value', 'expendent_type_violences.type_violence as text')
            ->orderBy('expendent_type_violences.id', 'asc')->get();
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'Peticion satisfactoria | Lista de problemas';
            $response->data["result"] = $list;
        }
        catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }
    public function create(Request $request, Response $response)
    {
        $response->data = ObjResponse::DefaultResponse();
        try {
          $expedent =Expendent::create([
                 'date' => date('Y-m-d', strtotime($request->date)),
                 'procceding_id' => intval($request->procceding_id),
                 'type_violences_id'=>intval($request->type_violences_id),
                 'motive_closed_id'=>intval($request->motive_closed_id),
                 'problems_id'=>intval($request->problems_id),
                 'diagnostic'=>$request->diagnostic,
                 'dateclosed'=>date('Y-m-d', strtotime($request->dateclosed)),
             
            ]);
            for ($i = 1; $i <= 18; $i++) { 
                if ($request->{"date$i"} !== null && $request->{"came$i"} !== null && $request->{"comment$i"} !== null) {
                    ExpendentSessions::create([
                        'expendents_id' => $expedent->id,
                        'date' => date('Y-m-d', strtotime($request->{"date$i"})),
                        'came' => intval($request->{"came$i"}),
                        'comment' => $request->{"comment$i"}
                    ]);
                }
            }
            
            $response->data = ObjResponse::CorrectResponse();
            $response->data["message"] = 'peticion satisfactoria | expediente registrado.';
            $response->data["alert_text"] = 'expediente registrada';
        }
        catch (\Exception $ex) {
            $response->data = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response->data["status_code"]);
    }
    // public function index(Response $response)
    // {
    //     /**
    //      * Mostrar lista de todos los programa de ejes  activos.
    //      *
    //      * @return \Illuminate\Http\Response $response
    //      */
    //     $response->data = ObjResponse::DefaultResponse();
    //     try {
    //         $list = Expendent::where('expendents.active', true)
    //         ->join('expendents as exp', 'axisprograms.id_axi', '=', 'user_proceedings.id')
    //         ->select('expendents.procceding_id as Folio' , 'axis.axi as axi')
    //         ->orderBy('axisprograms.axisprogram', 'asc')->get();

    //         $response->data = ObjResponse::CorrectResponse();
    //         $response->data["message"] = 'Peticion satisfactoria | Lista de programa de ejes.';
    //         $response->data["result"] = $list;
    //     }
    //     catch (\Exception $ex) {
    //         $response->data = ObjResponse::CatchResponse($ex->getMessage());
    //     }
    //     return response()->json($response, $response->data["status_code"]);
    // }
}
