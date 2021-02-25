@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card text-center">
                <div class="card-header bg-dark text-light h3 font-weight-bold">Dashboard</div>

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

                    <h2>
                        {{ Config::get('empresa.nombre') }}
                    </h2>
                    <hr>
                    @if($resultados != null)
                        @foreach($resultados as $contenedor)
                            <div class="text-left">
                                <span><i class="fas fa-file-invoice-dollar"></i> FACTURA: <b>{{ $contenedor->factura_id }}</b></span> <br />
                                <span><i class="fas fa-building"></i> CLIENTE: <b>{{ $contenedor->factura->cliente->nombre }}</b></span> <br />
                                <span><i class="fas fa-truck"></i> CONTENEDOR: <b>{{ $contenedor->serial }}</b></span> <br />
                                <span><i class="fas fa-file-alt"></i> DESCRIPCIÓN: <b>{{ $contenedor->descripcion }}</b></span> <br />
                                <span><i class="fas fa-clock"></i> FECHA: <b>{{ $contenedor->factura->created_at }}</b></span> <br />
                            </div>
                            <h3> Otros Contenedores de la Factura </h3>
                            <div class="text-left">
                                @foreach($contenedor->factura->items as $item)
                                    @if ($loop->count === 1)
                                        @break
                                    @endif
                                    <hr />
                                    <span><i class="fas fa-truck"></i> CONTENEDOR: <b><a href="{{route('home', ['contenedor' => $item->tags ])}}"> {{ $item->tags }}</a></b></span> <br />
                                @endforeach
                            </div>
                            @if (!$loop->last)
                                <hr />
                            @endif
                        @endforeach
                        @if($exoneraciones != null)
                            @foreach($exoneraciones as $contenedor)
                            <h4 class="text-danger"> Contenedor Exonerado </h4>
                            <hr>
                            <div class="text-left">
                                <span><i class="fas fa-file-invoice-dollar"></i> FECHA DE EXONERACIÓN: <b>{{ $contenedor->created_at->format('d-m-Y') }}</b></span> <br />
                                <span><i class="fas fa-building"></i> BL: <b>{{ $contenedor->bl }}</b></span> <br />
                                <span><i class="fas fa-truck"></i> CONTENEDOR: <b>{{ $contenedor->serial }}</b></span> <br />
                                <span><i class="fas fa-file-alt"></i> DESCRIPCIÓN: <b>{{ $contenedor->descripcion }}</b></span> <br />
                                <span><i class="fas fa-clock"></i> CLIENTE: <b>{{ App\Cliente::find($contenedor->cliente_id)->nombre }}</b></span> <br />
                            </div>
                            @endforeach                       
                        @endif
                        @if($noFacturado != null)                            
                            <h4 class="text-info font-weight-bold"> Contenedor No Facturado </h4>
                            <hr>
                            <div class="text-left">
                                <span><i class="fas fa-file-invoice-dollar"></i> Serial: <b>{{ $noFacturado->serial }}</b></span> <br />
                                <span><i class="fas fa-building"></i> BL: <b>{{ $noFacturado->bl }}</b></span> <br />
                                <span><i class="fas fa-truck"></i> Descripción: <b>{{ $noFacturado->descripcion }}</b></span> <br />
                            </div>                                                  
                        @endif
                    @else
                        <a class="btn btn- btn-secondary" href="{{ route('validacion') }}">{{ __('Verificación') }}</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection