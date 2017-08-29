<?php

namespace sacep\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use sacep\Usuario;
use sacep\Empleado;
use sacep\Departamento;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['usuarios'] = Usuario::where('nivel','!=','admin')->with('empleado')->paginate(15);

        return view('usuario.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['empleados'] = Departamento::with(['empleados'=> function($query){
            $query->where('estado','activo');
        }])->get();

        $data['gerente'] = Usuario::where('nivel','gerente')->where('estado',1)->first();
        $data['th'] = Usuario::where('nivel','th')->where('estado',1)->first();

        //dd($data['empleados'][0]);
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
        $data->password = bcrypt($request->get('clave'));
        $data->estado = 1;

        $data->save();

        $id = $data->id_usuario;

        $empleado = Empleado::find($request->get('cedula_empleado'));
        $empleado->id_usuario = $id;
        $empleado->save();



        $msg = [
            'type' => 'success',
            'msg' => 'Se ha modificado el usuario con el nombre '.$request->get('nombre').' y permisos de '.trans('enums.usuario'.$request->get('nivel')),
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
            'clave'  => 'min:7|nullable',
        ]);

        $usuario->nombre = $request->get('nombre');
        $usuario->correo = $request->get('correo');
        $usuario->nivel = $request->get('nivel');
        if ($request->get('clave') != '') {
            $usuario->password = bcrypt($request->get('clave'));
        }
        $usuario->estado = $request->get('estado');
        $usuario->save();


        if ($request->get('perfil') !== NULL && $request->get('perfil') == 1) {
            $msg = [
                'type' => 'success',
                'msg' => $request->get('nombre').' hemos modifcado su usuario con exito.',
                'title' => 'Usuario modificado',
            ];
            return redirect()->route('perfil')->with('notif', $msg);
        }

        $msg = [
            'type' => 'success',
            'msg' => 'Se ha modificado el usuario con el nombre '.$request->get('nombre'),
            'title' => 'Usuario modificado',
        ];
        return redirect()->route('usuarios')->with('notif', $msg);

    }

    /**
     * Muestra el perfil de usuario
     *
     * @return \Illuminate\Http\Response
     */
    public function perfil()
    {
        date_default_timezone_set('America/Caracas');
		setlocale(LC_ALL,'es_VE.UTF-8','es_VE','Windows-1252','esp','es_ES.UTF-8','es_ES');
        $data['usuario'] = Auth::user();

        return view('usuario.perfil',$data);
    }

    /**
     * Cambiar foto de perfil de usuario
     * @param  Request $request
     * @param  Usuario $usuario
     * @return \Illuminate\Http\Response
     */
    public function avatar(Request $request, Usuario $usuario)
    {

        $this->validate($request,[
            'avatar' => 'required|mimes:jpeg,png,jpg|max:1000'
        ]);

        $file = $request->file('avatar');
        $avatar_name = Auth::id().'-'.date('Y-m-d').'.'.$file->getClientOriginalExtension();
        $file->storeAs('public/avatar',$avatar_name);
        //$save = $file->storeAs('img/avatar');
        $usuario->avatar = $avatar_name;
        $usuario->save();

        $msg = [
            'type' => 'success',
            'msg' => 'Felicidades, '.$usuario->nombre.' has modificado tu foto de perfil.',
            'title' => 'Foto actualizada',
        ];
        return redirect()->route('perfil')->with('notif', $msg);
    }
}
