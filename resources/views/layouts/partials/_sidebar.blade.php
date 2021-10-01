<div class="page-sidebar-inner slimscroll">
    <ul class="accordion-menu">
        <li class="sidebar-title">
            Menú
        </li>
        <li class="{{ request()->is('/') ? 'active-page' : '' }}">
            <a href="{{ route('home') }}"><i class="material-icons-outlined">dashboard</i>Dashboard</a>
        </li>

        @if( auth()->user()->rol == 'Admin' )
            <li class="{{ request()->is('usuarios*') ? 'active-page' : '' }}">
                <a href="{{ route('usuarios.index') }}"><i class="material-icons-outlined">manage_accounts</i>Usuarios</a>
            </li>
            <li class="{{ request()->is('clinicas*') ? 'active-page' : '' }}">
                <a href="{{ route('clinicas.index') }}"><i class="material-icons-outlined">local_hospital</i>Clínicas</a>
            </li>
        @endif

        <li class="{{ request()->is('citas*') ? 'active-page' : '' }}">
            <a href="{{ route('citas.index') }}"><i class="material-icons">masks</i>Citas</a>
        </li>
    </ul>
</div>
