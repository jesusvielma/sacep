<?php

namespace sacep\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Controlador para el login y sesión del sistema
 */
class LoginController extends Controller
{
    /**
     * Muestra el formulario de inicio de sesión
     *
     * @return \Illuminate\Http\Response
     */
    public function mostrarFormularioLogin()
    {
        return view('auth.login');
    }

    /**
     * Hace el logueo del usuario
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function postLogin(Request $request)
    {
        $this->validate($request,[
            'correo' => 'required|email',
            'clave'  => 'required',
        ]);

        if (!Auth::attempt(['correo'=>$request->get('correo'),'password'=>$request->get('clave'),'estado'=>'1'])) {
            return redirect()->route('mostrar_login')->withInput($request->only(['correo','clave']))
            ->withErrors('Las credenciasles no coinciden con las registradas en el sistema');
        }

        return redirect()->intended('/');

        // $pass = \Hash::make($request->get("clave"));
        // echo $pass;
        // echo "$2y$10$97OPGIFfYICD8YZ.Eko9xOvJ1u6PKWv46SR1UBp.v/3fU7gblJywy";
    }

    /**
     * Hace el logout del sistema
     * @return \Illuminate\Http\Response
     */
    public function salir()
    {
        Auth::logout();
        return redirect('/');
    }
}
