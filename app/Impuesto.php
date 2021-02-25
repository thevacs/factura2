<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Impuesto extends Model
{
    use SoftDeletes;

    protected $table = 'impuestos';
    protected $connection = 'mysql';
    protected $fillable = ['nombre', 'acronimo', 'descripcion', 'valor', 'vigencia_ini', 'vigencia_fin'];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
}
