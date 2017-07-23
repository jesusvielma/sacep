<?php

use Illuminate\Database\Seeder;
use sacep\Departamento;

class SeederTablaDepartamento extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $empleado = sacep\Empleado::first();

        $data = [
            'nombre' => 'Coordinación de Talento Humano',
            'responsable' => $empleado->cedula_empleado,
        ];

        Departamento::create($data);
    }
}
