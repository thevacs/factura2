<?php

namespace App\Exports;

use App\Factura;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class FacturaExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    private $request;

    public function __construct($request)
    {
        $this->request = $request;

    }
    public function headings(): array
    {
        return [
            'ID',
            'Fecha',
            'Cliente',
            'Contenedores',
            'Tasa',
            'Monto Total',
            'Observaciones',
            'T. Pago',
            'Referencia',
            'Taquilla',
            'Anulada',
        ];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $retVal = isset($this->request['desde']) ?? false ;
        $retVal1 = isset($this->request['hasta']) ?? false ;

        $desde = $retVal ? Carbon::parse($this->request['desde'])->format('Y-m-d') : false;
        $hasta = $retVal1 ? Carbon::parse($this->request['hasta'])->format('Y-m-d') : false;

        $query =  Factura::select('facturas.id',
                                'facturas.created_at',
                                'clientes.nombre',
                                'facturas.base_value as tasa',
                                'facturas.observacion',
                                DB::raw('(SELECT SUM(facturas_items.precio) FROM facturas_items where facturas_items.factura_id = facturas.id) as monto'),
                                DB::raw('(SELECT count(facturas_items.precio) FROM facturas_items where facturas_items.factura_id = facturas.id) as contenedores'),
                                'tipo_pagos.nombre as pago',
                                'facturas.referencia',
                                'facturas.anulada',
                                'users.name as usuario'
                            )
                            ->join('clientes', 'clientes.id', '=', 'facturas.cliente_id')
                            ->join('tipo_pagos', 'tipo_pagos.id', '=', 'facturas.tipo_pago_id')
                            ->join('users', 'users.id', '=', 'facturas.user_id')
                            ->distinct('facturas.id')
                            ->orderby('facturas.id', 'DESC');
        $facturas =  [];

         if( (isset($this->request['desde']) && !empty($this->request['desde'])) && (isset($this->request['hasta']) && !empty($this->request['hasta']))) {
            if (isset($this->request['cliente']) && !empty($this->request['cliente'])) {
                $facturas = $query->whereBetween('facturas.created_at', [$desde, $hasta])
                                    ->where('clientes.nombre', $this->request['cliente'])->get();
            } else {
                $facturas = $query->whereBetween('facturas.created_at', [$desde, $hasta])->get();
            }
        } elseif (isset($this->request['desde']) && !empty($this->request['desde'])) {
            if (isset($this->request['cliente']) && !empty($this->request['cliente'])) {
                $facturas = $query->whereDate('facturas.created_at', $desde)
                                    ->where('clientes.nombre', $this->request['cliente'])->get();
            } else {
                $facturas = $query->whereDate('facturas.created_at', $desde)->get();
            }
        } else {
            if (isset($this->request['cliente']) && !empty($this->request['cliente'])) {

                $facturas =  $query->where('clientes.nombre', $this->request['cliente'])->get();
            } 
        }

        $datos = collect();

        foreach ($facturas as $factura) {
            $datos->push([
                'ID' => $factura->id,
                'Fecha' => $factura->created_at,
                'Cliente' => $factura->nombre,
                'Contenedores' => $factura->contenedores,
                'Tasa' => $factura->tasa,
                'Monto Total' => $factura->monto,
                'Observaciones' => $factura->observacion ?? 'NO',
                'T. Pago' => $factura->pago,
                'Referencia' => $factura->referencia ?? 'NO',
                'Taquilla' => $factura->usuario,
                'Anulada' => $factura->anulada ? 'SI' : 'NO'
            ]);
        }

        return $datos;
    }

}