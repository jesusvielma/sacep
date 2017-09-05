<?php

namespace sacep\Http\Controllers;

/**
 * Controlador para manejar el inicio del sistema
 */
class InicioController extends Controller
{
    /**
     * Muestra la pagina de inicio del sistema
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home.index');
    }
}
