<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link" href="/">
                    <i class="fas fa-comment-alt mr-3"></i> Inicio
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/pedidos">
                    <i class="fas fa-list-ul mr-3"></i> Pedidos
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/direcciones">
                    <i class="fas fa-map-marker-alt mr-3"></i> Direcciones
                </a>
            </li>
            @can('read-users','read-dashboard')
            <li class="nav-item">
                <a class="nav-link" href="/dashboard">
                    <i class="nav-icon icon-speedometer"></i> Dashboard
                </a>
            </li>
            @endcan
            @can('read-users','read-roles')
            <li class="nav-title">Settings</li>
            @endcan
            @can('read-users')
            <li class="nav-item">
                <a class="nav-link" href="/users">
                    <i class="nav-icon icon-people"></i> Users
                </a>
            </li>
            @endcan
            @can('read-roles')
            <li class="nav-item">
                <a class="nav-link" href="/roles">
                    <i class="nav-icon icon-key"></i> Roles
                </a>
            </li>
            @endcan
        </ul>
    </nav>
    <sidebar></sidebar>
</div>
