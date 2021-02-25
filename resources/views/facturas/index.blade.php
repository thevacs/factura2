@extends('layouts.app')
@section('titulo-pagina', 'Facturas')
@section('content')
<div class="container" id="app">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <i class="fas fa-clipboard mr-1"></i> Facturas
                    <a href="{{ route('facturas.create') }}" class="float-right btn btn-light btn-sm ml-1"> <i
                            class="fas fa-plus"></i> Nueva Factura</a>
                    <a href="{{ route('facturas.reporte') }}" class="float-right btn btn-light btn-sm ml-1"> <i
                            class="fas fa-file-pdf"></i> Reporte Diario</a>
                    <a href="{{ route('facturas.reporte-excel') }}" class="float-right btn btn-light btn-sm"> <i
                            class="fas fa-file-excel"></i> Reporte</a>
                </div>
                <div class="card-body pt-0">
                    <form action="{{ route('facturas.index') }}" class="form-inline float-right my-3">
                        {!! Form::label('buscar', 'Buscar', ['class' => 'font-weight-bold form-control-label mr-2']) !!}
                        {!! Form::text('buscar', request()->buscar, ['class' => 'form-control form-control-sm mr-2',
                        'placeholder' => '#']) !!}
                        {{ Form::button('<i class="fa fa-search text-white"></i>', ['type' => 'submit', 'class' => 'btn btn-info btn-sm mr-1'] )  }}
                        <a class="btn btn-sm btn-secondary" href="{{ route('facturas.index') }}"><i
                                class="fas fa-redo"></i></a>
                    </form>
                    <table class="table table-sm">
                        <thead class="thead-light">
                            <tr class="text-center">
                                <th>#</th>
                                <th>Fecha</th>
                                <th width="20%">Cliente</th>
                                <th>Tipo</th>
                                <th>Contenedores</th>
                                <th>Monto</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($facturas->sortByDesc('id') as $item)
                            <tr class="text-center" @if($item->anulada == 1) class="text-danger" @endif>
                                <td scope="row">{{ $item->id }} @if($item->anulada == 1) ANULADA @endif</td>
                                <td>{{ $item->created_at }}</td>
                                <td>{{ $item->cliente ? $item->cliente->nombre : '' }}</td>
                                <td>{{ $item->tipopago ? $item->tipopago->nombre : '' }}</td>
                                <td>{{ $item->items ? $item->items->count() : 0 }}</td>
                                <td>{{ $item->items ? number_format($item->items->sum('precio'),2) : 0 }}</td>
                                <td>
                                    @if(1==1)
                                    <a class="btn btn-sm btn-primary" href="{{ route('facturas.show', $item->id) }}"
                                        title="Detalle Factura"><i class="fas fa-eye"></i></a>
                                    <a class="btn btn-sm btn-warning" href="{{ route('facturas.edit', $item->id) }}"
                                        title="Editar Factura"><i class="fas fa-edit"></i></a>
                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                        data-target="#modal{{$item->id}}" title="Anular Factura">
                                        <i class="fas fa-ban"></i>
                                    </button>

                                    <div class="modal fade" id="modal{{$item->id}}" tabindex="-1" role="dialog"
                                        aria-labelledby="modal{{$item->id}}Label" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header bg-dark text-light">
                                                    <h5 class="modal-title" id="modal{{$item->id}}Label"><i
                                                            class="fas fa-ban text-danger mr-1"></i> Anular Factura</h5>
                                                    <button type="button" class="close text-light" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="anular{{$item->id}}"
                                                        action="{{ route('facturas.anular', $item->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('PUT')

                                                        <div class="form-group">
                                                            <label for="nf_factura" class="col-form-label">NÚMERO DE LA
                                                                FACTURA FISCAL:</label>
                                                            <input type="text" class="form-control" id="nf_factura"
                                                                name="nf_factura" placeholder="Numero Factura Fiscal"
                                                                required>
                                                            <input type="hidden" class="form-control" id="tipo"
                                                                name="tipo" value="fiscal">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="contenedor" class="col-form-label">NÚMERO DE
                                                                CONTENEDOR:</label>
                                                            <input type="text" class="form-control" id="contenedor"
                                                                name="contenedor" placeholder="Numero contenedor"
                                                                required>
                                                        </div>
                                                    </form>
                                                    <form id="anular2{{$item->id}}"
                                                        action="{{ route('facturas.anular', $item->id) }}" method="POST"
                                                        style="display: none;">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" class="form-control" id="tipo" name="tipo"
                                                            value="local">
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Canelar</button>
                                                    <button type="button" onclick="event.preventDefault();
                                        if(!confirm('¿Está seguro que desea Anular la factura?')){return false;}
                                        document.getElementById('anular2{{$item->id}}').submit();"
                                                        class="btn btn-primary">ANULAR LOCAL</button>
                                                    <button type="button" onclick="event.preventDefault();
                                        if(!confirm('¿Está seguro que desea Anular la factura?')){return false;}
                                        document.getElementById('anular{{$item->id}}').submit();"
                                                        class="btn btn-danger">NOTA DE CREDITO FISCAL</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{ $facturas->appends(request()->query())->links() }}

                    <!-- Modal -->
                    <div class="modal fade" id="productoModal" tabindex="-1" role="dialog"
                        aria-labelledby="productoModalLabel" aria-hidden="true">
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
                                                <td scope="row" class="text-center">@{{ factura.detalles.cantidad }}
                                                </td>
                                                <td>
                                                    @{{ factura.detalles.producto }} <br>
                                                    @{{ factura.detalles.serial }} <br>
                                                    <small>@{{ factura.detalles.descripcion }}</small>
                                                </td>
                                                <td class="text-right">@{{ factura.detalles.precio }}</td>
                                                <td class="text-right">
                                                    @{{ factura.detalles.cantidad * factura.detalles.precio }}</td>
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
<script>
    var app = new Vue({
        el: '#app',

        data: {
            factura: null
        },

        methods: {
            getFactura: function(item) {
                const url = 'facturas/' + item + '/printerFiscal'
                axios.get(url).then(response => {
                    this.factura = response.data;
                }).catch(error => {
                    console.log(error)
                })
            }
        }
    });
</script>
@endsection