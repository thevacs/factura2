<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Notifications\ProfitVC as NProfitVC;
use App\User;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;

class ProfitVC extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'profit:vargascontainer';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Ganancias de vargas container';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $usuario = User::find(1);

        $client = new Client;
        $response = $client->get('https://api.gonavi.com.ve/v1/divisas');
        $code = $response->getStatusCode();

        if ($code == 200) {
            $respuesta = $response->getBody();
            $respuesta = json_decode($respuesta, true);

            $tasaDia = $respuesta[0]['proveedores'][0]['valores'][0]['precio'];

            $tasaDia = str_replace('.', '', $tasaDia);
            $tasaDia = (float) str_replace(',', '.', $tasaDia);
        } else {
            $tasaDia = false;
        }

        $fecha = now()->format('Y-m-d');
        $fecha2 = now()->format('n');

        $diario = DB::table('facturas_items')
                    ->join('facturas', 'facturas.id', '=', 'facturas_items.factura_id')
                    ->selectRaw('COUNT(facturas_items.id) as cantidad,	SUM(facturas_items.precio) as total')
                    ->whereDate('facturas_items.created_at', $fecha)
                    ->where('facturas.anulada', 0)
                    ->first();

        $diarioF = DB::table('facturas')
                    ->selectRaw('COUNT(facturas.id) as cfacturas')
                    ->whereDate('facturas.created_at', $fecha)
                    ->where('facturas.anulada', 0)
                    ->first();

        $mes = DB::table('facturas_items')
                    ->join('facturas', 'facturas.id', '=', 'facturas_items.factura_id')
                    ->selectRaw('COUNT(facturas_items.id) as cantidad, SUM(facturas_items.precio) as total')
                    ->whereMonth('facturas_items.created_at', $fecha2)
                    ->where('facturas.anulada', 0)
                    ->first();

        $mesF = DB::table('facturas')
                    ->selectRaw('COUNT(facturas.id) as cfacturas')
                    ->whereMonth('facturas.created_at', $fecha2)
                    ->where('facturas.anulada', 0)
                    ->first();

        // diario
        $facturas = number_format($diarioF->cfacturas,0,',','.');
        $contenedores = number_format($diario->cantidad,0,',','.');
        $monto = $diario->total;
        $monto2 = number_format($diario->total,2,',','.');
        $montoD = number_format(round($monto / $tasaDia, 2), 2, ',', '.');

        // mensual
        $facturasMes = number_format($mesF->cfacturas,0,',','.');
        $contenedoresMes = number_format($mes->cantidad,0,',','.');
        $montoMes = $mes->total;
        $montoMes2 = number_format($mes->total,2,',','.');
        $montoMesD = number_format(round($montoMes / $tasaDia, 2), 2, ',', '.');
        
        $tasaDia2 = number_format($tasaDia,2,',','.');

        if ($tasaDia) {

            $mensaje = "📈 *Reporte Ingresos Vargas Container* 📈\n\n📅 Fecha: *".now()->format('Y-m-d'). "*\nTasa del día *BCV* Bs. *" . $tasaDia2 . "*\n\n💳 Facturas: *" . $facturas . "*\n🚚 Contenedores: *".$contenedores. "*\n💰 Total Facturado: ** Bs. * ". $monto2."* (💵$ ". $montoD. ")\n\n💳 Mes Facturas: *" . $facturasMes . "*\n🚚 Mes Contenedores: *" . $contenedoresMes . "* 🎰\n💰 Mes Total Facturado: ** Bs. * " . $montoMes2 . "* (💵$ " . $montoMesD . ")\n\nUltima actualización _".now()."_";
        } else {

            $mensaje = "📈 *Reporte Ingresos Vargas Container* 📈\n\n📅 Fecha: *" . now()->format('Y-m-d') . "*\nTasa del día *BCV* Bs. *" . $tasaDia2 . "*\n\n💳 Facturas: *" . $facturas . "*\n🚚 Contenedores: *" . $contenedores . "*\n💰 Total Facturado: ** Bs. * " . $monto2 . "*\n\n💳 Mes Facturas: *" . $facturasMes . "*\n🚚 Mes Contenedores: *" . $contenedoresMes . "* 🎰\n💰 Mes Total Facturado: ** Bs. * " . $montoMes2 . "*\n\nUltima actualización _" . now() . "_";
        }
        
        $usuario->notify(new NProfitVC($mensaje));
    }
}