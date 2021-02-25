@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <p class="text-center">
                <small><b>{{ Config::get('empresa.nombre') }}</b></small><br>
                <small><b>RIF: {{ Config::get('empresa.rif') }}</b></small><br>
                <small><b>{{ Config::get('empresa.direccion') }}</b></small>
            </p>
            <a class="d-print-none btn btn-sm btn-info text-white" href="#" onclick="window.print()">IMPRIMIR</a>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <span class="float-left">
                {!!QrCode::size(160)->generate(sprintf('%06d', $credito->id)) !!}
            </span>
        </div>
        <div class="col">
            <img class="img-fluid float-right" style="max-height: 160px;" src="{{ asset('storage/img/5.png') }}" alt="">
        </div>
    </div>
    <div class="row">
        <div class="col">
            <h2 class="text-center">NOTA DE CRÉDITO {{ sprintf('%06d', $credito->id) }}</h2>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <span class="float-right"><small>{{ $credito->created_at }}</small></span>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <span class="float-right">NOTA CRÉDITO: <b class="text-danger">#{{ sprintf('%06d', $credito->id) }}</b></span>
            <small>RIF: <b>{{ $credito->cliente->rif }}</b> </small> <br>
            <small>Cliente: <b>{{ $credito->cliente->nombre }}</b> </small> <br>
            <small>Dirección: <b>{{ $credito->cliente->direccion }}</b> </small> <br>
        </div>
    </div>
    <div class="row my-2">
        <div class="col">
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
                        <td></td>
                        <td>
                            {{ $credito->observacion }}
                        </td>

                        <td class="text-right"> </td>
                        <td class="text-right">
                            {{ number_format($credito->monto,2) }}
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="text-right">Sub-Total</td>
                        <td class="text-right">{{ number_format($credito->monto,2) }}</td>
                    </tr>
                    <tr>
                        <td colspan="3" class="text-right">IVA (0%)</td>
                        <td class="text-right">{{ number_format(0,2) }}</td>
                    </tr>
                    <tr>
                        <td colspan="2">

                        </td>
                        <td colspan="1" class="text-right">Total</td>
                        <td class="text-right">{{ number_format($credito->monto,2) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<script>
    function facturar() {
        window.print()
    }
</script>
@endsection