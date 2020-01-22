<?php

use Illuminate\Database\Seeder;
use DentalSoft\User;
use DentalSoft\Departamento;
use DentalSoft\Provincia;
use DentalSoft\Distrito;
use DentalSoft\Clinica;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
		User::truncate();
		Departamento::truncate();;
		Provincia::truncate();;
		Distrito::truncate();;
		Clinica::truncate();;

		$this->call('UsuarioSeeder');
    }
}
