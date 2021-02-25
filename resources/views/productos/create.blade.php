@extends('layouts.app')
@section('content')
<div class="container">
    <div class="card">
        <div class="card-header bg-dark text-light">
            <i class="fas fa-edit mr-1"></i> Nuevo Producto
            <a href="{{ url()->previous() }}" class="btn btn-sm btn-secondary float-right">
                <i class="fas fa-arrow-left"></i> Regresar
            </a>
        </div>
        <div class="card-body">
            @if ($errors->any())
            <div class="row">
                <div class="col">
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            @endif
            <div class="row">
                <div class="col-4">
                    {!! Form::open(['route'=>'productos.store','method' => 'POST']) !!}
                    <div class="form-group">
                        {!! Form::label('nombre', 'Nombre', ['class' => 'form-control-label font-weight-bold']) !!}
                        {!! Form::text('nombre', null, ['class' => 'form-control']) !!}
                        {!! $errors->first('nombre', '<small class="help-block text-danger">:message</small>') !!}
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" id="servicio" name="servicio">
                            <label class="form-check-label" for="servicio">
                                Servicio
                            </label>
                        </div>
                        <div class="form-group my-2">
                            {!! Form::label('tamano', 'Tamaño', ['class' => 'form-control-label font-weight-bold']) !!}
                            {!! Form::select('tamano', ['20'=>'20', '40'=>'40', '45'=>'45'], null, ['class' =>
                            'form-control', 'placeholder' => 'Selección']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('tipo', 'Tipo', ['class' => 'form-control-label font-weight-bold']) !!}
                            {!! Form::select('tipo', ['DC'=>'DC', 'HC'=>'HC', 'RF'=>'RF', 'RH' => 'RH'], null, ['class'
                            => 'form-control', 'placeholder' => 'Selección']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('moneda_id', 'Moneda', ['class' => 'form-control-label font-weight-bold'])
                            !!}
                            {!! Form::select('moneda_id', \App\Moneda::pluck('nombre','id'), null, ['class' =>
                            'form-control']) !!}
                            {!! $errors->first('moneda_id', '<small class="help-block text-danger">:message</small>')
                            !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('costo', 'Costo', ['class' => 'form-control-label font-weight-bold']) !!}
                            {!! Form::number('costo', null, ['class' => 'form-control', 'type' => 'decimal', 'step' =>
                            '0.01', 'min' => '0']) !!}
                            {!! $errors->first('costo', '<small class="help-block text-danger">:message</small>') !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('base1', 'Base 1', ['class' => 'form-control-label font-weight-bold']) !!}
                            {!! Form::number('base1', null, ['class' => 'form-control', 'type' => 'decimal', 'step' =>
                            '0.01', 'min' => '1']) !!}
                            {!! $errors->first('base1', '<small class="help-block text-danger">:message</small>') !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('base2', 'Base 2', ['class' => 'form-control-label font-weight-bold']) !!}
                            {!! Form::number('base2', null, ['class' => 'form-control', 'type' => 'decimal', 'step' =>
                            '0.01', 'min' => '1']) !!}
                            {!! $errors->first('base2', '<small class="help-block text-danger">:message</small>') !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('base3', 'Base 3', ['class' => 'form-control-label font-weight-bold']) !!}
                            {!! Form::number('base3', null, ['class' => 'form-control', 'type' => 'decimal', 'step' =>
                            '0.01', 'min' => '1']) !!}
                            {!! $errors->first('base3', '<small class="help-block text-danger">:message</small>') !!}
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" id="aporte" name="aporte">
                            <label class="form-check-label" for="defaultCheck1">
                                Aporte
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" id="iva" name="iva">
                            <label class="form-check-label" for="defaultCheck1">
                                IVA
                            </label>
                        </div>
                        {!! Form::submit('Registrar', ['class' => 'btn btn-primary mt-2']) !!}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection