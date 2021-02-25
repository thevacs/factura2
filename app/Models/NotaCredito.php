<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\User;
use App\Cliente;
use App\Factura;

class NotaCredito extends Model
{
    use SoftDeletes;

    /**
     * Nombre de la tabla.
     *
     * @var string
     */
    protected $table = 'nota_creditos';

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
        'cliente_id',
        'monto',
        'usada',
        'facturag_id',
        'facturau_id',
        'observacion',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    /**
     * Los campos que son fecha.
     *
     * @var array
     */
    protected $date = [
        'created_at', 'updated_at', 'deleted_at'
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function usuario_u()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

    public function usuario_d()
    {
        return $this->belongsTo(User::class, 'deleted_by', 'id');
    }

    public function generador()
    {
        return $this->belongsTo(Factura::class, 'facturag_id', 'id');
    }

    public function usuado()
    {
        return $this->belongsTo(Factura::class, 'facturau_id', 'id');
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id', 'id');
    }
}
