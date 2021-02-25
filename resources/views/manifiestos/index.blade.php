@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-3">
      @include('inventarios.partials.menu')
    </div>

    <div class="col">

      @include('alert')

      <div class="card">
        <div class="card-header text-white bg-primary mb-3">
          Manifiestos
          <a href="{{ route('manifiestos.create') }}" class="float-right btn btn-light btn-sm"> <i class="fas fa-plus"></i> Subir Manifiesto</a>
        </div>

        <div class="card-body">

          <table class="table table-sm table-striped table-bordered">
            <caption>Manifiestos registrados en la base de datos.</caption>
            <thead>
              <tr class="text-center">
                <th>#</th>
                <th>Buque</th>
                <th>Fecha</th>
                <th>Contenedores</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($manifiestos as $manifiesto)
              <tr>
                <td class="align-middle text-center">{{ $manifiesto->id }}</td>
                <td class="align-middle text-center">{{ $manifiesto->buque }}</td>
                <td class="align-middle text-center">{{ $manifiesto->fecha }}</td>
                <td class="align-middle text-center">{{ $manifiesto->contenedores->count() }}</td>
                <td class="align-middle">
                  <a href="{{ route('manifiestos.show', $manifiesto->id) }}" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i></a>
                  <a href="{{ route('manifiestos.edit', $manifiesto->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                  <a href="{{ route('manifiestos.destroy', $manifiesto->id) }}" class="float-right btn btn-danger btn-sm" onclick="event.preventDefault();
                      if(!confirm('¿Está seguro que desea borrarlo?')){return false;}
                      document.getElementById('eliminar{{$manifiesto->id}}').submit();">
                    <i class="fas fa-trash-alt"></i>
                  </a>
                  @if ($manifiesto->procesado == 0)
                      <a onclick="return confirm('¿Está seguro que desea procesar los contenedores?')" href="{{ route('manifiestos.procesar', $manifiesto->id) }}" class="float-right mr-1 btn btn-secondary btn-sm"><i class="fas fa-sign-in-alt"></i></a>
                  @endif
                  <form id="eliminar{{$manifiesto->id}}" action="{{ route('manifiestos.destroy', $manifiesto->id) }}" method="POST" style="display: none;">
                    @csrf
                    @method('DELETE')
                  </form>

                </td>
              </tr>
              @empty
              <tr>
                <td colspan="5" class="text-center">
                  <br />
                  <br />
                  <br />
                  No hay manifiestos cargados.
                  <br />
                  <br />
                  <br />
                  <a href="{{ route('manifiestos.create') }}" class="btn btn-primary mb-5">Subir Manifiesto</a>
                </td>
              </tr>
              @endforelse
            </tbody>
          </table>

          {{ $manifiestos->links() }}
        </div>

      </div>
    </div>
  </div>

  @endsection
