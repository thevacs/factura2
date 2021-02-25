<?php

namespace App\Http\Controllers;

use App\Inventario;
use App\Models\AnulacionFiscal;
use App\Models\Taquilla;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AnulacionFiscalController extends Controller
{

    public function show(AnulacionFiscal $anulacion)
    {
        return view('anulacion.show', compact('anulacion'));
    }

    public function fiscal(AnulacionFiscal $anulacion)
    {
        $string = "";

        $factura = $anulacion->factura;

        $inventario = $factura->items()
            ->join('inventarios', 'inventarios.id', '=', 'facturas_items.inventario_id')
            //->onlyTrashed()
            ->where('serial', $anulacion->contenedor)->first();

            //dd($inventario);

        $string .= "";
        $string .= "iS*" . strtoupper(Str::limit($factura->cliente->nombre, 40, '')) . "\r\n";
        $string .= "iR*" . $factura->cliente->rif . "\r\n";
        $string .= "iF*" . $anulacion->numero_factura_fiscal . "\r\n";
        $string .= "iI*" . $anulacion->impresora . "\r\n";
        $string .= "iD*" . $factura->created_at->format('d-m-y') . "\r\n";
        $string .= "i01DIRECCION: " . strtoupper(Str::limit($factura->cliente->direccion, 40, '')) . "\r\n";

        foreach ($factura->items as $item) {
                $aporte = number_format($item->precio, 2, '', '');
                //$aporteprueba = '0000000400'; //4,00
                $divide = 99000000;

                $div = false;

                if($item->precio >= $divide){
                    $div = true;
                    $nuevoValor = $item->precio / 3;
                    $nuevo = number_format($nuevoValor, 2, '', '');
                }

                if($div){

                    $tasa = "d0";
                    $string .= $tasa . $nuevo . "00001000".strtoupper($item->nombre ?? $item->tags) . "\r\n";
                    $string .= $tasa . $nuevo . "00001000".strtoupper($item->nombre ?? $item->tags) . "\r\n";
                    $string .= $tasa . $nuevo . "00001000".strtoupper($item->nombre ?? $item->tags) . "\r\n";

                } else {
                    $tasa = "d0";
                    $string .= $tasa . $aporte . "00001000".strtoupper($item->nombre ?? $item->tags) . "\r\n";
                }
            }





        $string .= "101\r\n";

        return response($string);
    }

    public function print(Request $request)
    {
        return view('anulacion.show2');
    }

    public function print2(Request $request)
    {
        $usuario = $request->usuario_id;
        $impresora = Taquilla::first();
        $taquilla = $request->taquilla;

        $anulacion = AnulacionFiscal::create([
            'factura_id' => null,
            'user_id' => $usuario,
            'impresora' => $taquilla === 1 ? $impresora->taquilla1 : $impresora->taquilla2,
            'numero_factura_fiscal' => $request->nf_factura,
            'contenedor' => $request->contenedor,
            'contenedor' => $request->contenedor
        ]);

        return redirect()->route('anulacion.show', $anulacion->id);
    }

}
