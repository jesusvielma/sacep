<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaMaterialAsignadoEmpleado extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('material_asignado_empleado', function (Blueprint $table) {
            $table->integer('cedula_empleado');
            $table->integer('id_material')->unsigned();
            $table->dateTime('fecha');
            $table->enum('tipo',['entregado','devuelto']);
            $table->primary(['cedula_empleado','id_material']);
            $table->foreign('cedula_empleado')->references('cedula_empleado')->on('empleado')
            ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('id_material')->references('id_material')->on('material')
            ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('material_asignado_empleado');
    }
}
