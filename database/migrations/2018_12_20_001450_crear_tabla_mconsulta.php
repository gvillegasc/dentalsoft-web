<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaMconsulta extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_mconsulta', function (Blueprint $table) {
            $table->increments('mconsulta_id');
            $table->string('mconsulta_desc');
            $table->string('mconsulta_duracion');
            $table->string('mconsulta_tiempo');
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
        Schema::dropIfExists('t_mconsulta');
    }
}
