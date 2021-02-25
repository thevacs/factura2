@extends('layouts.app')
@section('titulo-pagina', 'Reportes')
@section('content')
<div class="container" id="app">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header bg-dark text-white">
                    Reportes Filtro
                </div>
                <div class="card-body">
                        <form>
                            <div class="form-row">
                                <div class="form-group col">
                                    <label for="fmin">Desde</label>
                                    <input type="date" class="form-control" name="desde" id="desde">
                                </div>
                                <div class="form-group col">
                                    <label for="fmax">Hasta</label>
                                    <input type="date" class="form-control" name="hasta" id="hasta">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="cliente">Clientes</label>
                                <input v-if="selectedCliente" type="hidden" id="cliente" name="cliente" :value="selectedCliente">
                                <vue-bootstrap-typeahead :data="clientes" v-model="clienteSearch" placeholder="Buscar cliente" @hit="selectedCliente = $event" />
                            </div>
                                <button type="submit" class="btn btn-primary">Buscar</button>
                                <button type="reset" class="btn btn-secondary">Limpiar</button>
                            </form>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header bg-dark text-white">
                    Resultados
                    <a href="{{ route('facturas.reporte-excel',['reporte' => true, 'desde' => request()->desde, 'hasta' => request()->hasta, 'cliente' => request()->cliente]) }}" class="float-right btn btn-light btn-sm"> <i class="fas fa-file-excel"></i> Descargar</a>
                </div>
                <div class="card-body">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Fecha</th>
                                <th>Cliente</th>
                                <th>Monto</th>
                                <th>Tasa</th>
                                <th>Contenedores</th>
                                <th>Taquilla</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($facturas as $item)
                            <tr @if($item->anulada == 1) class="text-danger" @endif>
                                <td scope="row">{{ $item->id }} @if($item->anulada == 1) ANULADA @endif</td>
                                <td>{{ $item->created_at }}</td>
                                <td>{{ $item->nombre ? $item->nombre : '' }}</td>
                                <td>{{ number_format($item->monto,2) }}</td>
                                <td>{{ number_format($item->tasa,2) }}</td>
                                <td>{{ $item->contenedores }}</td>
                                <td>{{ $item->usuario }}</td>                            
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

@section('js')
<script>
    var app = new Vue({
        el: '#app',
        data: {
            clientes: [],
            clienteSearch: null,
            selectedCliente: null,
        },
        mounted() {
            axios.all([
                    axios.get('/clientes/autocomplete'),
                    axios.get('/inventarios/autocomplete')
                ])
                .then(axios.spread((clientes, inventarios) => {
                    this.clientes = clientes.data
                    this.inventarios = inventarios.data
                }));
        },
    });
</script>
@endsection