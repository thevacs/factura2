<?php

namespace App\Http\Controllers;

use App\Imports\ManifiestosImport;
use App\Inventario;
use App\Manifiesto;
use App\ManifiestoContenedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ManifiestoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $manifiestos = Manifiesto::orderBy('id', 'DESC')->paginate(20);
        return view('manifiestos.index', compact('manifiestos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('manifiestos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // Validamos los datos recibidos.
        $request->validate([
            'buque' => 'required|string|max:191',
            'fecha' => 'required|date',
            'excel' => 'required|mimes:xlsx,xls',
        ]);

        $excel = $request->file('excel');

        $procesar = $request->procesar == 'on' ? true : false;

        $manifiesto = Manifiesto::create([
            'buque' => $request->buque,
            'fecha' => $request->fecha,
            'created_by' => $request->user()->id,
            'procesador' => $procesar,
        ]);

        $contenedores = Excel::toCollection(new ManifiestosImport, $excel);
        $contenedores = $contenedores[0]->slice(1)->map(function ($row) use ($manifiesto) {
            return new ManifiestoContenedor([
                'manifiesto_id' => $manifiesto->id,
                'linea' => $row[0],
                'buque' => $row[1],
                'viaje' => $row[2],
                'bl' => $row[3],
                'procedencia' => $row[4],
                'comodity' => $row[5],
                'peso' => $row[6],
                'numero' => $row[7],
                'tamano' => $row[8],
                'tipo' => $row[9],
            ]);
        });

        DB::connection('mysql')->disableQueryLog();

        foreach ($contenedores->chunk(500) as $chunk) {
            $manifiesto->contenedores()->insert($chunk->toArray());
        }

        return redirect()->route('manifiestos.index')->with('status', 'El manifiesto ha sido importado con exito.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Manifiesto  $manifiesto
     * @return \Illuminate\Http\Response
     */
    public function show(Manifiesto $manifiesto)
    {
        return view('manifiestos.show', compact('manifiesto'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Manifiesto  $manifiesto
     * @return \Illuminate\Http\Response
     */
    public function edit(Manifiesto $manifiesto)
    {
        return view('manifiestos.edit', compact('manifiesto'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Manifiesto  $manifiesto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Manifiesto $manifiesto)
    {
        // Validamos los datos recibidos.
        $validacion = $request->validate([
            'buque' => 'required|string|max:191',
            'fecha' => 'required|date',
        ]);

        if ($manifiesto->update($validacion)) {
            return redirect()->route('manifiestos.index')->with('status', 'El manifiesto fue editado con exito.');
        } else {
            return redirect()->route('manifiestos.index')->with('error', 'Ocurrio un error al editar el manifiesto');
        }
    }

    public function procesar(Request $request, Manifiesto $manifiesto)
    {
        // dd($manifiesto);

        $manifiesto->procesado = false;

        if ($manifiesto->save()) {
            $inventarios = $manifiesto->contenedores->map(function ($inventario) {
                return collect([
                    'producto_id' => 1,
                    'descripcion' => $inventario->tamano . $inventario->tipo . '-' . $inventario->linea . '-' . $inventario->buque . '-' . $inventario->viaje,
                    'serial' => $inventario->numero,
                    'bl' => $inventario->bl,
                ]);
            });

            // dd($inventarios->whereNull('producto_id'));

            foreach ($inventarios->chunk(500) as $chunk) {
                Inventario::insert($chunk->toArray());
            }
            $manifiesto->procesado = true;
            $manifiesto->save();

            return redirect()->back()->with('status', 'Los contenedores se han cargado al Inventario correctamente.');
        } else {
            return redirect()->back()->with('error', 'Ha ocurrido un error al cargar los contenedores de este manifiesto.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Manifiesto  $manifiesto
     * @return \Illuminate\Http\Response
     */
    public function destroy(Manifiesto $manifiesto)
    {
        //
        $manifiesto->delete();
        return redirect()->back()->with('status', 'El manifiesto se ha borrado con exito.');
    }

    public function destroyContenedores(Manifiesto $manifiesto)
    {
        $manifiesto->procesado = false;

        if ($manifiesto->contenedores()->delete() && $manifiesto->save()) {
            return redirect()->back()->with('status', 'Los contenedores del manifiestos han sido borrados con exito.');
        } else {
            return redirect()->back()->with('error', 'Hay contenedores en uso que no se pueden borrar.');
        }
    }

    public function destroyContenedor(Manifiesto $manifiesto, $contenedor)
    {
        $buscarContenedor = $manifiesto->contenedores()->where('id', $contenedor);

        if ($buscarContenedor->delete()) {
            return redirect()->back()->with('status', 'El contenedor han sido borrado del manifiesto con exito.');
        } else {
            return redirect()->back()->with('error', 'El contenedor esta en uso no se puede borrar.');
        }
    }

    public function updateContenedor(Request $request, Manifiesto $manifiesto, $contenedor)
    {
        // Validamos los datos recibidos.
        $validacion = $request->validate([
            'numero' => 'required',
            'tipo' => 'required',
            'tamano' => 'required',
        ]);

        $buscarContenedor = $manifiesto->contenedores()->where('id', $contenedor);

        if ($buscarContenedor->update($validacion)) {
            return redirect()->back()->with('status', 'El contenedor han sido actualizado del manifiesto con exito.');
        } else {
            return redirect()->back()->with('error', 'Ha ocurrido un error al actualizar el contenedor.');
        }
    }

    public function uploadContenedor(Request $request, Manifiesto $manifiesto)
    {
        // Validamos los datos recibidos.
        $request->validate([
            'excel' => 'required|mimes:xlsx,xls',
        ]);

        $excel = $request->file('excel');

        $contenedores = Excel::toCollection(new ManifiestosImport, $excel);
        $contenedores = $contenedores[0]->slice(1)->map(function ($row) use ($manifiesto) {
            return new ManifiestoContenedor([
                'manifiesto_id' => $manifiesto->id,
                'linea' => $row[0],
                'buque' => $row[1],
                'viaje' => $row[2],
                'bl' => $row[3],
                'procedencia' => $row[4],
                'comodity' => $row[5],
                'peso' => $row[6],
                'numero' => $row[7],
                'tamano' => $row[8],
                'tipo' => $row[9],
            ]);
        });

        DB::connection('mysql')->disableQueryLog();

        foreach ($contenedores->chunk(500) as $chunk) {
            $manifiesto->contenedores()->insert($chunk->toArray());
        }

        return redirect()->back()->with('status', 'Los contenedores han sido importado con exito.');
    }
}