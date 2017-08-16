<?php

namespace sacep\Http\Controllers;

use sacep\Usuario;
use sacep\Empleado;
use sacep\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use sacep\Departamento;

class MaterialController extends Controller
{
    /**
     * Muestra un listado de los materiales para el departamento del Usuario
     * actual
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dep_usuario = Auth::user()->empleado->id_departamento;
        $data['materiales'] = Material::where('id_departamento',$dep_usuario)->get();

        return view('material.index',$data);
    }

    /**
     * Crear un nuevo material
     * @param  Departamento $departamento
     * @return \Illuminate\Http\Response
     */
    public function create(Departamento $departamento)
    {
        $data['departamento'] = $departamento;
        return view('material.crear',$data);
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
            'nombre' => 'required|string',
            'codigo_material' => 'nullable',
            'cantidad' => 'required|numeric',
        ]);

        Material::create($request->only(['nombre','codigo_material','cantidad','id_departamento']));

        $msg = [
            'type' => 'success',
            'msg' => 'Se ha registrado el nuevo material',
            'title' => 'Material creado',
        ];

        return redirect()->route('materiales')->with('notif', $msg);
    }

    /**
     * Display the specified resource.
     *
     * @param  \sacep\Material  $material
     * @return \Illuminate\Http\Response
     */
    public function show(Material $material)
    {
        $this->authorize('material',Departamento::class);
        $data['material'] = $material;

        return view('material.mostrar',$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \sacep\Material  $material
     * @return \Illuminate\Http\Response
     */
    public function edit(Material $material)
    {
        $data['material'] = $material;

        return view('material.editar',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \sacep\Material  $material
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Material $material)
    {
        $this->validate($request,[
            'nombre' => 'required|string',
            'codigo_material' => 'nullable',
            'cantidad' => 'required|numeric',
        ]);

        $material->nombre = $request->get('nombre');
        if ($request->get('codigo_material') !== NULL ) {
            $material->codigo_material = $request->get('codigo_material');
        }
        $material->cantidad = $request->get('cantidad');
        $material->save();

        $msg = [
            'type' => 'success',
            'msg' => 'Se ha modicado el material '.$material->nombre,
            'title' => 'Material modifcado',
        ];

        return redirect()->route('materiales')->with('notif', $msg);
    }

    /**
     * Muestra el fomulario para entregar materiales a un empleado
     * @param  Empleado $empleado
     * @return \Illuminate\Http\Response
     */
    public function entregar_material()
    {

    }
}
