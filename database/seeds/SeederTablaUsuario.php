<?php

use Illuminate\Database\Seeder;
use sacep\User;

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
            'correo' => 'admin@sacep.stm',
            'clave'  => bcrypt('admin'),
            'nivel'  => 'admin',
        ];
        User::create($data);
    }
}
