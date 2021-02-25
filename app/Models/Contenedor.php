<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contenedor extends Model
{
  protected $connection = 'mysql2';
  protected $table = 'contenedores';

  public function tipo()
  {
    return $this->hasOne(Tipo::class,'id','tipo_id')->with('iso');
  }
}
