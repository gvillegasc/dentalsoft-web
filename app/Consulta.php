<?php

namespace DentalSoft;

use Illuminate\Database\Eloquent\Model;

class Consulta extends Model
{
    protected $table = 't_consulta';

    protected $primaryKey="consulta_id";
	protected $fillable = ['consulta_observ','cita_id','mconsulta_id','paciente_id','receta_id'];

	public function paciente(){
		return $this->belongsTo('DentalSoft\Paciente','paciente_id');
	}

	public function cita(){
		return $this->belongsTo('DentalSoft\Cita','cita_id');
	}

	public function mconsulta(){
		return $this->belongsTo('DentalSoft\MConsulta','mconsulta_id');
	}

	public function receta(){
		return $this->belongsTo('DentalSoft\Receta','receta_id');
	}
}
