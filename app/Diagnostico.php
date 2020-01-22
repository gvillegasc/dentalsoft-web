<?php

namespace DentalSoft;

use Illuminate\Database\Eloquent\Model;

class Diagnostico extends Model
{
    protected $table = 't_diagnostico';

    protected $primaryKey="diagnostico_id";
	protected $fillable = ['diagnostico_desc','diagnostico_color'];
	
	public function dodontogramas(){
		return $this->hasMany('DentalSoft\DOdontograma');
	}

	public function dtratamientos(){
		return $this->hasMany('DentalSoft\Dtratamiento');
	}

	/*public function dtpiezas(){
		return $this->hasMany('DentalSoft\DTPieza');
	}*/
}
