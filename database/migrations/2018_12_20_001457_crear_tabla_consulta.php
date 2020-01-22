<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaConsulta extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_consulta', function (Blueprint $table) {
            $table->increments('consulta_id');
            $table->string('consulta_observ');
            $table->integer('cita_id')->unsigned();
            $table->integer('mconsulta_id')->unsigned();
            $table->integer('paciente_id')->unsigned();
            $table->integer('receta_id')->unsigned();
            $table->foreign('cita_id')->references('cita_id')->on('t_cita');
            $table->foreign('mconsulta_id')->references('mconsulta_id')->on('t_mconsulta');
            $table->foreign('paciente_id')->references('paciente_id')->on('t_paciente');
            $table->foreign('receta_id')->references('receta_id')->on('t_receta');
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
        Schema::dropIfExists('t_consulta');
    }
}
