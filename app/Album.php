<?php

namespace DentalSoft;

use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    protected $table = 't_album';

    protected $primaryKey="album_id";
	protected $fillable = ['album_titulo','album_desc','paciente_id'];
	
	public function imagenes(){
		return $this->hasMany('DentalSoft\Imagen');
	}

	public function paciente(){
		return $this->belongsTo('DentalSoft\Paciente','paciente_id');
	}
}
