<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaEmpleadoSancion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empleado_sancion', function (Blueprint $table) {
            $table->integer('cedula_empleado');
            $table->smallInteger('id_acta')->unsigned();
            $table->enum('tipo',['sancionado','sancionador','testigo1','testigo2']);
            $table->primary(['cedula_empleado','id_acta','tipo']);
            $table->foreign('id_acta')->references('id_acta')->on('acta')
            ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('cedula_empleado')->references('cedula_empleado')->on('empleado')
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
        Schema::dropIfExists('empleado_sancion');
    }
}
