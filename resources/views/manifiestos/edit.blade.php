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
          Editar Manifiesto #{{ $manifiesto->id }} {{ $manifiesto->buque }} - {{ $manifiesto->fecha }}
          <a href="{{ URL::previous() }}" class="float-right btn btn-light btn-sm"> <i class="fas fa-long-arrow-alt-left"></i> Atrás</a>
        </div>

        <div class="card-body">

          <form method="POST" action="{{ route('manifiestos.update', $manifiesto->id) }}">
            @csrf
            @method('PUT')
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="buque">Nombre del Buque</label>
                <input type="text" class="form-control @error('buque') is-invalid @enderror" id="buque" name="buque" value="{{ old('buque') ?? $manifiesto->buque }}" placeholder="MAERKS WISMARK" required>
                @error('buque')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
              <div class="form-group col-md-6">
                <label for="fecha">Fecha del Buque</label>
                <input type="text" class="form-control @error('fecha') is-invalid @enderror" id="fecha" name="fecha" value="{{ old('fecha') ?? $manifiesto->fecha }}" required>
                @error('fecha')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>

            <button type="submit" class="btn btn-primary">Editar</button>
          </form>

        </div>

      </div>

      <div class="card mt-5">
        <div class="card-header text-white bg-primary mb-3">
          Editar Contenedores
          <a href="{{ route('manifiestos.destroyContenedores', $manifiesto->id) }}" class="float-right btn btn-danger btn-sm" onclick="event.preventDefault();
                      if(!confirm('¿Está seguro que desea borrar todos los contenedores de este manifiesto?')){return false;}
                      document.getElementById('eliminar{{$manifiesto->id}}').submit();">
            <i class="fas fa-trash-alt"></i> Eliminar Todos los Contenedores
          </a>
          <form id="eliminar{{$manifiesto->id}}" action="{{ route('manifiestos.destroyContenedores', $manifiesto->id) }}" method="POST" style="display: none;">
            @csrf
            @method('DELETE')
          </form>

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
                <th></th>
              </tr>
            </thead>
            <tbody>
              @forelse ($manifiesto->contenedores as $contenedor)
              <tr class="text-center">
                <td>{{ $loop->iteration }}</td>
                <td>{{ $contenedor->numero }}</td>
                <td>{{ $contenedor->tamano }} {{ $contenedor->tipo }}</td>
                <td>{{ $contenedor->procedencia }}</td>
                <td>{!! Str::limit($contenedor->comodity, 22, ' <a href="#" data-toggle="modal" data-target="#modalM'.$contenedor->id.'">(...)</a>') !!}</td>
                <td class="align-middle">
                  <a href="#" data-toggle="modal" data-target="#modal{{$contenedor->id}}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                  <a href="{{ route('manifiestos.destroy.contenedor', [$manifiesto->id, $contenedor->id]) }}" class="float-right btn btn-danger btn-sm" onclick="event.preventDefault();
                      if(!confirm('¿Está seguro que desea borrarlo?')){return false;}
                      document.getElementById('eliminar{{$contenedor->id}}').submit();">
                    <i class="fas fa-trash-alt"></i>
                  </a>

                  <!-- Modal -->
                  <div class="modal fade" id="modal{{$contenedor->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalCenterTitle">Contenedor {{$contenedor->numero}}</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <form method="POST" action="{{ route('manifiestos.update.contenedor', [$manifiesto->id, $contenedor->id]) }}">
                          @csrf
                          @method('PUT')
                          <div class="modal-body">

                            <div class="form-row">
                              <div class="col">
                                <label for="numero">Contenedor</label>
                                <input type="text" class="form-control" name="numero" id="numero" value="{{ $contenedor->numero }}" require autofocus placeholder="Número">
                              </div>
                              <div class="col">
                                <label for="tamano">Tamaño</label>
                                <select class="custom-select" id="tamano" name="tamano" required>
                                  <option selected disabled value="">Eliga...</option>
                                  <option value="20" @if($contenedor->tamano == 20) selected @endif>20</option>
                                  <option value="40" @if($contenedor->tamano == 40) selected @endif>40</option>
                                  <option value="45" @if($contenedor->tamano == 45) selected @endif>45</option>
                                </select>
                              </div>
                              <div class="col">
                                <label for="tamano">Tipo</label>
                                <select class="custom-select" id="tipo" name="tipo" required>
                                  <option selected disabled value="">Eliga...</option>
                                  <option value="CH" @if($contenedor->tipo == 'CH') selected @endif>CH</option>
                                  <option value="FR" @if($contenedor->tipo == 'FR') selected @endif>FR</option>
                                  <option value="DC" @if($contenedor->tipo == 'DC') selected @endif>DC</option>
                                  <option value="HC" @if($contenedor->tipo == 'HC') selected @endif>HC</option>
                                  <option value="OT" @if($contenedor->tipo == 'OT') selected @endif>OT</option>
                                  <option value="RF" @if($contenedor->tipo == 'RF') selected @endif>RF</option>
                                  <option value="TK" @if($contenedor->tipo == 'TK') selected @endif>TK</option>
                                </select>
                              </div>
                            </div>

                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>

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

                  <form id="eliminar{{$contenedor->id}}" action="{{ route('manifiestos.destroy.contenedor', [$manifiesto->id, $contenedor->id]) }}" method="POST" style="display: none;">
                    @csrf
                    @method('DELETE')
                  </form>

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
