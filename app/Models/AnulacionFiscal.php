<?php

namespace App\Models;

use App\Factura;
use App\User;
use Illuminate\Database\Eloquent\Model;

class AnulacionFiscal extends Model
{
    /**
     * Nombre de la tabla.
     *
     * @var string
     */
    protected $table = 'anulacion_fiscal';

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
        'user_id', 'impresora', 'factura_id', 'monto', 'numero_factura_fiscal', 'contenedor'
    ];

    /**
     * Los campos que son fecha.
     *
     * @var array
     */
    protected $date = [];

    public function factura()
    {
        return $this->belongsTo(Factura::class, 'factura_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}