<?php

namespace sacep\Http\Controllers;

use sacep\Articulo;
use Illuminate\Http\Request;

/**
 * Controlador para el modulo de artículos
 * @author Jesus Vielma <jesusvielma309@gmail.com>
 */
class ArticuloController extends Controller
{
    /**
     * Muestra un listado de todos los recursos del modelo
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['articulos'] = Articulo::all();

        return view('articulo.index',$data);
    }

    /**
     * Muestra el formulario para crear un articulo, literal o párrafo
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['articulos'] = Articulo::all();
        return view('articulo.crear',$data);
    }

    /**
     * Guarda la información de un nuevo articulo, literal o párrafo
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'identificador' => 'required|string',
            'contenido'     => 'required',
            'ley'           => 'required|max:255',
            'tipo'          => 'required'
        ]);

        Articulo::create($request->except(['_token','files']));

        return redirect()->route('articulos');
    }

    /**
     * Muestra el formulario para editar el recurso
     *
     * @param  \sacep\Articulo  $articulo
     * @return \Illuminate\Http\Response
     */
    public function edit(Articulo $articulo)
    {
        $data['articulo'] = $articulo;
        $data['articulos'] = Articulo::all();

        return view('articulo.editar',$data);
    }

    /**
     * Actualiza la información del recurso
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \sacep\Articulo  $articulo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Articulo $articulo)
    {
        $this->validate($request,[
            'identificador' => 'required|string',
            'contenido'     => 'required',
            'ley'           => 'required|max:255',
            'tipo'          => 'required'
        ]);

        $articulo->identificador = $request->get('identificador');
        $articulo->contenido = $request->get('contenido');
        $articulo->ley = $request->get('ley');
        $articulo->tipo = $request->get('tipo');
        $articulo->padre = $request->get('padre');

        $articulo->save();
        return redirect()->route('articulos');
    }
}
