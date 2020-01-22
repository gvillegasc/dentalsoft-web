<?php

namespace DentalSoft;

use Illuminate\Database\Eloquent\Model;

class MConsulta extends Model
{
    protected $table = 't_mconsulta';

    protected $primaryKey="mconsulta_id";
	protected $fillable = ['mconsulta_desc','mconsulta_duracion','mconsulta_tiempo'];
	
	public function consultas(){
		return $this->hasMany('DentalSoft\Consulta');
	}
}
