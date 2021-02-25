@extends('layouts.app')
@section('titulo-pagina', 'EXONERAR')
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
    {!! Form::open(['route' => 'exoneraciones.store', 'method' => 'POST']) !!}
    <div class="row">
        @php $moneda= App\Moneda::find(2); @endphp
        <input type="hidden" name="aporte" id="aporte" value="1">
        <input type="hidden" name="moneda_id" id="moneda_id" value="1">
        <input type="hidden" name="base_value" id="base_value" value="{{ $moneda->valor }}">
        <input type="hidden" name="user_id" id="user_id" value="{{ auth()->user()->id }}">
        <input type="hidden" name="bl" id="bl" :value="bl">

        <div v-for="(item, index) in items" track-by="index">
            <input type="hidden" :name="'seriales[' + index + '][id]'" :value="item.id">
            <input type="hidden" :name="'seriales[' + index + '][seva]'" :value="item.seva">
        </div>
    </div>
    <div class="row">
        <div class="col-4">
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
                    <span class="d-none d-print-block">Dirección: @{{ cliente_data.direccion }}</span>
                </div>
            </div>

        </div>
        <div class="col-3">
            <div class="card">
                <div class="card-header bg-dark text-white">
                    Contenedor/BL

                    <a href="{{ route('facturas.create') }}" class="btn btn-sm btn-light float-right">
                        <i class="fas fa-sync-alt"></i> Recargar
                    </a>

                </div>
                <div class="card-body">
                    <vue-bootstrap-typeahead :data="inventarios" v-model="inventarioSearch" placeholder="Serial / BL" @hit="selectedInventario = $event" />
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <div class="card-header bg-dark text-white d-print-none">
                    Numero(s) (@{{ items.length }})
                    <button type="submit" onclick="if(!confirm('¿Está seguro que desea EXONERAR?')){return false;}" class="btn btn-sm btn-light float-right"><i class="fas fa-cash-register"></i> EXONERAR</button>
                </div>
                <div class="card-body">
                    <table class="table table-sm table-striped" id="tabla1">
                        <tbody>
                            <tr v-for="(item, index) in items" track-by="index">
                                <th scope="row" class="align-middle">@{{ index+1 }}</th>
                                <td class="align-middle">@{{ item.serial }}</td>
                                <td class="align-middle">@{{ tasa.toLocaleString('us', {minimumFractionDigits: 2, maximumFractionDigits: 2}) }}</td>
                                <td class="align-middle">
                                    <a @click="updateSioNo(index)" class="btn btn-sm btn-danger text-white" href="#" title="Eliminar"><i class="fas fa-minus-circle"></i></a>
                                </td>
                            </tr>
                            <tr v-if="items.length" track-by="index" class="mt-3 text-right">
                                <td colspan="2">
                                    <h4>SUB-TOTAL:</h4>
                                </td>
                                <td>
                                    <h4>@{{ (tasa*items.length).toLocaleString('us', {minimumFractionDigits: 2, maximumFractionDigits: 2}) }}</h4>
                                </td>
                                <td></td>
                            </tr>
                            <tr v-if="items.length" track-by="index" class="mt-3 text-right">
                                <td colspan="2">
                                    <h4>TOTAL:</h4>
                                </td>
                                <td>
                                    <h4>@{{ (tasa*items.length).toLocaleString('us', {minimumFractionDigits: 2, maximumFractionDigits: 2}) }}</h4>
                                </td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>


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
            notas: null,
            inventarios: [],

            clienteSearch: null,
            selectedCliente: null,

            inventarioSearch: null,
            selectedInventario: null,

            cliente_data: [],
            observaciones: null,

            tasa: parseFloat('{{ $moneda->valor }}'),

            items: [],
            itemSearch: null,
            selectedItem: null,
            item_data: [],

            detalles: [],
            aporte_id: null,
            aporte: parseFloat('{{ $aportes->first()->valor }}'),
            iva: 0,

            //New
            neddle: '',
            bl: null,

            cambiobanco: 1,

        },

        mounted() {
            //Get Clientes;

            this.tasa = this.aporte * this.tasa;

            axios.all([
                    axios.get('/clientes/autocomplete'),
                    axios.get('/inventarios/autocomplete')
                ])
                .then(axios.spread((clientes, inventarios) => {
                    this.clientes = clientes.data
                    this.inventarios = inventarios.data
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
            selectedInventario: function() {
                axios.get('/inventarios/' + this.inventarioSearch + '/searchItem')
                    .then(response => {
                        if (response.data == false) {
                            alert('Error, no existe el BL/Contenedor');
                            this.inventarioSearch = '';
                        } else {
                            if (this.items.length > 0) {
                                this.items = [];
                            } else {
                                this.items = response.data;
                                this.bl = this.items[0].bl;
                            }
                        }
                    })
                    .catch(function(error) {
                        console.log(error)
                    })
            }
        },
        methods: {
            search: function() {
                if (this.neddle.length > 4) {
                    axios.get('/inventarios/' + this.neddle + '/searchItem')
                        .then(response => {
                            if (response.data == false) {
                                alert('Error, no existe el BL/Contenedor');
                                this.neddle = '';
                            } else {
                                if (this.items.length > 0) {
                                    this.items = null;
                                } else {
                                    this.items = response.data;
                                    this.bl = this.items[0].bl;
                                }
                            }
                        })
                        .catch(function(error) {
                            console.log(error)
                        })
                }
            },
            updateSioNo: function(index) {
                //limpiamos el input de buscar bl
                if (this.items.length == 1) {
                    this.bl = ''
                    this.inventarioSearch = ''
                    this.selectedInventario = ''
                }
                this.items.splice(index, 1);
            }
        }
    });
</script>
@endsection