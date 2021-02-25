@extends('layouts.app')
@section('titulo-pagina', 'Preliquidar')
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
    {!! Form::open(['route' => 'preliquidaciones.store', 'method' => 'POST']) !!}
    <div class="row">
        <div class="col-4">
            <div class="alert alert-success">
                @foreach ($monedas as $item)
                @if($item->codigo != 'BS' && $item->codigo != 'PTR' && $item->codigo != 'EUR')
                <span><span class="font-weight-bold">{{ $item->codigo }}</span>: {{ number_format($item->valor,2) }}</span>
                <input type="hidden" name="base_value" id="base_value" value="{{ $item->valor }}">
                <input type="hidden" name="user_id" id="user_id" value="{{ auth()->user()->id }}">
                <input type="hidden" name="bl" id="bl" :value="bl">
                @endif
                @endforeach
            </div>
        </div>
        <div class="col">
            {!! Form::submit('Preliquidar', [
            'class' => 'btn btn-info text-white my-2 float-right',
            'onclick' => "if(!confirm('¿Está seguro que desea PRELIQUIDAR?')){return false;}" ]) !!}
        </div>
    </div>
    <div class="row">
        <div class="col-4">
            <div class="card d-print-inline">
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
                    <div class="form-group d-print-none">
                        <label class="form-control-label" for="dirección">Dirección: </label> <br>
                        <span v-if="selectedCliente">@{{ cliente_data.direccion }}</span>
                    </div>
                    <span class="d-none d-print-block">Dirección: @{{ cliente_data.direccion }}</span>
                    <div class="form-group d-print-none">
                        <label class="form-control-label" for="observacion">Observación</label>
                        {!! Form::textarea('observacion', null, ['class'=>'form-control form-control-sm','rows'=>2,'placeholder'=>'Observaciones', 'v-model' => 'observaciones']) !!}
                        <small id="observacionesHelpBlock" class="form-text text-muted">Observaciones adicionales</small>
                    </div>
                    <span v-if="observaciones != null" class="d-none d-print-block">observaciones: @{{ observaciones }}</span>
                </div>
            </div>
            <div class="card mt-3">
                <div class="card-header bg-dark text-white">Forma de Pago</div>
                <div class="card-body">
                    <div class="form-group">
                        {!! Form::label('moneda_id', 'Forma de Pago', ['class' => 'form-control-label']) !!}
                        {!! Form::select('moneda_id', \App\Moneda::pluck('nombre', 'id'), 1, ['class' => 'form-control', 'placeholder' => 'Selección', 'required']) !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-3 d-print-none">
            <div class="card my-2">
                <div class="card-header bg-dark text-white">Contenedor/BL</div>
                <div class="card-body">
                    <input class="form-control text-uppercase" type="text" name="neddle" id="neddle" placeholder="Serial / BL" v-model="neddle" autocomplete="off">
                    <button v-if="neddle.length > 4" type="button" class="btn btn-sm btn-info text-white mt-2" @click="search()">Buscar</button>
                </div>
            </div>
            <div class="card my-2" v-if="items.length > 0">
                <div class="card-header bg-dark text-white">Aportes</div>
                <div class="card-body">
                    @foreach ($aportes as $item)
                    <div class="form-group" style="padding: 8px;">
                        <input class="form-check-input" type="checkbox" value="1" id="aporte" name="aporte" checked>
                        <label class="form-check-label" for="defaultCheck1">
                            <small>{{ $item->nombre }}</small>
                        </label>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card my-2">
                <div class="card-header bg-dark text-white d-print-none">Numero(s) (@{{ items.length }})</div>
                <div class="card-body">
                    <small v-for="(item, index) in items">@{{ item.serial }} &nbsp; </small>
                </div>
            </div>
        </div>
    </div>

    <div class="row my-2">
        <div class="col">

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
            observaciones: null,

            items: [],
            itemSearch: null,
            selectedItem: null,
            item_data: [],

            detalles: [],
            aporte_id: null,
            aporte: null,
            iva: 0,

            //New
            neddle: '',
            bl: null,
        },

        mounted() {
            //Get Clientes;
            axios.get('/clientes/autocomplete')
                .then(response => {
                    this.clientes = response.data
                })
                .catch(function(error) {
                    console.log(error)
                });
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
            selectedItem: function() {}
        },

        methods: {
            search: function() {
                if (this.neddle.length > 4) {
                    axios.get('/inventarios/' + this.neddle + '/searchItem')
                        .then(response => {
                            if (this.items.length > 0) {
                                this.items = null;
                            }
                            if (response.data == false) {
                                Swal.fire({
                                    type: 'error',
                                    title: 'Oops...',
                                    text: 'Sin Registro!',
                                })
                            } else if (response.data == -1) {
                                Swal.fire({
                                    type: 'error',
                                    title: 'Oops...',
                                    text: 'Sin BL!',
                                })
                            } else {
                                this.items = response.data;
                                this.bl = this.items[0].bl;
                            }
                        })
                        .catch(function(error) {
                            console.log(error)
                        })
                }
            }
        }
    });
</script>
@endsection