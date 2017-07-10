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
            'nombre' => 'admin',
            'correo' => 'admin@sacep.app',
            'clave'  => bcrypt('admin'),
            'nivel'  => 'admin',
        ];
        Usuario::create($data);
    }
}
