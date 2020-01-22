<?php

namespace DentalSoft;

use Illuminate\Database\Eloquent\Model;

class CAdicional extends Model
{
    protected $table = 't_cadicional';

    protected $primaryKey="cadicional_id";
	protected $fillable = ['cadicional_nombre','cadicional_parentesco','cadicional_telefono','paciente_id'];
	
	public function paciente(){
		return $this->belongsTo('DentalSoft\Paciente','paciente_id');
	}
}
