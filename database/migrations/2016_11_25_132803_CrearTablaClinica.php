<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaClinica extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('t_clinica', function(Blueprint $table)
		{
			$table->increments('clinica_id');
			$table->string('clinica_descripcion');
			$table->string('clinica_ruc');
			$table->string('clinica_direccion');
			$table->integer('departamento_id')->unsigned();
			$table->foreign('departamento_id')->references('departamento_id')->on('t_departamento');
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
		Schema::drop('t_clinica');
	}

}
