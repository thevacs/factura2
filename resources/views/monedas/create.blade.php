@extends('layouts.app')

@section('content')
<div class="container">
    <div class="container">
        <div class="card">
            <div class="card-header bg-dark text-light">
                <i class="fas fa-coins text-warning mr-1"></i> Crear Nueva Moneda
                <a href="{{ url()->previous() }}" class="btn btn-sm btn-secondary float-right">
                    <i class="fas fa-arrow-left mr-1"></i> Regresar
                </a>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-4">
                        {!! Form::open(['route'=>'monedas.store','method' => 'POST']) !!}
                        <div class="form-group">
                            {!! Form::label('nombre', 'Nombre', ['class' => 'form-control-label font-weight-bold']) !!}
                            {!! Form::text('nombre', null, ['class' => 'form-control']) !!}
                            {!! $errors->first('nombre', '<small class="help-block text-danger">:message</small>') !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('simbolo', 'Simbolo', ['class' => 'form-control-label font-weight-bold']) !!}
                            {!! Form::text('simbolo', null, ['class' => 'form-control']) !!}

                        </div>
                        <div class="form-group">
                            {!! Form::label('valor', 'Valor', ['class' => 'form-control-label font-weight-bold']) !!}
                            {!! Form::number('valor', null, ['class' => 'form-control','step' => 'any']) !!}
                        </div>
                        {!! Form::submit('Registrar', ['class' => 'btn btn-primary']) !!}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection