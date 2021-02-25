<?php

namespace App\Http\Controllers;

use App\Preliquidacion;
use App\PreliquidacionDetalle;
use App\Aporte;
use App\Cliente;
use App\Inventario;
use App\Moneda;

use Illuminate\Http\Request;

class PreliquidacioneController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index(Request $request)
    {
        $preliquidaciones = Preliquidacion::orderByDesc('id')
        ->with('cliente:id,rif,nombre')
        ->when(request()->buscar, function ($query, $buscar) {
            $ids = Cliente::where('nombre', 'like', '%' . $buscar . '%')->select('id')->get();
            return $query->whereIn('cliente_id', $ids);
        })
        ->paginate();
        return view('preliquidaciones.index', compact('preliquidaciones'));
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create()
    {
        $monedas = Moneda::select('codigo', 'valor')->get();
        $cliente = Cliente::count();
        $inventario = Inventario::count();
        $aportes = Aporte::all();

        if ($cliente > 0 && $inventario > 0) {
            return view('preliquidaciones.create', compact('monedas', 'aportes'));
        } else {
            return redirect('home')->with('message', ' Sin Clientes/Inventario registrado');
        }
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
            'base_value' => 'required',
            'aporte' => 'required',
        ]);

        $contenedores = collect();
        $extras = collect();

        foreach ($request->seriales as $serial) {
            $contenedores->push($serial['id']);
        }

        if ($request->extras) {
            # code...     
            foreach ($request->extras as $extra) {

                $monto = $extra['monto'] * $extra['tasa'];

                $monto1 = $extra['iva'] === '1' ? $monto * $extra['monto1'] : $monto ;

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

        // dd($request->all());
        $preliquidacion = \App\Preliquidacion::create([
                'cliente_id' => $request->cliente_id,
                'user_id' => $request->user_id,
                'base_value' => $request->base_value,
                'aporte_id' => $request->aporte,
                ]);

        foreach ($seriales as $key => $value) {
            PreliquidacionDetalle::create([
                'preliquidacion_id' => $preliquidacion->id,
                'item' => $value->id,
                'cantidad' => 1,
                'tags' => $value->serial,
                'precio' => $value->producto->costo * $value->producto->moneda->valor
            ]);
        }

        foreach ($extras as $extra) {
            PreliquidacionDetalle::create([
                'preliquidacion_id' => $preliquidacion->id,
                'item' => 0,
                'tags' => $extra['nombre'],
                'cantidad' => 1,
                'precio' => $extra['monto'],
                'iva' => $extra['iva'] ? 1 : null,
            ]);
        }

        return redirect()->route('preliquidaciones.printPreliquidacion', $preliquidacion->id);
    }

    public function printPreliquidacion(Preliquidacion $preliquidacion)
    {
        $cliente = Cliente::find($preliquidacion->cliente_id);
        $cantidad = 1;
        $aporte = Aporte::find(1);
        $detalles = \App\PreliquidacionDetalle::where('preliquidacion_id', $preliquidacion->id)->get();

        if ($preliquidacion->id > 909) {
            return view('preliquidaciones.print_preliquidacion2', compact('cliente', 'cantidad', 'aporte', 'preliquidacion', 'detalles'));
        } else {
            return view('preliquidaciones.print_preliquidacion', compact('cliente', 'cantidad', 'aporte', 'preliquidacion', 'detalles'));
        }

    }

    /**
    * Display the specified resource.
    *
    * @param  \App\Preliquidacion  $preliquidacion
    * @return \Illuminate\Http\Response
    */
    public function show(Preliquidacion $preliquidacion)
    {
        //
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  \App\Preliquidacion  $preliquidacion
    * @return \Illuminate\Http\Response
    */
    public function edit(Preliquidacion $preliquidacion)
    {
        //
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\Preliquidacion  $preliquidacion
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request, Preliquidacion $preliquidacion)
    {
        //
    }

    public function reporte(Request $request)
    {
        $dia = $request->fecha ?? now()->format('Y-m-d');
        $preliquidaciones = Preliquidacion::withTrashed()->whereDate('created_at', $dia)->get();

        return view('preliquidaciones.reporte', compact('preliquidaciones', 'dia'));
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  \App\Preliquidacion  $preliquidacion
    * @return \Illuminate\Http\Response
    */
    public function destroy(Preliquidacion $preliquidacion)
    {
        //
    }

    public function anular(Preliquidacion $preliquidacion, Request $request)
    {
        $preliquidacion->delete();

        return redirect()->back();
    }
}