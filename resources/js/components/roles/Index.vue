<template>
  <div>
    <ol class="breadcrumb">
      <li class="breadcrumb-item active">Roles</li>
      <li class="breadcrumb-menu">
        <a class="btn btn-outline-success text-success" href="/roles/create">New role</a>
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
                <a href="#" class="text-dark" @click.prevent="sort('display_name')">
                  <i class="mr-1 fas" :class="{'fa-sort-amount-down': filters.orderBy.column == 'display_name' && filters.orderBy.direction == 'asc', 'fa-sort-amount-up': filters.orderBy.column == 'display_name' && filters.orderBy.direction == 'desc'}"></i>
                  Role
                </a>
              </th>
              <th>
                <a href="#" class="text-dark" @click.prevent="sort('name')">
                  <i class="mr-1 fas" :class="{'fa-sort-amount-down': filters.orderBy.column == 'name' && filters.orderBy.direction == 'asc', 'fa-sort-amount-up': filters.orderBy.column == 'name' && filters.orderBy.direction == 'desc'}"></i>
                  Slug
                </a>
              </th>
              <th>Permissions</th>
              <th>Users&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
              <th class="d-none d-sm-table-cell">
                <a href="#" class="text-dark" @click.prevent="sort('created_at')">
                  <i class="mr-1 fas" :class="{'fa-sort-amount-down': filters.orderBy.column == 'created_at' && filters.orderBy.direction == 'asc', 'fa-sort-amount-up': filters.orderBy.column == 'created_at' && filters.orderBy.direction == 'desc'}"></i>
                  Created
                </a>
              </th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="role in roles">
              <td>{{role.id}}</td>
              <td>{{role.display_name}}</td>
              <td>{{role.name}}</td>
              <td>
                <small class="text-muted">{{role.permissions.length}} of {{permissionsCount}}</small>
                <div class="progress" style="height: 4px;">
                  <div class="progress-bar bg-info" role="progressbar" :style="`width: ${role.permissions.length*100/permissionsCount}%`" :aria-valuenow="role.permissions.length*100/permissionsCount" aria-valuemin="0" :aria-valuemax="this.permissionsCount"></div>
                </div>
              </td>
              <td>
                <div class="avatars-stack">
                  <div class="avatar-sm" v-for="(user, index) in role.users.slice(0,4)">
                    <img class="img-avatar" :src="user.avatar_url">
                  </div>
                  <div class="avatar-sm ml-3" v-if="role.users.length > 4"> +{{role.users.length - 4}}</div>
                </div>
              </td>
              <td class="d-none d-sm-table-cell">
                <small>{{role.created_at | moment("LLL")}}</small>
              </td>
              <td>
                <a :href="`/roles/${role.id}/edit`">
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
                  <a class="page-link" href="#" @click.prevent="changePage(pagination.current_page -  1)"><i class="fas fa-angle-left"></i></a>
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
        <div class="no-items-found text-center mt-5" v-if="!loading && !roles.length > 0">
          <i class="icon-magnifier fa-3x text-muted"></i>
          <p class="mb-0 mt-3"><strong>Could not find any items</strong></p>
          <p class="text-muted">Try changing the filters or add a new one</p>
          <a class="btn btn-success" href="/users/create" role="button">
            <i class="fa fa-plus"></i>&nbsp; New Role
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
      roles: [],
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
      permissionsCount: 0,
      loading: true
    }
  },
  mounted () {
    if (localStorage.getItem("filtersTableRoles")) {
      this.filters = JSON.parse(localStorage.getItem("filtersTableRoles"))
    } else {
      localStorage.setItem("filtersTableRoles", this.filters);
    }
    this.getPermissionsCount()
    this.getRoles()
  },
  methods: {
    getRoles () {
      this.loading = true
      this.roles = []

      localStorage.setItem("filtersTableRoles", JSON.stringify(this.filters));

      axios.post(`/api/roles/filter?page=${this.filters.pagination.current_page}`, this.filters)
      .then(response => {
        this.roles = response.data.data
        delete response.data.data
        this.filters.pagination = response.data
        this.loading = false
      })
    },
    filter() {
      this.filters.pagination.current_page = 1
      this.getRoles()
    },
    changeSize (perPage) {
      this.filters.pagination.current_page = 1
      this.filters.pagination.per_page = perPage
      this.getRoles()
    },
    sort (column) {
      if(column == this.filters.orderBy.column) {
        this.filters.orderBy.direction = this.filters.orderBy.direction == 'asc' ? 'desc' : 'asc'
      } else {
        this.filters.orderBy.column = column
        this.filters.orderBy.direction = 'asc'
      }

      this.getRoles()
    },
    changePage (page) {
      this.filters.pagination.current_page = page
      this.getRoles()
    },
    getPermissionsCount() {
      axios.get(`/api/permissions/count`)
      .then(response => {
        this.permissionsCount = response.data
      })
    }
  }
}
</script>
