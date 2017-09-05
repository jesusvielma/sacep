<?php

namespace sacep\Http\Controllers;

use FontLib\Table\Type\name;
use sacep\FactorDeEvaluacion;
use Illuminate\Http\Request;

/**
 * Controlador para el modulo de factores de evaluación
 * @author Jesus Vielma <jesusvielma309@gmail.com>
 */
class FactorDeEvaluacionController extends Controller
{
    /**
     * Muestro todos los factores con sus ítems.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['factores'] = FactorDeEvaluacion::with('items')->get();

        return view('factor_evaluacion.index',$data);
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
     * Guarda la información de un nuevo factor de evaluación
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'nombre' => 'required',
            'porcentaje' => 'numeric',
        ]);

        $factor = new FactorDeEvaluacion;
        $factor->nombre = $request->get('nombre');
        $factor->porcentaje = $request->get('porcentaje');
        $factor->estado = 1;
        $factor->save();

        $msg = [
            'type' => 'success',
            'msg' => 'Se ha creado el factor de evaluación '.$request->get('nombre'),
            'title' => 'Accion exitosa',
        ];

        return redirect()->route('factores')->with('notif', $msg);
    }

    /**
     * Display the specified resource.
     *
     * @param  \sacep\FactorDeEvaluacion  $factorDeEvaluacion
     * @return \Illuminate\Http\Response
     */
    public function show($factorDeEvaluacion)
    {
        //
    }

    /**
     * Envia la información de un factor mediante json.
     *
     * @param  \sacep\FactorDeEvaluacion  $factor
     * @return \Illuminate\Http\Response
     */
    public function edit(FactorDeEvaluacion $factor)
    {
        $data = [
            'nombre' => $factor->nombre,
            'porcentaje' => $factor->porcentaje,
            'estado'    => $factor->estado
        ];

        return response()->json($data);
    }

    /**
     * Actualiza la información de un ffactor de evaluación
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \sacep\FactorDeEvaluacion  $factor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FactorDeEvaluacion $factor)
    {
        $this->validate($request,[
            'nombre'    => 'required',
            'porcentaje'=> 'numeric',
            'estado'    => 'required'
        ]);

        $factor->fill($request->except('_token'));
        $factor->save();

        $msg = [
            'type' => 'success',
            'msg' => 'Se ha modificado el factor de evaluación '.$request->get('nombre'),
            'title' => 'Modificación exitosa',
        ];

        return redirect()->route('factores')->with('notif', $msg);
    }

    /**
     * Borrar factor de evaluación
     * @param  FactorDeEvaluacion $factor
     * @return \Illuminate\Http\Response
     */
    public function destroy(FactorDeEvaluacion $factor)
    {
        $factor->delete();
        return redirect()->route('factores');
    }

}
