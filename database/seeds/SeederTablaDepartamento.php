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
        $dep = new Departamento;
        $dep->nombre = 'Coordinación de Talento Humano';
        $dep->tipo   = 'coordinacion';
        $dep->save();

        $dep->empleados()->saveMany(factory(sacep\Empleado::class,10)->make());

        unset($dep);

        $dep = new Departamento;
        $dep->nombre = 'Coordinación Gestión tecnologica';
        $dep->tipo   = 'coordinacion';
        $dep->save();

        $dep->empleados()->saveMany(factory(sacep\Empleado::class,15)->make());

        unset($dep);

        $dep = new Departamento;
        $dep->nombre = 'Coordinación Gestión Administrativa';
        $dep->tipo   = 'coordinacion';
        $dep->save();

        $dep->empleados()->saveMany(factory(sacep\Empleado::class,5)->make());

        unset($dep);

        $dep = new Departamento;
        $dep->nombre = 'Gerencia STM';
        $dep->tipo   = 'coordinacion';
        $dep->save();
    }
}
