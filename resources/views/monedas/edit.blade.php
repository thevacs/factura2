@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header bg-dark text-light">
            <i class="fas fa-coins text-warning mr-1"></i> Editar {{ $moneda->nombre }}
            <a href="{{ url()->previous() }}" class="btn btn-sm btn-secondary float-right"><i class="fas fa-arrow-left"></i> Regresar</a>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-4">
                    {!! Form::model($moneda, ['route' => ['monedas.update', $moneda->id],'method' =>'PATCH']) !!}
                    <div class="form-group">
                        {!! Form::label('nombre', 'Nombre', ['class' => 'form-control-label font-weight-bold']) !!}
                        {!! Form::text('nombre', $moneda->nombre, ['class' => 'form-control']) !!}
                        {!! $errors->first('nombre', '<small class="help-block text-danger">:message</small>') !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('simbolo', 'Simbolo', ['class' => 'form-control-label font-weight-bold']) !!}
                        {!! Form::text('simbolo', $moneda->simbolo, ['class' => 'form-control']) !!}
                        {!! $errors->first('simbolo', '<small class="help-block text-danger">:message</small>') !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('valor', 'Valor', ['class' => 'form-control-label font-weight-bold']) !!}
                        {!! Form::number('valor', $moneda->valor, ['class' => 'form-control','step' => 'any']) !!}
                        {!! $errors->first('valor', '<small class="help-block text-danger">:message</small>') !!}
                    </div>
                    {!! Form::submit('Editar', ['class' => 'btn btn-primary']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
