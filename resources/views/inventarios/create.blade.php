@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-6">
                <div class="card">
                    <div class="card-header bg-dark text-white">Nuevo Item a Inventario</div>
                    <div class="card-body">
                        {!! Form::open(['route' => 'inventarios.store', 'method' => 'POST']) !!}
                        <div class="form-group">
                            {!! Form::label('producto_id', 'Producto', ['class' => 'form-control-label']) !!}
                            {!! Form::select('producto_id', \App\Producto::where('servicio',0)->pluck('nombre','id'), null, ['class' => 'form-control', 'placeholder' => 'Selección', 'required']) !!}
                            {!! $errors->first('producto_id', '<small class="help-block text-danger">:message</small>') !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('descripcion', 'Descripción', ['class' => 'form-control-label']) !!}
                            {!! Form::text('descripcion', null, ['class' => 'form-control']) !!}
                            {!! $errors->first('descripcion', '<small class="help-block text-danger">:message</small>') !!}
                            <small class="form-text text-muted">Ej. tamaño+tipo+linea+viaje+bl</small>
                        </div>
                        <div class="form-group">
                            {!! Form::label('serial', 'Serial/Numero', ['class' => 'form-control-label', 'placeholder' => 'Serial/Numero']) !!}
                            {!! Form::text('serial', null, ['class' => 'form-control', 'required']) !!}
                            {!! $errors->first('serial', '<small class="help-block text-danger">:message</small>') !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('bl', 'BL', ['class' => 'form-control-label', 'placeholder' => 'BL']) !!}
                            {!! Form::text('bl', null, ['class' => 'form-control', 'required']) !!}
                            {!! $errors->first('bl', '<small class="help-block text-danger">:message</small>') !!}
                        </div>
                        {{ Form::button('<i class="fas fa-sticky-note"></i> Registrar', ['type' => 'submit', 'class' => 'btn btn-info btn-sm text-white mr-3'] )  }}
                        <a class="btn btn-sm btn-warning" href="{{ route('inventarios.index') }}"><i class="fas fa-redo"></i> Cancelar</a>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
