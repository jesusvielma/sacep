<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AgregarPadreAArticulo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('articulo', function (Blueprint $table) {
            $table->integer('padre')->unsigned()->nullable();
            $table->foreign('padre')->references('id_articulo')->on('articulo');
        });
    }
}
