<?php

namespace DentalSoft;

use Illuminate\Database\Eloquent\Model;

class Receta extends Model
{
    protected $table = 't_receta';

    protected $primaryKey="receta_id";
	protected $fillable = ['receta_fecha','receta_rp','receta_estado','paciente_id'];
	
	public function consulta(){
		return $this->hasOne('DentalSoft\Consulta');
	}

	public function paciente(){
		return $this->belongsTo('DentalSoft\Paciente','paciente_id');
	}
}
