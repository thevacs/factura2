<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Exoneracion extends Model
{
    use SoftDeletes;

    protected $table = 'exoneraciones';
    protected $connection = 'mysql';
    protected $fillable = ['cliente_id', 'user_id', 'base_value', 'aporte_id'];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];


    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }


    public function detalles()
    {
        return $this->hasMany(ExoneracionDetalle::class, 'exoneracion_id', 'id')->with('inventario');
    }
}
