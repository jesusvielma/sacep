<?php

namespace sacep\Http\Controllers;

use sacep\Cargo;
use sacep\Empleado;
use Illuminate\Http\Request;
use sacep\Departamento;

/**
 * Controlador para el modulo de Empleados
 * @author Jesus Vielma <jesusvielma309@gmail.com>
 */
class EmpleadoController extends Controller
{
    /**
     * Muestro todos los empleados.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['empleados'] = Empleado::with(['cargo','departamento'])->get();

        return view('empleado.index',$data);
    }

    /**
     * Muestra un formulario para ingresar un nuevo empleado
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['cargos'] = Cargo::where('estado','=',1)->select('nombre','id_cargo')->get();
        $data['deps']  = Departamento::all(['nombre','id_departamento']);

        return view('empleado.crear',$data);
    }

    /**
     * Guarda la información del nuevo empleado
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'nombre_completo' => 'required',
            'cedula_empleado' => 'required|unique:empleado,cedula_empleado',
            'fecha_ingreso'   => 'required',
            'fecha_nacimiento'   => 'required',
            'id_cargo'        => 'required',
            'id_departamento' => 'required'
        ]);

        Empleado::create($request->except('_token'));
        $msg = [
            'type' => 'success',
            'msg' => 'El registro del trabajador '.$request->get('nombre_completo').' se ha completado, le recordamos que se debe proceder a entregar los materiales para el desempeño de sus funciones.',
            'title' => 'Se ha registro el nuevo empleado',
        ];

        return redirect()->route('empleados')->with('notif', $msg);
    }

    /**
     * Display the specified resource.
     *
     * @param  \sacep\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function show(Empleado $empleado)
    {
        //
    }

    /**
     * Muestra el formulario para editar la información de un empleado
     *
     * @param  \sacep\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function edit(Empleado $empleado)
    {
        $data['empleado'] = $empleado;
        $data['cargos'] = Cargo::where('estado','=',1)->select('nombre','id_cargo')->get();
        $data['deps']  = Departamento::all(['nombre','id_departamento']);

        return view('empleado.editar',$data);
    }

    /**
     * Actualizar la información de un empleado
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \sacep\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Empleado $empleado)
    {
        $this->validate($request,[
            'nombre_completo' => 'required',
            'cedula_empleado' => 'required',
            'fecha_ingreso'   => 'required',
            'fecha_nacimiento'   => 'required',
            'id_cargo'        => 'required',
            'id_departamento' => 'required'
        ]);

        $empleado->nombre_completo = $request->get('nombre_completo');
        $empleado->cedula_empleado = $request->get('cedula_empleado');
        $empleado->fecha_ingreso = $request->get('fecha_ingreso');
        $empleado->fecha_nacimiento = $request->get('fecha_nacimiento');
        $empleado->id_departamento = $request->get('id_departamento');
        $empleado->id_cargo = $request->get('id_cargo');
        $empleado->save();

        $msg = [
            'type' => 'success',
            'msg' => 'El registro del trabajador '.$request->get('nombre_completo').' se ha modicado con éxito.',
            'title' => 'Se ha modificado el registro del empleado',
        ];

        return redirect()->route('empleados')->with('notif', $msg);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \sacep\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function destroy(Empleado $empleado)
    {
        //
    }
}
