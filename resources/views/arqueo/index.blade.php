@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row">
        <div class="col-2">

            <div class="list-group d-print-none">
                @foreach($taquillas as $taquilla)
                <a href="{{ route('arqueo.taquilla', [$fechaCarbon->format('d-m-Y'), $taquilla->id]) }}"
                    class="list-group-item list-group-item-action {{ active(['arqueo-caja/'.$fechaCarbon->format('d-m-Y').'/'.$taquilla->id, 'arqueo-caja/arqueo-caja/'.$taquilla->id.'/*']) }}">
                    <i class="fas fa-cash-register"></i> {{ mb_strtoupper($taquilla->name) }}
                </a>
                @endforeach
            </div>

        </div>

        <div class="col">

            @include('alert')

            <div class="card">
                <div class="card-header text-white bg-primary mb-3">
                    <div class="row">
                        <div class="col-3">Arqueo de Caja - TODOS <br> <span
                                class="font-weight-bold">{{$fechaCarbon->format('d-m-Y')}}</span></div>
                        <div class="col-5">
                            <div class="input-group mb-3 float-left">
                                <input type="date" class="form-control form-control-sm" id="fecha" value="">
                                <div class="input-group-append">
                                    <button class="btn btn-secondary btn-sm" onclick="arqueoCaja()" type="button">Buscar
                                        <i class="fas fa-search"></i></button>
                                </div>
                            </div>

                        </div>
                        <div class="col-4"><a href="{{ route('facturas.reporte') }}"
                                class="float-right ml-2 btn btn-light btn-sm">
                                <i class="fas fa-arrow-left"></i> Regresar
                            </a>
                            <a href="#" onclick="window.print()" class="float-right ml-2 btn btn-light btn-sm"><i
                                    class="fas fa-print"></i> IMPRIMIR</a></div>
                    </div>
                </div>

                <div class="card-body">

                    <table class="table table-borderless">
                        @php
                        $monto1F = 0;
                        $monto2F = 0;
                        $monto3F = 0;
                        @endphp
                        @foreach($tipopagos as $tipo)
                        @php $monto1F = $monto1F + $tipo->facturas()->where(['anulada' => 0])->whereDate('created_at',
                        $fechaCarbon)->count() @endphp
                        <tr>
                            <td scope="row">{{ $tipo->nombre }}</td>
                            <td class="text-right">Facturas:</td>
                            <td class="text-left">
                                <b>{{ $tipo->facturas()->where(['anulada' => 0])->whereDate('created_at', $fechaCarbon)->count() }}</b>
                            </td>
                            <td class="text-right">Contenedores:
                            <td class="text-left">
                                <b>
                                    @php
                                    $montoF = 0;
                                    @endphp
                                    @if(!$tipo->facturas()->where(['anulada' => 0])->whereDate('created_at',
                                    $fechaCarbon)->get()->isEmpty())
                                    @foreach($tipo->facturas()->where(['anulada' => 0])->whereDate('created_at',
                                    $fechaCarbon)->get() as $factura2)
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
                                    @if(!$tipo->facturas()->where(['anulada' => 0])->whereDate('created_at',
                                    $fechaCarbon)->get()->isEmpty())
                                    @foreach($tipo->facturas()->where(['anulada' => 0])->whereDate('created_at',
                                    $fechaCarbon)->get() as $factura3)
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

                </div>

            </div>
        </div>
    </div>


    <script>
        function arqueoCaja(){
        let fecha = document.getElementById("fecha").value;
        window.location.assign('/arqueo-caja/'+fecha)        
    }
    </script>


    @endsection