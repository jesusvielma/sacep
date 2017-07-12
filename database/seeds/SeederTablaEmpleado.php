<?php

use Illuminate\Database\Seeder;

class SeederTablaEmpleado extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(sacep\Empleado::class)->create([
            'cedula_empleado' => 21183652,
            'nombre_completo' => 'Joeinny Osorio',
            'fecha_ingreso'   => '2016-01-01',
            'fecha_nacimiento'=> '1992-02-06',
            'estado'          => 'activo',
            'id_usuario'      => 1
        ]);

        factory(sacep\Empleado::class,15)->create();
    }

}
