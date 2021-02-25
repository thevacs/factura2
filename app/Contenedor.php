<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contenedor extends Model
{
  protected $table = 'contenedors';
  protected $connection = 'mysql';
  protected $guarded = ['id'];
  protected $fillable = ['numero','tamano','tipo','descripcion','iso'];
  protected $dates = ['created_at','updated_at','deleted_at'];
}
