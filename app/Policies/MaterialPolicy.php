<?php

namespace sacep\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use sacep\Usuario;

class MaterialPolicy
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

    public function material(Usuario $usuario)
    {
        return isset($usuario->empleado->departamento->entrega_material) && $usuario->empleado->departamento->entrega_material == 1;
    }
}
