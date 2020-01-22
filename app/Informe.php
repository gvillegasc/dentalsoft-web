<?php

namespace DentalSoft;

use Illuminate\Database\Eloquent\Model;

class Informe extends Model
{
    protected $table = 't_informe';

    protected $primaryKey="informe_id";
	protected $fillable = ['informe_desc','informe_observ','informe_url','paciente_id'];
	
	public function paciente(){
		return $this->belongsTo('DentalSoft\Paciente','paciente_id');
	}
}
