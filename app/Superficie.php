<?php

namespace DentalSoft;

use Illuminate\Database\Eloquent\Model;

class Superficie extends Model
{
    protected $table = 't_superficie';

    protected $primaryKey="superficie_id";
	protected $fillable = ['superficie_codigo','superficie_desc'];
	
	public function dodontogramas(){
		return $this->hasMany('DentalSoft\DOdontograma');
	}

	public function dtratamientos(){
		return $this->hasMany('DentalSoft\DTratamiento');
	}

	/*public function dtpiezas(){
		return $this->hasMany('DentalSoft\DTPieza');
	}*/
}
