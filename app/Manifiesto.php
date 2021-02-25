<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Manifiesto extends Model
{
    use SoftDeletes;

  /**
   * Nombre de la tabla.
   *
   * @var string
   */
  protected $table = 'manifiestos';

  /**
   * El modelo usa los campos datetime created_at ni updated_at.
   *
   * @var boolean
   */
  public $timestamps = true;

  /**
   * Los campos que podrán ser actualizados.
   *
   * @var array
   */
  protected $fillable = [
    'id', 'buque', 'fecha', 'datos', 'procesado', 'created_by'
  ];

  /**
   * Los campos que son fecha.
   *
   * @var array
   */
  protected $date = [
    'fecha','created_at', 'updated_at', 'deleted_at'
  ];

  /**
   * Contendores que pertencen a este manifiesto.
   *
   * @return App\ManifiestoContenedor
   */
  public function contenedores()
  {
    return $this->hasMany(ManifiestoContenedor::class);
  }
}
