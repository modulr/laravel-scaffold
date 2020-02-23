<template>
  <div class="container">
    <div class="card-header px-0 mt-2 bg-transparent clearfix">
      <h4 class="float-left pt-2">Tiendas</h4>
      <div class="card-header-actions mr-1">
        <a class="btn btn-primary" href="/stores/create">Nueva tienda</a>
      </div>
    </div>
    <div class="card-body px-0">
      <div class="row justify-content-between">
        <div class="col-7 col-md-5">
          <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Seach" v-model.trim="filters.search" @keyup.enter="filter">
            <div class="input-group-prepend">
              <span class="input-group-text" @click="filter">
                <i class="fas fa-spinner fa-spin" v-if="loading"></i>
                <i class="fas fa-search" v-else></i>
              </span>
            </div>
          </div>
        </div>
        <div class="col-auto">
          <multiselect
            v-model="filters.pagination.per_page"
            :options="[25,50,100,200]"
            :searchable="false"
            :show-labels="false"
            :allow-empty="false"
            @select="changeSize"
            placeholder="Search">
          </multiselect>
        </div>
      </div>
      <ul class="list-group mb-1" v-for="(user, index) in users">
        <li class="list-group-item">
          <div class="row">
            <div class="col">
              <small class="text-muted">Paquete Publicidad: {{user.level}}</small>
            </div>
            <div class="col text-right">
              <rate :length="5" v-model="user.score" :disabled="true"/>
            </div>
            <div class="col-12">
              <hr class="mt-1 mb-2">
            </div>
            <div class="col-12">
              <div class="row no-gutters">
                <div class="col-4" @click="editUser(user.id)">
                  <img :src="user.avatar_url" class="card-img" :alt="user.name">
                </div>
                <div class="col-8">
                  <div class="card-body">
                    <h5 class="card-title mb-1" @click="editUser(user.id)">{{user.name}}</h5>
                    <p class="card-text mb-1" @click="editUser(user.id)">{{user.description}}</p>
                    <p class="card-text mb-1" v-if="user.address">
                      <small class="text-muted">
                        <a :href="`https://www.google.com/maps/search/Calle ${user.address}, Hidalgo del Parral, Chih.`" target="_blank">
                          <span class="text-muted">
                            <i class="icon-location-pin mr-1"></i>{{user.address}}
                          </span>
                        </a>
                      </small>
                    </p>
                    <p class="card-text mb-1" v-if="user.schedule">
                      <small class="text-muted">
                        <i class="far fa-clock mr-1"></i>{{user.schedule}}
                      </small>
                    </p>
                    <a :href="user.web" target="_blank" class="small text-muted" v-if="user.web">
                      <i class="fas fa-globe fa-fw mr-2"></i>
                    </a>
                    <a :href="user.facebook" target="_blank" class="small text-muted" v-if="user.facebook">
                      <i class="fab fa-facebook fa-fw mr-2"></i>
                    </a>
                    <a :href="user.instagram" target="_blank" class="small text-muted" v-if="user.instagram">
                      <i class="fab fa-instagram fa-fw mr-2"></i>
                    </a>
                    <a :href="user.link" target="_blank" class="small text-muted" v-if="user.link">
                      <i class="fas fa-link fa-fw mr-2"></i>
                    </a>
                    <a :href="`https://api.whatsapp.com/send?phone=52${user.cellphone}`" target="_blank" class="small text-muted" v-if="user.cellphone">
                      <i class="fab fa-whatsapp"></i>
                    </a>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12">
              <hr>
            </div>
            <div class="col" v-if="user.cellphone">
              <small class="text-muted"><i class="fas fa-mobile-alt mr-1"></i>Celular</small>
              <br>
              <a class="text-info" :href="`tel:${user.cellphone}`">
                {{user.cellphone}}
              </a>
            </div>
            <div class="col text-right" v-if="user.phone">
              <small class="text-muted"><i class="fas fa-phone mr-1"></i>Teléfono</small>
              <br>
              <a class="text-info" :href="`tel:${user.phone}`">
                {{user.phone}}
              </a>
            </div>
          </div>
        </li>
      </ul>
      <!-- <table class="table table-hover">
        <thead>
          <tr>
            <th class="d-none d-sm-table-cell">
              <a href="#" class="text-dark" @click.prevent="sort('id')">ID</a>
              <i class="mr-1 fas" :class="{'fa-long-arrow-alt-down': filters.orderBy.column == 'id' && filters.orderBy.direction == 'asc', 'fa-long-arrow-alt-up': filters.orderBy.column == 'id' && filters.orderBy.direction == 'desc'}"></i>
            </th>
            <th>
              <a href="#" class="text-dark" @click.prevent="sort('name')">Cliente</a>
              <i class="mr-1 fas" :class="{'fa-long-arrow-alt-down': filters.orderBy.column == 'name' && filters.orderBy.direction == 'asc', 'fa-long-arrow-alt-up': filters.orderBy.column == 'name' && filters.orderBy.direction == 'desc'}"></i>
            </th>
            <th>Teléfono</th>
            <th class="d-none d-sm-table-cell">
              <a href="#" class="text-dark" @click.prevent="sort('created_at')">Registrado</a>
              <i class="mr-1 fas" :class="{'fa-long-arrow-alt-down': filters.orderBy.column == 'created_at' && filters.orderBy.direction == 'asc', 'fa-long-arrow-alt-up': filters.orderBy.column == 'created_at' && filters.orderBy.direction == 'desc'}"></i>
            </th>
            <th class="d-none d-sm-table-cell"></th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="user in users" @click="editUser(user.id)">
            <td class="d-none d-sm-table-cell">{{user.id}}</td>
            <td>
              <div class="media">
                <div class="avatar float-left mr-3">
                  <img class="img-avatar" :src="user.avatar_url">
                  <span class="avatar-status badge-success"></span>
                </div>
                <div class="media-body">
                  <div>{{user.name}}</div>
                  <div class="small text-muted">
                    {{user.email}}
                  </div>
                </div>
              </div>
            </td>
            <td><a class="text-info" :href="`tel:${user.cellphone}`">{{user.cellphone}}</a></td>
            <td class="d-none d-sm-table-cell">
              <small>{{user.created_at | moment("LL")}}</small> - <small class="text-muted">{{user.created_at | moment("LT")}}</small>
            </td>
            <td class="d-none d-sm-table-cell">
              <a href="#" class="text-muted"><i class="fas fa-pencil-alt"></i></a>
            </td>
          </tr>
        </tbody>
      </table> -->
      <div class="row" v-if='!loading && filters.pagination.total > 0'>
        <div class="col">
          {{filters.pagination.from}}-{{filters.pagination.to}} of {{filters.pagination.total}}
        </div>
        <div class="col" v-if="filters.pagination.last_page>1">
          <nav aria-label="Page navigation">
            <ul class="pagination justify-content-end">
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
        <p class="mb-0 mt-3"><strong>Could not find any items</strong></p>
        <p class="text-muted">Try changing the filters or add a new one</p>
        <a class="btn btn-success" href="/users/create" role="button">
          <i class="fa fa-plus"></i>&nbsp; New User
        </a>
      </div>
      <content-placeholders v-if="loading">
        <content-placeholders-text/>
      </content-placeholders>
    </div>
  </div>
</template>

<script>
export default {
  data () {
    return {
      users: [],
      filters: {
        pagination: {
          from: 0,
          to: 0,
          total: 0,
          per_page: 25,
          current_page: 1,
          last_page: 0
        },
        orderBy: {
          column: 'name',
          direction: 'asc'
        },
        search: ''
      },
      loading: true
    }
  },
  mounted () {
    if (localStorage.getItem("filtersTableStores")) {
      this.filters = JSON.parse(localStorage.getItem("filtersTableStores"))
    } else {
      localStorage.setItem("filtersTableStores", this.filters);
    }
    this.getUsers()
  },
  methods: {
    getUsers () {
      this.loading = true
      this.users = []
      localStorage.setItem("filtersTableStores", JSON.stringify(this.filters));
      axios.post(`/api/stores/filter?page=${this.filters.pagination.current_page}`, this.filters)
      .then(response => {
        this.users = response.data.data
        delete response.data.data
        this.filters.pagination = response.data
        this.loading = false
      })
    },
    editUser (userId) {
      location.href = `/stores/${userId}/edit`
    },
    // filters
    filter() {
      this.filters.pagination.current_page = 1
      this.getUsers()
    },
    changeSize (perPage) {
      this.filters.pagination.current_page = 1
      this.filters.pagination.per_page = perPage
      this.getUsers()
    },
    sort (column) {
      if(column == this.filters.orderBy.column) {
        this.filters.orderBy.direction = this.filters.orderBy.direction == 'asc' ? 'desc' : 'asc'
      } else {
        this.filters.orderBy.column = column
        this.filters.orderBy.direction = 'asc'
      }

      this.getUsers()
    },
    changePage (page) {
      this.filters.pagination.current_page = page
      this.getUsers()
    }
  }
}
</script>
