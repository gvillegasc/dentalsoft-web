<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaDTPieza extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_dtpieza', function (Blueprint $table) {
            $table->increments('dtpieza_id');
            $table->integer('pieza_id')->unsigned();
            $table->integer('superficie_id')->unsigned();
            $table->integer('diagnostico_id')->unsigned();
            $table->integer('dtratamiento_id')->unsigned();
            $table->foreign('dtratamiento_id')->references('dtratamiento_id')->on('t_dtratamiento');
            $table->foreign('diagnostico_id')->references('diagnostico_id')->on('t_diagnostico');
            $table->foreign('superficie_id')->references('superficie_id')->on('t_superficie');
            $table->foreign('pieza_id')->references('pieza_id')->on('t_pieza');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_dtpieza');
    }
}
