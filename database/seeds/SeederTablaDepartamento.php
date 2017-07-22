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
        $data = [
            'nombre' => 'Coordinación de Talento Humano',
            'responsable' => rand(1,15),
        ];

        Departamento::create($data);
    }
}
