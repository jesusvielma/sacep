<?php

namespace sacep\Http\Controllers;

use sacep\Usuario;
use Illuminate\Http\Request;
use sacep\Empleado;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['usuarios'] = Usuario::with('empleado')->paginate(15);

        return view('usuario.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['empleados'] = Empleado::where('id_usuario',NULL)->where('estado','activo')->get();

        return view('usuario.crear',$data);
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
            'correo' => 'required|email',
            'nivel'  => 'required',
            'clave'  => 'required'
        ]);

        $data = new Usuario;

        $data->nombre = $request->get('nombre');
        $data->correo = $request->get('correo');
        $data->nivel = $request->get('nivel');
        $data->clave = bcrypt($request->get('clave'));

        $data->save();

        $id = $data->id_usuario;

        $empleado = Empleado::find($request->get('cedula_empleado'));
        $empleado->id_usuario = $id;
        $empleado->save();

        $msg = [
            'type' => 'success',
            'msg' => 'Se ha registrado un usuario con el nombre '.$request->get('nombre').' y permisos de '.$request->get('nivel'),
            'title' => 'Usuario registrado',
        ];

        return redirect()->route('usuarios')->with('notif', $msg);

    }

    /**
     * Display the specified resource.
     *
     * @param  \sacep\Usuario  $usuario
     * @return \Illuminate\Http\Response
     */
    public function show(Usuario $usuario)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \sacep\Usuario  $usuario
     * @return \Illuminate\Http\Response
     */
    public function edit(Usuario $usuario)
    {
        $data['usuario'] = $usuario;
        $data['empleados'] = Empleado::where('id_usuario',NULL)->where('estado','activo')->get();

        return view('usuario.editar',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \sacep\Usuario  $usuario
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Usuario $usuario)
    {
        $this->validate($request,[
            'nombre' => 'required|string',
            'correo' => 'required|email',
            'nivel'  => 'required',
            'clave'  => 'min:7|nullable'
        ]);

        $usuario->nombre = $request->get('nombre');
        $usuario->correo = $request->get('correo');
        $usuario->nivel = $request->get('nivel');
        if ($request->get('clave') != '') {
            $usuario->clave = bcrypt($request->get('clave'));
        }

        $usuario->save();

        $msg = [
            'type' => 'success',
            'msg' => 'Se ha registrado un usuario con el nombre '.$request->get('nombre'),
            'title' => 'Usuario modificado',
        ];

        return redirect()->route('usuarios')->with('notif', $msg);

    }
}
