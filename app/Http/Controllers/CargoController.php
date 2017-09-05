<?php

namespace sacep\Http\Controllers;

use sacep\Cargo;
use Illuminate\Http\Request;

/**
 * Controlador para el modulo de cargos
 * @author Jesus Vielma <jesusvielma309@gmail.com>
 */
class CargoController extends Controller
{

    /**
     * Muestra un listado de cargdos
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['cargos'] = Cargo::paginate(15);

        return view('cargo.index',$data);
    }

    /**
     * Almacena la información de nuevo cargo
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'nombre'    => 'required|unique:cargo,nombre'
        ]);

        $data = [
            'nombre'=> $request->get('nombre'),
            'estado'=> 1,
        ];

        Cargo::create($data);

        $msg = [
            'type' => 'success',
            'msg' => 'La solicitud para crear el cargo '.$request->get('nombre').' ha sido procesada con éxito.',
            'title' => 'Se ha creado un nuevo cargo',
        ];

        return redirect()->route('cargos')->with('notif', $msg);
    }

    /**
     * Envia mediante un arregla en formato json la información del
     * cargo solicitado.
     *
     * @param  \sacep\Cargo  $cargo
     * @return \Illuminate\Http\Response
     */
    public function edit(Cargo $cargo)
    {
        $data =[
            'nombre' => $cargo->nombre,
            'estado' => $cargo->estado
        ];
        return response()->json($data);
    }

    /**
     * Actualiza la información del cargo.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \sacep\Cargo  $cargo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cargo $cargo)
    {
        $cargo->nombre = $request->get('nombre');
        $cargo->estado = $request->get('estado');
        $cargo->save();

        $msg = [
            'type' => 'success',
            'msg' => 'La solicitud para modificar el cargo '.$request->get('nombre').' ha sido procesada con éxito.',
            'title' => 'Se ha modificado un cargo',
        ];

        return redirect()->route('cargos')->with('notif', $msg);
    }
}
