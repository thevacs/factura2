<?php

namespace App\Http\Controllers;

use App\Aporte;
use App\Cliente;
use Carbon\Carbon;
use App\Factura;
use App\Inventario;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\FacturaExport;
use App\Models\AnulacionFiscal;
use App\Models\Banco;
use App\Models\NotaCredito;
use App\Models\Taquilla;
use App\Models\TipoPago;
use App\Moneda;
use App\Preliquidacion;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class FacturaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (in_array($request->user()->id, [10, 11])) {
            $facturas = Factura::whereIn('user_id', [10, 11])->when(request()->buscar, function ($query, $buscar) {
                return $query->where('id', $buscar);
            })->orderby('id', 'DESC')->paginate(100);
        } else {
            $facturas = Factura::when(request()->buscar, function ($query, $buscar) {
                return $query->where('id', $buscar);
            })->orderby('id', 'DESC')->paginate(100);
        }

        return view('facturas.index', compact('facturas'));
    }

    public function reporteExcel(Request $request)
    {
        $desde = Carbon::parse($request->desde)->format('Y-m-d');
        $hasta = Carbon::parse($request->hasta)->format('Y-m-d');

        $query =  Factura::select(
            'facturas.id',
            'facturas.created_at',
            'clientes.nombre',
            'facturas.base_value as tasa',
            'facturas.observacion',
            DB::raw('(SELECT SUM(facturas_items.precio) FROM facturas_items where facturas_items.factura_id = facturas.id) as monto'),
            DB::raw('(SELECT COUNT(facturas_items.id) FROM facturas_items where facturas_items.factura_id = facturas.id) as contenedores'),
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

        if ((isset($request->desde) && !empty($request->desde)) && (isset($request->hasta) && !empty($request->hasta))) {

            if (isset($request->cliente) && !empty($request->cliente)) {

                $facturas = $query->whereBetween('facturas.created_at', [$desde, $desde])
                    ->where('clientes.nombre', $request->cliente)->get();
            } else {
                $facturas = $query->whereBetween('facturas.created_at', [$desde, $hasta])->get();
            }
        } elseif (isset($request->desde) && !empty($request->desde)) {
            //dd(1);
            if (isset($request->cliente) && !empty($request->cliente)) {
                $facturas = $query->whereDate('facturas.created_at', $desde)
                    ->where('clientes.nombre', $request->cliente)->get();
            } else {
                $facturas = $query->whereDate('facturas.created_at', $desde)->get();
            }
        } else {
            //dd(3);
            if (isset($request->cliente) && !empty($request->cliente)) {

                $facturas =  $query->where('clientes.nombre', $request->cliente)->get();
            }
        }

        if ($request->reporte) {
            $query = $request->all();
            //dd($query);
            return Excel::download(new FacturaExport($query), 'facturas.xlsx');
        }

        return view('facturas.reporte-excel', compact('facturas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cliente = Cliente::count();
        $inventario = Inventario::count();
        $aportes = Aporte::all();
        // $productos = Producto::whereNotIn('id', [1])->get();
        $tipo_pagos = TipoPago::all();
        $bancos = Banco::orderby('nombre')->get();

        if ($cliente > 0 && $inventario > 0) {
            return view('facturas.create', compact('aportes', 'tipo_pagos', 'bancos'));
        } else {
            return redirect('home')->with('message', ' Sin Clientes/Inventario registrado');
        }
    }

    public function credito()
    {
        return view('facturas.credito');
    }

    public function reporte(Request $request)
    {
        $dia = $request->fecha ?? now()->format('Y-m-d');

        if (in_array($request->user()->id, [10, 11])) {
            $facturas = Factura::whereIn('user_id', [10, 11])->whereDate('created_at', $dia)->orderBy('id', 'DESC')->get();
        } else {
            $facturas = Factura::whereDate('created_at', $dia)->orderBy('id', 'DESC')->get();
        }

        return view('facturas.reporte', compact('facturas', 'dia'));
    }

    public function preliquidar()
    {
        $monedas = Moneda::select('codigo', 'valor')->get();
        $cliente = Cliente::count();
        $inventario = Inventario::count();
        $aportes = Aporte::all();

        if ($cliente > 0 && $inventario > 0) {
            return view('facturas.preliquidar', compact('monedas', 'aportes'));
        } else {
            return redirect('home')->with('message', ' Sin Clientes/Inventario registrado');
        }
    }

    public function getPreliquidacion(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'cliente_id' => 'required',
            'user_id' => 'required',
            'base_value' => 'required',
            'aporte' => 'required',
        ]);

        $seriales = Inventario::where('bl', $request->bl)
            ->select('id', 'producto_id', 'serial', 'bl', 'descripcion')
            ->get();

        // dd($request->all());
        $preliquidacion = \App\Preliquidacion::create([
            'cliente_id' => $request->cliente_id,
            'user_id' => $request->user_id,
            'base_value' => $request->base_value,
            'aporte_id' => $request->aporte,
        ]);

        foreach ($seriales as $key => $value) {
            \App\PreliquidacionDetalle::create([
                'preliquidacion_id' => $preliquidacion->id,
                'item' => $value->id,
                'cantidad' => 1,
            ]);
        }

        return redirect()->route('facturas.printPreliquidacion', $preliquidacion->id);
    }

    public function printPreliquidacion(Preliquidacion $preliquidacion)
    {
        $cliente = Cliente::find($preliquidacion->cliente_id);
        $cantidad = 1;
        $aporte = Aporte::find(1);
        $detalles = \App\PreliquidacionDetalle::where('preliquidacion_id', $preliquidacion->id)->get();

        return view('facturas.print_preliquidacion', compact('cliente', 'cantidad', 'aporte', 'preliquidacion', 'detalles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'cliente_id' => 'required',
            'user_id' => 'required',
            'observacion' => 'sometimes',
            'moneda_id' => 'required',
            'base_value' => 'required',
            'aporte' => 'required',
            'tipo_pago_id' => 'required',
            'bl' => 'required',
        ]);

        $contenedores = collect();
        $extras = collect();

        foreach ($request->seriales as $serial) {
            $contenedores->push($serial['id']);
        }

        //dd($request->extras);
        if ($request->extras) {
            # code...
            foreach ($request->extras as $extra) {

                $monto = $extra['monto'] * $extra['tasa'];

                $monto1 = $extra['iva'] === '1' ? $monto * $extra['monto1'] : $monto;

                $extras->push([
                    'id' => $extra['id'],
                    'nombre' => $extra['nombre'],
                    'monto' => $monto,
                    'monto1' => $monto1,
                    'iva' => $extra['iva'],
                ]);
            }
        }

        $seriales = Inventario::whereIn('id', $contenedores)
            ->select('id', 'producto_id', 'serial', 'bl', 'descripcion')
            ->get();

        $factura = Factura::create([
            'cliente_id' => $request->cliente_id,
            'user_id' => auth()->user()->id,
            'observacion' => $request->observacion,
            'moneda_id' => $request->moneda_id,
            'base_value' => $request->base_value,
            'aporte_id' => $request->aporte,
            'tipo_pago_id' => $request->tipo_pago_id,
            'tipo_pago_id1' => $request->tipo_pago_id1 ?? null,
            'tmonto1' => $request->tmonto1 ?? null,
            'referencia' => $request->referencia,
            'banco_id' => $request->banco_id,
            'banco_id2' => $request->banco_id2 ?? null,
            'tmonto' => $request->tmonto ?? null,
            'validacion' => 0,
            'anulada' => 0,
        ]);

        foreach ($seriales as $key => $value) {
            \App\FacturaItem::create([
                'factura_id' => $factura->id,
                'inventario_id' => $value->id,
                'tags' => $value->serial,
                'cantidad' => 1,
                'precio' => $value->producto->costo * $value->producto->moneda->valor
            ]);
            Inventario::find($value->id)->delete();
        }

        foreach ($extras as $extra) {
            \App\FacturaItem::create([
                'factura_id' => $factura->id,
                'inventario_id' => 0,
                'tags' => 'EXTRA',
                'cantidad' => 1,
                'precio' => $extra['monto'],
                'iva' => $extra['iva'] ? 1 : null,
                'nombre' => $extra['nombre']
            ]);
        }

        $precio = $factura->items->sum('precio');

        if ($request->monto && $request->tmonto > $precio) { // me debes

            $nuevoMonto = $request->tmonto - $precio;

            NotaCredito::create([
                'monto' => $nuevoMonto,
                'cliente_id' => $request->cliente_id,
                'facturag_id' => $factura->id,
                'observacion' => 'GENERADO AUTOMATICO POR LA FACTURA #' . $factura->id . ' Y LA TRANSFERENCIA DE ' . number_format($request->tmonto),
                'created_by' => $request->user()->id,
            ]);
        }

        // Existe nota de credito
        if ($request->notaCreditoId && $request->notaCredito) {
            $notaCredito = NotaCredito::find($request->notaCreditoId);
            $notaCredito->facturau_id = $factura->id;
            $notaCredito->updated_by = $request->user()->id;
            $notaCredito->usada = true;
            $notaCredito->save();

            if ($notaCredito->monto > $precio) { // me debes

                $nuevoMonto = $notaCredito->monto - $precio;

                NotaCredito::create([
                    'monto' => $nuevoMonto,
                    'cliente_id' => $request->cliente_id,
                    'facturag_id' => $factura->id,
                    'observacion' => 'GENERADO AUTOMATICO POR LA FACTURA #' . $factura->id,
                    'created_by' => $request->user()->id,
                ]);
            }
        }

        return redirect()->route('facturas.printer', $factura->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Factura  $factura
     * @return \Illuminate\Http\Response
     */
    public function show(Factura $factura)
    {
        if ($factura->id > 5418) {
            return view('facturas.show2', compact('factura'));
        } else {
            return view('facturas.show', compact('factura'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Factura  $factura
     * @return \Illuminate\Http\Response
     */
    public function printer(Factura $factura)
    {
        if ($factura->id > 5418) {
            return view('facturas.print2', compact('factura'));
        } else {
            return view('facturas.print', compact('factura'));
        }
    }

    public function printerFiscal(Factura $factura)
    {
        $data = collect([
            'factura' => sprintf('%06d', $factura->id),
            'cliente' => collect([
                'id' => $factura->cliente_id,
                'rif' => $factura->cliente->rif,
                'nombre' => $factura->cliente->nombre,
                'direccion' => $factura->cliente->direccion,
            ]),
            'detalles' => collect([
                'cantidad' => $factura->items[0]->cantidad,
                'producto' => $factura->items[0]->inventario->producto->nombre,
                'serial' => $factura->items[0]->inventario->serial,
                'descripcion' => $factura->items[0]->inventario->descripcion,
                'precio' => $factura->items[0]->precio,
                'subtotal' => number_format($subtotal = $subtotal = $factura->items[0]->cantidad * $factura->items[0]->precio, 2),
            ]),
            'aportes' => $aportes = number_format(aporteToChange($factura->items[0]->inventario->producto->aporte), 2),
            'iva' => number_format($iva = $factura->items[0]->inventario->producto->iva > 0 ? ($factura->items[0]->cantidad * $factura->items[0]->precio) * (\App\Impuesto::find(1)->valor / 100) : (float) 0.00, 2),
            'total' => number_format($subtotal + aporteToChange($factura->items[0]->inventario->producto->aporte) + $iva, 2),
        ]);

        return response()
            ->json($data);
    }

    public function printerFiscal2(Factura $factura)
    {

        $string = "";

        if ($factura->id < 5418) {

            foreach ($factura->items as $item) {

                $string .= "";
                $string .= "i01NOMBRE: " . strtoupper(Str::limit($factura->cliente->nombre, 40, '')) . "\r\n";
                $string .= "i02RIF: " . $factura->cliente->rif . "\r\n";
                $string .= "i03DIRECCION: " . strtoupper(Str::limit($factura->cliente->direccion, 40, '')) . "\r\n";
                $string .= "i04FACTURA: " . $factura->id . "\r\n";

                $aporte = number_format($item->inventario->producto->aportes->valor * $factura->base_value, 2, '', '');
                $aporteprueba = '0000000400'; //4,00
                $string .= " " . $aporte . "00001000APORTE SOCIAL CONTENEDOR: " . strtoupper($item->inventario->serial) . "\r\n";

                $string .= "101\r\n";
            }
        } else {

            $string .= "";
            $string .= "i01NOMBRE: " . strtoupper(Str::limit($factura->cliente->nombre, 40, '')) . "\r\n";
            $string .= "i02RIF: " . $factura->cliente->rif . "\r\n";
            $string .= "i03DIRECCION: " . strtoupper(Str::limit($factura->cliente->direccion, 40, '')) . "\r\n";
            $string .= "i04FACTURA: " . $factura->id . "\r\n";

            foreach ($factura->items as $item) {
                $aporte = number_format($item->precio, 2, '', '');
                //$aporteprueba = '0000000400'; //4,00
                $divide = 99000000;

                $div = false;

                if ($item->precio >= $divide) {
                    $div = true;
                    $nuevoValor = $item->precio / 3;
                    $nuevo = number_format($nuevoValor, 2, '', '');
                }

                if ($div) {

                    $tasa = $item->iva ? '!' : " ";
                    $string .= $tasa . $nuevo . "00001000" . strtoupper($item->nombre ?? $item->tags) . "\r\n";
                    $string .= $tasa . $nuevo . "00001000" . strtoupper($item->nombre ?? $item->tags) . "\r\n";
                    $string .= $tasa . $nuevo . "00001000" . strtoupper($item->nombre ?? $item->tags) . "\r\n";
                } else {
                    $tasa = $item->iva ? '!' : " ";
                    $string .= $tasa . $aporte . "00001000" . strtoupper($item->nombre ?? $item->tags) . "\r\n";
                }
            }

            $string .= "101\r\n";
        }

        return response($string);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Factura  $factura
     * @return \Illuminate\Http\Response
     */
    public function edit(Factura $factura)
    {
        $tipos = TipoPago::orderBy('nombre')->get()->pluck('nombre', 'id');
        $clientes = Cliente::orderBy('nombre')->get()->pluck('nombre', 'id');
        $bancos = Banco::orderBy('nombre')->get()->pluck('nombre', 'id');
        return view('facturas.edit', compact('factura', 'tipos', 'clientes', 'bancos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Factura  $factura
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Factura $factura)
    {
        $factura->update([
            'cliente_id' => $request->cliente_id,
            'banco_id' => $request->banco_id,
            'referencia' => $request->referencia,
            'tipo_pago_id' => $request->tipo_pago_id,
        ]);

        return redirect()->route('facturas.index')->with('status', 'Actualizado con exito.');
    }

    public function anular(Factura $factura, Request $request)
    {

        $factura->anulada = 1;
        $factura->save();
        $ids = $factura->items->pluck('inventario_id');
        Inventario::onlyTrashed()->whereIn('id', $ids)->restore();

        if ($request->tipo == 'fiscal') {

            $usuario = $request->user()->id;
            $impresora = Taquilla::first();

            $anulacion = AnulacionFiscal::create([
                'factura_id' => $factura->id,
                'user_id' => $usuario,
                'impresora' => $usuario === 3 ? $impresora->taquilla1 : $impresora->taquilla2,
                'numero_factura_fiscal' => $request->nf_factura,
                'contenedor' => $request->contenedor
            ]);

            return redirect()->route('anulacion.show', $anulacion->id);
        }

        return redirect('facturas');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Factura  $factura
     * @return \Illuminate\Http\Response
     */
    public function destroy(Factura $factura)
    {
        //
    }
}
