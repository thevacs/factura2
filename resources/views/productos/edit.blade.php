@extends('layouts.app')
@section('content')
<div class="container">

    <div class="card">
        <div class="card-header bg-dark text-light">
            <i class="fas fa-edit mr-1"></i> Editar {{ $producto->nombre }}
            <a href="{{ url()->previous() }}" class="btn btn-sm btn-secondary float-right">
                <i class="fas fa-arrow-left"></i> Regresar
            </a>
        </div>
        <div class="card-body">
            {!! Form::model($producto, ['route' => ['productos.update', $producto->id],'method' =>'PATCH']) !!}
            <div class="row">
                <div class="col-4">
                    <h5>Producto</h5>
                    <div class="form-group">
                        {!! Form::label('nombre', 'Nombre', ['class'=>'form-control-label font-weight-bold']) !!}
                        {!! Form::text('nombre', $producto->nombre, ['class'=>'form-control']) !!}
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" id="servicio" name="servicio"
                                @if($producto->servicio > 0) checked @endif>
                            <label class="form-check-label" for="servicio">
                                Servicio
                            </label>
                        </div>
                        <div class="form-group">
                            {!! Form::label('tamano', 'Tamaño', ['class' => 'form-control-label font-weight-bold']) !!}
                            {!! Form::select('tamano', ['20'=>'20', '40'=>'40', '45'=>'45'], $producto->tamano, ['class'
                            => 'form-control', 'placeholder' => 'Selección']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('tipo', 'Tipo', ['class' => 'form-control-label font-weight-bold']) !!}
                            {!! Form::select('tipo', ['DC'=>'DC', 'HC'=>'HC', 'RF'=>'RF', 'RH' => 'RH'],
                            $producto->tipo, ['class' => 'form-control', 'placeholder' => 'Selección']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('moneda_id', 'Moneda', ['class'=>'form-control-label font-weight-bold']) !!}
                        {!! Form::select('moneda_id', \App\Moneda::pluck('nombre','id'), $producto->moneda_id,
                        ['class'=>'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('costo', 'Costo', ['class'=>'form-control-label font-weight-bold']) !!}
                        {!! Form::number('costo', $producto->costo, ['class'=>'form-control']) !!}
                    </div>
                </div>
                <div class="col-4">
                    <h5>Precios</h5>
                    <div class="form-group">
                        {!! Form::label('base1', 'Base/1', ['class'=>'form-control-label font-weight-bold']) !!}
                        {!! Form::number('base1', $producto->base1, ['class'=>'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('base2', 'Base/2', ['class'=>'form-control-label font-weight-bold']) !!}
                        {!! Form::number('base2', $producto->base2, ['class'=>'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('base3', 'Base/3', ['class'=>'form-control-label font-weight-bold']) !!}
                        {!! Form::number('base3', $producto->base3, ['class'=>'form-control']) !!}
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="aporte" name="aporte"
                            @if($producto->aporte > 0) checked @endif>
                        <label class="form-check-label" for="aporte">
                            Aporte
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="iva" name="iva" @if($producto->iva
                        > 0) checked @endif>
                        <label class="form-check-label" for="iva">
                            IVA
                        </label>
                    </div>
                </div>
            </div>
            {!! Form::submit('Guardar', ['class'=>'btn btn-primary']) !!}
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection