<!doctype html>
<html lang="es">
<head>

    @include('layouts.partials._head')

</head>
<body class="auth-page sign-in">

    <div class='loader'>
        <div class='spinner-grow text-primary' role='status'>
            <span class='sr-only'>Cargando...</span>
        </div>
    </div>
    <div class="connect-container align-content-stretch d-flex flex-wrap">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-5">

                    @yield('content')

                </div>
                <div class="col-lg-6 d-none d-lg-block d-xl-block">
                    <div class="auth-image"></div>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.partials._scripts')

</body>
</html>
