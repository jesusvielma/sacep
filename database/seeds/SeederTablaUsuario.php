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
            'password'  => bcrypt('admin'),
            'nivel'  => 'admin',
            'estado' => 1
        ];
        Usuario::create($data);
    }
}
