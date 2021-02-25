<?php

namespace App\Http\Controllers;

use App\Models\TipoPago;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ArqueoCajaController extends Controller
{
    public function __construct() {
    }

    public function index(Request $request, $fecha)
    {
        $fechaCarbon = Carbon::parse($fecha);
        if (in_array($request->user()->id, [10, 11])) {
            $taquillas = User::find([10,11]);
        } else {
            $taquillas = User::find([3, 4]);
        }
        
        $tipopagos = TipoPago::orderBy('nombre', 'ASC')->get();
        return view('arqueo.index', compact('taquillas', 'tipopagos', 'fechaCarbon'));
    }

    public function taquilla(Request $request, $fecha, User $taquilla)
    {
        $user = $taquilla;
        $fechaCarbon = Carbon::parse($fecha);

        if (in_array($request->user()->id, [10, 11])) {
            $taquillas = User::find([10, 11]);
        } else {
            $taquillas = User::find([3, 4]);
        }

        $tipopagos = TipoPago::orderBy('nombre', 'ASC')->get();
        return view('arqueo.taquilla', compact('taquillas', 'tipopagos', 'user', 'fechaCarbon'));
    }
}
