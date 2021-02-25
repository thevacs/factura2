@extends('layouts.app')
@section('content')
@php
$contenedores = $preliquidacion->detalles()->whereNotIn('item', [0])->get();
$extras = $preliquidacion->detalles()->where('item', [0])->get();
$exento = $preliquidacion->detalles()->WhereNull('iva')->sum('precio');
$iva = $preliquidacion->detalles()->where('iva', 1)->sum('precio');
@endphp
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
                <h4 class="text-center font-bold">ESTE DOCUMENTO NO ES VÁLIDO PARA EL TRANSITO DEL CONTENEDOR, EN EL ESTADO LA GUAIRA</h4>
            </p>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <h2 class="text-center">Preliquidación {{ sprintf('%06d', $preliquidacion->id) }}</h2>
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
                <div class="card-header"> <b>Contenido de la Preliquidación</b> </div>
                <div class="card-body">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th class="text-center">Cantidad</th>
                                <th class="text-center">Producto</th>
                                <th class="text-right">Precio</th>
                                <th class="text-right">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $contenedores->count() }}</td>
                                <td>
                                    {{ \App\Aporte::find($preliquidacion->aporte_id)->nombre }} (E)<br>
                                    <hr>
                                    <span>Seriales:</span> <br>
                                    <span>
                                        @foreach ($contenedores as $item)
                                            <b>{{ $item->tags }}</b>
                                        @endforeach
                                    </span>
                                </td>
                                @php
                                $precio = $contenedores->first()->precio;
                                @endphp
                                <td class="text-right"><b>{{ number_format($precio,2) }}</b></td>
                                <td class="text-right">
                                    <b>{{ number_format($contenedores->count() * $precio,2) }}</b>
                                </td>
                            </tr>
                            @foreach ($extras as $extra)
                            <tr>
                                <td>{{ $extra->cantidad }}</td> 
                                <td>{{ $extra->tags }} {{ $extra->iva ? '(G)' : '(E)' }}</td> 
                                <td class="text-right"><b>{{ number_format($extra->precio,2) }}</b></td> 
                                <td class="text-right"><b>{{ number_format($extra->precio,2) }}</b></td> 
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-right"></td>
                                <td class="text-right"></td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-right">EXENTO (E)</td>
                                <td class="text-right"><b>{{ number_format($exento,2) }}</b></td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-right">BI G (16%)</td>
                                <td class="text-right"><b>{{ number_format($iva,2) }}</b></td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-right">IVA G (16%)</td>
                                <td class="text-right"><b>{{ number_format($iva*0.16,2) }}</b></td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <h6><b>ESTE DOCUMENTO NO ES VÁLIDO PARA EL TRANSITO DEL CONTENEDOR, EN EL ESTADO LA GUAIRA</b></h6>
                                </td>
                                <td colspan="1" class="text-right">Total</td>
                                <td class="text-right"><b>{{ number_format($exento+$iva+($iva*0.16),2) }}</b></td>
                            </tr>
                        </tfoot>
                    </table>
                    <span><b>Tipo de Cambio: {{ number_format(\App\Moneda::find(2)->valor,2) }}</b></span> <br>
                    <small>
                        Esta Preliquidación no es una factura comercial, la factura definitiva se imprimira al momento de efectuar el pago.
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection