<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaProvincia extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('t_provincia', function(Blueprint $table)
		{
			$table->increments('provincia_id');
			$table->string('provincia_cod');
			$table->string('provincia_desc');
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
		Schema::drop('t_provincia');
	}

}
