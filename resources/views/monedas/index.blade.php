@extends('layouts.app')

@section('content')
<div class="container">
  <div class="card">
    <div class="card-header bg-dark text-light">
      <i class="fas fa-coins text-warning mr-1"></i> Monedas
      
      <a href="{{ route('monedas.create') }}" class="btn btn-sm btn-light float-right ml-1">
        <i class="fas fa-plus mr-1"></i> Nueva Moneda
      </a>
      <a href="{{ route('monedas.index', ['actualizar' => true]) }}" @if($connect==true)
        class="btn btn-sm btn-info float-right ml-1 text-light" @else class="btn btn-sm btn-info disabled ml-1 text-light" @endif>
        <i class="fas fa-sync"></i> Actualizar Divisas
      </a>
      <a href="{{ url('/home') }}" class="btn btn-sm btn-secondary float-right"><i class="fas fa-arrow-left"></i> Regresar</a>
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col">
          <table class="table table-bordered table-hover">
            <thead class="thead-light">
              <tr class="text-center">
                <th>Id</th>
                <th>Nombre</th>
                <th>Simbolo</th>
                <th>Valor</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($monedas as $item)
              <tr class="text-center">
                <td scope="row">{{ $item->id }}</td>
                <td>{{ $item->nombre }}</td>
                <td class="text-center">{{ $item->simbolo }}</td>
                <td class="text-success font-weight-bold">{{ number_format($item->valor,2,',','.') }}</td>
                <td>
                  <a href="{{ route('monedas.edit',['moneda'=> $item->id]) }}" class="btn btn-sm btn-warning"><i
                      class="fas fa-edit"></i></a>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
          <div class="alert alert-info">Ultima Actualizacion de Divisas
            <b>{{ $monedas->last()->updated_at ? $monedas->last()->updated_at : null }}</b></div>
        </div>
      </div>
    </div>
  </div>

</div>
@endsection