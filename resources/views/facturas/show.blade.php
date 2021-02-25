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
            <a class="d-print-none btn btn-sm btn-danger text-white" href="#" onclick="facturar()">IMPRESIÓN FISCAL</a>
            <a class="d-print-none btn btn-sm btn-info text-white" href="#" onclick="window.print()">Impresion No-Fiscal</a>
            @if($factura->cliente->notas)
            <a class="d-print-none btn btn-sm btn-secondary text-white" href="{{ route('creditos.index') }}">NOTA DE CRÉDITO</a>
            @endif

            <a class="d-print-none btn btn-sm btn-warning" href="{{ route('facturas.create') }}">Finalizar</a>
        </div>
    </div>
    <div class="row">
        {{-- @dd($factura->items->first()->inventario->serial) --}}
        <div class="col">
            <span class="float-left">
                {!!QrCode::size(160)->generate(sprintf('%06d', $factura->id)) !!}
            </span>
        </div>
        <div class="col">
            <img class="img-fluid float-right" style="max-height: 160px;" src="{{ asset('storage/img/5.png') }}" alt="">
        </div>
    </div>
    <div class="row">
        <div class="col">
            <span class="float-right"><small>{{ $factura->created_at }}</small></span>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <span class="float-right">Soporte de Factura <b class="text-danger">#{{ sprintf('%06d', $factura->id) }}</b></span>
            <small>RIF: <b>{{ $factura->cliente->rif }}</b> </small> <br>
            <small>Cliente: <b>{{ $factura->cliente->nombre }}</b> </small> <br>
            <small>Dirección: <b>{{ $factura->cliente->direccion }}</b> </small> <br>
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
                        <td>{{ $factura->items->count() }}</td>
                        <td>
                            {{ \App\Aporte::find($factura->aporte_id)->nombre }} <br>
                            {{ $factura->items->first()->inventario->producto->nombre }} x {{ $factura->items->count() }} <br>
                            <hr>
                            <span>Seriales:</span> <br>
                            <span>
                                @foreach ($factura->items as $item)
                                <small>{{ $item->inventario->serial }}</small>
                                @endforeach
                            </span>
                        </td>
                        @php
                        $precio = \App\Aporte::find($factura->aporte_id)->valor * $factura->base_value;
                        @endphp
                        <td class="text-right">{{ number_format($precio,2) }}</td>
                        <td class="text-right">
                            {{ number_format($factura->items->count() * $precio,2) }}
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="text-right">Sub-Total</td>
                        <td class="text-right">{{ number_format($factura->items->count() * $precio,2) }}</td>
                    </tr>
                    <tr>
                        <td colspan="3" class="text-right">IVA (0%)</td>
                        <td class="text-right">{{ number_format(0,2) }}</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <h6><b>ESTE DOCUMENTO ES VÁLIDO PARA EL TRANSITO DEL CONTENEDOR, EN EL ESTADO LA GUAIRA</b></h6>
                        </td>
                        <td colspan="1" class="text-right">Total</td>
                        <td class="text-right">{{ number_format($factura->items->count() * $precio,2) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<script>
    function facturar() {
        if (window.isElectron) {
            if (confirm('ESTA SEGURO QUE DESEA IMPRIMIR LA FACTURA?')) {
                window.ipcRenderer.send('ping', {{ $factura->id }})
                window.ipcRenderer.on('pong', (event, msg) => console.log(msg))
            }
        } else {
            window.print()
        }
    }
</script>
@endsection
