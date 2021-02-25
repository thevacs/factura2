<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
  protected $connection = 'mysql2';
  protected $table = 'inventarios';

  public function linea()
  {
    return $this->belongsTo(Linea::class,'linea_id','id');
  }

  public function buque()
  {
    return $this->belongsTo(Buque::class,'buque_id','id');
  }

  public function viaje()
  {
    return $this->belongsTo(Viaje::class,'viaje_id','id');
  }

  public function tipo()
  {
    return $this->belongsTo(Tipo::class,'tipo_id','id')->with('iso');
  }
}
