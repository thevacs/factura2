<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class DivisaController extends Controller
{
    public $Endpoint;

    public function __construct()
    {
        $this->Endpoint = 'https://api.gonavi.com.ve/v1/divisas';
    }


    public function getDivisas()
    {
        $client = new Client();
        $response = $client->request('GET', $this->Endpoint);
        $query = $response->getBody()->getContents();
        $results = \json_decode($query, true);

        dd($results);

    }
}
