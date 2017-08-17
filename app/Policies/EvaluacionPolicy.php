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
        return ($usuario->empleado->id_departamento === $empleado->id_departamento ) || ($usuario->nivel == 'gerente' && $empleado->usuario->nivel == 'coordinador' || $empleado->usuario->nivel == 'th');
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


    /**
    * Determina si la evaluación puede ser editada por el usuario dado
    * @param \sacep\Usuario $usuario
    * @param \sacep\Evaluacion $evaluacion
    * @return bool
    */
    public function editar_eval(Usuario $usuario, Evaluacion $evaluacion)
    {
        if ($evaluacion->estado == 'guardada') {
            foreach ($evaluacion->empleados as $empleado) {
                if ($usuario->empleado->cedula_empleado == $empleado->cedula_empleado && ($empleado->pivot->tipo == 'evaluador')) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Determina si el usuario puede procesar las evaluaciones
     * @param  Usuario $usuario
     * @return bool
     */
    public function procesar(Usuario $usuario)
    {
        return $usuario->nivel == 'th';
    }

    /**
     * Determina si el usuario es gerente y puede ver las evaluaciones de los empleados
     * @param  Usuario $usuario
     * @return bool
     */
    public function gerente_ve_evaluaciones(Usuario $usuario)
    {
        return $usuario->nivel == 'gerente';
    }
}
