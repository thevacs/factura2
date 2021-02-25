<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Moneda extends Model
{
    use SoftDeletes;

    protected $table = 'monedas';
    protected $connection = 'mysql';
    protected $fillable = ['nombre', 'codigo', 'simbolo', 'valor'];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $cast = [
        'valor' => 'decimal:2',
    ];

}
