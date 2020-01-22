<?php

namespace DentalSoft;

use Illuminate\Database\Eloquent\Model;

class DTratamiento extends Model
{
    protected $table = 't_dtratamiento';

    protected $primaryKey="dtratamiento_id";
	protected $fillable = ['dtratamiento_desc','dtratamiento_subtotal','dtratamiento_descuento','dtratamiento_total','pieza_id','superficie_id','diagnostico_id','tratamiento_id'];
	
	/*public function dtpiezas(){
		return $this->hasMany('DentalSoft\DTPiezas');
	}*/

	public function tratamiento(){
		return $this->belongsTo('DentalSoft\Tratamiento','tratamiento_id');
	}

	public function pieza(){
		return $this->belongsTo('DentalSoft\Pieza','pieza_id');
	}

	public function superficie(){
		return $this->belongsTo('DentalSoft\Superficie','superficie_id');
	}

	public function diagnostico(){
		return $this->belongsTo('DentalSoft\Diagnostico','diagnostico_id');
	}
}

/*class DTratamiento extends Model
{
    protected $table = 't_dtratamiento';

    protected $primaryKey="dtratamiento_id";
	protected $fillable = ['dtratamiento_desc','dtratamiento_subtotal','dtratamiento_descuento','dtratamiento_total','tratamiento_id'];
	
	public function dtpiezas(){
		return $this->hasMany('DentalSoft\DTPiezas');
	}

	public function tratamiento(){
		return $this->belongsTo('DentalSoft\Tratamiento','tratamiento_id');
	}
}*/
