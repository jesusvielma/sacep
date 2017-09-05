<?php

namespace sacep\Http\Controllers;

use Carbon\Carbon;
use FontLib\Table\Type\name;
use sacep\Acta;
use sacep\Empleado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

/**
 * Controlador para el modulo de llamado de atención
 * @author Jesus Vielma <jesusvielma309@gmail.com>
 */
class LlamadoController extends Controller
{
    /**
     * Muestra el formulario para levantar un acta al empleado
     * @param  Empleado $empleado
     * @return \Illuminate\Http\Response
     */
    public function crear(Empleado $empleado)
    {
        $acta = new Acta;
        $this->authorize('levantar',[$acta,$empleado]);
        $data['empleado'] = $empleado;

        return view('llamado.crear',$data);
    }

    /**
     * Guarda la información de un llamado de atención
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'descripcion' => 'required|string|max:500',
        ]);

        $llamado = new Acta;

        date_default_timezone_set('America/Caracas');
		setlocale(LC_ALL,'es_VE.UTF-8','es_VE','Windows-1252','esp','es_ES.UTF-8','es_ES');
        $llamado->descripcion = $request->get('descripcion');
        $llamado->fecha = Carbon::now()->toDateTimeString();
        $llamado->lugar = Auth::user()->empleado->departamento->nombre;
        $llamado->palabra_clave = 'llamado';
        $llamado->tipo = 'llamado';
        $llamado->estado = 'guardada';

        $llamado->save();

        $llamado->empleados()->attach([
            $request->get('sancionado') => ['tipo'=> 'sancionado'],
            $request->get('sancionador') => ['tipo'=> 'sancionador'],
        ]);

        return redirect()->route('imprimir_llamado',['id'=>$llamado->id_acta]);
    }

    /**
     * Muestra el PDF de un llamado de atención
     *
     * @param  \sacep\Acta  $llamado
     * @return \Illuminate\Http\Response
     */
    public function imprimir_llamado(Acta $llamado)
    {
        date_default_timezone_set('America/Caracas');
		setlocale(LC_ALL,'es_VE.UTF-8','es_VE','Windows-1252','esp','es_ES.UTF-8','es_ES');
        $data['llamado'] = $llamado;
        foreach ($llamado->empleados as $empleado) {
            if ($empleado->pivot->tipo == 'sancionado') {
                $data['sancionado'] = $empleado;
            }
            else{
                $data['sancionador'] = $empleado;
            }
        }
        $pdf = App::make('dompdf.wrapper');
		$pdf->loadView('llamado.llamado',$data);
		return $pdf->stream('SACEP-Llamado-de-atencion-de-'.str_replace(' ','-',$data['sancionado']->nombre_completo).'.pdf');

    }

    /**
     * Ver llamados de atención de un empleado
     * @param  Empleado $empleado
     * @return \Illuminate\Http\Response
     */
    public function ver(Empleado $empleado)
    {
        $data['empleado'] = $empleado;
        date_default_timezone_set('America/Caracas');
		setlocale(LC_ALL,'es_VE.UTF-8','es_VE','Windows-1252','esp','es_ES.UTF-8','es_ES');
        return view('llamado.llamados_empleado',$data);
    }

    /**
     * Muestra el formulario para editar un llamado de atención.
     *
     * @param  \sacep\Acta  $llamado
     * @return \Illuminate\Http\Response
     */
    public function edit(Acta $llamado)
    {
        $this->authorize('editar_acta',$llamado);
        $data['llamado'] = $llamado;

        foreach ($llamado->empleados as $empleado) {
            if ($empleado->pivot->tipo == 'sancionado') {
                $data['empleado'] = $empleado;
            }
        }

        return view('llamado.editar',$data);
    }

    /**
     * Actualiza la información de un llamado de atención
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \sacep\Acta  $llamado
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Acta $llamado)
    {
        $this->validate($request,[
            'descripcion'=> 'required|string|max:500'
        ]);

        $llamado->descripcion = $request->get('descripcion');
        $llamado->save();

        return redirect()->route('imprimir_llamado',['id'=>$llamado->id_acta]);
    }
}
