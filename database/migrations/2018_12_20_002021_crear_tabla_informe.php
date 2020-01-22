<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaInforme extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_informe', function (Blueprint $table) {
            $table->increments('informe_id');
            $table->string('informe_desc');
            $table->string('informe_observ');
            $table->string('informe_url');
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
        Schema::dropIfExists('t_informe');
    }
}
