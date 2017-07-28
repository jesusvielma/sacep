<?php

namespace sacep\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use sacep\Empleado;
use sacep\Evaluacion;
use Illuminate\Http\Request;
use sacep\FactorDeEvaluacion;

class EvaluacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dep = Auth::user()->empleado->id_departamento;

        $cedula = Auth::user()->empleado->cedula_empleado;

        $data['empleados'] = Empleado::where('estado','activo')
                                       ->where('id_departamento',$dep)
                                       ->where('cedula_empleado','!=',$cedula)
                                       ->get();

        return view('evaluar.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param \sacep\Empleado $empleado
     * @return \Illuminate\Http\Response
     */
    public function evaluar(Empleado $empleado)
    {
        $rol_evaluador = Auth::user()->nivel == 'gerente';
        if ($rol_evaluador === TRUE) {
            $data['factores'] = FactorDeEvaluacion::where('estado',1)->with(['items'=> function($query){
                $query->where('visivilidad','!=','trabajador');
            }])->get();
        }
        else{
            $data['factores'] = FactorDeEvaluacion::where('estado',1)->with(['items'=> function($query){
                $query->where('visivilidad','!=','coordinador');
            }])->get();
        }
        $data['empleado'] = $empleado;

        return view('evaluar.crear',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \sacep\Evaluacion  $evaluacion
     * @return \Illuminate\Http\Response
     */
    public function show(Evaluacion $evaluacion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \sacep\Evaluacion  $evaluacion
     * @return \Illuminate\Http\Response
     */
    public function edit(Evaluacion $evaluacion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \sacep\Evaluacion  $evaluacion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Evaluacion $evaluacion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \sacep\Evaluacion  $evaluacion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Evaluacion $evaluacion)
    {
        //
    }
}
