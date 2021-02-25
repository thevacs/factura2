<?php

namespace App;

use App\Models\Banco;
use App\Models\TipoPago;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Factura extends Model
{
    use SoftDeletes;

    protected $table = 'facturas';

    protected $fillable = [
        'cliente_id',
        'user_id',
        'observacion',
        'moneda_id',
        'base_value',
        'aporte_id',
        'tipo_pago_id',
        'tmonto',
        'tipo_pago_id1',
        'tmonto1',
        'tipo_pago_id2',
        'referencia',
        'referencia2',
        'banco_id',
        'banco_id2',
        'validacion',
        'anulada'
    ];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id', 'id');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function items()
    {
        return $this->hasMany(FacturaItem::class)->with('inventario');
    }

    public function moneda()
    {
        return $this->belongsTo(Moneda::class, 'moneda_id', 'id');
    }

    public function tipopago()
    {
        return $this->belongsTo(TipoPago::class, 'tipo_pago_id', 'id');
    }

    public function banco()
    {
        return $this->belongsTo(Banco::class, 'banco_id', 'id');
    }

}
