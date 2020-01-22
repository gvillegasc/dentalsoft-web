<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaPaciente extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_paciente', function (Blueprint $table) {
            $table->increments('paciente_id');
            $table->string('paciente_dni');
            $table->string('paciente_nombre');
            $table->string('paciente_apellido');
            $table->string('paciente_correo');
            $table->string('paciente_telefono');
            $table->date('paciente_fechanac');
            $table->string('paciente_genero');
            $table->string('paciente_ocupacion');
            $table->string('paciente_direccion');
            $table->integer('departamento_id')->unsigned();
            $table->integer('provincia_id')->unsigned();
            $table->integer('distrito_id')->unsigned();
            $table->integer('clinica_id')->unsigned();
            $table->integer('usuario_id')->unsigned();
            $table->foreign('departamento_id')->references('departamento_id')->on('t_departamento');
            $table->foreign('provincia_id')->references('provincia_id')->on('t_provincia');
            $table->foreign('distrito_id')->references('distrito_id')->on('t_distrito');
            $table->foreign('clinica_id')->references('clinica_id')->on('t_clinica');
            $table->foreign('usuario_id')->references('id')->on('users');
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
        Schema::dropIfExists('t_paciente');
    }
}
