<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaDistrito extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('t_distrito', function(Blueprint $table)
		{
			$table->increments('distrito_id');
			$table->string('distrito_cod');
			$table->string('distrito_desc');
			$table->integer('provincia_id')->unsigned();
			$table->foreign('provincia_id')->references('provincia_id')->on('t_provincia');
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
		Schema::drop('t_distrito');
	}

}
