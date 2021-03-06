<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaHistorialCargoEmpleado extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historial_cargo_empleado', function (Blueprint $table) {
            $table->integer('cedula_empleado');
            $table->integer('id_cargo')->unsigned();
            $table->date('desde');
            $table->date('hasta');
            $table->primary(['cedula_empleado','id_cargo']);
            $table->foreign('cedula_empleado')->references('cedula_empleado')->on('empleado')
            ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_cargo')->references('id_cargo')->on('cargo')
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
        Schema::dropIfExists('historial_cargo_empleado');
    }
}
