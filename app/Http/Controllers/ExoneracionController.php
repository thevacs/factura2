<?php

namespace App\Http\Controllers;

use App\Exoneracion;
use App\ExoneracionDetalle;
use App\Aporte;
use App\Cliente;
use App\Inventario;
use App\Moneda;

use Illuminate\Http\Request;

class ExoneracionController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index(Request $request)
    {
        $preliquidaciones = Exoneracion::orderByDesc('id')
        ->when(request()->buscar, function ($query, $buscar) {
            $ids = Cliente::where('nombre', 'like', '%' . $buscar . '%')->select('id')->get()->pluck('id');
            $inv = Inventario::where('serial', 'like', '%' . $buscar . '%')
                            ->orWhere('bl', 'like', '%' . $buscar . '%')
                            ->select('id')
                            ->withTrashed()
                            ->get()
                            ->pluck('id');

            $exo = ExoneracionDetalle::whereIn('item', $inv)->select('exoneracion_id')->get()->pluck('exoneracion_id');

            if ($ids->isEmpty()) {
                return $query->whereIn('exoneraciones.id', $exo);
            } else {
                return $query->whereIn('cliente_id', $ids);
            }

        })
        ->paginate();
        return view('exoneraciones.index', compact('preliquidaciones'));
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
            return view('exoneraciones.create', compact('monedas', 'aportes'));
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

        foreach ($request->seriales as $serial) {
            $contenedores->push($serial['id']);
        }

        $seriales = Inventario::whereIn('id', $contenedores)
            ->select('id', 'producto_id', 'serial', 'bl', 'descripcion')
            ->get();

        // dd($request->all());
        $preliquidacion = \App\Exoneracion::create([
                'cliente_id' => $request->cliente_id,
                'user_id' => $request->user_id,
                'base_value' => $request->base_value,
                'aporte_id' => $request->aporte,
                ]);

        foreach ($seriales as $key => $value) {
            ExoneracionDetalle::create([
                        'exoneracion_id' => $preliquidacion->id,
                        'item' => $value->id,
                        'cantidad' => 1,
                ]);

            Inventario::find($value->id)->delete();
        }

        return redirect()->route('exoneraciones.printPreliquidacion', $preliquidacion->id);
    }

    public function printPreliquidacion(Exoneracion $exoneracion)
    {
        $preliquidacion = $exoneracion;
        $cliente = Cliente::find($exoneracion->cliente_id);
        $cantidad = 1;
        $aporte = Aporte::find(1);
        $detalles = \App\ExoneracionDetalle::where('exoneracion_id', $exoneracion->id)->get();

        return view('exoneraciones.print_preliquidacion', compact('cliente', 'cantidad', 'aporte', 'preliquidacion', 'detalles'));
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
    public function update(Request $request, Exoneracion $exoneracion)
    {
        //
    }

    public function reporte(Request $request)
    {
        $dia = $request->fecha ?? now()->format('Y-m-d');
        $preliquidaciones = Exoneracion::withTrashed()->whereDate('created_at', $dia)->get();

        return view('exoneraciones.reporte', compact('preliquidaciones', 'dia'));
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

    public function anular(Exoneracion $exoneracion, Request $request)
    {
        $exoneracion->delete();

        return redirect()->back();
    }
}