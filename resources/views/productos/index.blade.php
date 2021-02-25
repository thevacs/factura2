@extends('layouts.app')

@section('content')
<div class="container">
  <div class="card">
    <div class="card-header bg-primary text-light">
      <i class="fas fa-clipboard-list mr-1"></i> Productos
      <a href="{{ url('/home') }}" class="btn btn-secondary btn-sm float-right ml-1">
        <i class="fas fa-arrow-left mr-1"></i> Regresar
      </a>
      <a href="{{ route('productos.create') }}" class="btn btn-light btn-sm float-right">
        <i class="fas fa-plus mr-1"></i> Nuevo Producto
      </a>
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col">
          <table class="table table-sm table-bordered table-hover">
            <thead class="thead-light">
              <tr class="text-center">
                <th>#</th>
                <th>Nombre</th>
                <th>Moneda</th>
                <th>Costo</th>
                <th>Base/1</th>
                <th>Base/2</th>
                <th>Base/3</th>
                <th>Aporte</th>
                <th>I.V.A.</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              {{-- @dd($productos) --}}
              @foreach ($productos as $element)
              <tr class="text-center">
                <td>{{ $element->id }}</td>
                <td>{{ $element->nombre }} @if($element->servicio > 0) <sup class="text-info" title="Servicio"><i
                      class="fab fa-stripe-s"></i></sup>@endif</td>
                <td>{{ $element->moneda->nombre }}</td>
                <td>{{ $element->moneda->simbolo }} {{ $element->costo }}</td>
                <td>{{ $element->base1 }}</td>
                <td>{{ $element->base2 }}</td>
                <td>{{ $element->base3 }}</td>
                <td @if($element->aporte == 0) class="text-muted" @else class="font-weight-bold" @endif
                  >{{ trueToString($element->aporte) }}</td>
                <td @if($element->iva == 0) class="text-muted" @else class="font-weight-bold" @endif
                  >{{ trueToString($element->iva) }}</td>
                <td>
                  <a href="{{ route('productos.edit',['producto'=> $element->id]) }}" class="btn btn-sm btn-warning"><i
                      class="fas fa-edit"></i></a>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection