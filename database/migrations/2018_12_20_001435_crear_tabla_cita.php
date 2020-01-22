<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaCita extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_cita', function (Blueprint $table) {
            $table->increments('cita_id');
            $table->date('cita_fecha');
            $table->time('cita_hora');
            $table->integer('cita_duracion');
            $table->string('cita_tiempo');
            $table->integer('ecita_id')->unsigned();
            $table->foreign('ecita_id')->references('ecita_id')->on('t_ecita');
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
        Schema::dropIfExists('t_cita');
    }
}
