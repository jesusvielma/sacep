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
            $table->primary('cedula_empleado');
            $table->integer('id_usuario')->nullable()->unsigned();
            $table->foreign('id_usuario')
                    ->references('id_usuario')->on('usuario')
                    ->onDelete('cascade')->onUpdate('cascade');
            $table->integer('id_cargo')->nullable()->unsigned();
            $table->foreign('id_cargo')
                    ->references('id_cargo')->on('cargo')
                    ->onDelete('cascade')->onUpdate('cascade');
            $table->integer('id_departamento')->nullable()->unsigned();
            $table->foreign('id_departamento')
                    ->references('id_departamento')->on('departamento')
                    ->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('empleado');
    }
}
