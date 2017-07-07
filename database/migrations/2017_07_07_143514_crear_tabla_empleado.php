<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaEmpleado extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empleado', function (Blueprint $table) {
            $table->integer('cedula_empleado')->unique();
            $table->string('nombre_completo',150);
            $table->date('fecha_ingreso');
            $table->date('fecha_nacimiento');
            $table->enum('estado',['activo','inactivo']);
            $table->integer('id_usuario')->nullable();
            $table->integer('id_departamento');
            $table->foreign('id_usuario')->references('id_usuario')->on('usuario');
            $table->foreign('id_departamento')->references('id_departamento')->on('departamento');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('empleado');
    }
}
