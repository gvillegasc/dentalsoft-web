<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaAnamnesis extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_anamnesis', function (Blueprint $table) {
            $table->increments('anamnesis_id');
            $table->string('anamnesis_motivo');
            $table->string('anamnesis_amedico');
            $table->string('anamnesis_alergia');
            $table->string('anamnesis_medicamento');
            $table->string('anamnesis_habito');
            $table->string('anamnesis_afamiliar');
            $table->string('anamnesis_embarazo');
            $table->string('anamnesis_coagulacion');
            $table->string('anamnesis_panestesia');
            $table->string('anamnesis_otros');
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
        Schema::dropIfExists('t_anamnesis');
    }
}
