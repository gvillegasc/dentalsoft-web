<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaNota extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_nota', function (Blueprint $table) {
            $table->increments('nota_id');
            $table->string('nota_titulo');
            $table->string('nota_observ');
            $table->integer('cita_id')->unsigned();
            $table->foreign('cita_id')->references('cita_id')->on('t_cita');
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
        Schema::dropIfExists('t_nota');
    }
}
