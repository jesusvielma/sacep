<?php

namespace sacep\Http\Controllers;

use Carbon\Carbon;
use sacep\Acta;
use sacep\Articulo;
use sacep\Empleado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;

class ActaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->nivel != 'gerente') {
            $data['empleados'] = Empleado::where('estado','activo')->where('id_departamento',Auth::user()->empleado->id_departamento)->get();
        }
        else{
            $data['empleados'] = Empleado::where('estado','activo')->get();
        }

        return view('acta.index',$data);
    }

    /**
     * Muestra el formulario para levantar un acta al empleado
     * @param  Empleado $empleado
     * @return \Illuminate\Http\Response
     */
    public function crear(Empleado $empleado)
    {
        $this->authorize('levantar',$empleado);
        $data['empleado'] = $empleado;
        $data['articulos'] = Articulo::all();
        $data['testigos'] = Empleado::where('estado','activo')->get();

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
            'articulo'  => 'required|min:1',
            'tipo'  => 'required',
            'lugar' => 'required',
            'testigo' => 'required'
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
        foreach ($request->get('articulo') as $articulo) {
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
		$pdf->loadView('acta.acta',$data);
		return $pdf->stream('acta_imprimir');

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
     * Show the form for editing the specified resource.
     *
     * @param  \sacep\Acta  $acta
     * @return \Illuminate\Http\Response
     */
    public function edit(Acta $acta)
    {
        $this->authorize('editar_acta',$acta);
        $data['acta'] = $acta;
        $data['articulos'] = Articulo::all();
        $data['testigos'] = Empleado::where('estado','activo')->get();

        foreach ($acta->empleados as $empleado) {
            if ($empleado->pivot->tipo == 'sancionado') {
                $data['empleado'] = $empleado;
            }
        }

        return view('acta.editar',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \sacep\Acta  $acta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Acta $acta)
    {
        $acta->descripcion = $request->get('descripcion');
        $acta->palabra_clave = $request->get('palabra_clave');
        $acta->lugar = $request->get('lugar');
        $acta->tipo = $request->get('tipo');
        $acta->save();

        $acta->articulos()->detach();

        foreach ($request->get('articulo') as $articulo) {
            $acta->articulos()->attach($articulo);
        }

        return redirect()->route('imprimir_acta',['id'=>$acta->id_acta]);
    }

    /**
     * [procesar_index description]
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
