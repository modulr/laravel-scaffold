<template>
  <div>
    <ol class="breadcrumb">
      <li class="breadcrumb-item active">Users</li>
      <li class="breadcrumb-menu">
        <a class="btn btn-outline-success text-success" href="/users/create">New user</a>
      </li>
    </ol>
    <div class="container">
      <div class="card-body">
        <div class="row justify-content-between">
          <div class="col-sm-7 col-md-5">
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" @click="filter">
                  <i class="fas fa-search"></i>
                </span>
              </div>
              <input type="text" class="form-control" placeholder="Seach" v-model.trim="filters.search" @keyup.enter="filter">
            </div>
          </div>
          <div class="col-sm-auto">
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
        <table class="table table-hover table-responsive-sm">
          <thead>
            <tr>
              <th>
                <a href="#" class="text-dark" @click.prevent="sort('id')">
                  <i class="mr-1 fas" :class="{'fa-sort-amount-down': filters.orderBy.column == 'id' && filters.orderBy.direction == 'asc', 'fa-sort-amount-up': filters.orderBy.column == 'id' && filters.orderBy.direction == 'desc'}"></i>
                  ID
                </a>
              </th>
              <th>
                <a href="#" class="text-dark" @click.prevent="sort('name')">
                  <i class="mr-1 fas" :class="{'fa-sort-amount-down': filters.orderBy.column == 'name' && filters.orderBy.direction == 'asc', 'fa-sort-amount-up': filters.orderBy.column == 'name' && filters.orderBy.direction == 'desc'}"></i>
                  User
                </a>
              </th>
              <th>Roles</th>
              <th class="d-none d-sm-table-cell">
                <a href="#" class="text-dark" @click.prevent="sort('created_at')">
                  <i class="mr-1 fas" :class="{'fa-sort-amount-down': filters.orderBy.column == 'created_at' && filters.orderBy.direction == 'asc', 'fa-sort-amount-up': filters.orderBy.column == 'created_at' && filters.orderBy.direction == 'desc'}"></i>
                  Registered
                </a>
              </th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="user in users">
              <td>{{user.id}}</td>
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
              <td>
                <span v-for="(role, index) in user.roles">
                  {{role.name}}<span v-if="index+1 < user.roles.length">, </span>
                </span>
              </td>
              <td class="d-none d-sm-table-cell">
                <small>{{user.created_at | moment("LLL")}}</small>
              </td>
              <td>
                <a :href="`/users/${user.id}/edit`">
                  <i class="fas fa-pencil-alt"></i>
                </a>
              </td>
            </tr>
          </tbody>
        </table>
        <div class="row" v-if='!loading && filters.pagination.total > 0'>
          <div class="col pt-2">
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
          column: 'id',
          direction: 'asc'
        },
        search: ''
      },
      loading: true
    }
  },
  mounted () {
    if (localStorage.getItem("filtersTableUsers")) {
      this.filters = JSON.parse(localStorage.getItem("filtersTableUsers"))
    } else {
      localStorage.setItem("filtersTableUsers", this.filters);
    }
    this.getUsers()
  },
  methods: {
    getUsers () {
      this.loading = true
      this.users = []

      localStorage.setItem("filtersTableUsers", JSON.stringify(this.filters));

      axios.post(`/api/users/filter?page=${this.filters.pagination.current_page}`, this.filters)
      .then(response => {
        this.users = response.data.data
        delete response.data.data
        this.filters.pagination = response.data
        this.loading = false
      })
    },
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
