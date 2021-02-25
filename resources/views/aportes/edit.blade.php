@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header bg-dark text-light">
                Editar {{ $aporte->nombre }}
                <a href="{{ url()->previous() }}" class="btn btn-sm btn-secondary float-right"><i class="fas fa-arrow-left"></i> Regresar</a>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-4">
                        {!! Form::model($aporte, ['route' => ['aportes.update', $aporte->id], 'method' => 'PUT']) !!}
                        <div class="form-group">
                            {!! Form::label('nombre', 'Nombre', ['class' => 'form-control-label font-weight-bold']) !!}
                            {!! Form::text('nombre', null, ['class' => 'form-control', 'placeholder' => 'Denominación del Aporte']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('descripcion', 'Descripción', ['class' => 'form-control-label font-weight-bold']) !!}
                            {!! Form::text('descripcion', null, ['class' => 'form-control', 'placeholder' => 'Descripción breve']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('acronimo', 'Acronimo/Siglas', ['class' => 'form-control-label font-weight-bold']) !!}
                            {!! Form::text('acronimo', null, ['class' => 'form-control', 'placeholder' => 'Acronimo o Sigla']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('moneda_id', 'Moneda', ['class' => 'form-control-label font-weight-bold']) !!}
                            {!! Form::select('moneda_id', \App\Moneda::pluck('nombre','id'), null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('valor', 'Valor del Aporte', ['class' => 'form-control-label font-weight-bold', 'step' => '0.01', 'min' => '1']) !!}
                        <input class="form-control" name="valor" id="valor" value="{{ $aporte->valor }}" type="decimal">
                        </div>
                        {{-- <div class="form-group"> --}}
                            {{-- {!! Form::label('vigencia_ini', 'Vigencia/Inicio', ['class' => 'form-control-label font-weight-bold']) !!} --}}
                            {{-- {!! Form::date('vigencia_ini', null, ['class' => 'form-control']) !!} --}}
                        {{-- </div> --}}
                        {{-- <div class="form-group"> --}}
                            {{-- {!! Form::label('vigencia_fin', 'Vigencia/Fin', ['class' => 'form-control-label font-weight-bold']) !!} --}}
                            {{-- {!! Form::date('vigencia_fin', null, ['class' => 'form-control']) !!} --}}
                        {{-- </div> --}}
                        {!! Form::submit('Actualizar', ['class' => 'btn btn-primary']) !!}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>        
    </div>
@endsection
