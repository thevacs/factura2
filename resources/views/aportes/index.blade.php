@extends('layouts.app')

@section('content')
<div class="container">

    <div class="card">
        <div class="card-header bg-dark text-light">
            <i class="fas fa-coins text-warning mr-1"></i> Aportes

            <a href="{{ url('/home') }}" class="btn btn-secondary btn-sm float-right ml-1"><i
                    class="fas fa-arrow-left mr-1"></i> Regresar</a>
            <a href="{{ route('aportes.create') }}" class="btn btn-light btn-sm float-right"><i
                    class="fas fa-plus mr-1"></i> Nuevo Aporte</a>
        </div>
        <div class="card-body pt-0">
            <div class="row mt-4">
                <div class="col">
                    <table class="table table-sm table-bordered table-hover">
                        <caption>Aportes</caption>
                        <thead class="thead-light">
                            <tr class="text-center">
                                <th>#</th>
                                <th>Nombre</th>
                                <th>Acronimo</th>
                                <th>Descripción</th>
                                <th>Valor</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($aportes as $item)
                            <tr class="text-center">
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->nombre }}</td>
                                <td>{{ $item->acronimo }}</td>
                                <td>{{ $item->descripcion }}</td>
                                <td class="text-right"> {{ $item->moneda->simbolo }}
                                    {{ number_format($item->valor,2,'.',',') }}</td>
                                <td><a class="btn btn-sm btn-warning"
                                        href="{{ route('aportes.edit', $item->id) }}"><i class="fas fa-edit"></i></a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection