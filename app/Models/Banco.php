<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Banco extends Model
{
    use SoftDeletes;

    /**
     * Nombre de la tabla.
     *
     * @var string
     */
    protected $table = 'bancos';

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
        'nombre'
    ];

    /**
     * Los campos que son fecha.
     *
     * @var array
     */
    protected $date = [];
}
