<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link" href="/dashboard">
                    <i class="nav-icon icon-speedometer"></i> Dashboard
                </a>
            </li>
            @can('read-companies')
            <li class="nav-item">
                <a class="nav-link" href="/transactions">
                    <i class="nav-icon icon-shuffle"></i> Transacciones
                </a>
            </li>
            @endcan
            @can('create-companies')
            <li class="nav-item">
                <a class="nav-link" href="/companies">
                    <i class="nav-icon icon-briefcase"></i> Empresas
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
