<?php

namespace sacep\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use sacep\Acta;
use sacep\Articulo;
use sacep\Empleado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use sacep\Departamento;
/**
 * Controllador para actas
 * @author Jesus Vielma <jesusvielma309@gmail.com>
 */
class ActaController extends Controller
{
    /**
     * Muestra un listado de todas las actas segun el usuario autenticado
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dep2 = Departamento::find(Auth::user()->empleado->id_departamento);
        if (Auth::user()->nivel != 'gerente') {
            $data['empleados'] = Empleado::where('estado','activo')->where('id_departamento',Auth::user()->empleado->id_departamento)->where('cedula_empleado','!=',Auth::user()->empleado->cedula_empleado)->get();
            if (Auth::user()->nivel == 'gerente' || Auth::user()->nivel == 'coordinador' ) {
                if ($dep2->hijo->count()) {
                    $data['cant_hijos'] = $dep2->hijo->count();
                    $data1= [];
                    $data2 = [];
                    $empl_consulta = [];
                    foreach ($dep2->hijo as $key => $hijo1) {
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
                    $data['empl_consulta'] = $empl_consulta;
                }
                else {
                    $data['cant_hijos'] = $dep2->hijo->count();
                }
            }
            else{
                $data['cant_hijos'] = $dep2->hijo->count();
            }
        }
        else{
            $data['empleados'] = Empleado::where('estado','activo')->where('cedula_empleado','!=',Auth::user()->empleado->cedula_empleado)->get();
            $data['cant_hijos'] = 0;
        }

        return view('acta.index',$data);
    }

    /**
     * Muestra el formulario para levantar un acta al empleado
     *
     * @param  Empleado $empleado
     * @return \Illuminate\Http\Response
     */
    public function crear(Empleado $empleado)
    {
        $acta = new Acta;
        $this->authorize('levantar',[$acta,$empleado]);
        $data['empleado'] = $empleado;
        $data['articulos'] = Articulo::orderBy('identificador','ASC')->get();
        //$data['testigos'] = Empleado::where('estado','activo')->get();
        $data['deps'] = Departamento::with(['empleados'=>function ($query){
            $query->where('estado','activo');
        }])->get();

        return view('acta.crear',$data);
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
            'descripcion' => 'required|string|max:255',
            'palabra_clave' => 'required',
            'articulo'  => 'required',
            'lp'    => 'required|array|min:1',
            'tipo'  => 'required',
            'lugar' => 'required',
            'testigo' => 'required|array|min:2'
        ], [
            'lp.min' => 'Debes seleccionar al menos un literal o párrafo',
            'testigo.min'=> 'Debes seleccionar dos (2) testigos'
        ]);

        $sancion = new Acta;

        date_default_timezone_set('America/Caracas');
		setlocale(LC_ALL,'es_VE.UTF-8','es_VE','Windows-1252','esp','es_ES.UTF-8','es_ES');
        $sancion->descripcion = $request->get('descripcion');
        $sancion->palabra_clave = $request->get('palabra_clave');
        $sancion->lugar = $request->get('lugar');
        $sancion->fecha = Carbon::now()->toDateTimeString();
        $sancion->tipo = $request->get('tipo');
        $sancion->estado = 'guardada';

        $sancion->save();
        $sancion->articulos()->attach($request->get('articulo'));
        foreach ($request->get('lp') as $articulo) {
            $sancion->articulos()->attach($articulo);
        }

        $testigo_count = 1;
        foreach ($request->get('testigo') as $testigo) {
            if ($testigo_count<3) {
                $sancion->empleados()->attach([$testigo => ['tipo'=>'testigo'.$testigo_count]]);
                $testigo_count++;
            }
        }

        $sancion->empleados()->attach([$request->get('sancionado') => ['tipo'=> 'sancionado']]);
        $sancion->empleados()->attach([$request->get('sancionador') => ['tipo'=> 'sancionador']]);

        return redirect()->route('imprimir_acta',['id'=>$sancion->id_acta]);
    }

    /**
     * PDF
     *
     * @param  \sacep\Acta  $acta
     * @return \Illuminate\Http\Response
     */
    public function imprimir_acta(Acta $acta)
    {
        date_default_timezone_set('America/Caracas');
		setlocale(LC_ALL,'es_VE.UTF-8','es_VE','Windows-1252','esp','es_ES.UTF-8','es_ES');
        $data['acta'] = $acta;
        foreach ($acta->empleados as $empleado) {
            if ($empleado->pivot->tipo == 'sancionado') {
                $data['sancionado'] = $empleado;
            }
            elseif ($empleado->pivot->tipo == 'sancionador') {
                $data['sancionador'] = $empleado;
            }
            elseif ($empleado->pivot->tipo == 'testigo1') {
                $data['testigo1'] = $empleado;
            }
            else{
                $data['testigo2'] = $empleado;
            }
        }
        foreach ($acta->articulos as $articulo) {
            if ($articulo->tipo == 'articulo') {
                $data['articulo'] = $articulo;
            }
        }
        $pdf = App::make('dompdf.wrapper');
        $nombre = $acta->fecha->format('Y-m-d').'-'.$acta->tipo.'-de-'.$data['sancionado']->cedula_empleado.'.pdf';
        Storage::makeDirectory('public/actas/'.date('Ym'));
		$pdf->loadView('acta.acta2',$data)->save(storage_path().'/app/public/actas/'.date('Ym').'/'.$nombre);
		//return $pdf->stream('SACEP-Acta-de-'.$acta->tipo.'-de-'.str_replace(' ','-',$data['sancionado']->nombre_completo).'.pdf');
        $msg = [
            'type' => 'success',
            'msg' => 'Se ha guardado el acta de '.$data['sancionado']->nombre_completo.', puede acceder a ella haciendo click sobre esta notificación o haciendo clic en el botón para ver la evaluaciones de '.$data['sancionado']->nombre_completo.' en el listado de trabajadores o puede esperar un minuto y automáticamente se abrirá la evaluación para imprimir. (Nota: esta notificación desaparece luego de un minuto)',
            'title' => 'Acta guardada',
            'url' => 'actas/'.date('Ym').'/'.$nombre,
        ];

        return redirect()->route('actas')->with('notif', $msg);

    }

    /**
     * Ver actas de un empleado
     * @param  Empleado $empleado
     * @return \Illuminate\Http\Response
     */
    public function ver(Empleado $empleado)
    {
        $data['empleado'] = $empleado;

        return view('acta.actas_empleado',$data);
    }

    /**
     * Muestra el formulario para editar un acta
     *
     * @param  \sacep\Acta  $acta
     * @return \Illuminate\Http\Response
     */
    public function edit(Acta $acta)
    {
        $this->authorize('editar_acta',$acta);
        $data['acta'] = $acta;
        $data['articulos'] = Articulo::orderBy('identificador','ASC')->get();
        $data['testigos'] = Empleado::where('estado','activo')->get();

        foreach ($acta->empleados as $empleado) {
            if ($empleado->pivot->tipo == 'sancionado') {
                $data['empleado'] = $empleado;
            }
        }

        return view('acta.editar',$data);
    }

    /**
     * Actualiza la información del acta
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \sacep\Acta  $acta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Acta $acta)
    {

        $this->validate($request,[
            'descripcion' => 'required|string|max:255',
            'palabra_clave' => 'required',
            'articulo'  => 'required',
            'lp'    => 'required|min:1',
            'tipo'  => 'required',
            'lugar' => 'required',
        ]);

        $acta->descripcion = $request->get('descripcion');
        $acta->palabra_clave = $request->get('palabra_clave');
        $acta->lugar = $request->get('lugar');
        $acta->tipo = $request->get('tipo');
        $acta->save();

        $acta->articulos()->detach();
        $acta->articulos()->attach($request->get('articulo'));
        foreach ($request->get('lp') as $articulo) {
            $acta->articulos()->attach($articulo);
        }

        return redirect()->route('imprimir_acta',['id'=>$acta->id_acta]);
    }

    /**
     * Muestra el listado de actas por empleado para ser procesadas
     * @return [type] [description]
     */
    public function procesar_index()
    {
        $data['actas'] = Acta::where('estado','guardada')->with(['empleados' => function($query){
            $query->where('empleado_sancion.tipo','=','sancionado')->orWhere('empleado_sancion.tipo','=','sancionador');
        }])->get();

        return view('acta.procesar_index',$data);
    }

    /**
     * Cambia el estado de un acta
     *
     * @param Acta $acta
     * @return \Illuminate\Http\Response
     */
    public function procesar_una(Acta $acta)
    {
        $acta->estado = 'procesada';
        $acta->save();

        return redirect()->route('procesar_actas');
    }

    /**
     * Cambia el estado de varias actas
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function procesar_varias(Request $request)
    {
        $eva = '';
        foreach ($request->get('id_evaluacion') as $act) {
            $acta = Acta::find($act);
            $acta->estado = 'procesada';
            $acta->save();
            unset($acta);
        }
        return redirect()->route('procesar_actas');
    }
}
