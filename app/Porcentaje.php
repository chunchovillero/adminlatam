<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Porcentaje extends Model
{
    protected $table = 'porcentajes';

    public function empresasafiliado(){
        return $this->belongsTo('\App\Empresa','afiliado');
    }

    public function empresasvendedor(){
        return $this->belongsTo('\App\Empresa','vendedor');
    }
}
