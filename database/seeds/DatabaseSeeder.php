<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(SeederTablaUsuario::class);
        $this->call(SeederTablaEmpleado::class);
    }
}
