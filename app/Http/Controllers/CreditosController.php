<?php

namespace App\Http\Controllers;

use App\Cliente;
use App\Models\NotaCredito;
use Illuminate\Http\Request;

class CreditosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if ($request->usada) {
            $facturas = NotaCredito::where('usada', 1)->orderby('id', 'DESC')->get();
        } else {
            $facturas = NotaCredito::where('usada', 0)->orderby('id', 'DESC')->get();
        }

        return view('creditos.index', compact('facturas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('creditos.create');
    }

    public function store(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'cliente_id' => 'required',
            'observacion' => 'sometimes',
        ]);

        $factura = NotaCredito::create([
            'cliente_id' => $request->cliente_id,
            'created_by' => auth()->user()->id,
            'observacion' => $request->observacion,
            'monto' => $request->monto,
        ]);

        return redirect()->route('creditos.show', $factura->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Factura  $factura
     * @return \Illuminate\Http\Response
     */
    public function show(NotaCredito $credito)
    {
        return view('creditos.show', compact('credito'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Factura  $factura
     * @return \Illuminate\Http\Response
     */
    public function edit(NotaCredito $credito)
    {
        $clientes = Cliente::orderBy('nombre')->get()->pluck('nombre','id');
        return view('creditos.edit', compact('credito','clientes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Factura  $factura
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, NotaCredito $credito)
    {
        $credito->update([
            'cliente_id' => $request->cliente_id,
        ]);

        return redirect()->route('creditos.index')->with('status', 'Actualizado con exito.');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Factura  $factura
     * @return \Illuminate\Http\Response
     */
    public function destroy(NotaCredito $credito)
    {
        $credito->delete();
        return redirect()->route('creditos.index');
    }
}
