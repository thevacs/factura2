@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-3">
            @include('inventarios.partials.menu')
        </div>

        <div class="col">
            <div class="card">
                <div class="card-header text-white bg-primary mb-3">
                    Inventario
                    <a class="btn btn-light btn-sm float-right" href="{{ route('inventarios.create') }}">Crear <i class="fas fa-plus"></i></a>                    
                    <a href="{{ url('/home') }}" class="btn btn-light btn-sm float-right mr-2"><i class="fas fa-arrow-left mr-1"></i> Regresar</a>
                </div>

                <div class="card-body pt-0">
                    {{-- <a class="btn btn-sm btn-info text-white float-left" href="{{ route('clientes.create') }}">Nuevo Cliente</a> --}}
                    <form action="{{ route('inventarios.index') }}" class="form-inline float-right my-3">
                        {!! Form::label('buscar', 'Buscar', ['class' => 'font-weight-bold form-control-label mr-2']) !!}
                        {!! Form::text('buscar', request()->buscar, ['class' => 'form-control form-control-sm mr-2', 'placeholder' => 'CNT/BL']) !!}
                        {{ Form::button('<i class="fa fa-search text-white"></i>', ['type' => 'submit', 'class' => 'btn btn-info btn-sm mr-1'] )  }}
                        <a class="btn btn-sm btn-secondary" href="{{ route('inventarios.index') }}"><i class="fas fa-redo"></i></a>
                    </form>
                    <table class="table table-sm table-striped table-bordered">
                        <caption>Productos registrados en la base de datos.</caption>
                        <thead>
                            <tr class="text-center">
                                <th>#</th>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Serial</th>
                                <th>BL</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($inventarios as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->producto->nombre }}</td>
                                <td><small>{{ $item->descripcion }}</small></td>
                                <td>{{ $item->serial }}</td>
                                <td>{{ $item->bl }}</td>
                                <td class="text-center">
                                    <a class="btn btn-sm btn-warning" href="{{ route('inventarios.edit', $item->id) }}" title="Editar"><i class="fas fa-edit"></i></a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">
                                    <br />
                                    <br />
                                    <br />
                                    No hay Productos
                                    <br />
                                    <br />
                                    <br />
                                    <a href="{{ route('manifiestos.index') }}" class="btn btn-primary mb-5">Importar Contenedores</a>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="float-left">
                        {{ $inventarios->appends(request()->query())->links() }}
                    </div>
                </div>

            </div>
        </div>
    </div>

    @endsection
