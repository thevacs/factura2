@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <a href="{{ url('/creditos') }}" class="btn btn-link float-right">Regresar</a>
        </div>
    </div>
    {!! Form::model($credito, ['route' => ['creditos.update', $credito->id],'method' =>'PATCH']) !!}
    <div class="row">
        <div class="col-4">
            <h5>NOTA DE CREDITO #{{$credito->id}}</h5>
            <div class="form-group">
                {!! Form::label('cliente_id', 'Cliente', ['class' => 'form-control-label']) !!}
                {!! Form::select('cliente_id', $clientes, $credito->cliente_id, ['class' => 'form-control', 'placeholder' => 'Selección']) !!}
            </div>
        </div>
        
    </div>
    {!! Form::submit('Guardar', ['class'=>'btn btn-primary']) !!}
    {!! Form::close() !!}
</div>
@endsection
