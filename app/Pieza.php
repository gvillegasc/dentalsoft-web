<?php

namespace DentalSoft;

use Illuminate\Database\Eloquent\Model;

class Pieza extends Model
{
    protected $table = 't_pieza';

    protected $primaryKey="pieza_id";
	protected $fillable = ['pieza_codigo','pieza_desc','pieza_nombre'];
	
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
