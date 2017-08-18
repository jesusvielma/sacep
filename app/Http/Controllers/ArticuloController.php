<?php

namespace sacep\Http\Controllers;

use sacep\Articulo;
use Illuminate\Http\Request;

class ArticuloController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['articulos'] = Articulo::all();

        return view('articulo.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('articulo.crear');
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
            'identificador' => 'required|string',
            'contenido'     => 'required',
            'ley'           => 'required|alpha_num|max:255',
            'tipo'          => 'required'
        ]);

        Articulo::create($request->except(['_token','files']));

        return redirect()->route('articulos');
    }

    /**
     * Display the specified resource.
     *
     * @param  \sacep\Articulo  $articulo
     * @return \Illuminate\Http\Response
     */
    public function show(Articulo $articulo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \sacep\Articulo  $articulo
     * @return \Illuminate\Http\Response
     */
    public function edit(Articulo $articulo)
    {
        $data['articulo'] = $articulo;

        return view('articulo.editar',$data);
    }

    /**
     * Update the specified resource in storage.
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
            'ley'           => 'required|alpha_num|max:255',
            'tipo'          => 'required'
        ]);

        $articulo->identificador = $request->get('identificador');
        $articulo->contenido = $request->get('contenido');
        $articulo->ley = $request->get('ley');
        $articulo->tipo = $request->get('tipo');

        $articulo->save();
        return redirect()->route('articulos');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \sacep\Articulo  $articulo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Articulo $articulo)
    {
        //
    }
}
