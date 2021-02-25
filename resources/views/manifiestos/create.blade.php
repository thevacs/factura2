@extends('layouts.app')

@section('content')
<div class="container">

  <div class="row">
    <div class="col-3">
      @include('inventarios.partials.menu')
    </div>

    <div class="col">
      <div class="card">
        <div class="card-header text-white bg-primary mb-3">
          Importar Manifiesto
          <a href="{{ URL::previous() }}" class="float-right btn btn-light btn-sm"> <i class="fas fa-long-arrow-alt-left"></i> Atrás</a>
        </div>

        <div class="card-body">

          <form method="POST" action="{{ route('manifiestos.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="buque">Nombre del Buque</label>
                <input type="text" class="form-control @error('buque') is-invalid @enderror" id="buque" name="buque" value="{{ old('buque') }}" placeholder="MAERKS WISMARK" required>
                @error('buque')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
              <div class="form-group col-md-6">
                <label for="fecha">Fecha del Buque</label>
                <input type="date" class="form-control @error('fecha') is-invalid @enderror" id="fecha" name="fecha" value="{{ old('fecha') ?? now()->format('Y-m-d') }}" required>
                @error('fecha')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>
            <div class="form-group">
              <label for="excel">Archivo Excel</label>
              <input type="file" class="form-control @error('excel') is-invalid @enderror" value="{{ old('excel') }}" id="excel" name="excel">
              @error('excel')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>
            <button type="submit" class="btn btn-primary">Importar</button>
          </form>

        </div>

      </div>
    </div>
  </div>

  @endsection
