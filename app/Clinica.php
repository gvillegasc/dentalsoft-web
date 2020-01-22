<?php

namespace DentalSoft;

use Illuminate\Database\Eloquent\Model;

class Clinica extends Model
{
    protected $table = 't_clinica';

    protected $primaryKey="clinica_id";
	protected $fillable = ['clinica_descripcion','clinica_ruc','clinica_direccion','departamento_id'];
	
	public function usuarios(){
		return $this->hasMany('DentalSoft\User');
	}

	public function pacientes(){
		return $this->hasMany('DentalSoft\Paciente');
	}

	public function departamento(){
		return $this->belongsTo('DentalSoft\Departamento','departamento_id');
	}
}
