@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <a class="d-print-none btn btn-sm btn-info text-white" href="#" onclick="window.print()">Imprimir</a>
        </div>
    </div>
    <div class="row">
        <div class="col d-flex justify-content-center">
            <img class="img-fluid" style="max-height: 160px;" src="{{ asset('storage/img/5.png') }}" alt="">
        </div>
    </div>

    <div class="row">
        <div class="col">
            <p class="text-center">
                <b>{{ Config::get('empresa.nombre') }}</b> <br>
                <b>RIF: {{ Config::get('empresa.rif') }}</b> <br>
                <b>{{ Config::get('empresa.direccion') }}</b>
                <br />
                <br />
                <h4 class="text-center font-bold">ESTE DOCUMENTO ES VÁLIDO PARA EL TRANSITO DEL CONTENEDOR, EN EL ESTADO LA GUAIRA</h4>
            </p>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <h2 class="text-center">Exoneracion {{ sprintf('%06d', $preliquidacion->id) }}</h2>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <span class="float-right">
                <p>{{ now() }}</p>
            </span>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header"> <b>Cliente</b> </div>
                <div class="card-body">
                    <p>
                        RIF: <b>{{ $cliente->rif }}</b> <br>
                        Cliente: <b>{{ $cliente->nombre }}</b> <br>
                        Dirección: <b>{{ $cliente->direccion }}</b>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="row my-2">
        <div class="col">
            <div class="card">
                <div class="card-header"> <b>Contenido de la Exoneración</b> </div>
                <div class="card-body">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Cantidad</th>
                                <th>Descripción</th>
                                <th>Precio</th>
                                <th>Importe</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td scope="row">{{ $detalles->count() }}</td>
                                <td>
                                    <b>{{ \App\Aporte::find($preliquidacion->aporte_id)->nombre }}</b> <br>
                                    {{ $detalles->first()->inventario->producto->nombre }} X {{ $detalles->count() }}
                                    <hr>
                                    <span>Seriales:</span> <br>
                                    <span>
                                        @foreach ($detalles as $item)
                                         {{ $item->inventario->serial }}
                                        @endforeach
                                    </span>
                                    <br>

                                </td>
                                <td class="text-right">
                                    {{ number_format(\App\Aporte::find($preliquidacion->aporte_id)->valor * \App\Aporte::find($preliquidacion->aporte_id)->moneda->valor,2) }}
                                </td>
                                <td class="text-right">
                                    {{ number_format($detalles->count() * (\App\Aporte::find($preliquidacion->aporte_id)->valor * \App\Aporte::find($preliquidacion->aporte_id)->moneda->valor),2) }}
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td class="text-right" colspan="3">Sub total Preliquidación</td>
                                <td class="text-right">{{ number_format($detalles->count() * (\App\Aporte::find($preliquidacion->aporte_id)->valor * \App\Aporte::find($preliquidacion->aporte_id)->moneda->valor),2) }}</td>
                            </tr>
                            <tr>
                                <td class="text-right" colspan="3">IVA (0%)</td>
                                <td class="text-right">{!! number_format(0,2) !!}</td>
                            </tr>
                            <tr>
                                <td class="text-right" colspan="3">Total Preliquidación</td>
                                <td class="text-right">{{ number_format($detalles->count() * (\App\Aporte::find($preliquidacion->aporte_id)->valor * \App\Aporte::find($preliquidacion->aporte_id)->moneda->valor),2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                    <span><b>Tipo de Cambio: {{ number_format(\App\Moneda::find(2)->valor,2) }}</b></span> <br>
                    <small>
                        Esta Exoneración no es una factura comercial, la factura definitiva se imprimira al momento de efectuar el pago.
                    </small>
                    @if (now() <= '2020-05-07' ) <p><b>Exonerado desde el 4 de Mayo 2020 hasta el 7 de Mayo 2020</b></p>
                        @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection