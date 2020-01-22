<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaTransaccion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_transaccion', function (Blueprint $table) {
            $table->increments('transaccion_id');
            $table->date('transaccion_fecha');
            $table->decimal('transaccion_monto',15,2);
            $table->integer('tratamiento_id')->unsigned();
            $table->integer('pago_id')->unsigned();
            $table->foreign('tratamiento_id')->references('tratamiento_id')->on('t_tratamiento');
            $table->foreign('pago_id')->references('pago_id')->on('t_pago');
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
        Schema::dropIfExists('t_transaccion');
    }
}
