<?php

namespace sacep\Http\Controllers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use sacep\Usuario;
use sacep\Empleado;
use sacep\Evaluacion;
use Illuminate\Http\Request;
use sacep\Departamento;
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
        $this->authorize('evaluar',$empleado);
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

        //$last_ev = Evaluacion::select('periodo_hasta')->with(['empleado'=> function ($query) use ($empleado) {
        //    $query->where('cedula_empleado', $empleado->cedula_empleado);
        //}])->get();

        $data['last_ev'] = Evaluacion::select('evaluacion.periodo_hasta')
        ->join('evaluacion_empleado','evaluacion_empleado.id_evaluacion','=','evaluacion.id_evaluacion')
        ->where('evaluacion_empleado.cedula_empleado','=',$empleado->cedula_empleado)
        ->latest('periodo_hasta')->first();

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
        $dep = $request->get('departamento_trabajador_evaluado');
        $evaluacion = [
            'fecha_evaluacion' => $request->get('fecha_evaluacion'),
            'periodo_desde'    => $request->get('periodo_desde'),
            'periodo_hasta'    => $request->get('periodo_hasta'),
            'motivo'           => $request->get('motivo'),
            'tipo'             => $request->get('tipo'),
            'estado'           => 'guardada',
            'departamento_trabajador_evaluado' => $dep,
            'cargo_trabajador_evaluado' => $request->get('cargo_trabajador_evaluado'),
            'descripcion'      => $request->get('descripcion'),
            'recomendacion'    => $request->get('recomendacion'),
            'comentario'       => $request->get('comentario')
        ];

        $ev = Evaluacion::create($evaluacion);


        $responsable = Departamento::select('responsable')->where('id_departamento',$dep)->first();
        $nivel_responsable = Empleado::with('usuario')->where('cedula_empleado','=',$responsable->responsable)->first();
        $empleado = Empleado::where('cedula_empleado','=',$request->get('cedula_empleado'))->first();
        $evaluador = Auth::user()->empleado->cedula_empleado;
        $th = Usuario::where('nivel','th')->with('empleado')->first();
        $gerente = Usuario::where('nivel','gerente')->with('empleado')->first();

        if($responsable->responsable == $evaluador){
            $evaluacion_empleado = [
                $empleado->cedula_empleado => ['tipo' => 'trabajador'],
                $evaluador               => ['tipo' => 'evaluador'],
                $th->empleado->cedula_empleado => ['tipo' => 'th'],
                $gerente->empleado->cedula_empleado => ['tipo' => 'gerente'],
            ];
            $ev->empleados()->attach($evaluacion_empleado);
        }else{
            $evaluacion_empleado = [
                $empleado->cedula_empleado => ['tipo' => 'trabajador'],
                $evaluador               => ['tipo' => 'evaluador'],
                $th->empleado->cedula_empleado => ['tipo' => 'th'],
                $gerente->empleado->cedula_empleado => ['tipo' => 'gerente'],
                $responsable->responsable => ['tipo'=> $nivel_responsable->usuario->nivel]
            ];
            $ev->empleados()->attach($evaluacion_empleado);
        }


        $items = $request->get('items');
        foreach($items as $item){
            $ev->item_evaluado()->attach([$item['item_evaluado'] => ['puntaje' => $this->cambiar_string_puntaje($item['puntaje'])]]);
            //echo "item_evaluado = ".$item['item_evaluado']." Puntaje= ".$this->cambiar_string_puntaje($item['puntaje'])."<br>";
        }

        // $msg = [
        //     'type' => 'success',
        //     'msg' => 'Se ha completado la evaluación de '.$empleado->nombre_completo.", para el periodo ".$request->get('periodo_desde')." hasta ".$request->get('periodo_hasta')." con motivo: ".ucfirst($request->get('motivo')).".",
        //     'title' => 'Evaluación completada',
        // ];

        //return redirect()->route('index_evaluar')->with('notif', $msg);

        return redirect()->route('imprimir_evaluacion',['id'=>$ev->id_evaluacion]);
    }

    /**
    * Cambiar el valor que viene del formulario de evaluacion para el puntaje
    * @param string $puntaje
    * @return int
    */

    private function cambiar_string_puntaje($puntaje)
    {
        if ($value == "Deficiente") {
            return 1;
        }elseif ($value == "Regular") {
            return 2;
        }elseif ($value == "Bueno") {
            return 3;
        }elseif ($value == "Muy Bueno") {
            return 4;
        }else {
            return 5;
        }
    }

    /**
     * Muestra la evaluación para imprimirla
     *
     * @param  int $eval
     * @return \Illuminate\Http\Response
     */
    public function imprimir($eval)
    {
        $data['evaluacion'] = Evaluacion::where('id_evaluacion',$eval)->with(['empleados','item_evaluado'])->first();

        foreach ($data['evaluacion']->empleados as $empleado) {
            if ($empleado->pivot->tipo == 'trabajador') {
                $data['empleado'] = $empleado;
            }elseif ($empleado->pivot->tipo == 'th') {
                $data['th'] = $empleado;
            }elseif ($empleado->pivot->tipo == 'gerente') {
                $data['gerente'] = $empleado;
            }elseif ($empleado->pivot->tipo == 'evaluador') {
                $data['evaluador'] = $empleado;
            }elseif ($empleado->pivot->tipo == 'coordinador' || $empleado->pivot->tipo == 'supervisor' || $empleado->pivot->tipo == 'jefe') {
                $data['responsable'] = $empleado;
            }
        }

        $data['factores'] = FactorDeEvaluacion::all();

        //$view =  \View::make('evaluacion_imprimir', compact('data', 'date', 'invoice'))->render();
		$pdf = App::make('dompdf.wrapper');
		$pdf->loadView('evaluacion_imprimir',$data);
		return $pdf->stream('evaluacion_imprimir');

        //return view('evaluacion_imprimir',$data);
    }


    /**
     * Muestra los resultados de las evaluaciones del empleado
     *
     * @param  int $empleado
     * @return \Illuminate\Http\Response
     */
    public function evaluaciones($empleado)
    {
        $emp = Empleado::find($empleado);
        $this->authorize('evaluaciones',$emp);
        $data['evaluaciones'] = Evaluacion::with(['item_evaluado','empleados' => function($query) use ($empleado){
            $query->where('evaluacion_empleado.cedula_empleado',$empleado);
        }])->get();

        $data['empleado'] = Empleado::find($empleado);

        $puntaje = 0;
        // foreach ($evaluaciones as $evaluacion) {
        //     $cant_items = $evaluacion->item_evaluado()->count();
        //     foreach($evaluacion->item_evaluado as $item) {
        //         $puntaje = $puntaje + $item->pivot->puntaje;
        //     }
        // }

        return view('evaluar.evaluaciones_empleado',$data);
     }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \sacep\Evaluacion  $evaluacion
     * @return \Illuminate\Http\Response
     */
    public function edit(Evaluacion $evaluacion)
    {
        $this->authorize('editar_eval',$evaluacion);

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
        $data['evaluacion'] = $evaluacion;

        foreach ($data['evaluacion']->empleados as $empleado) {
            if ($empleado->pivot->tipo == 'trabajador') {
                $data['empleado'] = $empleado;
            }elseif ($empleado->pivot->tipo == 'th') {
                $data['th'] = $empleado;
            }elseif ($empleado->pivot->tipo == 'gerente') {
                $data['gerente'] = $empleado;
            }elseif ($empleado->pivot->tipo == 'evaluador') {
                $data['evaluador'] = $empleado;
            }elseif ($empleado->pivot->tipo == 'coordinador' || $empleado->pivot->tipo == 'supervisor' || $empleado->pivot->tipo == 'jefe') {
                $data['responsable'] = $empleado;
            }
        }
        // $data['empleado'] = $empleado;
        //
        // $data['last_ev'] = Evaluacion::select('evaluacion.periodo_hasta')
        // ->join('evaluacion_empleado','evaluacion_empleado.id_evaluacion','=','evaluacion.id_evaluacion')
        // ->where('evaluacion_empleado.cedula_empleado','=',$empleado->cedula_empleado)
        // ->latest('periodo_hasta')->first();

        return  view('evaluar.editar',$data);
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
