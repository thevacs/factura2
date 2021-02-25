<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Taquilla extends Model
{
    /**
     * Nombre de la tabla.
     *
     * @var string
     */
    protected $table = 'taquillas';

    /**
     * El modelo usa los campos datetime created_at ni updated_at.
     *
     * @var boolean
     */
    public $timestamps = false;

    /**
     * Los campos que podrán ser actualizados.
     *
     * @var array
     */
    protected $fillable = [
        'taquilla1', 'taquilla2', 'taquilla3', 'taquilla4'
    ];

    /**
     * Los campos que son fecha.
     *
     * @var array
     */
    protected $date = [];
}
