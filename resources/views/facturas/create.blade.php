@extends('layouts.app')
@section('titulo-pagina', 'Factura')
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
    {!! Form::open(['route' => 'facturas.store', 'method' => 'POST']) !!}
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
        <div v-for="(item, index) in items2" track-by="index">
            <input type="hidden" :name="'extras[' + index + '][id]'" :value="item.id">
            <input type="hidden" :name="'extras[' + index + '][nombre]'" :value="item.nombre">
            <input type="hidden" :name="'extras[' + index + '][monto]'" :value="item.costo">
            <input type="hidden" :name="'extras[' + index + '][tasa]'" :value="tasaDia">
            <input type="hidden" :name="'extras[' + index + '][monto1]'" value="0.16">
            <input type="hidden" :name="'extras[' + index + '][iva]'" :value="item.iva">
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

            <div v-if="cliente_data.notas && cliente_data.notas.length" class="card mt-3">
                <div class="card-header bg-dark text-white d-print-none">Nota de crédito</div>
                <div class="card-body">

                    <table class="table table-sm table-striped" id="tabla1">
                        <tbody>
                            <tr v-for="(item, index) in cliente_data.notas" track-by="index">
                                <th scope="row" class="align-middle">@{{ index+1 }}</th>
                                <td class="align-middle">@{{ item.monto }}</td>
                                <td class="align-middle">
                                    <a @click="notaCredito(index)" class="btn btn-sm btn-info text-white" href="#" title="Usar">
                                        <i class="fas fa-credit-card"></i>
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>

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
            <div class="card my-2" v-if="items.length > 0">
                <div class="card-header bg-dark text-white">Pago</div>
                <div class="card-body">

                    <div class="form-group">
                        <label for="tipo_pago_id">Tipo</label>
                        <select v-model="cambiobanco" class="form-control" id="tipo_pago_id" name="tipo_pago_id">
                            @foreach ($tipo_pagos as $tipo)
                            <option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="refencia">Refencia</label>
                        {!! Form::textarea('referencia', null, ['class'=>'form-control form-control-sm','rows'=>2,'placeholder'=>'Referencia']) !!}
                    </div>

                    <div class="form-group" v-if="cambiobanco == 5">
                        <label for="banco_id">Banco</label>
                        <select class="form-control" id="banco_id" name="banco_id">
                            @foreach ($bancos as $banco)
                            <option value="{{ $banco->id }}">{{ $banco->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group" v-if="cambiobanco == 5 || cambiobanco == 4">
                        <label for="tmonto">Monto</label>
                        <input class="form-control" type="number" id="tmonto" name="tmonto" step="0.01">
                    </div>

                    <div class="form-group">
                        <label for="tipo_pago_id">Otro Tipo de Pago</label>
                        <select v-model="cambiobanco1" class="form-control" id="tipo_pago_id1" name="tipo_pago_id1">
                            <option value=" ">NINGUNO</option>
                            @foreach ($tipo_pagos as $tipo)
                            <option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group" v-if="cambiobanco1 == 5">
                        <label for="banco_id2">Banco 2</label>
                        <select class="form-control" id="banco_id2" name="banco_id2">
                            @foreach ($bancos as $banco)
                            <option value="{{ $banco->id }}">{{ $banco->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group" v-if="cambiobanco1 != ' ' ">
                        <label for="tmonto1">Monto</label>
                        <input class="form-control" type="number" id="tmonto1" name="tmonto1" step="0.01">
                    </div>
                </div>
            </div>
        </div>
        <div class="col">

            <div class="card mb-3">
                <div class="card-header bg-dark text-white d-print-none">
                    Otros Productos
                    <a @click="agregarProducto" class="btn btn-sm float-right"><i class="fas fa-plus"></i> AGREGAR</a>
                </div>
                <div class="card-body">
                    <select class="form-control" v-model="producto">
                        <option disabled value="">Seleccione un elemento</option>
                        <option v-for="item in productos" :value="item.id" :key="item.id">
                            @{{ item.nombre }}
                        </option>
                    </select>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-dark text-white d-print-none">
                    Numero(s) (@{{ items.length }})
                    <button type="submit" onclick="if(!confirm('¿Está seguro que desea FACTURAR?')){return false;}" class="btn btn-sm btn-light float-right"><i class="fas fa-cash-register"></i> FACTURAR</button>
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
                            <tr v-for="(item, index) in items2" track-by="index">
                                <th scope="row" class="align-middle">@{{ index+1 }}</th>
                                <td class="align-middle">@{{ item.nombre }}</td>
                                <td class="align-middle" v-if="item.iva">@{{ ((tasaDia * item.costo) + ((tasaDia * item.costo)*0.16)).toLocaleString('us', {minimumFractionDigits: 2, maximumFractionDigits: 2}) }}</td>
                                <td class="align-middle" v-else>@{{ (tasaDia * item.costo).toLocaleString('us', {minimumFractionDigits: 2, maximumFractionDigits: 2}) }}</td>
                                <td class="align-middle">
                                    <a @click="updateSioNo2(index)" class="btn btn-sm btn-danger text-white" href="#" title="Eliminar"><i class="fas fa-minus-circle"></i></a>
                                </td>
                            </tr>
                            <tr v-if="items.length" track-by="index" class="mt-3 text-right">
                                <td colspan="2">
                                    <h4>SUB-TOTAL:</h4>
                                </td>
                                <td>
                                    <h4 v-if="notas">@{{ ((tasa*items.length) - parseFloat(notas.monto)+precio).toLocaleString('us', {minimumFractionDigits: 2, maximumFractionDigits: 2}) }}</h4>
                                    <h4 v-else>@{{ (tasa*items.length+precio).toLocaleString('us', {minimumFractionDigits: 2, maximumFractionDigits: 2}) }}</h4>
                                </td>
                                <td></td>
                            </tr>
                            <tr v-if="notas" class="mt-3 text-right">
                                <td colspan="2">
                                    <h4>NOTA CREDITO:</h4>
                                </td>
                                <td>
                                    <h4>@{{ parseFloat(notas.monto).toLocaleString('us', {minimumFractionDigits: 2, maximumFractionDigits: 2}) }}</h4>
                                    <input type="hidden" name="notaCredito" :value="parseFloat(notas.monto)">
                                    <input type="hidden" name="notaCreditoId" :value="notas.id">
                                </td>
                                <td></td>
                            </tr>
                            <tr v-if="items.length" track-by="index" class="mt-3 text-right">
                                <td colspan="2">
                                    <h4>TOTAL:</h4>
                                </td>
                                <td>
                                    <h4>@{{ (tasa*items.length+precio).toLocaleString('us', {minimumFractionDigits: 2, maximumFractionDigits: 2}) }}</h4>
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
            productos: [],
            items2: [],
            precio: 0,
            producto: '',

            clienteSearch: null,
            selectedCliente: null,

            inventarioSearch: null,
            selectedInventario: null,

            cliente_data: [],
            observaciones: null,

            tasa: parseFloat('{{ $moneda->valor }}'),
            tasaDia: parseFloat('{{ $moneda->valor }}'),

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
            cambiobanco1: ' ',

        },

        mounted() {
            //Get Clientes;

            this.tasa = this.aporte * this.tasa;

            axios.all([
                    axios.get('/clientes/autocomplete'),
                    axios.get('/inventarios/autocomplete'),
                    axios.get('/getListProductos')
                ])
                .then(axios.spread((clientes, inventarios, productos) => {
                    this.clientes = clientes.data
                    this.inventarios = inventarios.data
                    this.productos = productos.data
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
            cambiobanco: function() {
                this.cambiobanco1 = ' ';
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
            },
            updateSioNo2: function(index) {
                
                let producto = this.productos[index]
                this.precio = this.precio - (this.tasaDia * parseFloat(producto.costo));
                this.items2.splice(index, 1);
            },
            notaCredito: function(index) {
                let nota = this.cliente_data.notas[index];
                this.notas = nota;
                this.cliente_data.notas.splice(index, 1);
            },
            agregarProducto: function(index) {

                if(this.producto === '') {
                    alert('Seleccione un producto!');
                    return false;
                } else {

                    if(!confirm('¿Está seguro que desea AGREGAR A LA FACTURA?')){
                        return false;
                    } else {
                        let producto = this.productos.find(x => x.id === this.producto);
                        this.items2.push(producto);

                        if (producto.iva) {
                            let suma = this.tasaDia * producto.costo;
                            this.precio = this.precio + suma + ( suma * 0.16);
                        } else {
                            let suma = this.tasaDia * producto.costo;
                            this.precio = this.precio + suma;
                        }

                    }

                }

            }
        }
    });
</script>
@endsection