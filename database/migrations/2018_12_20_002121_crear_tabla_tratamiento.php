<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaTratamiento extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_tratamiento', function (Blueprint $table) {
            $table->increments('tratamiento_id');
            $table->date('tratamiento_fecha');
            $table->string('tratamiento_estado');
            $table->string('tratamiento_titulo');
            $table->string('tratamiento_observ');
            $table->decimal('tratamiento_subtotal',15,2);
            $table->decimal('tratamiento_descuento',15,2);
            $table->decimal('tratamiento_total',15,2);
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
        Schema::dropIfExists('t_tratamiento');
    }
}
