<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Producto extends Model
{
    use SoftDeletes;

    protected $table = 'productos';
    protected $connection = 'mysql';
    protected $fillable = ['nombre', 'servicio', 'tamano', 'tipo', 'moneda_id', 'costo', 'base1', 'base2', 'base3', 'aporte', 'iva'];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function moneda()
    {
        return $this->belongsTo(Moneda::class, 'moneda_id', 'id');
    }

    public function aportes()
    {
        return $this->belongsTo(Aporte::class, 'aporte', 'id');
    }

}
