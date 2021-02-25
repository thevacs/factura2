<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ManifiestoContenedor extends Model
{
    use SoftDeletes;

    /**
     * Nombre de la tabla.
     *
     * @var string
     */
    protected $table = 'manifiestos_contenedor';

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
        'id', 'manifiesto_id', 'linea', 'buque', 'viaje', 'bl', 'procedencia', 'comodity', 'peso', 'numero', 'tamano', 'tipo',
    ];

    /**
     * Los campos que son fecha.
     *
     * @var array
     */
    protected $date = [
        'created_at', 'updated_at', 'deleted_at',
    ];

    /**
     * Manifiesto el cual se importaron los contenedores.
     *
     * @return App\Manifiesto
     */
    public function manifiesto()
    {
        return $this->belongsTo(Manifiesto::class);
    }
}
