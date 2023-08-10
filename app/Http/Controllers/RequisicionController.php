<?php

namespace App\Http\Controllers;

use App\Models\Requisicion;
use App\Models\Notificacion;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Mail\Correos;
use Illuminate\Support\Facades\Mail;

class RequisicionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    return Requisicion::join('Cat_Departamentos', 'Requisiciones.IDDepartamento', '=', 'Cat_Departamentos.IDDepartamento')
                            ->leftjoin('Det_Notificaciones', 'Requisiciones.IDRequisicion', '=', 'Det_Notificaciones.idRequisicion')
                            ->where("ejercicio",2023)->where("Status","OC")->orderBy('Requisiciones.IDRequisicion','desc')->get(['Requisiciones.IDRequisicion','Ejercicio','Status','Nombre_Departamento','Solicitante','Observaciones', 'Requisitor', 'FechaCotizacion','Det_Notificaciones.notificacion']);
    }

    public function store(Request $request)
    {
        $notificacion = new Notificacion;
        $notificacion->idRequisicion = $request->idRequi;
        $notificacion->notificacion = 1;
        $notificacion->fechaNotificacion = $request->fechaRegistro;
        $notificacion->usuarioNotificacion = $request->usuario;
        $notificacion->activo = 1;
        $notificacion->save();
        // $array = ['nestorpuentesin@gmail.com','samuelgarza1029@gmail.com', 'rocior@hotmail.com'];

        // foreach ( $array as $value) {

        //     Mail::to($value)->send(new Correos($request));
        // }

        Mail::to('samuel.garza29@hotmail.com')->send(new Correos($request));
        

        return 1 ;


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Requisicion  $requisicion
     * @return \Illuminate\Http\Response
     */
    public function show(Requisicion $requisicion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Requisicion  $requisicion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Requisicion $requisicion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Requisicion  $requisicion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Requisicion $requisicion)
    {
        //
    }
}
