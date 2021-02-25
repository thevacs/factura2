@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row my-2">
        <div class="col">
            <div class="card">
                <div class="card-header bg-dark text-white">
                    Exoneraciones
                    @if(!in_array(Auth::user()->id, [10, 11]))
                    <a href="{{ route('exoneraciones.create') }}" class="float-right ml-3 btn btn-light btn-sm"> <i class="fas fa-plus"></i> Exonerar</a>
                    @endif
                </div>
                <div class="card-body pt-0">
                    <form action="{{ route('exoneraciones.index') }}" class="form-inline float-right my-3">
                        {!! Form::label('buscar', 'Buscar', ['class' => 'form-control-label mr-3']) !!}
                        {!! Form::text('buscar', request()->buscar, ['class' => 'form-control form-control-sm mr-3', 'placeholder' => 'Cliente/Nombre']) !!}
                        {{ Form::button('<i class="text-white fa fa-search"></i>', ['type' => 'submit', 'class' => 'btn btn-info btn-sm mr-3'] )  }}
                    </form>
                    <table class="table table-sm">
                        <caption>Listado</caption>
                        <thead class="thead-light">
                            <tr class="text-center">
                                <th>#</th>
                                <th>RIF</th>
                                <th>Cliente</th>
                                <th>BL</th>
                                <th class="text-center">Cnts/Total</th>
                                <th class="text-center">Fecha</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($preliquidaciones as $item)

                            <tr class="text-center">
                                <td scope="row">{{ sprintf('%06d', $item->id) }}</td>
                                <td>{{ $item->cliente ? $item->cliente->rif : null  }}</td>
                                <td>{{ $item->cliente ? $item->cliente->nombre : null  }}</td>
                                <td>{{ $item->detalles->first()? $item->detalles->first()->inventario->bl : null  }}</td>
                                <td class="text-center">{{ $item->detalles->count() }}</td>
                                <td class="text-center">{{ $item->created_at->format('d-m-Y') }}</td>
                                <td class="text-center">
                                    <a class="btn btn-sm btn-info text-white" href="{{ route('exoneraciones.printPreliquidacion', $item->id) }}" title="Detalles"><i class="fas fa-eye"></i></a>

                                    @if(!in_array(Auth::user()->id, [10, 11]))
                                    <a href="{{ route('exoneraciones.anular', $item->id) }}" class="float-right btn btn-danger btn-sm" onclick="event.preventDefault();
                                        if(!confirm('¿Está seguro que desea Anular la Exoneracion?')){return false;}
                                        document.getElementById('anular{{$item->id}}').submit();">
                                        <i class="fas fa-ban"></i>
                                    </a>
                                    <form id="anular{{$item->id}}" action="{{ route('exoneraciones.anular', $item->id) }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $preliquidaciones->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection