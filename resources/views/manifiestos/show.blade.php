@extends('layouts.app')

@php
use Illuminate\Support\Str;
@endphp

@section('content')
<div class="container">

  <div class="row">
    <div class="col-3">
      @include('inventarios.partials.menu')
    </div>

    <div class="col">
      <div class="card">
        <div class="card-header text-white bg-primary mb-3">
          Manifiesto #{{ $manifiesto->id }} {{ $manifiesto->buque }} - {{ $manifiesto->fecha }}
          <a href="{{ URL::previous() }}" class="float-right btn btn-light btn-sm"> <i class="fas fa-long-arrow-alt-left"></i> Atrás</a>
        </div>

        <div class="card-body">

          ESTADISTICAS

        </div>

      </div>

      <div class="card mt-5">
        <div class="card-header text-white bg-primary mb-3">
          Contenedores
          <a href="{{ route('manifiestos.edit', $manifiesto->id) }}" class="float-right btn btn-light btn-sm">
            <i class="fas fa-edit"></i> Editar
          </a>

        </div>

        <div class="card-body">

          <table class="table table-sm table-striped table-bordered">
            <caption>Contenedores registrados en este manifiesto.</caption>
            <thead>
              <tr class="text-center">
                <th>#</th>
                <th>Número</th>
                <th>Tamaño</th>
                <th>Procedencia</th>
                <th>Mercancía</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($manifiesto->contenedores as $contenedor)
              <tr class="text-center">
                <td>{{ $loop->iteration }}</td>
                <td>{{ $contenedor->numero }}</td>
                <td>{{ $contenedor->tamano }} {{ $contenedor->tipo }}</td>
                <td>{{ $contenedor->procedencia }}</td>
                <td>
                  {!! Str::limit($contenedor->comodity, 22, ' <a href="#" data-toggle="modal" data-target="#modalM'.$contenedor->id.'">(...)</a>') !!}

                  <!-- Modal -->
                  <div class="modal fade" id="modalM{{$contenedor->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                      <div class="modal-content">
                        <div class="modal-body">
                          {{ $contenedor->comodity }}
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        </div>
                      </div>
                    </div>
                  </div>

                </td>
              </tr>
              @empty
              <tr>
                <td colspan="6" class="text-center">
                  <br />
                  <br />
                  <br />
                  No hay contenedores
                  <br />
                  <br />
                  <br />
                  <form action="{{ route('manifiestos.upload.contenedor', $manifiesto->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                      <label for="excel">Importar Contenedores</label>
                      <input type="file" onchange="this.form.submit();" class="form-control @error('excel') is-invalid @enderror" value="{{ old('excel') }}" id="excel" name="excel">
                      @error('excel')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                      @enderror
                    </div>
                  </form>
                </td>
              </tr>
              @endforelse
            </tbody>
          </table>

        </div>

      </div>
    </div>
  </div>

  @endsection
