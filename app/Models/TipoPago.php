<?php

namespace App\Models;

use App\Factura;
use Illuminate\Database\Eloquent\Model;

class TipoPago extends Model
{
    /**
     * Nombre de la tabla.
     *
     * @var string
     */
    protected $table = 'tipo_pagos';

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
        'nombre', 'activo'
    ];

    /**
     * Los campos que son fecha.
     *
     * @var array
     */
    protected $date = [
        'created_at', 'updated_at'
    ];

    public function facturas()
    {
        return $this->hasMany(Factura::class);
    }
}