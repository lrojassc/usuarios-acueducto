<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    @vite(['resources/scss/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div class="menu">
        <ion-icon name="menu-outline"></ion-icon>
        <ion-icon name="close-outline"></ion-icon>
    </div>
    <div class="barra-lateral">
        <div>
            <div class="nombre-pagina">
                <button class="btn fs-4" type="button" id="logo">J.A.Q</button>
            </div>
        </div>

        <nav class="navegacion">
            <ul>
                <li>
                    <a id="inbox" href="{{ route('user.list') }}">
                        <ion-icon name="mail-unread-outline"></ion-icon>
                        <span>Usuarios</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('user.create') }}">
                        <ion-icon name="star-outline"></ion-icon>
                        <span>Crear Usuario</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('invoice.list') }}">
                        <ion-icon name="paper-plane-outline"></ion-icon>
                        <span>Facturas</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('invoice.create') }}">
                        <ion-icon name="document-text-outline"></ion-icon>
                        <span>Crear Factura</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('payment.list') }}">
                        <ion-icon name="bookmark-outline"></ion-icon>
                        <span>Pagos</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('invoice.create_massive') }}">
                        <ion-icon name="alert-circle-outline"></ion-icon>
                        <span>Crear Facturas</span>
                    </a>
                </li>
            </ul>
        </nav>

        <div>
            <div class="usuario">
                <img src="#" alt="">
                <div class="info-usuario">
                    <div class="nombre-email">
                        <span class="nombre">Usuario</span>
                        <span class="email">Liever Rojas</span>
                    </div>
                    <ion-icon name="ellipsis-vertical-outline"></ion-icon>
                </div>
            </div>
        </div>
    </div>
    <!--
    <nav class="navbar navbar-expand-lg bg-body-tertiary" style="background-color: #dfdfdf !important; font-size: large">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('index') }}">Junta Acueducto Quituro</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent" style="flex-direction: row-reverse">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('user.list') }}">Usuarios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('user.create') }}">Crear Usuario</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('invoice.list') }}">Facturas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('invoice.create') }}">Crear Factura</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('payment.list') }}">Pagos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('invoice.create_massive') }}">Generar Facturas Masivas</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    -->

    <main class="py-4">
        @yield('content')
    </main>
</body>
</html>
