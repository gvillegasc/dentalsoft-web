<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaRpago extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_rpago', function (Blueprint $table) {
            $table->increments('rpago_id');
            $table->string('rpago_nombre');
            $table->string('rpago_nota');
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
        Schema::dropIfExists('t_rpago');
    }
}
