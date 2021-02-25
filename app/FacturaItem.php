<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FacturaItem extends Model
{
    use SoftDeletes;

    protected $table = 'facturas_items';
    protected $connection = 'mysql';
    protected $fillable = [
        'factura_id',
        'inventario_id',
        'tags',
        'cantidad',
        'precio',
        'subtotal',
        'iva',
        'nombre',
    ];
    
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function factura()
    {
        return $this->belongsTo(Factura::class, 'factura_id', 'id');
    }

    public function inventario()
    {
        return $this->belongsTo(Inventario::class)->withTrashed();
    }

}
