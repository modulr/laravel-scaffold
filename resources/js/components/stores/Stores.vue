<template>
  <div class="container">
    <div class="card-body pt-0 pb-5">
      <div class="row justify-content-center pt-2 pb-4">
        <div class="col-lg-7 col-md-12">
          <h1>Tus tiendas favoritas</h1>
        </div>
        <div class="col-lg-5 col-md-12">
          <div class="input-group mt-1 mb-1">
            <input type="text" class="form-control border-right-0" placeholder="Buscar" v-model.trim="filters.search" @keyup.enter="filter">
            <div class="input-group-prepend">
              <a href="#" class="input-group-text border-left-0" v-if="clearSearchBtn" @click.prevent="clearSearch">x</a>
              <span class="input-group-text" @click="filter">
                <i class="fas fa-spinner fa-spin" v-if="loading"></i>
                <i class="fas fa-search" v-else></i>
              </span>
            </div>
          </div>
        </div>
        <div class="col-12 mt-3 py-1 scrollmenu invisible-scrollbar">
          <a href="#" class="btn btn-outline-secondary py-0 btn-pill" @click.prevent="filterByCategory('Comida')">Comida</a>
          <a href="#" class="btn btn-outline-secondary py-0 btn-pill" @click.prevent="filterByCategory('Postres')">Postres</a>
          <a href="#" class="btn btn-outline-secondary py-0 btn-pill" @click.prevent="filterByCategory('Recibos')">Recibos</a>
          <a href="#" class="btn btn-outline-secondary py-0 btn-pill" @click.prevent="filterByCategory('Super')">Super</a>
          <a href="#" class="btn btn-outline-secondary py-0 btn-pill" @click.prevent="filterByCategory('Licores')">Licores</a>
          <a href="#" class="btn btn-outline-secondary py-0 btn-pill" @click.prevent="filterByCategory('Paquetes')">Paquetes</a>
          <a href="#" class="btn btn-outline-secondary py-0 btn-pill" @click.prevent="filterByCategory('Farmacia')">Farmacia</a>
          <a href="#" class="btn btn-outline-secondary py-0 btn-pill" @click.prevent="filterByCategory('Regalos')">Regalos</a>
          <a href="#" class="btn btn-outline-secondary py-0 btn-pill" @click.prevent="filterByCategory('Otro')">Otro</a>
          <a href="#" class="btn btn-outline-secondary py-0 btn-pill" @click.prevent="filterByCategory('Tacos')">Tacos</a>
          <a href="#" class="btn btn-outline-secondary py-0 btn-pill" @click.prevent="filterByCategory('Hamburguesas')">Hamburguesas</a>
          <a href="#" class="btn btn-outline-secondary py-0 btn-pill" @click.prevent="filterByCategory('Pizza')">Pizza</a>
          <a href="#" class="btn btn-outline-secondary py-0 btn-pill" @click.prevent="filterByCategory('Sushi')">Sushi</a>
          <a href="#" class="btn btn-outline-secondary py-0 btn-pill" @click.prevent="filterByCategory('Gorditas')">Gorditas</a>
          <a href="#" class="btn btn-outline-secondary py-0 btn-pill" @click.prevent="filterByCategory('Tortas')">Tortas</a>
          <a href="#" class="btn btn-outline-secondary py-0 btn-pill" @click.prevent="filterByCategory('Lonches')">Lonches</a>
          <a href="#" class="btn btn-outline-secondary py-0 btn-pill" @click.prevent="filterByCategory('Flautas')">Flautas</a>
          <a href="#" class="btn btn-outline-secondary py-0 btn-pill" @click.prevent="filterByCategory('Quesadillas')">Quesadillas</a>
          <a href="#" class="btn btn-outline-secondary py-0 btn-pill" @click.prevent="filterByCategory('Tripitas')">Tripitas</a>
        </div>
      </div>
      <div class="row">
        <div class="col-12 col-md-6 px-2 pt-2" v-for="(user, index) in users">
          <!-- <div class="card-deck"> -->
            <div class="card" :class="{'shadow-sm': user.level > 0}">
              <div class="row no-gutters">
                <div class="col-4">
                  <img :src="user.avatar_url" class="card-img" :alt="user.name">
                </div>
                <div class="col-8">
                  <div class="card-body">
                    <h5 class="card-title mb-0">{{user.name}}</h5>
                    <p class="card-text mb-0">{{user.description}}</p>
                    <p class="card-text mb-0" v-if="user.address">
                      <small class="text-muted">
                        <a :href="`https://www.google.com/maps/search/${user.address}, Hidalgo del Parral, Chih.`" target="_blank">
                          <span class="text-muted">
                            <i class="icon-location-pin mr-1"></i>{{user.address}}
                          </span>
                        </a>
                      </small>
                    </p>
                    <p class="card-text mb-0" v-if="user.schedule">
                      <small class="text-muted">
                        <i class="far fa-clock mr-1"></i>{{user.schedule}}
                      </small>
                    </p>
                    <div class="mt-2">
                      <a :href="user.facebook" target="_blank" class="text-info" v-if="user.facebook">
                        <i class="fab fa-facebook fa-fw mr-2"></i>
                      </a>
                      <a :href="user.instagram" target="_blank" class="text-muted" v-if="user.instagram">
                        <i class="fab fa-instagram fa-fw mr-2"></i>
                      </a>
                      <a :href="user.web" target="_blank" class="text-muted" v-if="user.web">
                        <i class="fas fa-globe fa-fw mr-2"></i>
                      </a>
                      <a :href="user.link" target="_blank" class="text-muted" v-if="user.link">
                        <i class="fas fa-link fa-fw mr-2"></i>
                      </a>
                      <a class="btn btn-secondary btn-sm float-right" href="" @click.prevent="create(user)">
                        Pedir
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          <!-- </div> -->
        </div>
        <!-- Loading -->
        <!-- <infinite-loading @infinite="loadUsers" ref="infiniteLoading">
          <span slot="no-results"></span>
          <span slot="no-more"></span>
        </infinite-loading> -->
      </div>
      <div class="row" v-if='!loading && filters.pagination.total > 0'>
        <div class="col mt-4" v-if="filters.pagination.last_page>1">
          <nav aria-label="Page navigation">
            <ul class="pagination">
              <li class="page-item" :class="{'disabled': filters.pagination.current_page <= 1}">
                <a class="page-link" href="#" @click.prevent="changePage(filters.pagination.current_page -  1)"><i class="fas fa-angle-left"></i></a>
              </li>
              <li class="page-item" v-for="page in filters.pagination.last_page" :class="{'active': filters.pagination.current_page == page}">
                <span class="page-link" v-if="filters.pagination.current_page == page">{{page}}</span>
                <a class="page-link" href="#" v-else @click.prevent="changePage(page)">{{page}}</a>
              </li>
              <li class="page-item" :class="{'disabled': filters.pagination.current_page >= filters.pagination.last_page}">
                <a class="page-link" href="#" @click.prevent="changePage(filters.pagination.current_page +  1)"><i class="fas fa-angle-right"></i></a>
              </li>
            </ul>
          </nav>
        </div>
      </div>
      <div class="no-items-found text-center mt-5" v-if="!loading && !users.length > 0">
        <i class="icon-magnifier fa-3x text-muted"></i>
        <p class="mb-0 mt-3"><strong>No se encontro ninguna tienda</strong></p>
        <p class="text-muted">Intenta con otra palabra</p>
      </div>
      <content-placeholders v-if="loading" class="mt-3">
        <content-placeholders-heading :img="true" />
        <content-placeholders-heading :img="true" />
        <content-placeholders-heading :img="true" />
        <content-placeholders-heading :img="true" />
        <content-placeholders-heading :img="true" />
        <content-placeholders-heading :img="true" />
      </content-placeholders>
    </div>
  </div>
</template>

<script>
export default {
  data () {
    return {
      users: [],
      order: {},
      filters: {
        pagination: {
          from: 0,
          to: 0,
          total: 0,
          per_page: 20,
          current_page: 1,
          last_page: 0
        },
        orderBy: {
          column: 'level',
          direction: 'desc'
        },
        search: ''
      },
      clearSearchBtn: false,
      loading: true
    }
  },
  mounted () {
    this.getUsers()
    if (localStorage.getItem("order")) {
      this.order = JSON.parse(localStorage.getItem("order"))
    }
    let str = window.location.pathname
    let res = str.split("/")
    if (res[2]) {
      this.filterByCategory(res[2])
    }
    //this.loadUsers();
  },
  methods: {
    // loadUsers ($state) {
    //   this.loading = true
    //   var page = Number(this.filters.pagination.current_page) + 1;
    //   axios.get(`/api/stores/filters?page=${page}`, this.filters)
    //   .then(response => {
    //       this.users = this.users.concat(response.data.data);
    //       this.filters.pagination = response.data
    //       $state.loaded();
    //       this.loading = false
    //       if (!this.filters.pagination.next_page_url)
    //           $state.complete();
    //   });
    // },
    getUsers () {
      this.loading = true
      this.clearSearchBtn = false
      this.users = []
      axios.post(`/api/stores/filters?page=${this.filters.pagination.current_page}`, this.filters)
      .then(response => {
        this.users = response.data.data
        delete response.data.data
        this.filters.pagination = response.data
        this.loading = false
        if (this.filters.search != '') {
          this.clearSearchBtn = true
        }
      })
    },
    create (user) {
      this.order.order = `Traeme de ${user.name}`
      localStorage.setItem("order", JSON.stringify(this.order))
      location.href = `/`
    },
    clearSearch() {
      this.filters.search = ''
      this.filter()
    },
    // filters
    filter() {
      this.filters.pagination.current_page = 1
      this.getUsers()
    },
    filterByCategory (category) {
      this.filters.search = category
      this.getUsers()
    },
    changePage (page) {
      this.filters.pagination.current_page = page
      this.getUsers()
    }
  }
}
</script>
