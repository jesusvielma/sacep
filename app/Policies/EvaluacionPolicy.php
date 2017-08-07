<?php

namespace sacep\Policies;

use sacep\Usuario;
use sacep\Empleado;
use Illuminate\Auth\Access\HandlesAuthorization;

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
        return $usuario->empleado->id_departamento === $empleado->id_departamento;
    }
}
