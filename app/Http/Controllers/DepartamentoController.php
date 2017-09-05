<?php

namespace sacep\Http\Controllers;

use Illuminate\Queue\RedisQueue;
use sacep\Empleado;
use sacep\Departamento;
use Illuminate\Http\Request;

/**
 * Controlador para el modulo de coordinación o unidades
 * @author Jesus Vielma <jesusvielma309@gmail.com>
 */
class DepartamentoController extends Controller
{
    /**
     * Muestra las coordinaciones y unidades
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['dptos'] = Departamento::all();

        return view('departamento.index',$data);
    }

    /**
     * Muestra el formulario para crear una coordinación o unidad
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //$data['empleados'] = Empleado::select(['nombre_completo','cedula_empleado'])->where('estado','activo')->get();
        $data['departamentos'] = Departamento::with(['empleados' => function ($query){
            $query->where('estado','activo');
        }])->get();
        $data['deps'] = Departamento::where('tipo','coordinacion')->get();

        return view('departamento.crear',$data);
    }

    /**
     * Guarda la información de una nueva coordinación o unidad
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'nombre' => 'required|max:60',
            'tipo'   => 'required'
        ]);

        if($request->get('tipo') == 'unidad')
            Departamento::create($request->only(['nombre','responsable','tipo','departamento_padre']));
        else
            Departamento::create($request->only(['nombre','responsable','tipo']));
        $msg = [
            'type' => 'success',
            'msg' => 'Se ha creado el departamento '.$request->get('nombre'),
            'title' => 'Accion exitosa',
        ];

        return redirect()->route('departamento.index')->with('notif', $msg);
    }

    /**
     * Display the specified resource.
     *
     * @param  \sacep\Departamento  $departamento
     * @return \Illuminate\Http\Response
     */
    public function show(Departamento $departamento)
    {
        //
    }

    /**
     * Muestra el formulario para editar una coordinación o unidad
     *
     * @param  \sacep\Departamento  $departamento
     * @return \Illuminate\Http\Response
     */
    public function edit($departamento)
    {
        $data['dep'] = Departamento::findOrFail($departamento);
        $data['empleados'] = Empleado::select(['nombre_completo','cedula_empleado'])->where('estado','activo')->get();
        $data['departamentos'] = Departamento::with(['empleados' => function ($query){
            $query->where('estado','activo');
        }])->get();
        $data['deps'] = Departamento::where('tipo','coordinacion')->get();

        return view('departamento.editar',$data);
    }

    /**
     * Actualizar la información de la coordinación o unidad
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \sacep\Departamento  $departamento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Departamento $departamento)
    {
        $this->validate($request,[
            'nombre' => 'required|max:60',
            'responsable' => 'required',
        ]);

        $departamento->fill($request->only(['nombre','responsable']));

        $departamento->save();

        $msg = [
            'type' => 'info',
            'msg' => 'Se ha editado el departamento '.$request->get('nombre'),
            'title' => 'Se ha editado el departamento',
        ];

        return redirect()->route('departamento.index')->with('notif', $msg);
    }

    /**
     * Borrar una coordinación o unidad
     *
     * @param  \sacep\Departamento  $departamento
     * @return \Illuminate\Http\Response
     */
    public function destroy(Departamento $departamento)
    {
        $dep = Departamento::find($departamento);
        //$nombre = $dep->nombre;
        $departamento->delete();

        $msg = [
            'type' => 'success',
            'msg' => 'Se ha eliminado el departamento ',
            'title' => 'Accion exitosa',
        ];

        return redirect()->route('departamento.index')->with('notif',$msg);
    }
}
