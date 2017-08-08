<?php

namespace sacep\Policies;

use sacep\Usuario;
use sacep\Empleado;
use Illuminate\Auth\Access\HandlesAuthorization;
use sacep\Evaluacion;

class EvaluacionPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
    * Determina si el usuario actual puede evaluar a empleado solicitado
    * @param \sacep\Usuario $usuario
    * @param \sacep\Empleado $empleado
    * @return bool
    */

    public function evaluar(Usuario $usuario,Empleado $empleado)
    {
        return $usuario->empleado->id_departamento === $empleado->id_departamento ;
    }

    /**
    * Determina si el usuario actual puede ver las evaluaciones del empleado determinado.
    * @param \sacep\Usuario $usuario
    * @param \sacep\Empleado $empleado
    * @return bool
    */

    public function evaluaciones(Usuario $usuario,Empleado $empleado)
    {
        return $usuario->empleado->id_departamento === $empleado->id_departamento || $usuario->nivel == 'th' || $usuario->nivel == 'gerente';
    }

    public function editar_eval(Usuario $usuario, Evaluacion $evaluacion)
    {
        foreach ($evaluacion->empleados as $empleado) {
            if ($usuario->empleado->cedula_empleado == $empleado->cedula_empleado && ($empleado->pivot->tipo == 'evaluador')) {
                return true;
            }
        }
    }
}
