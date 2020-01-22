<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('apellido');
            $table->string('tipo');
            $table->string('genero');
            $table->string('dni');
            $table->date('fechanac');
            $table->string('telefono1');
            $table->string('telefono2');
            $table->string('direccion');
            $table->integer('clinica_id')->unsigned();
            $table->integer('departamento_id')->unsigned();
            $table->integer('provincia_id')->unsigned();
            $table->integer('distrito_id')->unsigned();
            $table->foreign('departamento_id')->references('departamento_id')->on('t_departamento');
            $table->foreign('provincia_id')->references('provincia_id')->on('t_provincia');
            $table->foreign('distrito_id')->references('distrito_id')->on('t_distrito');
            $table->foreign('clinica_id')->references('clinica_id')->on('t_clinica');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
