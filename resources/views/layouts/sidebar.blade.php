<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link" href="/profile">
                    <i class="far fa-user-circle mr-2"></i> Mi cuenta
                </a>
            </li>
            @auth
                @can('read-orders')
                <li class="nav-item">
                    <a class="nav-link" href="/orders">
                        <i class="fas fa-list-ul mr-2"></i> Mandados
                    </a>
                </li>
                @endcan
                @can('read-address')
                <li class="nav-item">
                    <a class="nav-link" href="/address">
                        <i class="fas fa-map-marker-alt mr-2"></i> Direcciones
                    </a>
                </li>
                @endcan
            @else
                <li class="nav-item">
                    <a class="nav-link" href="/register">Crear una cuenta</a>
                </li>
            @endauth
            <li class="nav-item pt-3 pb-2">
                <a class="nav-title">Promociones</a>
            </li>
            @auth
            @else
                <li class="nav-item">
                    <a class="btn btn-sm btn-brand btn-facebook ml-2 mt-4" href="/auth/facebook">
                        <i class="fab fa-facebook-f"></i>
                        <span>Registrate con Facebook</span>
                    </a>
                    <p class="ml-1 mb-5 text-center">y recibe tu primer mandado ¡<strong>Gratis</strong>!</p>
                </li>
            @endauth

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
    <nav>
        <ul class="nav">
            <li class="nav-item">
            <a class="btn btn-link btn-lg btn-phone" href="tel:811-897-7886">
                <small class="fa-stack">
                    <i class="fas fa-circle fa-stack-2x"></i>
                    <i class="fas fa-phone fa-stack-1x fa-inverse"></i>
                </small>
                813 089 8642
            </a>
            </li>
        </ul>
    </nav>
    <sidebar></sidebar>
</div>
