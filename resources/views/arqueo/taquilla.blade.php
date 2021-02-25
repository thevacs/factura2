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
            <a class="d-print-none btn btn-sm btn-primary text-white" href="{{ URL::previous() }}">REGRESAR</a>
        </div>
    </div>
    <div class="row">
        <div class="col">

        </div>
        <div class="col">
            <img class="img-fluid float-right" style="max-height: 160px;" src="{{ asset('storage/img/5.png') }}" alt="">
        </div>
    </div>
    <div class="row">
        <div class="col">
            <h2 class="text-center">ARQUEO DE CAJA<br />{{ $fechaCarbon->format('Y-m-d') }}</h2>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <span class="float-right"><small>{{ $fechaCarbon }}</small></span>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <span class="float-right"><b>#{{ $user->name }}</b></span> <br />
            @php $moneda= App\Moneda::find(2); @endphp
            @php $aporte= App\Aporte::find(1); @endphp
            <span class="float-right">TASA DEL DIA Bs: <b>{{ number_format($moneda->valor,2) }}</b></span><br />
            <span class="float-right">TASA DEL DIA USD: <b>{{ $aporte->valor }}</b></span>
        </div>
    </div>
    <div class="row my-2">
        <div class="col">
            <table class="table table-sm">

                @php
                $monto1F = 0;
                $monto2F = 0;
                $monto3F = 0;
                @endphp
                @foreach($tipopagos as $tipo)
                @php $monto1F = $monto1F + $tipo->facturas()->where(['anulada' => 0, 'user_id' => $user->id])->whereDate('created_at', $fechaCarbon)->count() @endphp
                <tr>
                    <td scope="row">{{ $tipo->nombre }}</td>
                    <td class="text-right">Facturas:</td>
                    <td class="text-left"><b>{{ $tipo->facturas()->where(['anulada' => 0, 'user_id' => $user->id])->whereDate('created_at', $fechaCarbon)->count() }}</b></td>
                    <td class="text-right">Contenedores:
                    <td class="text-left">
                        <b>
                            @php
                            $montoF = 0;
                            @endphp
                            @if(!$tipo->facturas()->where(['anulada' => 0, 'user_id' => $user->id])->whereDate('created_at', $fechaCarbon)->get()->isEmpty())
                            @foreach($tipo->facturas()->where(['anulada' => 0, 'user_id' => $user->id])->whereDate('created_at', $fechaCarbon)->get() as $factura2)
                            @php
                            $montoF = $montoF + $factura2->items->count();
                            @endphp
                            @endforeach
                            @php $monto2F = $monto2F + $montoF @endphp
                            @endif
                            {{ $montoF }}
                        </b>
                    </td>
                    <td class="text-right">Monto:
                    <td class="text-left">
                        <b>
                            @php
                            $monto = 0;
                            @endphp
                            @if(!$tipo->facturas()->where(['anulada' => 0, 'user_id' => $user->id])->whereDate('created_at', $fechaCarbon)->get()->isEmpty())
                            @foreach($tipo->facturas()->where(['anulada' => 0, 'user_id' => $user->id])->whereDate('created_at', $fechaCarbon)->get() as $factura3)
                            @php
                            $monto = $monto + $factura3->items->sum('precio');
                            @endphp
                            @endforeach
                            @endif
                            @php $monto3F = $monto3F + $monto @endphp
                            {{ number_format($monto, 2) }}
                        </b>
                    </td>
                </tr>
                @endforeach
                <tr>
                    <td colspan="2" class="text-right">
                        TOTAL:
                    </td>
                    <td>
                        <b>{{ $monto1F }}</b>
                    </td>
                    <td class="text-right">
                        TOTAL:
                    </td>
                    <td class="text-left">
                        <b>{{ $monto2F }}</b>
                    </td>
                    <td class="text-right">TOTAL:</td>
                    <td class="text-left">
                        <b>{{ number_format($monto3F, 2) }}</b>
                    </td>
                </tr>

            </table>
            <br /><br />
            <div class="row">
                <div class="col text-center">
                    <b>Elaborado por</b><br /><br /><br />
                    _______________________________<br /><br />
                    @if($user->id == 3)
                    <b>Maria Alejandra Belisario</b><br />
                    @elseif($user->id == 4)
                    <b>Nailyn Garcia</b><br />
                    @endif
                    Analista de Facturación

                </div>
                <div class="col text-center">
                    <b>Revisado por</b><br /><br /><br />
                    _______________________________<br /><br />
                    <b>Yolanda Jiménez</b><br />
                    Administradora
                </div>
                <div class="col text-center">
                    <b>Confirmado por</b><br /><br /><br />
                    _______________________________<br /><br />
                    <b>José Miguel Mendoza</b><br />
                    Contador
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    function facturar() {
        window.print()
    }
</script>
@endsection
