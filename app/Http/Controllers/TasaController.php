<?php

namespace App\Http\Controllers;

use App\Tasa;
use Illuminate\Http\Request;

class TasaController extends Controller
{
  /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function index()
  {
    $tasas = Tasa::paginate();
    return view('tasas.index', compact('tasas'));
  }

  /**
  * Show the form for creating a new resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function create()
  {
    return view('tasas.create');
  }

  /**
  * Store a newly created resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @return \Illuminate\Http\Response
  */
  public function store(Request $request)
  {
    //
  }

  /**
  * Display the specified resource.
  *
  * @param  \App\Tasa  $tasa
  * @return \Illuminate\Http\Response
  */
  public function show(Tasa $tasa)
  {
    //
  }

  /**
  * Show the form for editing the specified resource.
  *
  * @param  \App\Tasa  $tasa
  * @return \Illuminate\Http\Response
  */
  public function edit(Tasa $tasa)
  {
    return view('tasas.edit', compact('tasa'));
  }

  /**
  * Update the specified resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @param  \App\Tasa  $tasa
  * @return \Illuminate\Http\Response
  */
  public function update(Request $request, Tasa $tasa)
  {
    $tasa->update($request->all());
    return redirect()->route('tasas.index');
  }

  /**
  * Remove the specified resource from storage.
  *
  * @param  \App\Tasa  $tasa
  * @return \Illuminate\Http\Response
  */
  public function destroy(Tasa $tasa)
  {
    //
  }
}
