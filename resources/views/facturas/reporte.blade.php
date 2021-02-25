@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row my-2">
        <div class="col">
            <div class="card">
                <div class="card-header bg-dark text-white">Reporte Diario de Facturación
                    <a href="{{ route('facturas.index') }}" class="float-right ml-2 btn btn-light btn-sm">
                        <i class="fas fa-arrow-left"></i> Regresar
                    </a>

                    <a href="#" onclick="arqueoCaja()" class="ml-2 float-right btn btn-light btn-sm">
                        <i class="fas fa-cash-register"></i> ARQUEO DE CAJA
                    </a>

                    <a href="#" onclick="reportez()" class="ml-2 float-right btn btn-light btn-sm"><i
                            class="fas fa-print"></i> REPORTE Z</a>
                    <a href="#" onclick="reportex()" class="ml-2 float-right btn btn-light btn-sm"><i
                            class="fas fa-print"></i> REPORTE X</a>

                </div>
                <div class="card-body d-print-none row">

                    <form action="{{ route('facturas.reporte') }}" class="col mr-3 form-inline float-right">
                        <label for="date">Fecha</label>
                        <input type="date" name="fecha" class="form-control ml-2" id="date" value="{{ date('Y-m-d') }}">
                        {{ Form::button('<i class="text-white fa fa-search"></i>', ['type' => 'submit', 'class' => 'btn btn-info btn-sm mr-3'] )  }}
                    </form>

                    <div class="col">
                        <a href="#" onclick="window.print()" class="ml-2 btn btn-primary btn-sm"><i
                                class="fas fa-print"></i> IMPRIMIR</a>
                    </div>

                </div>
            </div>

            <div class="card card-body mt-4">
                <h2 class="text-center">Fecha: {{ $dia }}</h2>

                <span>Facturas: <b>{{ $facturas->count() }}</b> </span>

                @php
                $monto = 0;
                $contenedores = 0;

                foreach($facturas as $factura){

                if(!$factura->anulada) {
                $contenedores = $contenedores + $factura->items->count();
                $monto = $monto + $factura->items()->sum('precio');
                }
                }
                @endphp

                <span>Contenedores: <b>{{ $contenedores }}</b> </span>
                <span>MONTO TOTAL: <b>{{ number_format($monto,2) }}</b> </span> <br />

                <table class="table table-sm">
                    <caption>Cantidad de Facturas generadas hoy <b>{{ $facturas->count() }}</b></caption>
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">Cliente</th>
                            <th class="text-center">Tipo</th>
                            <th class="text-center">Referencia</th>
                            <th class="text-center">Monto</th>
                            <th class="text-center">Cantidad</th>
                            <th class="text-center">Fecha</th>
                            <th class="text-center">Taquilla</th>
                        </tr>
                    </thead>
                    @foreach($facturas as $factura)
                    <tr @if($factura->anulada == 1) class="bg-danger" @endif>
                        <td scope="row">{{ sprintf('%06d', $factura->id) }}</td>
                        <td class="text-center">{{ $factura->cliente->rif }} - {{ $factura->cliente->nombre }}</td>
                        <td class="text-center">
                            @if($factura->tipo_pago_id)
                            {{ $factura->tipopago->nombre }}
                            @endif
                        </td>
                        <td class="text-center">
                            {{ $factura->referencia ?? '' }}
                            @if($factura->tipo_pago_id == 5)
                            <br />{{ $factura->banco->nombre }} - {{ $factura->referencia }}
                            @endif
                        </td>
                        <td class="text-center">{{ number_format($factura->items()->sum('precio'),2) }}</td>
                        <td class="text-center">{{ $factura->items()->count() }}</td>
                        <td class="text-center">{{ $factura->created_at }}</td>
                        <td class="text-center">{{ $factura->usuario->name }}</td>
                    </tr>
                    @endforeach
                </table>
            </div>

        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="arqueoCaja" tabindex="-1" aria-labelledby="arqueoCaja" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-dark text-light">
                <h5 class="modal-title" id="arqueoCaja"><i class="fas fa-cash-register text-warning mr-1"></i>
                    Seleccione la fecha del Arqueo de Caja</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <!-- Inicio Fecha Desde -->
                    <div class="form-group col">
                        <label class="form-label" for="fecha"><b>Fecha</b></label>
                        <input type="date" class="form-control" name="fecha" id="fecha" value="" required>
                    </div>
                    <!-- Fin Fecha Desde -->
                    <!-- Inicio Fecha Hasta -->
                    {{-- <div class="form-group col">
                            <label class="form-label" for="hasta"><b>Hasta</b></label>
                            <input type="date" class="form-control" name="hasta" id="hasta" required>
                        </div> --}}
                    <!-- Fin Fecha Hasta -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary" onclick="arqueoCaja()">Enviar</button>
            </div>
        </div>
    </div>
</div>
</div>



<script>
    function arqueoCaja(){
        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
        var yyyy = today.getFullYear();

        today = dd + '-' + mm + '-' + yyyy;
        window.location.assign('/arqueo-caja/'+today)        
    }
    function reportez() {
        if (window.isElectron) {
            if (confirm('ESTA SEGURO QUE DESEA IMPRIMIR EL REPORTE Z?')) {
                window.ipcRenderer.send('reportez', 1)
            }
        } else {
            alert('Tienes que abrir desde la aplicación 1');
        }
    }

    function reportex() {
        if (window.isElectron) {
            if (confirm('ESTA SEGURO QUE DESEA IMPRIMIR EL REPORTE X?')) {
                window.ipcRenderer.send('reportex', 1)
            }
        } else {
            alert('Tienes que abrir desde la aplicación 2');
        }
    }
</script>
@endsection