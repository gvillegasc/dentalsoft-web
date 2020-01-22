<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaImagen extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_imagen', function (Blueprint $table) {
            $table->increments('imagen_id');
            $table->string('imagen_desc');
            $table->string('imagen_url');            
            $table->integer('paciente_id')->unsigned();            
            $table->integer('album_id')->unsigned();
            $table->foreign('paciente_id')->references('paciente_id')->on('t_paciente');
            $table->foreign('album_id')->references('album_id')->on('t_album');
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
        Schema::dropIfExists('t_imagen');
    }
}
