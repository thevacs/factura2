<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExoneracionDetalle extends Model
{
    use SoftDeletes;

    protected $table = 'exoneracion_detalles';
    protected $connection = 'mysql';
    protected $fillable = ['exoneracion_id', 'item', 'cantidad'];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function inventario()
    {
        return $this->belongsTo(Inventario::class, 'item', 'id')->withTrashed();
    }

    public function exoneracion()
    {
        return $this->belongsTo(Exoneracion::class, 'exoneracion_id', 'id');
    }

}
