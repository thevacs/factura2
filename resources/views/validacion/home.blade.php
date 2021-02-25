@extends('layouts.app')

@section('content')
<div class="container" id="app">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header bg-dark text-white text-center">
                    <h3>Verificación de Contenedores</h3>
                </div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    @if (session('message'))
                    <div class="alert alert-warning" role="alert">
                        <b>{{ session('message') }}</b>
                    </div>
                    @endif

                    <div>
                        <vue-bootstrap-typeahead :data="inventarios" v-model="inventarioSearch" placeholder="NUMERO DE CONTENEDOR" @hit="selectedInventario = $event" />
                    </div>
                    <br />
                    <div v-if="cargando">
                        <span class="btn btn-xl text-center btn-light">
                            <i class="fas fa-sync-alt"></i> Cargando ...
                        </span>
                    </div>
                    <div v-if="tipo === 'facturado'">
                        <span class="text-success font-weight-bold text-center">FACTURADO</span> <br />
                        <span><i class="fas fa-file-invoice-dollar"></i> FACTURA: <b>@{{ inventarioSearch2.factura_id }}</b></span> <br />
                        <span><i class="fas fa-truck"></i> CONTENEDOR: <b>@{{ inventarioSearch2.serial }}</b></span> <br />
                        <span><i class="fas fa-file-alt"></i> DESCRIPCIÓN: <b>@{{ inventarioSearch2.descripcion }}</b></span> <br />
                        <span><i class="fas fa-sort-numeric-up-alt"></i> BL: <b>@{{ inventarioSearch2.bl }}</b></span> <br />
                        <span><i class="fas fa-clock"></i> FECHA: <b>@{{ inventarioSearch2.factura.created_at }}</b></span> <br />
                    </div>
                    
                    <div v-if="tipo === 'exonerado'">
                        <span class="text-danger font-weight-bold">EXONERADO</span> <br />
                        <span><i class="fas fa-truck"></i> CONTENEDOR: <b>@{{ inventarioSearch2.serial }}</b></span> <br />
                        <span><i class="fas fa-file-alt"></i> DESCRIPCIÓN: <b>@{{ inventarioSearch2.descripcion }}</b></span> <br />
                        <span><i class="fas fa-sort-numeric-up-alt"></i> BL: <b>@{{ inventarioSearch2.bl }}</b></span> <br />
                        <span><i class="fas fa-clock"></i> FECHA: <b>@{{ inventarioSearch2.created_at }}</b></span> <br />
                    </div>

                    <div v-if="tipo === 'noFacturado'">
                        <span class="text-info font-weight-bold">NO FACTURADO</span> <br />
                        <span><i class="fas fa-truck"></i> CONTENEDOR: <b>@{{ inventarioSearch2.serial }}</b></span> <br />
                        <span><i class="fas fa-file-alt"></i> DESCRIPCIÓN: <b>@{{ inventarioSearch2.descripcion }}</b></span> <br />
                        <span><i class="fas fa-sort-numeric-up-alt"></i> BL: <b>@{{ inventarioSearch2.bl }}</b></span> <br />
                    </div>

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
            inventarios: [],
            inventarioSearch: null,
            inventarioSearch2: [],
            tipo: null,
            selectedInventario: null,
            cargando: false
        },

        mounted() {
            axios.get('/api/validacion')
                .then(response => {
                    this.inventarios = response.data
                });
        },
        watch: {
            selectedInventario: function() {
                this.cargando = !this.cargando

                axios.get('/api/validacion?id=' + this.inventarioSearch)
                    .then(response => {

                        this.inventarioSearch2 = response.data.data
                        this.tipo = response.data.tipo
                        this.cargando = !this.cargando

                    })
                    .catch(function(error) {
                        console.log(error)
                    })
            }
        }
    });
</script>
@endsection