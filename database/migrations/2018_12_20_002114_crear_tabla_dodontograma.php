<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaDodontograma extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_dodontograma', function (Blueprint $table) {
            $table->increments('dodontograma_id');
            $table->string('dodontograma_observ');
            $table->integer('pieza_id')->unsigned();
            $table->integer('superficie_id')->unsigned();
            $table->integer('diagnostico_id')->unsigned();
            $table->integer('odontograma_id')->unsigned();
            $table->foreign('odontograma_id')->references('odontograma_id')->on('t_odontograma');
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
        Schema::dropIfExists('t_dodontograma');
    }
}
