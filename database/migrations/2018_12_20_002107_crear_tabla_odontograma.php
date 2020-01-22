<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaOdontograma extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_odontograma', function (Blueprint $table) {
            $table->increments('odontograma_id');
            $table->date('odontograma_fecha');
            $table->string('odontograma_estado');
            $table->string('odontograma_titulo');
            $table->string('odontograma_observ');
            $table->integer('paciente_id')->unsigned();
            $table->foreign('paciente_id')->references('paciente_id')->on('t_paciente');
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
        Schema::dropIfExists('t_odontograma');
    }
}
