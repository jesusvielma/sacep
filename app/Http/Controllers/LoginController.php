<?php

namespace sacep\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function mostrarFormularioLogin()
    {
        return view('auth.login');
    }

    public function postLogin(Request $request)
    {
        $this->validate($request,[
            'correo' => 'required|email',
            'clave'  => 'required',
        ]);

        if (!Auth::attempt(['correo'=>$request->get('correo'),'password'=>$request->get('clave')])) {
            return redirect()->route('mostrar_login')->withInput($request->only(['correo']))
            ->withErrors('Las credenciasles no coinciden con las registradas en el sistema');
        }

        return redirect('/');
    }

    public function salir()
    {
        Auth::logout();
        return redirect('/');
    }
}
