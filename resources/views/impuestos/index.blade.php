@extends('layouts.app')

@section('content')
<div class="container">

    <div class="card">
        <div class="card-header bg-dark text-light">
            <i class="fas fa-coins text-warning mr-1"></i> Impuestos

            <a href="{{ url('/home') }}" class="btn btn-secondary btn-sm float-right ml-1"><i
                    class="fas fa-arrow-left mr-1"></i> Regresar</a>
            <a href="{{ route('impuestos.create') }}" class="btn btn-light btn-sm float-right"><i
                    class="fas fa-plus mr-1"></i> Nuevo Impuesto</a>
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
                                <th>Valor (%)</th>
                                <th>Vigencia/Ini</th>
                                <th>Vigencia/Fin</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($impuestos as $item)
                            <tr class="text-center">
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->nombre }}</td>
                                <td>{{ $item->acronimo }}</td>
                                <td>{{ $item->descripcion }}</td>
                                <td class="text-center"> {{ $item->valor }}</td>
                                <td class="text-center">{{ $item->vigencia_ini }}</td>
                                <td class="text-center">{{ $item->vigencia_fin }}</td>
                                <td>
                                    <a class="btn btn-sm btn-warning mr-2"
                                        href="{{ route('impuestos.edit', $item->id) }}"><i
                                            class="fas fa-edit"></i></a>
                                    {{-- {!! Form::open(['route' => ['impuestos.destroy', $item->id], 'method' => 'DELETE', 'class' => 'form-inline']) !!} --}}
                                    {{-- {!! Form::submit('Borrar', ['class' => 'btn btn-sm btn-danger']) !!} --}}
                                    {{-- {!! Form::close() !!} --}}
                                </td>
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