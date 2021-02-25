@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header bg-dark text-white">
                    Clientes
                    <a href="{{ route('creditos.index') }}" class="ml-2 float-right btn btn-light btn-sm"> <i class="fas fa-credit-card"></i> Notas De Creditos</a>
                    <a href="{{ route('clientes.create') }}" class="float-right btn btn-light btn-sm"> <i class="fas fa-plus"></i> Nuevo Cliente</a>
                </div>
                <div class="card-body">
                    <form action="{{ route('clientes.index') }}" class="form-inline float-right my-3">
                        {!! Form::label('buscar', 'Buscar', ['class' => 'form-control-label mr-3']) !!}
                        {!! Form::text('buscar', null, ['class' => 'form-control form-control-sm mr-3', 'placeholder' => 'RIF/NOMBRE']) !!}
                        {{ Form::button('<i class="text-white fa fa-search"></i>', ['type' => 'submit', 'class' => 'btn btn-info btn-sm mr-3'] )  }}
                    </form>
                    <table class="table table-sm table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>RIF</th>
                                <th>Nombre</th>
                                <th>Contacto</th>
                                <th>Telefono</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($clientes as $element)
                            <tr>
                                <td>{{ $element->id }}</td>
                                <td>{{ $element->rif }}</td>
                                <td>{{ $element->nombre }}</td>
                                <td>{{ $element->contacto }}</td>
                                <td>{{ $element->telefono1 }} - {{ $element->telefono2 }}</td>
                                <td>
                                    <a class="btn btn-sm btn-warning" href="{{ route('clientes.edit', $element->id) }}"><i class="fas fa-edit"></i></a>
                                    <a href="{{ route('clientes.destroy', $element->id) }}" class="float-right btn btn-danger btn-sm" onclick="event.preventDefault();
                                        if(!confirm('¿Está seguro que desea borrarlo?')){return false;}
                                        document.getElementById('eliminar{{$element->id}}').submit();">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                    <form id="eliminar{{$element->id}}" action="{{ route('clientes.destroy', $element->id) }}" method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $clientes->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection