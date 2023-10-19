<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" type="image/png" href="img/sns.png" sizes="96x96">
    <title>{{"Gestão de Bens Imóveis e Património"}}</title>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

    <!-- Select2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2/dist/js/select2.min.js"></script> 
    
    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div id="app">
        <nav class="navbar  bg-primary fixed-top">
            @guest
                <a class="navbar-brand navbar-dark m-auto" >
                    {{'Bem Vindo À Gestão de Bens Imóveis e Património'}}
                </a>
            @endguest
            @auth
                <div class="container-fluid">
                    <a class="navbar-brand navbar-dark" href="{{ url('/') }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Pagina Inicial"><i class="bi bi-house"></i></a>
                    <a class="navbar-brand navbar-dark m-auto" >
                    {{'Gestão de Bens Imóveis e Património'}}
                        </a>
                        <button class="navbar-toggler navbar-dark" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" data-bs-toggle="tooltip" data-bs-placement="top" title="Menu">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        
                    <div class="offcanvas offcanvas-end " tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                        <div class="offcanvas-header">
                            <h5 class="offcanvas-title" id="offcanvasNavbarLabel">{{ Auth::user()->name }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                        
                        
                        </div>
                        <div class="offcanvas-body">
                            <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">                                
                                 @can('visualizar-inventario')
                                <li class="nav-item">
                                    <a class="nav-link active" aria-current="page" href="{{ route('inventario.index') }}">{{'Bens'}}</a>
                                </li>
                                @endcan
                                @can('visualizar-edificio') 
                                <li class="nav-item">
                                    <a class="nav-link active" aria-current="page" href="{{ route('edificio.index') }}">{{'Edificios'}}</a>
                                </li>
                                @endcan
                                 @can('visualizar-unidade')
                                <li class="nav-item">
                                    <a class="nav-link active" aria-current="page" href="{{ route('unidade.index') }}">{{'Unidades'}}</a>
                                </li>
                                @endcan
                                @can('visualizar-categoria')
                                <li class="nav-item">
                                    <a class="nav-link active" aria-current="page" href="{{ route('bens.index') }}">{{'Categorias'}}</a>
                                </li>
                                @endcan
                                @can('relatorio')
                                <li class="nav-item">
                                    <a class="nav-link active" aria-current="page" href="{{ route('relatorio.index') }}">{{'Relatorios'}}</a>
                                </li>
                                @endcan
                                @can('visualizar-permissao')
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    {{'Permissoes'}}
                                    </a>
                                    <ul class="dropdown-menu">
                                     @can('visualizar-permissao-utilizador')
                                        <li><a class="dropdown-item" href="{{ route('users.index') }}">{{ __('Utilizadores') }}</a></li> 
                                    @endcan  
                                    @can('visualizar-permissao-perfis')     
                                        <li><a class="dropdown-item" href="{{ route('roles.index') }}">{{ __('Perfis') }}</a></li>
                                     @endcan 
                                       
                                    </ul>
                                </li>
                                @endcan    
                                @can('logs')                               
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    {{'Logs'}}
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="{{ route('logs.index') }}">{{ __('Logs') }}</a></li>
                                        <li><a class="dropdown-item" href="{{ route('logusers.index') }}">{{ __('Logs User') }}</a></li>
                                        
                                    </ul>
                                </li>
                                @endcan
                                 <li class="nav-item">                                    
                                    <a class="nav-link active" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                                    <i class="bi bi-map"></i> {{'Plantas'}}
                                    </a>
                                    <div class="collapse" id="collapseExample">
                                        <div class="card card-body">
                                            {{'Link do Ambiente de Trabalho : ACES Central Informações / Informatica NSICA / Cadastro - Mapas'}}
                                        </div>
                                    </div>
                                </li>
                            </ul> 
                       
                        </div>

                        
                            <ul class="navbar-nav justify-content-end flex-grow-1 ps-3">
                                <li class="nav-item">
                                    <a class="nav-link active text-danger" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </div>  
                </div>
            @endauth
        </nav>
        <main class="p-4">
            @yield('content')
        </main>
    </div>
     
</body>
<script>
const exampleEl = document.getElementById('example')
const popover = new bootstrap.Popover(exampleEl, options)
</script>
</html>
