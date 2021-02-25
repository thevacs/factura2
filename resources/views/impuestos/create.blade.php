@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header bg-dark text-light">
            <i class="fas fa-plus mr-1"></i> Nuevo Impuesto
            <a href="{{ url()->previous() }}" class="btn btn-sm btn-secondary float-right"><i
                    class="fas fa-arrow-left"></i> Regresar</a>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-4">
                    {!! Form::open(['route' => 'impuestos.store', 'method' => 'POST']) !!}
                    <div class="form-group">
                        {!! Form::label('nombre', 'Nombre', ['class' => 'form-control-label']) !!}
                        {!! Form::text('nombre', null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('acronimo', 'Acronimo', ['class' => 'form-control-label']) !!}
                        {!! Form::text('acronimo', null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('descripcion', 'Descripción', ['class' => 'form-control-label']) !!}
                        {!! Form::textarea('descripcion', null, ['class' => 'form-control', 'rows' => '4']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('valor', 'Porcentaje', ['class' => 'form-control-label']) !!}
                        {!! Form::number('valor', null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('vigencia_ini', 'Vigencia/Ini', ['class' => 'form-control-label']) !!}
                        {!! Form::date('vigencia_ini', null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('vigencia_fin', 'Vigencia/Fin', ['class' => 'form-control-label']) !!}
                        {!! Form::date('vigencia_fin', null, ['class' => 'form-control']) !!}
                    </div>
                    {!! Form::submit('Registrar', ['class' => 'btn btn-primary']) !!}
                    <a class="btn btn-secondary" href="{{ url()->previous() }}">Cancelar</a>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

</div>

@endsection