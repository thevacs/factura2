<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Aporte extends Model
{
    use SoftDeletes;

    protected $table = 'aportes';
    protected $connection = 'mysql';
    protected $fillable = ['nombre', 'descripcion', 'moneda_id', 'acronimo', 'valor', 'vigencia_ini', 'vigencia_fin'];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function moneda()
    {
        return $this->hasOne('App\Moneda', 'id', 'moneda_id');
    }
}
