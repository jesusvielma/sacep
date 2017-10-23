<?php

namespace sacep\Policies;

use sacep\Usuario;
use sacep\Empleado;
use Illuminate\Auth\Access\HandlesAuthorization;
use sacep\Evaluacion;

/**
 * êrmisos para usar el modelo de Evaluacion
 */
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
    * @param \sacep\Evaluacion $evaluacion
    * @return bool
    */

    public function evaluar(Usuario $usuario,Evaluacion $evaluacion,Empleado $empleado)
    {
        // return ($usuario->empleado->id_departamento === $empleado->id_departamento ) ||
        // ($usuario->nivel == 'gerente' && ($empleado->usuario->nivel == 'coordinador' || $empleado->usuario->nivel == 'th')) ||
        // ($usuario->nivel == 'gerente' && ($empleado->departamento->departamento_padre == $usuario->empleado->id_departamento)) ||
        // ($usuario->nivel == 'coordinador' &&  $empleado->usuario->nivel == 'supervisor' || $empleado->usuario->nivel == 'jefe');
        if ($usuario->empleado->id_departamento === $empleado->id_departamento ) {
            return true;
        }
        elseif ($usuario->nivel == 'gerente') {
            if (isset($empleado->usuario->nivel)) {
                if ($empleado->usuario->nivel == 'coordinador' || $empleado->usuario->nivel == 'th') {
                    return true;
                }
                elseif($empleado->departamento->departamento_padre == $usuario->empleado->id_departamento && $empleado->usuario->nivel == 'supervisor'){
                    return true;
                }
            }
            elseif($empleado->departamento->departamento_padre == $usuario->empleado->id_departamento){
                return true;
            }
        }
        elseif ($usuario->nivel == 'coordinador') {
            if ($empleado->usuario->nivel == 'supervisor' || $empleado->usuario->nivel == 'jefe') {
                return true;
            }
        }
    }

    /**
    * Determina si el usuario actual puede ver las evaluaciones del empleado determinado.
    * @param \sacep\Usuario $usuario
    * @param \sacep\Evaluacion $evaluacion
    * @param \sacep\Empleado $empleado
    * @return bool
    */
    public function evaluaciones(Usuario $usuario,Evaluacion $evaluacion,Empleado $empleado)
    {
        return $usuario->empleado->id_departamento === $empleado->id_departamento || $usuario->nivel == 'th' || $usuario->nivel == 'gerente' || ($usuario->nivel == 'coordinador' && (isset($empleado->departamento->departamento_padre) && $empleado->departamento->departamento_padre == $usuario->empleado->id_departamento));
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
        return $usuario->nivel == 'gerente' || $usuario->nivel == 'th';
    }
}
