<template>
  <div class="container">
    <div class="card-body px-0 pt-0 pb-5">
      <div class="row justify-content-center">
        <div class="col-7 col-md-5">
          <div class="input-group mt-3 mb-4">
            <input type="text" class="form-control border-right-0" placeholder="Buscar" v-model.trim="filters.search" @keyup.enter="filter">
            <div class="input-group-prepend">
              <span class="input-group-text border-left-0" v-if="clearSearchBtn" @click="clearSearch">x</span>
              <span class="input-group-text" @click="filter">
                <i class="fas fa-spinner fa-spin" v-if="loading"></i>
                <i class="fas fa-search" v-else></i>
              </span>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-12 col-md-6 p-2" v-for="(user, index) in users">
          <ul class="list-group">
          <li class="list-group-item">
            <div class="row">
              <div class="col-12">
                <div class="row no-gutters">
                  <div class="col-4">
                    <img :src="user.avatar_url" class="card-img" :alt="user.name">
                  </div>
                  <div class="col-8">
                    <div class="card-body pb-0">
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
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-12">
                <hr>
              </div>
              <div class="col">
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
              </div>
              <div class="col text-right">
                <a class="btn btn-light btn-sm" href="/">
                  Pedir
                </a>
              </div>
            </div>
          </li>
          </ul>
        </div>
        <!-- Loading -->
        <!-- <infinite-loading @infinite="loadUsers" ref="infiniteLoading">
          <span slot="no-results"></span>
          <span slot="no-more"></span>
        </infinite-loading> -->
      </div>
      <div class="row mt-3" v-if='!loading && filters.pagination.total > 0'>
        <!-- <div class="col">
          {{filters.pagination.from}}-{{filters.pagination.to}} of {{filters.pagination.total}}
        </div> -->
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
          per_page: 15,
          current_page: 1,
          last_page: 0
        },
        orderBy: {
          column: 'name',
          direction: 'asc'
        },
        search: ''
      },
      clearSearchBtn: false,
      loading: true
    }
  },
  mounted () {
    this.getUsers()
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
    clearSearch() {
      this.filters.search = ''
      this.filter()
    },
    editUser (userId) {
      location.href = `/stores/${userId}/edit`
    },
    // filters
    filter() {
      this.filters.pagination.current_page = 1
      this.getUsers()
    },
    // changeSize (perPage) {
    //   this.filters.pagination.current_page = 1
    //   this.filters.pagination.per_page = perPage
    //   this.getUsers()
    // },
    // sort (column) {
    //   if(column == this.filters.orderBy.column) {
    //     this.filters.orderBy.direction = this.filters.orderBy.direction == 'asc' ? 'desc' : 'asc'
    //   } else {
    //     this.filters.orderBy.column = column
    //     this.filters.orderBy.direction = 'asc'
    //   }
    //
    //   this.getUsers()
    // },
    changePage (page) {
      this.filters.pagination.current_page = page
      this.getUsers()
    }
  }
}
</script>
