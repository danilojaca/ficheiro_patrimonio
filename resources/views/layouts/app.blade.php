<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Ficheiro de Patrimonio</title>
    <link rel="icon" type="images/x-icon" href="img/sns.png" />

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div id="app">
    
        <nav class="navbar navbar-expand-md navbar-dark bg-primary shadow-sm">
            <div class="container">
                @guest
                    <a class="navbar-brand m-auto" >
                        Bem Vindo
                    </a>
                @endguest
                @auth
                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav me-auto">
                        <!-- Authentication Links -->
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">

                                    @if (auth()->user()->ou == 'Estagiarios') 

                                    <a class="dropdown-item" href="{{ route('logs.index') }}">{{ __('Logs') }}</a>
                                    <a class="dropdown-item" href="{{ route('logusers.index') }}">{{ __('Logs User') }}</a>
                                    
                                    @endif
                                    
                                    <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>                       
                    </ul>
                    
                     <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <a class="navbar-brand " href="{{ url('/') }}">
                            <i class="bi bi-house"></i>
                        </a> 
                    </ul>
                @endauth
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
     
</body>
</html>
