<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inventario extends Model
{
    use SoftDeletes;

    /**
     * Nombre de la tabla.
     *
     * @var string
     */
    protected $table = 'inventarios';

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
        'producto_id', 'descripcion', 'serial', 'bl'
    ];

    /**
     * Los campos que son fecha.
     *
     * @var array
     */
    protected $date = [
        'created_at', 'updated_at', 'deleted_at',
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id', 'id')->with('moneda');
    }
}