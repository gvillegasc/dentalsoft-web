<?php

namespace DentalSoft;

use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    protected $table = 't_paciente';

    protected $primaryKey="paciente_id";
	protected $fillable = ['paciente_dni','paciente_nombre','paciente_apellido','paciente_correo','paciente_telefono','paciente_fechanac','paciente_genero','paciente_ocupacion','paciente_direccion','departamento_id','provincia_id','distrito_id','clinica_id','usuario_id'];
	
	public function consultas(){
		return $this->hasMany('DentalSoft\Consulta','paciente_id');
	}

	public function anamnesis(){
		return $this->hasOne('DentalSoft\Anamnesis','paciente_id');
	}

	public function rpago(){
		return $this->hasOne('DentalSoft\Rpago','paciente_id','paciente_id');
	}

	public function cadicional(){
		return $this->hasOne('DentalSoft\CAdicional','paciente_id');
	}


	public function departamento(){
		return $this->belongsTo('DentalSoft\Departamento','departamento_id');
	}

	public function provincia(){
		return $this->belongsTo('DentalSoft\Provincia','provincia_id');
	}

	public function distrito(){
		return $this->belongsTo('DentalSoft\Distrito','distrito_id');
	}

	public function clinica(){
		return $this->belongsTo('DentalSoft\Clinica','clinica_id');
	}

	public function usuario(){
		return $this->belongsTo('DentalSoft\Usuario','usuario_id');
	}

	public function imagenes(){
		return $this->hasMany('DentalSoft\Imagen');
	}

	public function tratamientos(){
		return $this->hasMany('DentalSoft\Tratamiento','paciente_id');
	}

}
