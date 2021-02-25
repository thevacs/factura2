<?php

namespace App\Http\Controllers;

use App\Contenedor;
use Illuminate\Http\Request;

class ContenedorController extends Controller
{
  /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function index()
  {
    $contenedores = Contenedor::paginate();
    return view('contenedores.index', compact('contenedores'));
  }

  /**
  * Show the form for creating a new resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function create()
  {
    //
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
  * @param  \App\Contenedors  $contenedors
  * @return \Illuminate\Http\Response
  */
  public function show(Contenedors $contenedors)
  {
    //
  }

  /**
  * Show the form for editing the specified resource.
  *
  * @param  \App\Contenedors  $contenedors
  * @return \Illuminate\Http\Response
  */
  public function edit(Contenedors $contenedors)
  {
    //
  }

  /**
  * Update the specified resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @param  \App\Contenedors  $contenedors
  * @return \Illuminate\Http\Response
  */
  public function update(Request $request, Contenedors $contenedors)
  {
    //
  }

  /**
  * Remove the specified resource from storage.
  *
  * @param  \App\Contenedors  $contenedors
  * @return \Illuminate\Http\Response
  */
  public function destroy(Contenedors $contenedors)
  {
    //
  }
}
