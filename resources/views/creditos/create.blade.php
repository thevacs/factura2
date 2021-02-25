@extends('layouts.app')
@section('titulo-pagina', 'Creditos')
@section('content')
<div class="container" id="app" v-cloak>
    @if ($errors->any())
    <div class="row">
        <div class="col">
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    @endif
    {!! Form::open(['route' => 'creditos.store', 'method' => 'POST']) !!}
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header bg-dark text-white d-print-none">Cliente</div>
                <div class="card-body">
                    <div class="form-group">
                        <span>RIF: <span v-if="selectedCliente">@{{ cliente_data.rif }}</span> </span>
                        <input v-if="selectedCliente" type="hidden" id="cliente_id" name="cliente_id" :value="cliente_data.id">
                    </div>
                    <div class="form-group">
                        Cliente:
                        <span class="mr-2 d-print-none">
                            <vue-bootstrap-typeahead :data="clientes" v-model="clienteSearch" placeholder="Buscar cliente" @hit="selectedCliente = $event" />
                        </span>
                        <span class="d-none d-print-block">Cliente: @{{ clienteSearch }}</span>
                    </div>
                    <div class="form-group">
                        <label for="monto">Monto</label>
                        <input class="form-control" type="number" id="monto" name="monto" step="0.01">
                    </div>
                    <div class="form-group">
                        <label for="observaciones">Observaciones</label>
                        <textarea class="form-control" id="observacion" name="observacion"></textarea>
                    </div>
                    <button type="submit" onclick="if(!confirm('¿Está seguro que desea CREAR LA NOTA DE CREDITO?')){return false;}" class="btn btn-primary">GUARDAR</button>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
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

            cliente_data: [],
        },
        mounted() {
            //Get Clientes;
            axios.all([
                    axios.get('/clientes/autocomplete')
                ])
                .then(axios.spread((clientes) => {
                    this.clientes = clientes.data
                }));
        },
        watch: {
            selectedCliente: function() {
                axios.post('/clientes/getCliente', {cliente: this.selectedCliente})
                    .then(response => {
                        this.cliente_data = response.data
                    })
                    .catch(function(error) {
                        console.log(error)
                    })
            },
        }
    });
</script>
@endsection