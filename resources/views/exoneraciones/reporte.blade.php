@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row my-2">
        <div class="col">
            <div class="card">
                <div class="card-header bg-dark text-white">Reporte Diario de Pre-Liquidaciones
                    <a href="{{ route('preliquidaciones.index') }}" class="float-right ml-3 btn btn-light btn-sm">
                        <i class="fas fa-arrow-left"></i> Regresar
                    </a>
                </div>
                <div class="card-body d-print-none row">
                    <form action="{{ route('preliquidaciones.reporte.index') }}" class="col mr-3 form-inline float-right">
                        <label for="date">Fecha</label>
                        <input type="date" name="fecha" class="form-control ml-2" id="date" value="{{ date('Y-m-d') }}">
                        {{ Form::button('<i class="text-white fa fa-search"></i>', ['type' => 'submit', 'class' => 'btn btn-info btn-sm mr-3'] )  }}
                    </form>
                    <div class="col">
                        <a class="d-print-none btn btn-info text-white" href="#" onclick="window.print()">IMPIMIR</a>

                    </div>
                </div>
            </div>

            <div class="card card-body mt-4">
                <h2 class="text-center">Fecha: {{ $dia }}</h2>

                <span>BL's: <b>{{ $preliquidaciones->count() }}</b> </span>

                @php
                $contenedores = 0;

                foreach($preliquidaciones as $preliquidacion){
                $contenedores = $contenedores + $preliquidacion->detalles->count();
                }

                @endphp

                <span>Contenedores: <b>{{ $contenedores }}</b> </span> <br />

                <table class="table table-sm">
                    <caption>Cantidad de Pre-Liquidaciones hoy <b>{{ $preliquidaciones->count() }}</b></caption>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>RIF</th>
                            <th>Cliente</th>
                            <th>BL</th>
                            <th class="text-center">Cnts/Total</th>
                            <th class="text-center">Fecha</th>
                        </tr>
                    </thead>
                    @foreach($preliquidaciones as $preliquidacion)
                    <tr class="@if(!is_null($preliquidacion->deleted_at)) bg-danger text-white @endif">
                        <td scope="row">{{ sprintf('%06d', $preliquidacion->id) }} @if(!is_null($preliquidacion->deleted_at)) ANULADO @endif</td>
                        <td>{{ $preliquidacion->cliente->rif }}</td>
                        <td>{{ $preliquidacion->cliente->nombre }}</td>
                        <td>{{ $preliquidacion->detalles->first()->inventario ? $preliquidacion->detalles->first()->inventario->bl : null  }}</td>

                        <td class="text-center">{{ $preliquidacion->detalles->count() }}</td>
                        <td class="text-center">{{ $preliquidacion->created_at->format('d-m-Y') }}</td>
                    </tr>
                    @endforeach
                </table>
            </div>

        </div>
    </div>
</div>
</div>
@endsection