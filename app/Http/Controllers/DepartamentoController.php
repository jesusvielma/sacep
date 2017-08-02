<?php

namespace sacep\Http\Controllers;

use Illuminate\Queue\RedisQueue;
use sacep\Empleado;
use sacep\Departamento;
use Illuminate\Http\Request;

class DepartamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['dptos'] = Departamento::all();

        return view('departamento.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['empleados'] = Empleado::select(['nombre_completo','cedula_empleado'])->where('estado','activo')->get();

        return view('departamento.crear',$data);
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
            'nombre' => 'required|max:60',
        ]);

        Departamento::create($request->only(['nombre','responsable']));
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
     * Show the form for editing the specified resource.
     *
     * @param  \sacep\Departamento  $departamento
     * @return \Illuminate\Http\Response
     */
    public function edit($departamento)
    {
        $data['dep'] = Departamento::findOrFail($departamento);
        $data['empleados'] = Empleado::select(['nombre_completo','cedula_empleado'])->where('estado','activo')->get();

        return view('departamento.editar',$data);
    }

    /**
     * Update the specified resource in storage.
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
     * Remove the specified resource from storage.
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
