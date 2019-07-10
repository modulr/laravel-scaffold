<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link" href="/">
                    <i class="nav-icon far fa-comment-alt mr-2"></i>Pedir
                </a>
            </li>
            @can('read-orders')
            <li class="nav-item">
                <a class="nav-link" href="/orders">
                    <i class="nav-icon fas fa-list-ul mr-2"></i>Mis Mandados
                </a>
            </li>
            @endcan
            @can('read-address')
                <li class="nav-item">
                    <a class="nav-link" href="/address">
                        <i class="nav-icon fas fa-map-marker-alt mr-2"></i>Direcciones
                    </a>
                </li>
            @endcan
            @role('dealer')
                <li class="nav-title">Repartidor</li>
                <li class="nav-item">
                    <a class="nav-link" href="/orders/availables">
                        <i class="nav-icon fas fa-list-ul mr-2"></i>Mandados
                        <orders-availables-count></orders-availables-count>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/orders/dealer">
                        <i class="nav-icon fas fa-motorcycle mr-2"></i>Mis vueltas
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/stores">
                        <i class="nav-icon fas fa-store mr-2"></i>Tiendas
                    </a>
                </li>
            @endrole
            @hasanyrole('superadmin|admin')
            <li class="nav-title">Administrador</li>
            <li class="nav-item">
                <a class="nav-link" href="/orders/all">
                    <i class="nav-icon fas fa-list-ul mr-2"></i>Mandados
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/clients">
                    <i class="nav-icon fas fa-users mr-2"></i>Clientes
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/stores">
                    <i class="nav-icon fas fa-store mr-2"></i>Tiendas
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/dealers">
                    <i class="nav-icon fas fa-motorcycle mr-2"></i>Repartidores
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/rates">
                    <i class="nav-icon fas fa-dollar-sign"></i>Tarifas
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/codes">
                    <i class="nav-icon fas fa-percent"></i>Cupones
                </a>
            </li>
            @endhasanyrole
            @can('read-users','read-roles')
            <li class="nav-title">Settings</li>
            @endcan
            @can('read-users')
            <li class="nav-item">
                <a class="nav-link" href="/users">
                    <i class="nav-icon icon-people"></i>Users
                </a>
            </li>
            @endcan
            @can('read-roles')
            <li class="nav-item">
                <a class="nav-link" href="/roles">
                    <i class="nav-icon icon-key"></i>Roles
                </a>
            </li>
            @endcan
        </ul>
    </nav>
    <!-- <nav>
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link" href="tel:627-110-1145">
                    <i class="nav-icon fas fa-phone"></i> 627 110 1145
                </a>
            </li>
        </ul>
    </nav> -->
    <sidebar></sidebar>
</div>
