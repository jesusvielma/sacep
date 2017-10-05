<?php

namespace sacep\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use sacep\Usuario;
use sacep\Empleado;
use sacep\Evaluacion;
use sacep\Departamento;
use sacep\FactorDeEvaluacion;

/**
 * Controlador para el modulo de evaluaciones
 * @author Jesus Vielma <jesusvielma309@gmail.com>
 */
class EvaluacionController extends Controller
{
    /**
     * Muestra los empleados segun el departamento del usuario conectado
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dep = Auth::user()->empleado->id_departamento;

        $cedula = Auth::user()->empleado->cedula_empleado;

        $dep2 = Departamento::find($dep);

        if (Auth::user()->nivel == 'gerente' || Auth::user()->nivel == 'coordinador' ) {
            if ($dep2->hijo->count()) {
                $data['cant_hijos'] = $dep2->hijo->count();
                $data1= [];
                $data2 = [];
                $empl_consulta = [];
                foreach ($dep2->hijo as $key => $hijo1) {
                    //echo 'dep = '.$hijo1->id_departamento.' responsable'.$hijo1->responsable."<br />";
                    if ($hijo1->responsable) {
                        $hijo = Empleado::find($hijo1->responsable);
                        $data1 = $data1 + [$key => $hijo];
                        $empl_consulta = $empl_consulta + [$key => $hijo1->empleados];
                    }else{
                        $data2 = $data2 + [$key => $hijo1->empleados];
                    }
                }
                $data['hijos'] = $data1;
                $data['otros_empls'] = $data2;
                //dd($data1);
                $data['empl_consulta'] = $empl_consulta;
            }
            else {
                $data['cant_hijos'] = $dep2->hijo->count();
            }
        }else{
            $data['cant_hijos'] = $dep2->hijo->count();
        }

        if(Auth::user()->nivel !='gerente'){
            $data['empleados'] = Empleado::where('estado','activo')
            ->where('id_departamento',$dep)
            ->where('cedula_empleado','!=',$cedula)
            ->get();

        }
        else{
            $data['empleados'] = Empleado::where('empleado.estado','activo')
                                            ->where('empleado.id_departamento',$dep)
                                            ->where('empleado.cedula_empleado','!=',$cedula)
                                            ->orWhere('usuario.nivel','coordinador')
                                            ->orWhere('usuario.nivel','th')
                                            ->leftJoin('usuario','usuario.id_usuario','=','empleado.id_usuario')->get();
        }

        return view('evaluar.index',$data);
    }

    /**
     * Muestra el formulario para evaluar a un empleado
     *
     * @param \sacep\Empleado $empleado
     * @return \Illuminate\Http\Response
     */
    public function evaluar(Empleado $empleado)
    {
        $eval = new Evaluacion;
        $this->authorize('evaluar',[$eval,$empleado]);
        $rol_evaluador = Auth::user()->nivel == 'gerente';
        if (($rol_evaluador === TRUE && (isset($empleado->id_usuario) && ($empleado->usuario->nivel == 'supervisor' || $empleado->usuario->nivel == 'jefe'))) || (isset($empleado->id_usuario) && ($empleado->usuario->nivel == 'supervisor' || $empleado->usuario->nivel == 'jefe')) ) {
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
     * Guarda la evaluación
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

        $empleado = Empleado::where('cedula_empleado','=',$request->get('cedula_empleado'))->first();
        $evaluador = Auth::user()->empleado->cedula_empleado;
        $th = Usuario::where('nivel','th')->with('empleado')->first();
        $gerente = Usuario::where('nivel','gerente')->with('empleado')->first();

        $ev = Evaluacion::create($evaluacion);

        $departamento = Departamento::find($dep);
        if ($departamento->departamento_padre) {
            $ev->empleados()->attach([$departamento->padre->encargado->cedula_empleado => ['tipo'=>'superior']]);
        }

        $ev->empleados()->attach([$evaluador => ['tipo' => 'evaluador'],]);
        $ev->empleados()->attach([$empleado->cedula_empleado => ['tipo' => 'evaluado']]);
        $ev->empleados()->attach([$th->empleado->cedula_empleado => ['tipo' => 'th']]);
        $ev->empleados()->attach([$gerente->empleado->cedula_empleado => ['tipo' => 'gerente']]);


        $items = $request->get('items');
        foreach($items as $item){
            $ev->item_evaluado()->attach([
                $item['item_evaluado'] => ['puntaje' => $this->cambiar_string_puntaje($item['puntaje'])]
            ]);
        }

        return redirect()->route('imprimir_evaluacion',['id'=>$ev->id_evaluacion]);
    }

    /**
    * Cambiar el valor que viene del formulario de evaluación para el puntaje
    * @param string $puntaje
    * @return int
    */

    private function cambiar_string_puntaje($puntaje)
    {
        if ($puntaje == "Deficiente") {
            return 1;
        }elseif ($puntaje == "Regular") {
            return 2;
        }elseif ($puntaje == "Bueno") {
            return 3;
        }elseif ($puntaje == "Muy Bueno") {
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
        $data['evaluacion'] = $evalu= Evaluacion::where('id_evaluacion',$eval)->with(['empleados','item_evaluado'])->first();

        foreach ($data['evaluacion']->empleados as $empleado) {
            if ($empleado->pivot->tipo == 'evaluado') {
                $data['empleado'] = $evaluado = $empleado;
            }elseif ($empleado->pivot->tipo == 'th') {
                $data['th'] = $empleado;
            }elseif ($empleado->pivot->tipo == 'gerente') {
                $data['gerente'] = $empleado;
            }elseif ($empleado->pivot->tipo == 'evaluador') {
                $data['evaluador'] = $empleado;
            }elseif ($empleado->pivot->tipo == 'superior') {
                $data['responsable'] = $empleado;
            }
        }

        date_default_timezone_set('America/Caracas');
		setlocale(LC_ALL,'es_VE.UTF-8','es_VE','Windows-1252','esp','es_ES.UTF-8','es_ES');

        $data['factores'] = FactorDeEvaluacion::all();

        //$view =  \View::make('evaluacion_imprimir', compact('data', 'date', 'invoice'))->render();
		$pdf = App::make('dompdf.wrapper');
        $nombre = $evalu->fecha_evaluacion->format('Y-m-d').'-'.$evaluado->cedula_empleado.'.pdf';
        // $directories = Storage::allDirectories();
        // foreach ($directories as $dir) {
        //     if ($dir != 'public/evaluaciones') {
        //         Storage::makeDirectory('/public/evaluaciones');
        //     }
        //     else{
        //         Storage::makeDirectory('public/evaluaciones/'.date('Ym'));
        //     }
        // }

        Storage::makeDirectory('public/evaluaciones/'.date('Ym'));


		$pdf->loadView('evaluacion_imprimir',$data)->save(storage_path().'/app/public/evaluaciones/'.date('Ym').'/'.$nombre);
        //$pdf->loadView('evaluacion_imprimir',$data);
		//return $pdf->stream('evaluacion_imprimir');

        //return view('evaluacion_imprimir',$data);
        $msg = [
            'type' => 'success',
            'msg' => 'Se ha guardado la evaluación de '.$evaluado->nombre_completo.', puede acceder a ella haciendo click sobre esta notificación o haciendo clic en el botón para ver la evaluaciones de '.$evaluado->nombre_completo.' en el listado de trabajadores o puede esperar un minuto y automáticamente se abrirá la evaluación para imprimir. (Nota: esta notificación desaparece luego de un minuto)',
            'title' => 'Evaluación guardada',
            'url' => date('Ym').'/'.$nombre,
        ];

        return redirect()->route('index_evaluar')->with('notif', $msg);
    }


    /**
     * Muestra los resultados de las evaluaciones del empleado
     *
     * @param  Empleado $empleado
     * @return \Illuminate\Http\Response
     */
    public function evaluaciones(Empleado $empleado)
    {
        //$empleado = Empleado::findOrFail($empleado);
        $ev = new Evaluacion;

        $this->authorize('evaluaciones',[$ev,$empleado]);
        $data['evaluaciones'] = Evaluacion::with(['item_evaluado','empleados' => function($query) use ($empleado){
            $query->where('evaluacion_empleado.cedula_empleado','=',$empleado->cedula_empleado)->where('evaluacion_empleado.tipo','=','evaluado');
        }])->get();

        $data['empleado'] = $empleado;

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
     * Muestra el formulario para editar la evaluación
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
            if ($empleado->pivot->tipo == 'evaluado') {
                $data['empleado'] = $empleado;
            }elseif ($empleado->pivot->tipo == 'th') {
                $data['th'] = $empleado;
            }elseif ($empleado->pivot->tipo == 'gerente') {
                $data['gerente'] = $empleado;
            }elseif ($empleado->pivot->tipo == 'evaluador') {
                $data['evaluador'] = $empleado;
            }elseif ($empleado->pivot->tipo == 'superior') {
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
     * Actualiza la información de la evaluación
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \sacep\Evaluacion  $evaluacion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$evaluacion)
    {
        $evaluacion = Evaluacion::find($evaluacion);

        $evaluacion->comentario = $request->get('comentario');
        $evaluacion->recomendacion = $request->get('recomendacion');
        $evaluacion->descripcion = $request->get('descripcion');
        $evaluacion->save();

        $items = $request->get('items');
        foreach($items as $item){
            $evaluacion->item_evaluado()->updateExistingPivot($item['item_evaluado'],
            ['puntaje' => $this->cambiar_string_puntaje($item['puntaje'])]);
            //echo "item_evaluado = ".$item['item_evaluado']." Puntaje= ".$this->cambiar_string_puntaje($item['puntaje'])."<br>";
        }

        return redirect()->route('imprimir_evaluacion',['id'=>$evaluacion->id_evaluacion]);
    }

    /**
     * Lista la evaluaciones que deben procesarse
     *
     * @return \Illuminate\Http\Response
     */
    public function procesar_index()
    {
        $this->authorize('procesar',\sacep\Evaluacion::class);
        $data['evaluaciones'] = Evaluacion::where('estado','guardada')->with(['item_evaluado','empleados' => function($query){
            $query->where('evaluacion_empleado.tipo','=','evaluado')->orWhere('evaluacion_empleado.tipo','=','evaluador');
        }])->get();

        return view('evaluar.procesar_index',$data);
    }

    /**
     * Cambia el estado de un evaluación
     *
     * @param \sacep\Evaluacion $evaluacion
     * @return \Illuminate\Http\Response
     */
    public function procesar_una(Evaluacion $evaluacion)
    {
        $evaluacion->estado = 'procesada';
        $evaluacion->save();

        return redirect()->route('procesar_index');
    }

    /**
     * Cambia el estado de un evaluación
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function procesar_varias(Request $request)
    {
        $eva = '';
        foreach ($request->get('id_evaluacion') as $ev) {
            $eva = Evaluacion::find($ev);
            $eva->estado = 'procesada';
            $eva->save();
            unset($eva);
        }
        return redirect()->route('procesar_index');
    }

    /**
     * Ver las evaluaciones de todos los empleados separados por
     * departamento.
     * @return \Illuminate\Http\Response
     */
    public function ver_empleados()
    {

        $data['deps'] =  Departamento::all();

        return view('evaluar.todo_empleados',$data);

    }

    /**
     * Eliminar evaluaciones mal creadas
     * @param  Evaluacion $evaluacion
     * @return \Illuminate\Http\Response
     */
    public function eliminar(Evaluacion $evaluacion)
    {
        if(Auth::user()->nivel == 'th'){
            $evaluacion->delete();
        }
        return redirect()->route('procesar_index');
    }
}
