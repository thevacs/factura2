<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tipo extends Model
{
  protected $connection = 'mysql2';
  protected $table = 'tipos';

  public function iso()
  {
    return $this->hasMany(Tipos_Iso::class,'id','tipo_iso_id');
  }
}
