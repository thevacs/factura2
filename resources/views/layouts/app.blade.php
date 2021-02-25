<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        [v-cloak]>* {
            display: none;
        }

        [v-cloak]::before {
            content: " ";
            display: block;
            width: 16px;
            height: 16px;
            background-image: url('data:image/gif;base64,R0lGODlhEAAQAPIAAP///wAAAMLCwkJCQgAAAGJiYoKCgpKSkiH/C05FVFNDQVBFMi4wAwEAAAAh/hpDcmVhdGVkIHdpdGggYWpheGxvYWQuaW5mbwAh+QQJCgAAACwAAAAAEAAQAAADMwi63P4wyklrE2MIOggZnAdOmGYJRbExwroUmcG2LmDEwnHQLVsYOd2mBzkYDAdKa+dIAAAh+QQJCgAAACwAAAAAEAAQAAADNAi63P5OjCEgG4QMu7DmikRxQlFUYDEZIGBMRVsaqHwctXXf7WEYB4Ag1xjihkMZsiUkKhIAIfkECQoAAAAsAAAAABAAEAAAAzYIujIjK8pByJDMlFYvBoVjHA70GU7xSUJhmKtwHPAKzLO9HMaoKwJZ7Rf8AYPDDzKpZBqfvwQAIfkECQoAAAAsAAAAABAAEAAAAzMIumIlK8oyhpHsnFZfhYumCYUhDAQxRIdhHBGqRoKw0R8DYlJd8z0fMDgsGo/IpHI5TAAAIfkECQoAAAAsAAAAABAAEAAAAzIIunInK0rnZBTwGPNMgQwmdsNgXGJUlIWEuR5oWUIpz8pAEAMe6TwfwyYsGo/IpFKSAAAh+QQJCgAAACwAAAAAEAAQAAADMwi6IMKQORfjdOe82p4wGccc4CEuQradylesojEMBgsUc2G7sDX3lQGBMLAJibufbSlKAAAh+QQJCgAAACwAAAAAEAAQAAADMgi63P7wCRHZnFVdmgHu2nFwlWCI3WGc3TSWhUFGxTAUkGCbtgENBMJAEJsxgMLWzpEAACH5BAkKAAAALAAAAAAQABAAAAMyCLrc/jDKSatlQtScKdceCAjDII7HcQ4EMTCpyrCuUBjCYRgHVtqlAiB1YhiCnlsRkAAAOwAAAAAAAAAAAA==');
        }

        .table-sm {
            font-size: 0.8em;
        }

        .btn-sm-action {
            font-size: .8em;
        }
    </style>
    @yield('css')
</head>

<body>
    <div>
        <nav class="navbar navbar-expand-md navbar-dark bg-primary shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/home') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    @auth
                    <ul class="navbar-nav mr-auto">
                    <form method="GET" action="{{route('home')}}" accept-charset="UTF-8" class="form-inline ml-3">
                        <div class="input-group input-group-sm">
                            <input class="form-control form-control-navbar text-uppercase" @if(request()->contenedor) value="{{request()->contenedor}}" @endif id="contenedor" name="contenedor" type="search" placeholder="Buscar" aria-label="Buscar" autocomplete="off">
                            <div class="input-group-append">
                                <button class="btn btn-light btn-navbar" type="submit">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                        @if(!in_array(Auth::user()->id, [10, 11]))
                        <li class="nav-item">
                            <a class="nav-link {{ active('inventarios*') }}" href="{{ route('inventarios.index') }}">{{ __('Inventories') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ active('clientes*') }}" href="{{ route('clientes.index') }}">{{ __('Clients') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ active('facturas*') }}" href="{{ route('facturas.index') }}">{{ __('Invoices') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ active('preliquidaciones*') }}" href="{{ route('preliquidaciones.index') }}">Preliquidaciones</a>
                        </li>
                        @endif
                        <li class="nav-item">
                            <a class="nav-link {{ active('exoneraciones*') }}" href="{{ route('exoneraciones.index') }}">Exoneraciones</a>
                        </li>
                        @if(!in_array(Auth::user()->id, [10, 11]))
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ __('Systems') }}
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('monedas.index') }}">{{ __('Coins') }}</a>
                                <a class="dropdown-item" href="{{ route('impuestos.index') }}">{{ __('Taxes') }}</a>
                                <a class="dropdown-item" href="{{ route('aportes.index') }}">{{ __('Contributions') }}</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('productos.index') }}">{{ __('Products') }}</a>
                                <a class="dropdown-item" href="{{ route('manifiestos.index') }}">Manifiesto</a>
                            </div>
                        </li>
                        @endif
                    </ul>
                    @endauth

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                        @endif
                        @else
                        <li class="nav-item dropdown">
                        <li>
                            @php $moneda= App\Moneda::find(2); @endphp
                            <span class="navbar-brand"><b style="color:#29944a"> $ Bs/USD</b> {{ number_format($moneda->valor,2) }}</span>
                        </li>
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                        </li>
                    </ul>
                    @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @include('sweetalert::alert')
            <div class="container">
                <div class="row">
                    @if (session('status'))
                    <div class="alert alert-success col-6" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                </div>
            </div>
            @yield('content')
        </main>
        @yield('js')
    </div>
</body>

</html>