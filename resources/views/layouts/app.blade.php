<!doctype html>
<html lang="es">
<head>

    @include('layouts.partials._head')

</head>
<body>

    <div class='loader'>
        <div class='spinner-grow text-primary' role='status'>
            <span class='sr-only'>Cargando...</span>
        </div>
    </div>

    <div class="connect-container align-content-stretch d-flex flex-wrap">
        <div class="page-sidebar">

            <div class="logo-box">
                <a href="#" class="logo-text">Citas IGSS</a>
                <a href="#" id="sidebar-close"><i class="material-icons">close</i></a>
                <a href="#" id="sidebar-state"><i class="material-icons">adjust</i><i class="material-icons compact-sidebar-icon">panorama_fish_eye</i></a>
            </div>

            @include('layouts.partials._sidebar')
        </div>

        <div class="page-container">

            <div class="page-header">
                <nav class="navbar navbar-expand">
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <ul class="navbar-nav">
                        <li class="nav-item small-screens-sidebar-link">
                            <a href="#" class="nav-link"><i class="material-icons-outlined">menu</i></a>
                        </li>
                        <li class="nav-item nav-profile dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img src="{{ asset('assets/images/avatars/profile-image-1.png') }}" alt="profile image">
                                <span>{{ Auth::user()->nombres_apellidos }}</span><i class="material-icons dropdown-icon">keyboard_arrow_down</i>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a
                                    class="dropdown-item"
                                    href="{{ route('logout') }}"
                                    onclick="event.preventDefault();document.getElementById('logout-form').submit();"
                                >Cerrar Sesión</a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    </ul>
                </nav>
            </div>

            <div class="page-content">
                @yield('content')
            </div>

            <div class="page-footer">
                <div class="row">
                    <div class="col-md-12">
                        <span class="footer-text">{{ date('Y') }} © Josue Carrillo</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.partials._scripts')

</body>
</html>
