<?php

namespace sacep\Http\Controllers;

use sacep\Cargo;
use Illuminate\Http\Request;

class CargoController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['cargos'] = Cargo::paginate(15);

        return view('cargo.index',$data);
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
            'nombre'    => 'required|unique:cargo,nombre'
        ]);

        Cargo::create($request->only('nombre'));

        $msg = [
            'type' => 'success',
            'msg' => 'La solicitud para crear el cargo '.$request->get('nombre').' ha sido procesada con éxito.',
            'title' => 'Se ha creado un nuevo cargo',
        ];

        return redirect()->route('cargos')->with('notif', $msg);
    }

    /**
     * Display the specified resource.
     *
     * @param  \sacep\Cargo  $cargo
     * @return \Illuminate\Http\Response
     */
    public function show(Cargo $cargo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \sacep\Cargo  $cargo
     * @return \Illuminate\Http\Response
     */
    public function edit(Cargo $cargo)
    {
        return $cargo->nombre;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \sacep\Cargo  $cargo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cargo $cargo)
    {
        $cargo->nombre = $request->get('nombre');
        $cargo->save();

        $msg = [
            'type' => 'success',
            'msg' => 'La solicitud para modificar el cargo '.$request->get('nombre').' ha sido procesada con éxito.',
            'title' => 'Se ha modificado un cargo',
        ];

        return redirect()->route('cargos')->with('notif', $msg);
    }
}
