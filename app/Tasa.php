<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tasa extends Model
{
    protected $table = 'tasas';
    protected $connection = 'mysql';
    protected $fillable = ['nombre','acronimo','descripcion','moneda_id','monto','vigencia_ini','vigencia_fin'];
    protected $dates = ['created_at','updated_at','deleted_at'];

    public function moneda()
    {
        return $this->belongsTo(Moneda::class, 'moneda_id', 'id');
    }
}
