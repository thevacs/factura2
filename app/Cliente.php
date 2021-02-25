<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\NotaCredito;

class Cliente extends Model
{
    use SoftDeletes;

  protected $table = 'clientes';
  protected $connection = 'mysql';
  
  protected $fillable = [
    'rif',
    'nombre',
    'direccion',
    'contacto',
    'telefono1',
    'telefono2'
  ];

  protected $dates = ['created_at','updated_at','deleted_at'];

  public function notas()
  {
    return $this->hasMany(NotaCredito::class)->where('usada', false);
  }
}
