<div class="page-sidebar-inner slimscroll">
    <ul class="accordion-menu">
        <li class="sidebar-title">
            Menú
        </li>
        <li class="{{ request()->is('/') ? 'active-page' : '' }}">
            <a href="{{ route('home') }}"><i class="material-icons-outlined">dashboard</i>Dashboard</a>
        </li>
        <li class="{{ request()->is('usuarios*') ? 'active-page' : '' }}">
            <a href="{{ route('usuarios.index') }}"><i class="material-icons-outlined">manage_accounts</i>Usuarios</a>
        </li>
        <li class="{{ request()->is('clinicas*') ? 'active-page' : '' }}">
            <a href="profile.html"><i class="material-icons-outlined">local_hospital</i>Clínicas</a>
        </li>
        <li class="{{ request()->is('citas*') ? 'active-page' : '' }}">
            <a href="file-manager.html"><i class="material-icons">masks</i>Citas</a>
        </li>
    </ul>
</div>
