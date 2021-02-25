<?php

namespace App\Http\Controllers;

use App\Aporte;
use App\Moneda;
use App\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $productos = Producto::paginate();
        return view('productos.index', compact('productos'));
    }

    public function lists(Request $request)
    {
        $productos = Producto::select('id','nombre','costo', 'iva')
                        ->whereNotIn('id',[1])
                        ->orderBy('id')
                        ->get();
        return response()->json($productos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('productos.create');
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
            'nombre' => 'required|string|unique:productos|max:191',
            'servicio' => 'sometimes|boolean',
            'tamano' => 'sometimes',
            'tipo' => 'sometimes',
            'moneda_id' => 'required',
            'costo' => 'required|numeric',
            'base1' => 'required|numeric',
            'aporte' => 'sometimes|numeric',
            'iva' => 'sometimes|numeric',
        ]);

        Producto::create($request->all());
        return redirect()->route('productos.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function show(Producto $producto)
    {
        //
    }

    public function getProducto(Producto $producto)
    {
        $moneda = Moneda::find($producto->moneda_id);
        $monto = $moneda->valor * $producto->costo;
        if ($producto->aporte > 0) {
            $aporte = Aporte::find($producto->aporte);
            $valor_aporte = getValueForCalc($aporte->moneda_id, $aporte->valor);
        }
        return [
            'id' => $producto->id,
            'nombre' => $producto->nombre,
            'tamano' => $producto->tamano,
            'tipo' => $producto->tipo,
            'moneda' => $moneda->nombre,
            'simbolo' => $moneda->simbolo,
            'valor' => $moneda->valor,
            'costo' => $producto->costo,
            'monto' => $producto->costo * $moneda->valor,
            'aporte_id' => $producto->aporte ? $producto->aporte : null,
            'aporte' => $producto->aporte ? $valor_aporte : null,
            'iva' => $producto->iva,
        ];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function edit(Producto $producto)
    {
        return view('productos.edit', compact('producto'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Producto $producto)
    {
        $producto->update($request->all());
        return redirect()->route('productos.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function destroy(Producto $producto)
    {
        //
    }
}
