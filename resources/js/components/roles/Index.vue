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
              <input type="text" class="form-control" placeholder="Seach" v-model.trim="search" @keyup.enter="filter">
            </div>
          </div>
          <div class="col-sm-auto">
            <multiselect
              v-model="pagination.perPage"
              :options="[50,100,200]"
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
                  <i class="mr-1 fas" :class="{'fa-sort-amount-down': orderBy.column == 'id' && orderBy.direction == 'asc', 'fa-sort-amount-up': orderBy.column == 'id' && orderBy.direction == 'desc'}"></i>
                  ID
                </a>
              </th>
              <th>
                <a href="#" class="text-dark" @click.prevent="sort('display_name')">
                  <i class="mr-1 fas" :class="{'fa-sort-amount-down': orderBy.column == 'name' && orderBy.direction == 'asc', 'fa-sort-amount-up': orderBy.column == 'display_name' && orderBy.direction == 'desc'}"></i>
                  Role
                </a>
              </th>
              <th>
                <a href="#" class="text-dark" @click.prevent="sort('name')">
                  <i class="mr-1 fas" :class="{'fa-sort-amount-down': orderBy.column == 'name' && orderBy.direction == 'asc', 'fa-sort-amount-up': orderBy.column == 'name' && orderBy.direction == 'desc'}"></i>
                  Slug
                </a>
              </th>
              <th>
                <a href="#" class="text-dark" @click.prevent="sort('created_at')">
                  <i class="mr-1 fas" :class="{'fa-sort-amount-down': orderBy.column == 'created_at' && orderBy.direction == 'asc', 'fa-sort-amount-up': orderBy.column == 'created_at' && orderBy.direction == 'desc'}"></i>
                  Created
                </a>
              </th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="role in collection">
              <td>{{role.id}}</td>
              <td>{{role.display_name}}</td>
              <td>{{role.name}}</td>
              <td>
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
        <div class="no-items-found text-center mt-5" v-if="!loadingCollection && !collection.length > 0">
          <i class="icon-magnifier fa-3x text-muted"></i>
          <p class="mb-0 mt-3"><strong>Could not find any items</strong></p>
          <p class="text-muted">Try changing the filters or add a new one</p>
          <a class="btn btn-success" href="/users/create" role="button">
            <i class="fa fa-plus"></i>&nbsp; New Role
          </a>
        </div>
      </div>
      <div class="card-footer bg-transparent">
        <div class="row">
          <div class="col" v-if="pagination.total>0">
            {{pagination.from}}-{{pagination.to}} of {{pagination.total}}
          </div>
          <div class="col" v-if="pagination.lastPage>1">
            <nav aria-label="Page navigation">
              <ul class="pagination justify-content-end">
                <li class="page-item" :class="{'disabled': pagination.currentPage <= 1}">
                  <a class="page-link" href="#" @click.prevent="changePage(pagination.currentPage -  1)">«</a>
                </li>
                <li class="page-item" v-for="page in pagination.lastPage" :class="{'active': pagination.currentPage == page}">
                  <span class="page-link" v-if="pagination.currentPage == page">{{page}}</span>
                  <a class="page-link" href="#" v-else @click.prevent="changePage(page)">{{page}}</a>
                </li>
                <li class="page-item" :class="{'disabled': pagination.currentPage >= pagination.lastPage}">
                  <a class="page-link" href="#" @click.prevent="changePage(pagination.currentPage +  1)">»</a>
                </li>
              </ul>
            </nav>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data () {
    return {
      collection: [],
      pagination: {
        from: 0,
        to: 0,
        total: 0,
        perPage: 50,
        currentPage: 1,
        lastPage: 0
      },
      orderBy: {
        column: 'id',
        direction: 'asc'
      },
      search: '',
      loadingCollection: true
    }
  },
  mounted () {
    this.getRoles()
  },
  methods: {
    getRoles () {
      this.loadingCollection = true
      this.collection = []

      let filters = {
        perPage: this.pagination.perPage,
        page: this.pagination.currentPage,
        search: this.search,
        column: this.orderBy.column,
        direction: this.orderBy.direction
      }

      axios.post(`/api/roles/filter`, filters)
      .then(response => {
        if (response.data) {
          this.collection = response.data.data
          this.pagination = {
            from: response.data.from,
            to: response.data.to,
            total: response.data.total,
            perPage: response.data.per_page,
            currentPage: response.data.current_page,
            lastPage: response.data.last_page
          }
        }
        this.loadingCollection = false
      })
    },
    filter() {
      this.getRoles()
    },
    changeSize (perPage) {
      this.pagination.perPage = perPage
      this.getRoles()
    },
    sort (column) {
      if(column == this.orderBy.column) {
        this.orderBy.direction = this.orderBy.direction == 'asc' ? 'desc' : 'asc'
      } else {
        this.orderBy.column = column
        this.orderBy.direction = 'asc'
      }

      this.getRoles()
    },
    changePage (page) {
      this.pagination.currentPage = page
      this.getRoles()
    }
  }
}
</script>
