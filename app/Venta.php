<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $table = 'ventas';

	public function empresasafiliado(){
		return $this->belongsTo('\App\Empresa','desde_id');
	}

	public function empresasvendedor(){
		return $this->belongsTo('\App\Empresa','adonde_id');
	}
}
