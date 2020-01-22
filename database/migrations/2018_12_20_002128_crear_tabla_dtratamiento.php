<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaDtratamiento extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_dtratamiento', function (Blueprint $table) {
            $table->increments('dtratamiento_id');
            $table->string('dtratamiento_desc');
            $table->decimal('dtratamiento_subtotal',15,2);
            $table->decimal('dtratamiento_descuento',15,2);
            $table->decimal('dtratamiento_total',15,2);
            $table->integer('tratamiento_id')->unsigned();
            $table->foreign('tratamiento_id')->references('tratamiento_id')->on('t_tratamiento');
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
        Schema::dropIfExists('t_dtratamiento');
    }
}
