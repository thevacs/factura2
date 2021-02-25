<?php

namespace App\Http\Controllers;

use App\Contenedor;
use App\Models\Contenedor as GnaviContenedor;
use App\Models\Tipo;
use DB;

class DataController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function getDataContenedors()
    {
        if (Contenedor::count() == 0) {
            DB::statement('INSERT INTO contenedors(numero,tamano,tipo,descripcion,iso)
      SELECT a.numero, b.tamano, b.tipo, b.descripcion, c.iso
      FROM ecxplutinte.contenedores AS a
      JOIN ecxplutinte.tipos AS b ON a.tipo_id = b.id
      JOIN ecxplutinte.tipo_isos AS c ON b.tipo_iso_id = c.id;');
            return redirect()->route('contenedores.index');
        } else {
            toast('La Tabla ya tiene datos!', 'warning', 'top-right');
            return redirect()->route('contenedores.index');
        }
    }

    public function getContenedor($numero)
    {
        $contenedor = GnaviContenedor::with('tipo:id,tamano,tipo,descripcion,teus,tipo_iso_id')
            ->where('numero', $numero)->get();
        if ($contenedor->count() == 1) {
            $data = collect([
                'numero' => $contenedor->first()->numero,
                'tamano' => $contenedor->first()->tipo->tamano,
                'tipo' => $contenedor->first()->tipo->tipo,
                'descripcion' => $contenedor->first()->tipo->descripcion,
                'iso' => $contenedor->first()->tipo->iso->first()->iso,
            ]);
            return $data;
        } else if ($contenedor->count() == 0) {
            die('error');
        } else if ($contenedor->count() > 1) {
            die('error');
        }
    }

    public function getContenedorsLocal()
    {
        $contenedores = Contenedor::select('numero')
            ->cursor()
            ->filter(function ($contenedor) {
                return $contenedor;
            });

        $results = array_column($contenedores->toArray(), 'numero');
        return response()->json($results);
    }

    public function getContenedorLocalData($numero)
    {
        $resultado = Contenedor::where('numero', $numero)->get()->first();
        return $resultado;
    }

}
