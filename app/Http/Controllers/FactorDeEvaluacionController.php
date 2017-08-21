<?php

namespace sacep\Http\Controllers;

use sacep\FactorDeEvaluacion;
use Illuminate\Http\Request;

class FactorDeEvaluacionController extends Controller
{
    /**
     * Display a listing of the resource.
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
     * Store a newly created resource in storage.
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
     * Show the form for editing the specified resource.
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
     * Update the specified resource in storage.
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
     * [destroy description]
     * @param  FactorDeEvaluacion $factor
     * @return \Illuminate\Http\Response
     */
    public function destroy(FactorDeEvaluacion $factor)
    {
        $factor->delete();
        return redirect()->route('factores');
    }

}
