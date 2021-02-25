@extends('layouts.app')
@section('titulo-pagina', 'Facturas')
@section('content')
<div class="container" id="app">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header bg-dark text-white">
                    Notas de Créditos ({{ $facturas->count() }} {{ request()->usada ? 'usadas' : 'activas' }})
                    <a href="#" onclick="window.print()" class="float-right ml-2 btn btn-light btn-sm"><i class="fas fa-print"></i> IMPRIMIR</a>
                    <a href="{{ route('creditos.index', ['usada' => true]) }}" class="float-right ml-2 btn btn-light btn-sm"><i class="fas fa-check"></i> Usadas</a>
                    <a href="{{ route('creditos.create') }}" class="float-right btn btn-light btn-sm ml-1"> <i class="fas fa-plus"></i> Nueva Nota de Crédito</a>
                    <a href="{{ route('creditos.index') }}" class="float-right ml-2 btn btn-light btn-sm">
                        <i class="fas fa-arrow-left"></i> Regresar
                    </a>
                </div>
                <div class="card-body">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Fecha</th>
                                <th width="20%">Cliente</th>
                                <th width="20%">Observación</th>
                                <th>Monto</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($facturas->sortByDesc('id') as $item)
                            <tr @if($item->anulada == 1) class="text-muted" style="text-decoration: line-through;" @endif>
                                <td scope="row">{{ $item->id }}</td>
                                <td>{{ $item->created_at }}</td>
                                <td>{{ $item->cliente->rif }} - {{ $item->cliente->nombre }}</td>
                                <td>{{ $item->observacion }}</td>
                                <td>{{ number_format($item->monto,2) }}</td>
                                <td>
                                    @if($item->anulada == 0)
                                    <a class="btn btn-sm btn-info text-white" href="{{ route('creditos.show', $item->id) }}" title="Detalles"><i class="fas fa-eye"></i></a>
                                    <a class="btn btn-sm btn-warning text-white" href="{{ route('creditos.edit', $item->id) }}" title="Detalles"><i class="fas fa-edit"></i></a>
                                    <a href="{{ route('creditos.destroy', $item->id) }}" class="btn btn-danger btn-sm" onclick="event.preventDefault();
                                        if(!confirm('¿Está seguro que desea elminar la nota de credito?')){return false;}
                                        document.getElementById('anular{{$item->id}}').submit();">
                                        <i class="fas fa-ban"></i>
                                    </a>
                                    <form id="anular{{$item->id}}" action="{{ route('creditos.destroy', $item->id) }}" method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!-- Modal -->
                    <div class="modal fade" id="productoModal" tabindex="-1" role="dialog" aria-labelledby="productoModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="productoModalLabel">Detalles</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Cantidad</th>
                                                <th>Item</th>
                                                <th>Precio</th>
                                                <th>Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-if="factura">
                                                <td scope="row" class="text-center">@{{ factura.detalles.cantidad }}</td>
                                                <td>
                                                    @{{ factura.detalles.producto }} <br>
                                                    @{{ factura.detalles.serial }} <br>
                                                    <small>@{{ factura.detalles.descripcion }}</small>
                                                </td>
                                                <td class="text-right">@{{ factura.detalles.precio }}</td>
                                                <td class="text-right">@{{ factura.detalles.cantidad * factura.detalles.precio }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@section('js')
<script type="text/javascript">
    const toast = swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 4000
    });
</script>
@endsection