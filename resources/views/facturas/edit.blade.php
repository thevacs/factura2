@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <a href="{{ url('/facturas') }}" class="btn btn-link float-right">Regresar</a>
        </div>
    </div>
    {!! Form::model($factura, ['route' => ['facturas.update', $factura->id],'method' =>'PATCH']) !!}
    <div class="row">
        <div class="col-4">
            <h5>FACTURA #{{$factura->id}}</h5>
            <div class="form-group">
                {!! Form::label('cliente_id', 'Cliente', ['class' => 'form-control-label']) !!}
                {!! Form::select('cliente_id', $clientes, $factura->cliente_id, ['class' => 'form-control', 'placeholder' => 'Selección']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('tipo_pago_id', 'Tipo Pagos', ['class' => 'form-control-label']) !!}
                {!! Form::select('tipo_pago_id', $tipos, $factura->tipo_pago_id, ['class' => 'form-control', 'placeholder' => 'Selección']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('banco_id', 'Banco', ['class' => 'form-control-label']) !!}
                {!! Form::select('banco_id', $bancos, $factura->banco_id, ['class' => 'form-control', 'placeholder' => 'Selección']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('referencia', 'Referencia', ['class' => 'form-control-label']) !!}
                {!! Form::text('referencia', $factura->referencia, ['class' => 'form-control']) !!}
            </div>
        </div>
        
    </div>
    {!! Form::submit('Guardar', ['class'=>'btn btn-primary']) !!}
    {!! Form::close() !!}
</div>
@endsection
