@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <p class="text-center">
                <small><b>{{ Config::get('empresa.nombre') }}</b></small><br>
                <small><b>RIF: {{ Config::get('empresa.rif') }}</b></small><br>
                <small><b>{{ Config::get('empresa.direccion') }}</b></small>
            </p>
            <a class="d-print-none btn btn-sm btn-danger text-white" href="#" onclick="anular({{$anulacion->id}})">ANULAR FISCAL</a>
            <a class="d-print-none btn btn-sm btn-warning" href="{{ route('facturas.index') }}">Finalizar</a>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <img class="img-fluid float-right" style="max-height: 160px;" src="{{ asset('storage/img/5.png') }}" alt="">
        </div>
    </div>
</div>

<script>
    function anular(id) {
        if (window.isElectron) {
            if (confirm('ESTA SEGURO?')) {
                window.ipcRenderer.send('anulacion', id)
            }
        } else {
            alert('Tiene que anularlo desde la aplicación.');
        }
    }
</script>
@endsection