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
                    <a class="option" href="{{ route('user.list') }}" onclick="marcarOpcion(this)">
                        <svg class="icon-menu" xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24"><path fill="currentColor" d="M12 4a4 4 0 0 1 4 4a4 4 0 0 1-4 4a4 4 0 0 1-4-4a4 4 0 0 1 4-4m0 2a2 2 0 0 0-2 2a2 2 0 0 0 2 2a2 2 0 0 0 2-2a2 2 0 0 0-2-2m0 7c2.67 0 8 1.33 8 4v3H4v-3c0-2.67 5.33-4 8-4m0 1.9c-2.97 0-6.1 1.46-6.1 2.1v1.1h12.2V17c0-.64-3.13-2.1-6.1-2.1"/></svg>
                        <span>Usuarios</span>
                    </a>
                </li>
                <li>
                    <a class="option" href="{{ route('user.create') }}" onclick="marcarOpcion(this)">
                        <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24"><path fill="currentColor" d="M14 14.252v2.09A6 6 0 0 0 6 22H4a8 8 0 0 1 10-7.749M12 13c-3.315 0-6-2.685-6-6s2.685-6 6-6s6 2.685 6 6s-2.685 6-6 6m0-2c2.21 0 4-1.79 4-4s-1.79-4-4-4s-4 1.79-4 4s1.79 4 4 4m6 6v-3h2v3h3v2h-3v3h-2v-3h-3v-2z"/></svg>
                        <span>Crear Usuario</span>
                    </a>
                </li>
                <li>
                    <a class="option" href="{{ route('invoice.list') }}" onclick="marcarOpcion(this)">
                        <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3h14v18l-1.032-.884a2 2 0 0 0-2.603 0L14.333 21l-1.031-.884a2 2 0 0 0-2.604 0L9.667 21l-1.032-.884a2 2 0 0 0-2.603 0L5 21zm10 4H9m6 4H9m6 4h-4"/></svg>
                        <span>Facturas</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('invoice.create') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24"><path fill="currentColor" d="M21 13.34c-.63-.22-1.3-.34-2-.34V5H5v13.26l1-.66l3 2l3-2l1.04.69c-.04.21-.04.47-.04.71c0 .65.1 1.28.3 1.86L12 20l-3 2l-3-2l-3 2V3h18zM18 15v3h-3v2h3v3h2v-3h3v-2h-3v-3z"/></svg>
                        <span>Crear Factura</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('payment.list') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24"><path fill="currentColor" d="M20 4H4c-1.11 0-1.99.89-1.99 2L2 18c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V6c0-1.11-.89-2-2-2m0 14H4v-6h16zm0-10H4V6h16z"/></svg>
                        <span>Pagos</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('invoice.create_massive') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24"><path fill="currentColor" d="M21 13.34c-.63-.22-1.3-.34-2-.34V5H5v13.26l1-.66l3 2l3-2l1.04.69c-.04.21-.04.47-.04.71c0 .65.1 1.28.3 1.86L12 20l-3 2l-3-2l-3 2V3h18zM17 9V7H7v2zm-2 4v-2H7v2zm3 2v3h-3v2h3v3h2v-3h3v-2h-3v-3z"/></svg>
                        <span>Crear Facturas</span>
                    </a>
                </li>
            </ul>
        </nav>

        <div>
            <div class="usuario">
                <div class="svg-user">
                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 20 20"><path fill="currentColor" d="M7.725 2.146c-1.016.756-1.289 1.953-1.239 2.59c.064.779.222 1.793.222 1.793s-.313.17-.313.854c.109 1.717.683.976.801 1.729c.284 1.814.933 1.491.933 2.481c0 1.649-.68 2.42-2.803 3.334C3.196 15.845 1 17 1 19v1h18v-1c0-2-2.197-3.155-4.328-4.072c-2.123-.914-2.801-1.684-2.801-3.334c0-.99.647-.667.932-2.481c.119-.753.692-.012.803-1.729c0-.684-.314-.854-.314-.854s.158-1.014.221-1.793c.065-.817-.398-2.561-2.3-3.096c-.333-.34-.558-.881.466-1.424c-2.24-.105-2.761 1.067-3.954 1.929"/></svg>
                </div>
                <div class="info-usuario">
                    <div class="nombre-email">
                        <span class="nombre">Liever Rojas</span>
                        <span class="documento">1234567890</span>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 16 16"><path fill="currentColor" d="M10 2a2 2 0 1 1-3.999.001A2 2 0 0 1 10 2m0 6a2 2 0 1 1-3.999.001A2 2 0 0 1 10 8m0 6a2 2 0 1 1-3.999.001A2 2 0 0 1 10 14"/></svg>
                </div>
            </div>
        </div>
    </div>

    <main class="py-4">
        @yield('content')
    </main>
</body>
<script>
    function marcarOpcion(opcionSeleccionada) {
        // Elimina la clase 'activa' de todas las opciones
        const opciones = document.querySelectorAll('.option');
        opciones.forEach(opcion => {
            opcion.classList.remove('activa');
        });

        // Agrega la clase 'activa' solo a la opción seleccionada
        opcionSeleccionada.classList.add('activa');
    }
</script>
</html>
