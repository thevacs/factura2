@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col">
        <a href="{{ url('/home') }}" class="btn btn-link float-right">regresar</a>
      </div>
    </div>
    <div class="row mb-2">
      <div class="col">
        <a href="{{ route('tasas.create') }}" class="btn btn-primary">Nueva Tasa</a>
      </div>
    </div>
    <div class="row">
      <div class="col">
        <table class="table table-bordered table-hover">
          <thead>
            <tr>
              <th>#</th>
              <th>Nombre</th>
              <th>Acronimo</th>
              <th>Descripción</th>
              <th>Moneda</th>
              <th>Monto</th>
              <th>Vigencia</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($tasas as $element)
              <tr>
                <td>{{ $element->id }}</td>
                <td>{{ $element->nombre }}</td>
                <td>{{ $element->acronimo }}</td>
                <td>{{ $element->descripcion }}</td>
                <td>{{ $element->moneda->nombre }}</td>
                <td>{{ $element->monto }}</td>
                <td>{{ $element->vigencia_ini }}/{{ $element->vigencia_fin }}</td>
                <td>
                  <a href="{{ route('tasas.edit',['tasa'=> $element->id]) }}" class="btn btn-sm btn-warning">Editar</a>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection
