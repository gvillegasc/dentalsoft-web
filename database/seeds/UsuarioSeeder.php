<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use DentalSoft\User;
use DentalSoft\Departamento;
use DentalSoft\Provincia;
use DentalSoft\Distrito;
use DentalSoft\Clinica;

class UsuarioSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{

		Departamento::create
		([
			'departamento_id' => "1",
			'departamento_cod' => "1",
			'departamento_desc' => "Ninguno"
		]);

		Provincia::create
		([
			'provincia_id' => "1",
			'provincia_cod' => "1",
			'provincia_desc' => "Ninguno",
			'departamento_id' => "1"
		]);

		Distrito::create
		([
			'distrito_id' => "1",
			'distrito_cod' => "1",
			'distrito_desc' => "Ninguno",
			'provincia_id' => "1"
		]);

		Clinica::create
		([
			'clinica_id' => "1",
			'clinica_descripcion' => "Clinica 1",
			'clinica_ruc' => "343434",
			'clinica_direccion' => "",
			'departamento_id' => "1"
		]);


		User::create
		([
			'nombre' => "Juan",
			'email' => "prueba@dentalsoft.com",
			'password' => bcrypt("dental123"),
			'apellido' => "Perez",
			'tipo' => "medico",
			'genero' => "M",
			'dni' => "11111111",
			'fechanac' => "1990-10-10",
			'telefono1' => "123123",
			'telefono2' => "",
			'direccion' => "",
			'departamento_id' => "1",
			'provincia_id' => "1",
			'distrito_id' => "1",
			'clinica_id' => "1"
		]);
		
		/*
		INSERT INTO `t_superficie` (`superficie_id`, `superficie_codigo`, `superficie_desc`, `created_at`, `updated_at`) VALUES ('1', 'N', 'Ninguno', NULL, NULL);
		INSERT INTO `t_superficie` (`superficie_id`, `superficie_codigo`, `superficie_desc`, `created_at`, `updated_at`) VALUES ('2', 'C', 'Cervical', NULL, NULL);
		INSERT INTO `t_superficie` (`superficie_id`, `superficie_codigo`, `superficie_desc`, `created_at`, `updated_at`) VALUES ('3', 'D', 'Distal', NULL, NULL);
		INSERT INTO `t_superficie` (`superficie_id`, `superficie_codigo`, `superficie_desc`, `created_at`, `updated_at`) VALUES ('4', 'I', 'Incisal', NULL, NULL);
		INSERT INTO `t_superficie` (`superficie_id`, `superficie_codigo`, `superficie_desc`, `created_at`, `updated_at`) VALUES ('5', 'L', 'Lingual', NULL, NULL);
		INSERT INTO `t_superficie` (`superficie_id`, `superficie_codigo`, `superficie_desc`, `created_at`, `updated_at`) VALUES ('6', 'M', 'Mesial', NULL, NULL);
		INSERT INTO `t_superficie` (`superficie_id`, `superficie_codigo`, `superficie_desc`, `created_at`, `updated_at`) VALUES ('7', 'O', 'Oclusal', NULL, NULL);
		INSERT INTO `t_superficie` (`superficie_id`, `superficie_codigo`, `superficie_desc`, `created_at`, `updated_at`) VALUES ('8', 'P', 'Palatino', NULL, NULL);
		INSERT INTO `t_superficie` (`superficie_id`, `superficie_codigo`, `superficie_desc`, `created_at`, `updated_at`) VALUES ('9', 'V', 'Vestibular', NULL, NULL);
		INSERT INTO `t_superficie` (`superficie_id`, `superficie_codigo`, `superficie_desc`, `created_at`, `updated_at`) VALUES ('10', 'Ot', 'Otro', NULL, NULL);
		
		--------------------------------

		INSERT INTO `t_diagnostico` (`diagnostico_id`, `diagnostico_desc`, `diagnostico_color`, `created_at`, `updated_at`) VALUES ('1', 'Ninguno', 'Ninguno', NULL, NULL);
		INSERT INTO `t_diagnostico` (`diagnostico_id`, `diagnostico_desc`, `diagnostico_color`, `created_at`, `updated_at`) VALUES ('2', 'sano', '#fff', NULL, NULL);
		INSERT INTO `t_diagnostico` (`diagnostico_id`, `diagnostico_desc`, `diagnostico_color`, `created_at`, `updated_at`) VALUES ('3', 'caries', '#E74C3C', NULL, NULL);
		INSERT INTO `t_diagnostico` (`diagnostico_id`, `diagnostico_desc`, `diagnostico_color`, `created_at`, `updated_at`) VALUES ('4', 'sellante', '#33FF3E', NULL, NULL);
		INSERT INTO `t_diagnostico` (`diagnostico_id`, `diagnostico_desc`, `diagnostico_color`, `created_at`, `updated_at`) VALUES ('5', 'amalgama', '#33FAFF', NULL, NULL);
		INSERT INTO `t_diagnostico` (`diagnostico_id`, `diagnostico_desc`, `diagnostico_color`, `created_at`, `updated_at`) VALUES ('6', 'composite', '#2980B9', NULL, NULL);
		INSERT INTO `t_diagnostico` (`diagnostico_id`, `diagnostico_desc`, `diagnostico_color`, `created_at`, `updated_at`) VALUES ('7', 'incrustacion', '#F4D03F', NULL, NULL);
		INSERT INTO `t_diagnostico` (`diagnostico_id`, `diagnostico_desc`, `diagnostico_color`, `created_at`, `updated_at`) VALUES ('8', 'fractura', '#37883B', NULL, NULL);
		INSERT INTO `t_diagnostico` (`diagnostico_id`, `diagnostico_desc`, `diagnostico_color`, `created_at`, `updated_at`) VALUES ('9', 'surco', '#A569BD', NULL, NULL);
		INSERT INTO `t_diagnostico` (`diagnostico_id`, `diagnostico_desc`, `diagnostico_color`, `created_at`, `updated_at`) VALUES ('10', 'endodoncia', '#fff', NULL, NULL);
		INSERT INTO `t_diagnostico` (`diagnostico_id`, `diagnostico_desc`, `diagnostico_color`, `created_at`, `updated_at`) VALUES ('11', 'ausente', '#fff', NULL, NULL);
		INSERT INTO `t_diagnostico` (`diagnostico_id`, `diagnostico_desc`, `diagnostico_color`, `created_at`, `updated_at`) VALUES ('12', 'extraccion', '#fff', NULL, NULL);
		INSERT INTO `t_diagnostico` (`diagnostico_id`, `diagnostico_desc`, `diagnostico_color`, `created_at`, `updated_at`) VALUES ('13', 'coronada', '#fff', NULL, NULL);
		INSERT INTO `t_diagnostico` (`diagnostico_id`, `diagnostico_desc`, `diagnostico_color`, `created_at`, `updated_at`) VALUES ('14', 'implante', '#fff', NULL, NULL);
		INSERT INTO `t_diagnostico` (`diagnostico_id`, `diagnostico_desc`, `diagnostico_color`, `created_at`, `updated_at`) VALUES ('15', 'lcnc', '#fff', NULL, NULL);
		*/
	}

}