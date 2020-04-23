<template>
  <div class="sidebar" v-touch:swipe="swipeHandler">
      <nav class="sidebar-nav">
          <ul class="nav">
              <li class="nav-item">
                  <a class="nav-link" href="/">
                      <i class="nav-icon far fa-comment-alt mr-2"></i>Pedir
                  </a>
              </li>
              <li class="nav-item" v-if="user && user.hasPermission['read-orders']">
                  <a class="nav-link" href="/orders">
                      <i class="nav-icon fas fa-list-ul mr-2"></i>Mis Mandados
                  </a>
              </li>
              <li class="nav-item">
                  <a class="nav-link" href="/tiendas">
                      <i class="nav-icon fas fa-store mr-2"></i>Tiendas
                  </a>
              </li>
              <li class="nav-title" v-if="user && user.hasRole['dealer']">Repartidor</li>
              <li class="nav-item" v-if="user && user.hasRole['dealer']">
                <dealers-active :user="user"></dealers-active>
              </li>
              <li class="nav-item" v-if="user && user.hasRole['dealer']">
                  <a class="nav-link" href="/orders/availables">
                      <i class="nav-icon fas fa-list-ul mr-2"></i>Mandados
                      <orders-availables-count></orders-availables-count>
                  </a>
              </li>
              <li class="nav-item" v-if="user && user.hasRole['dealer']">
                  <a class="nav-link" href="/orders/dealer">
                      <i class="nav-icon fas fa-motorcycle mr-2"></i>Mis vueltas
                  </a>
              </li>
              <li class="nav-item" v-if="user && user.hasRole['dealer']">
                  <a class="nav-link" href="/stores">
                      <i class="nav-icon fas fa-store mr-2"></i>Tiendas
                  </a>
              </li>
              <li class="nav-item" v-if="user && user.hasRole['dealer']">
                  <a class="nav-link" href="/schedule">
                      <i class="nav-icon fas fa-calendar-alt mr-2"></i>Horario
                  </a>
              </li>
              <li class="nav-item" v-if="user && user.hasRole['dealer']">
                  <a class="nav-link" href="/rules">
                      <i class="nav-icon fas fa-book mr-2"></i>Reglas
                  </a>
              </li>
              <li class="nav-item" v-if="user && user.hasRole['dealer']">
                  <a class="nav-link" href="/contract">
                      <i class="nav-icon fas fa-file-signature mr-2"></i>Contrato
                  </a>
              </li>
              <li class="nav-title" v-if="user && user.hasRole['admin']">Administrador</li>
              <li class="nav-item" v-if="user && user.hasRole['admin']">
                  <a class="nav-link" href="/orders/all">
                      <i class="nav-icon fas fa-list-ul mr-2"></i>Mandados
                  </a>
              </li>
              <li class="nav-item" v-if="user && user.hasRole['admin']">
                  <a class="nav-link" href="/clients">
                      <i class="nav-icon fas fa-users mr-2"></i>Clientes
                  </a>
              </li>
              <li class="nav-item" v-if="user && user.hasRole['admin']">
                  <a class="nav-link" href="/dealers">
                      <i class="nav-icon fas fa-motorcycle mr-2"></i>Repartidores
                  </a>
              </li>
              <li class="nav-item" v-if="user && user.hasRole['admin']">
                  <a class="nav-link" href="/stores">
                      <i class="nav-icon fas fa-store mr-2"></i>Tiendas
                  </a>
              </li>
              <li class="nav-item" v-if="user && user.hasRole['admin']">
                  <a class="nav-link" href="/schedule">
                      <i class="nav-icon fas fa-calendar-alt mr-2"></i>Horario
                  </a>
              </li>
              <li class="nav-item" v-if="user && user.hasRole['admin']">
                  <a class="nav-link" href="/rules">
                      <i class="nav-icon fas fa-book mr-2"></i>Reglas
                  </a>
              </li>
              <li class="nav-item" v-if="user && user.hasRole['admin']">
                  <a class="nav-link" href="/rates">
                      <i class="nav-icon fas fa-dollar-sign"></i>Tarifas
                  </a>
              </li>
              <li class="nav-title" v-if="user && (user.hasPermission['read-users'] || user.hasPermission['read-roles'])">Settings</li>
              <li class="nav-item" v-if="user && user.hasPermission['read-users']">
                  <a class="nav-link" href="/users">
                      <i class="nav-icon icon-people"></i>Users
                  </a>
              </li>
              <li class="nav-item" v-if="user && user.hasPermission['read-roles']">
                  <a class="nav-link" href="/roles">
                      <i class="nav-icon icon-key"></i>Roles
                  </a>
              </li>
          </ul>
      </nav>
      <button class="sidebar-minimizer brand-minimizer" type="button" @click="toogleStorage"></button>
  </div>
</template>

<script>
export default {
  data () {
    return {
      user: Laravel.user
    }
  },
  mounted () {
    this.addMinimizedClass()
  },
  methods: {
    toogleStorage () {
      if (localStorage.getItem("sidebarMinimized")) {
        localStorage.removeItem("sidebarMinimized");
      } else {
        localStorage.setItem("sidebarMinimized", true);
      }
    },
    addMinimizedClass () {
      if (localStorage.getItem("sidebarMinimized")) {
        document.body.classList.add("brand-minimized", "sidebar-minimized")
      }
    },
    swipeHandler (direction) {
      if (direction == 'left') {
        document.body.classList.remove("sidebar-show")
      }
    }
  }
}
</script>
