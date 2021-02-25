<?php

namespace App\Http\Controllers;

use App\Impuesto;
use Illuminate\Http\Request;

class ImpuestoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $impuestos = Impuesto::paginate();
        return view('impuestos.index', compact('impuestos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('impuestos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'nombre' => 'required|string|max:191',
            'acronimo' => 'required|string|unique:impuestos',
            'descripcion' => 'nullable',
            'valor' => 'required|numeric',
            'vigencia_ini' => 'required|date',
            'vigencia_fin' => 'required|date|after_or_equal:vigencia_ini',
        ]);

        Impuesto::create([
            'nombre' => $request->nombre,
            'acronimo' => $request->acronimo,
            'descripcion' => $request->descripcion,
            'valor' => (float) $request->valor,
            'vigencia_ini' => $request->vigencia_ini,
            'vigencia_fin' => $request->vigencia_fin,
        ]);

        return redirect('impuestos');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Impuesto  $impuesto
     * @return \Illuminate\Http\Response
     */
    public function show(Impuesto $impuesto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Impuesto  $impuesto
     * @return \Illuminate\Http\Response
     */
    public function edit(Impuesto $impuesto)
    {
        return view('impuestos.edit', compact('impuesto'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Impuesto  $impuesto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Impuesto $impuesto)
    {
        $request->validate([
            'nombre' => 'required|string|max:191',
            'acronimo' => 'required|string|unique:impuestos,acronimo,' . $impuesto->id,
            'descripcion' => 'nullable',
            'valor' => 'required|numeric',
            'vigencia_ini' => 'required|date',
            'vigencia_fin' => 'required|date|after_or_equal:vigencia_ini',
        ]);

        $impuesto->update($request->all());
        return redirect('impuestos');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Impuesto  $impuesto
     * @return \Illuminate\Http\Response
     */
    public function destroy(Impuesto $impuesto)
    {
        dd($impuesto);
    }
}
