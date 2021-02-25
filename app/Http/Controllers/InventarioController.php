<?php

namespace App\Http\Controllers;

use App\Inventario;
use Illuminate\Http\Request;

class InventarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $inventarios = Inventario::when(request()->buscar, function ($query, $buscar) {
            return $query->Where('serial', 'like', '%' . $buscar . '%')
                ->orWhere('bl', 'like', '%' . $buscar . '%');
        })
            ->paginate();

        return view('inventarios.index', compact('inventarios'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('inventarios.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'producto_id' => 'required|numeric',
            'descripcion' => 'required|string|max:191',
            'serial' => 'required|string|max:11',
            'bl' => 'required'
        ]);

        Inventario::create($request->all());
        toast('Item Registrado!', 'success', 'top-right');
        return redirect('inventarios')->with('status', 'Item Registrado');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Inventario  $inventario
     * @return \Illuminate\Http\Response
     */
    public function show(Inventario $inventario)
    {
        //
    }

    public function getItems()
    {
        return Inventario::all();
    }

    public function autocomplete()
    {
        $contenedores = Inventario::select('serial')->get()->pluck('serial');
        $bls = Inventario::select('bl')->groupBy('bl')->get()->pluck('bl');
        return response()->json($bls->merge($contenedores));
    }

    public function searchItem($neddle)
    {
        $search = Inventario::orWhere('serial', 'like', '%' . $neddle . '%')
            ->orWhere('bl', 'like', '%' . $neddle . '%')
            ->get();

        if ($search->count() == 1) {
            $searchBL = Inventario::where('bl', $search->first()->bl)
                ->get();
            if ($searchBL->first()->bl == '' || $searchBL->first()->bl == null) {
                $results = -1;
            } else {
                $results = $searchBL;
            }
        } elseif ($search->count() > 1) {
            $results = $search;
        } elseif ($search->isEmpty()) {
            $results = false;
        }

        return response()->json($results);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Inventario  $inventario
     * @return \Illuminate\Http\Response
     */
    public function edit(Inventario $inventario)
    {
        return view('inventarios.edit', compact('inventario'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Inventario  $inventario
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Inventario $inventario)
    {
        $request->validate([
            'producto_id' => 'required|numeric',
            'descripcion' => 'required|string|max:191',
            'serial' => 'required|string|max:11',
            'bl' => 'required'
        ]);

        $inventario->update($request->all());
        if ($inventario->isDirty()) {
            toast('Item Actualizado!', 'success', 'top-right');
            return redirect('inventarios')->with('status', 'Item Actualizado');
        } else {
            return redirect('inventarios')->with('status', 'Item sin cambios');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Inventario  $inventario
     * @return \Illuminate\Http\Response
     */
    public function destroy(Inventario $inventario)
    {
        //
    }
}