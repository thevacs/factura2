<?php

namespace App\Http\Controllers;

use App\Aporte;
use Illuminate\Http\Request;

class AporteController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $aportes = Aporte::all();
        return view('aportes.index', compact('aportes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('aportes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Aporte::create($request->all());
        return redirect()->route('aportes.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Aporte  $aporte
     * @return \Illuminate\Http\Response
     */
    public function show(Aporte $aporte)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Aporte  $aporte
     * @return \Illuminate\Http\Response
     */
    public function edit(Aporte $aporte)
    {
        return view('aportes.edit', compact('aporte'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Aporte  $aporte
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Aporte $aporte)
    {
        $aporte->nombre = $request->nombre;
        $aporte->descripcion = $request->descripcion;
        $aporte->acronimo = $request->acronimo;
        $aporte->moneda_id = $request->moneda_id;
        $aporte->valor = $request->valor;
        $aporte->save();
        return redirect()->route('aportes.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Aporte  $aporte
     * @return \Illuminate\Http\Response
     */
    public function destroy(Aporte $aporte)
    {
        //
    }
}
