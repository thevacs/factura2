<?php

namespace App\Http\Controllers;

use App\FacturaItem;
use App\ExoneracionDetalle;
use App\Inventario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['validacion', 'validacion2']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $contenedor = $request->contenedor;
        $resultados = null;
        $exoneraciones = null;
        $noFacturado = null;

        if ($contenedor) {
            $resultados = FacturaItem::with('factura')
                ->join('inventarios', 'facturas_items.inventario_id', '=', 'inventarios.id')
                ->where('inventarios.serial', 'like', '%' . $contenedor . '%')
                ->get();

            if ($resultados->count() < 1) {
                $exoneraciones =  ExoneracionDetalle::join('inventarios', 'item', '=', 'inventarios.id')
                    ->join('exoneraciones', 'exoneracion_detalles.exoneracion_id', '=', 'exoneraciones.id')
                    ->where('inventarios.serial', 'like', '%' . $contenedor . '%')
                    ->get();

                if ($exoneraciones->count() < 1) {
                    $noFacturado = Inventario::select('descripcion', 'serial', 'bl')->where('serial', $contenedor)->get()->first();
                }
            }
        }

        return view('home', compact('resultados', 'exoneraciones', 'noFacturado'));
    }

    public function validacion()
    {
        return view('validacion.home');
    }

    public function validacion2(Request $request)
    {
        if ($request->id) {
            $contenedor = FacturaItem::with('factura')
                ->join('inventarios', 'facturas_items.inventario_id', '=', 'inventarios.id')
                ->where('inventarios.serial', substr(request()->id, 0, 11))
                ->first();

            if ($contenedor === null) {
                $contenedor2 = ExoneracionDetalle::join('inventarios', 'item', '=', 'inventarios.id')
                    ->join('exoneraciones', 'exoneracion_detalles.exoneracion_id', '=', 'exoneraciones.id')
                    ->where('inventarios.serial', substr(request()->id, 0, 11))
                    ->get()->first();

                    if($contenedor2 === null){
                        $contenedor3 = Inventario::select('descripcion', 'serial', 'bl')->where('serial', substr(request()->id, 0, 11))->get()->first();
                        return response()->json(['data' => $contenedor3, 'tipo' => 'noFacturado'], 200);
                    }
                    return response()->json(['data' => $contenedor2, 'tipo' => 'exonerado'], 200);
            } else {
                return response()->json(['data' => $contenedor, 'tipo' => 'facturado'], 200);
            }
        }

        

        $contenedores = FacturaItem::with('inventario')->selectRaw('CONCAT(inventarios.serial, " (FACTURADO)") AS serial')
            ->join('inventarios', 'facturas_items.id', '=', 'inventarios.id')
            ->join('facturas', 'facturas_items.factura_id', '=', 'facturas.id')
            ->where('facturas.anulada', 0)->get()->pluck('serial');

        $contenedores2 = ExoneracionDetalle::selectRaw('CONCAT(inventarios.serial, " (EXONERADO)") AS serial')
            ->join('inventarios', 'item', '=', 'inventarios.id')
            ->join('exoneraciones', 'exoneracion_detalles.exoneracion_id', '=', 'exoneraciones.id')
            ->get()
            ->pluck('serial');

        $contenedores3 = Inventario::selectRaw('CONCAT(serial, " (NO FACTURADO)") AS serial')
            ->where('deleted_at', null)
            ->get()
            ->pluck('serial');

        return response()->json($contenedores3->merge($contenedores2->merge($contenedores)));
    }
}
