<?php

namespace App\Http\Controllers\becas;
use App\Models\becas\Role;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ObjResponse;
use Illuminate\Support\Facades\DB;


class SchoolController extends Controller
{
    public function __construct() {
        Roles::on('mysql_becas')->get();
    }
    
    /**
     * Mostrar lista de todas las difficultades.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Schools = DB::connection('mysql_becas')->table('roles')->get();

        $response = ObjResponse::DefaultResponse();
        try {
            //OPCIOIN 1 - Query
            // $lista = DB::select('SELECT * FROM users where active = 1');
            // $list = Difficult::select('difficult_id','difficult_name', 'difficult_score')
            // ->get();
            // $response = ObjResponse::CorrectResponse();
            // data_set($response,'message','peticion satisfactoria | lista de dificultades.');
            // data_set($response,'data',$list);

            //OPCIOIN 2 - Eloquent
            // $list = Difficult::whereNotNull('difficult_id')
            // ->select('difficults.difficult_id','difficults.difficult_name', 'difficults.difficult_score')
            // ->orderBy('difficults.difficult_name', 'asc')->get();
            $response = ObjResponse::CorrectResponse();
            data_set($response, 'message', 'Peticion satisfactoria | listado de escuelas.');
            data_set($response, 'data', $Schools);

        } catch (\Exception $ex) {
            $response = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response["status_code"]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $response = ObjResponse::DefaultResponse();
        try {
            $new_difficult = Difficult::create([
                'difficult_name' => $request->difficult_name,
                'difficult_score' => $request->difficult_score,
            ]);
            $response = ObjResponse::CorrectResponse();
            data_set($response,'message','peticion satisfactoria | dificultad registrada.');
            data_set($response,'alert_text','dificultad registrada');
        }
        catch (\Exception $ex) {
            $response = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response, $response["status_code"]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Difficult  $difficult
     * @return \Illuminate\Http\Response
     */
    public function show(Difficult $difficult, int $id)
    {
        $response = ObjResponse::DefaultResponse();
        try{
            $difficult = Difficult::where('difficult_id', $id)
            ->select('difficults.difficult_id','difficults.difficult_name','difficults.difficult_score')
            ->get();
            
            $response = ObjResponse::CorrectResponse();
            data_set($response,'message','peticion satisfactoria | dificultad encontrada.');
            data_set($response,'data',$difficult);
        }
        catch (\Exception $ex) {
            $response = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response,$response["status_code"]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Difficult  $difficult
     * @return \Illuminate\Http\Response
     */
    public function edit(Difficult $difficult)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Difficult  $difficult
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Difficult $difficult)
    {
        $response = ObjResponse::DefaultResponse();
        try{
            $difficult = Difficult::where('difficults.difficult_id', $request->difficult_id)
            ->update([
                'difficult_name' => $request->difficult_name,
                'difficult_score' => $request->difficult_score,
            ]);

            $response = ObjResponse::CorrectResponse();
            data_set($response,'message','peticion satisfactoria | respuesta actualizada.');
            data_set($response,'alert_text','Respuesta actualizada');
        }
        catch (\Exception $ex) {
            $response = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response,$response["status_code"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Difficult  $difficult
     * @return \Illuminate\Http\Response
     */
    public function destroy(Difficult $difficult, int $id)
    {
        $response = ObjResponse::DefaultResponse();
        try{
            Difficult::where('difficult_id', $id)
            ->delete();
            $response = ObjResponse::CorrectResponse();
            data_set($response, 'message', 'petición satisfactoria. Dificultad eliminada.');
            data_set($response, 'alert_text', 'Dificultad eliminada.');
        }
        catch(\Exception $ex){
            $response = ObjResponse::CatchResponse($ex->getMessage());
        }
        return response()->json($response,$response["status_code"]);
    }
}