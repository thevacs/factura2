@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row">
        <div class="col">
            <a href="{{ url('/tasas') }}" class="btn btn-link float-right">regresar</a>
        </div>
    </div>
    <div class="row">
      <div class="col-4">
        {!! Form::model($tasa, ['route' => ['tasas.update', $tasa->id],'method' =>'PATCH']) !!}
        <div class="form-group">
          {!! Form::label('nombre', 'Nombre', ['class'=>'form-control-label']) !!}
          {!! Form::text('nombre', $tasa->nombre, ['class'=>'form-control']) !!}
        </div>
        <div class="form-group">
          {!! Form::label('acronimo', 'Acronimo', ['class'=>'form-control-label']) !!}
          {!! Form::text('acronimo', $tasa->acronimo, ['class'=>'form-control']) !!}
        </div>
        <div class="form-group">
          {!! Form::label('descripcion', 'Descripción', ['class'=>'form-control-label']) !!}
          {!! Form::textarea('descripcion', $tasa->descripcion, ['class'=>'form-control','rows'=>'2']) !!}
        </div>
        <div class="form-group">
          {!! Form::label('moneda_id', 'Moneda', ['class'=>'form-control-label']) !!}
          {!! Form::select('moneda_id', \App\Moneda::pluck('nombre','id'), $tasa->moneda_id, ['class'=>'form-control']) !!}
        </div>
        <div class="form-group">
          {!! Form::label('monto', 'Monto', ['class'=>'form-control-label']) !!}
          {!! Form::number('monto', $tasa->monto, ['class'=>'form-control','step'=>'any']) !!}
        </div>
        <div class="form-row">
          <div class="form-group col-6">
            {!! Form::label('vigencia_ini', 'Vigencia/Inicio', ['class'=>'form-control-label']) !!}
            {!! Form::date('vigencia_ini', $tasa->vigencia_ini, ['class'=>'form-control']) !!}
          </div>
          <div class="form-group col-6">
            {!! Form::label('vigencia_fin', 'Vigencia/Fin', ['class'=>'form-control-label']) !!}
            {!! Form::date('vigencia_fin', $tasa->vigencia_fin, ['class'=>'form-control']) !!}
          </div>
        </div>
        {!! Form::submit('Editar', ['class' => 'btn btn-primary']) !!}
        {!! Form::close() !!}
      </div>
    </div>
  </div>
@endsection
