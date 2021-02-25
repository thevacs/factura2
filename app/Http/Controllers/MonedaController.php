<?php

namespace App\Http\Controllers;

use App\Http\Resources\CurrencyResource;
use App\Moneda;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class MonedaController extends Controller
{
    public $Endpoint;

    public function __construct()
    {
        $this->Endpoint = 'https://api.gonavi.com.ve/v1/divisas';
    }

    protected function getDivisas()
    {
        $client = new Client();
        $response = $client->request('GET', $this->Endpoint);
        $query = $response->getBody()->getContents();
        $results = collect(\json_decode($query, true));

        return CurrencyResource::collection($results);
    }

    public function is_connect()
    {
        $connect = fsockopen("gonavi.com.ve", 443, $errno, $errstr, 30);
        if ($connect) {
            $is_conn = true;
            fclose($connect);
        } else {
            $is_conn = false;
        }
        return $is_conn;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $monedas = Moneda::all();
        $connect = $this->is_connect();

        if ($connect && $request->actualizar) {
            $currency = $this->getDivisas();
            if ($currency) {

                foreach ($currency->collection as $key => $value) {
                    $valor1 = str_replace('.', '', $value->resource['proveedores'][0]['valores'][0]['precio']);
                    $valor2 = (float) str_replace(',', '.', $valor1);

                    Moneda::where('codigo', $value->resource['codigo'])->update(['valor' => $valor2]);
                }

            }

        }

        return view('monedas.index', compact('monedas', 'connect'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('monedas.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Moneda::create($request->all());
        return redirect()->route('monedas.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Moneda  $moneda
     * @return \Illuminate\Http\Response
     */
    public function show(Moneda $moneda)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Moneda  $moneda
     * @return \Illuminate\Http\Response
     */
    public function edit(Moneda $moneda)
    {
        return view('monedas.edit', compact('moneda'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Moneda  $moneda
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Moneda $moneda)
    {
        $moneda->update($request->all());
        return redirect()->route('monedas.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Moneda  $moneda
     * @return \Illuminate\Http\Response
     */
    public function destroy(Moneda $moneda)
    {
        //
    }
}
