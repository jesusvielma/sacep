<?php

namespace sacep\Policies;

use sacep\Usuario;
use sacep\Acta;
use Illuminate\Auth\Access\HandlesAuthorization;
use sacep\Empleado;

class ActaPolicy
{
    use HandlesAuthorization;

    /**
     * Empleado que puede editar la evaluación
     * @param  Usuario $usuario
     * @param  Acta    $acta
     * @return bool
     */
    public function editar_acta(Usuario $usuario,Acta $acta)
    {
        if ($usuario->nivel== 'gerente') {
            return true;
        }
        else{
            foreach ($acta->empleados as $empleado) {
                if ($empleado->pivot->tipo == 'sancionador' && $empleado->cedula_empleado == $usuario->empleado->cedula_empleado) {
                    return true;
                }
            }
        }
    }

    public function levantar(Usuario $usuario, Empleado $empleado)
    {
        if ($usuario->nivel == 'gerente') {
            return true;
        }else{
            if ($usuario->empleado->id_departamento == $empleado->id_departamento) {
                return true;
            }
        }
    }
}
