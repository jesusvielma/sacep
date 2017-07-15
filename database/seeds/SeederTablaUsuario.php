<?php

use Illuminate\Database\Seeder;
use sacep\Usuario;

class SeederTablaUsuario extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $data = [
            'nombre' => 'Administrador del sistema',
            'correo' => 'admin@sacep.app',
            'clave'  => bcrypt('admin'),
            'nivel'  => 'th',
        ];
        Usuario::create($data);
    }
}
