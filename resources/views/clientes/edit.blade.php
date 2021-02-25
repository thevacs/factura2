@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-6">
            {!! Form::model($cliente, ['route' => ['clientes.update', $cliente->id],'method' =>'PATCH']) !!}
            <div class="form-row">
                <div class="form-group col-1 mr-2">
                    {!! Form::label('rif', 'RIF', ['class' => 'form-control-label']) !!}
                </div>
                <div class="form-group mr-2">
                    {!! Form::select('char1', ['G' => 'G', 'J' => 'J', 'V' => 'V', 'E' => 'E'], $char1, ['class' => 'form-control', 'placeholder' => 'Tipo', 'required']) !!}
                    {!! $errors->first('rif', '<small class="help-block text-danger">:message</small>') !!}
                </div>
                <div class="form-group">
                    {!! Form::text('number', $number, ['class' => 'form-control', 'required']) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('nombre', 'Nombre', ['class' => 'form-control-label']) !!}
                {!! Form::text('nombre', null, ['class' => 'form-control', 'required']) !!}
                {!! $errors->first('nombre', '<small class="help-block text-danger">:message</small>') !!}
            </div>
            <div class="form-group">
                {!! Form::label('contacto', 'Contacto', ['class' => 'form-control-label']) !!}
                {!! Form::text('contacto', null, ['class' => 'form-control']) !!}
                {!! $errors->first('contacto', '<small class="help-block text-danger">:message</small>') !!}
            </div>
            <div class="form-group">
                {!! Form::label('telefono1', 'Telefono 1', ['class' => 'form-control-label']) !!}
                {!! Form::text('telefono1', null, ['class' => 'form-control']) !!}
                {!! $errors->first('telefono1', '<small class="help-block text-danger">:message</small>') !!}
            </div>
            <div class="form-group">
                {!! Form::label('telefono2', 'Telefono 2', ['class' => 'form-control-label']) !!}
                {!! Form::text('telefono2', null, ['class' => 'form-control']) !!}
                {!! $errors->first('telefono2', '<small class="help-block text-danger">:message</small>') !!}
            </div>
            <div class="form-group">
                {!! Form::label('direccion', 'Dirección Fiscal', ['class' => 'form-control-label']) !!}
                {!! Form::textarea('direccion', null, ['class' => 'form-control', 'rows' => '4', 'required']) !!}
                {!! $errors->first('direccion', '<small class="help-block text-danger">:message</small>') !!}
            </div>
            {!! Form::submit('Actualizar', ['class' => 'btn btn-primary']) !!}
            <a class="btn btn-warning" href="{{ route('clientes.index') }}">Cancelar</a>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection