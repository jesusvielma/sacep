<?php

namespace sacep\Policies;

use sacep\Usuario;
use sacep\Acta;
use Illuminate\Auth\Access\HandlesAuthorization;
use sacep\Empleado;

/**
 * Politica/ permisos para usuar el modelo de actasç
 * @author Jesus Vielma <jesusvielma309@gmail.com>
 */
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

    /**
     * El usuario puede lenvatar actas y llamados de atención
     * @param  Usuario  $usuario
     * @param  Acta     $acta
     * @param  Empleado $empleado
     * @return bool
     */
    public function levantar(Usuario $usuario,Acta $acta, Empleado $empleado)
    {
        if ($usuario->nivel == 'gerente') {
            return true;
        }else{
            if ($usuario->empleado->id_departamento == $empleado->id_departamento) {
                return true;
            }
            elseif ($usuario->nivel == 'coordinador' && ( isset($empleado->departamento->departamento_padre) && $empleado->departamento->departamento_padre == $usuario->empleado->id_departamento)) {
                return true;
            }
        }
    }
}
