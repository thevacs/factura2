<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PreliquidacionDetalle extends Model
{
    use SoftDeletes;

    protected $table = 'preliquidacion_detalles';
    protected $connection = 'mysql';
    protected $fillable = ['preliquidacion_id', 'item', 'cantidad','iva', 'tags','precio'];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function inventario()
    {
        return $this->belongsTo(Inventario::class, 'item', 'id');
    }

}
