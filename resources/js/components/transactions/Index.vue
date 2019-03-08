<template>
  <div class="container">
    <div class="card-header px-0 mt-2 bg-transparent clearfix">
      <h4 class="float-left pt-2">Transacciones</h4>
      <div class="card-header-actions mr-1" v-if="user.hasPermission['create-transactions']">
        <a class="btn btn-success" href="/transactions/create"><i class="fas fa-plus mr-1"></i>Crear</a>
      </div>
    </div>
    <div class="card-body px-0">
      <div class="row justify-content-between">
        <!-- <div class="col-7 col-md-5">
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text" @click="filter">
                <i class="fas fa-search"></i>
              </span>
            </div>
            <input type="text" class="form-control" placeholder="Seach" v-model.trim="filters.search" @keyup.enter="filter">
          </div>
        </div> -->
        <div class="col-auto">
          <multiselect
            v-model="filters.wich"
            track-by="id" label="name"
            :options="options.wich"
            :searchable="false"
            :allow-empty="false"
            select-label=""
            deselect-label=""
            selected-label=""
            @select="changeWich">
          </multiselect>
        </div>
        <div class="col-auto">
          <multiselect
            v-model="filters.finished"
            track-by="id" label="name"
            :options="options.finished"
            :searchable="false"
            :allow-empty="false"
            select-label=""
            deselect-label=""
            selected-label=""
            @select="changeFinished">
          </multiselect>
        </div>
      </div>
      <table class="table table-hover mt-3">
        <thead>
          <tr>
            <th class="d-none d-sm-table-cell">
              <a href="#" class="text-dark" @click.prevent="sort('id')">ID</a>
              <i class="fas" :class="{'fa-long-arrow-alt-down': filters.orderBy.column == 'id' && filters.orderBy.direction == 'asc', 'fa-long-arrow-alt-up': filters.orderBy.column == 'id' && filters.orderBy.direction == 'desc'}"></i>
            </th>
            <th>
              <a href="#" class="text-dark" @click.prevent="sort('name')">Nombre</a>
              <i class="fas" :class="{'fa-long-arrow-alt-down': filters.orderBy.column == 'name' && filters.orderBy.direction == 'asc', 'fa-long-arrow-alt-up': filters.orderBy.column == 'name' && filters.orderBy.direction == 'desc'}"></i>
            </th>
            <th>Import</th>
            <th>Export</th>
            <th>
              <a href="#" class="text-dark" @click.prevent="sort('finished')">Finalizada</a>
              <i class="fas" :class="{'fa-long-arrow-alt-down': filters.orderBy.column == 'finished' && filters.orderBy.direction == 'asc', 'fa-long-arrow-alt-up': filters.orderBy.column == 'finished' && filters.orderBy.direction == 'desc'}"></i>
            </th>
            <th class="d-none d-sm-table-cell">
              <a href="#" class="text-dark" @click.prevent="sort('created_at')">Creada</a>
              <i class="fas" :class="{'fa-long-arrow-alt-down': filters.orderBy.column == 'created_at' && filters.orderBy.direction == 'asc', 'fa-long-arrow-alt-up': filters.orderBy.column == 'created_at' && filters.orderBy.direction == 'desc'}"></i>
            </th>
            <th class="d-none d-sm-table-cell" v-if="user.hasPermission['create-transactions']"></th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="transaction in transactions" @click="edit(transaction.id)">
            <td class="d-none d-sm-table-cell">{{transaction.id}}</td>
            <td>{{transaction.name}}</td>
            <td>
              <div v-for="company in companyImport(transaction.companies)">
                <small class="badge badge-secondary mr-1">{{company.company_type_acronym}}</small>
                <small class="text-muted">{{company.name}}</small>
              </div>
            </td>
            <td>
              <div v-for="company in companyExport(transaction.companies)">
                <small class="badge badge-secondary mr-1">{{company.company_type_acronym}}</small>
                <small class="text-muted">{{company.name}}</small>
              </div>
            </td>
            <td>
              <span class="badge badge-pill badge-success" v-if="transaction.finished">Finalizada</span>
              <span class="badge badge-pill badge-primary" v-else>Abierta</span>
            </td>
            <td class="d-none d-sm-table-cell">
              <small>{{transaction.created_at | moment("LL")}}</small></small>
            </td>
            <td class="d-none d-sm-table-cell" v-if="user.hasPermission['create-transactions']">
              <a href="#" class="text-muted"><i class="fas fa-pencil-alt"></i></a>
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
      <div class="no-items-found text-center mt-5" v-if="!loading && !transactions.length > 0">
        <i class="icon-magnifier fa-3x text-muted"></i>
        <p class="mb-0 mt-3"><strong>Could not find any items</strong></p>
        <p class="text-muted">Try changing the filters or add a new one</p>
        <a class="btn btn-success" href="/transactions/create" role="button">
          <i class="fa fa-plus"></i>&nbsp; Crear Transaccion
        </a>
      </div>
      <content-placeholders v-if="loading">
        <content-placeholders-text/>
        <content-placeholders-text/>
      </content-placeholders>
    </div>
  </div>
</template>

<script>
export default {
  data () {
    return {
      user: Laravel.user,
      transactions: [],
      options: {
        wich: [
          {id: 1, name: 'Todas'},
          {id: 2, name: 'Tuyas'},
          {id: 3, name: 'Invitado'}
        ],
        finished: [
          {id: 0, name: "Abiertas"},
          {id: 1, name: "Finalizadas"},
          {id: 2, name: "Ambas"},
        ]
      },
      filters: {
        wich: {
          id: 1,
          name: 'Todas'
        },
        finished: [{
          id: 2,
          name: "Ambas"
        }],
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
          direction: 'desc'
        },
        search: ''
      },
      loading: true
    }
  },
  mounted () {
    if (localStorage.getItem("filtersTableTransactions")) {
      this.filters = JSON.parse(localStorage.getItem("filtersTableTransactions"))
    } else {
      localStorage.setItem("filtersTableTransactions", this.filters);
    }
    this.getTransactions()
  },
  methods: {
    getTransactions () {
      this.loading = true
      this.transactions = []

      localStorage.setItem("filtersTableTransactions", JSON.stringify(this.filters));

      axios.post(`/api/transactions/filter?page=${this.filters.pagination.current_page}`, this.filters)
      .then(response => {
        this.transactions = response.data
        // delete response.data.data
        // this.filters.pagination = response.data
        this.loading = false
      })
    },
    edit (transactionId) {
      location.href = `/transactions/${transactionId}/edit`
    },
    // filters
    // filter() {
    //   this.filters.pagination.current_page = 1
    //   this.getTransactions()
    // },
    changeWich (wich) {
      this.filters.wich = wich
      this.getTransactions()
    },
    changeFinished (finished) {
      this.filters.finished = finished
      this.getTransactions()
    },
    changeSize (perPage) {
      this.filters.pagination.current_page = 1
      this.filters.pagination.per_page = perPage
      this.getTransactions()
    },
    sort (column) {
      if(column == this.filters.orderBy.column) {
        this.filters.orderBy.direction = this.filters.orderBy.direction == 'asc' ? 'desc' : 'asc'
      } else {
        this.filters.orderBy.column = column
        this.filters.orderBy.direction = 'asc'
      }

      this.getTransactions()
    },
    // changePage (page) {
    //   this.filters.pagination.current_page = page
    //   this.getTransactions()
    // }
    companyImport (companies) {
      return companies.filter(function(company){
        if (company.company_type_acronym == 'EI' || company.company_type_acronym == 'AI' || company.company_type_acronym == 'CI') {
          return company
        }
      })
    },
    companyExport (companies) {
      return companies.filter(function(company){
        if (company.company_type_acronym == 'EE' || company.company_type_acronym == 'AE' || company.company_type_acronym == 'CE') {
          return company
        }
      })
    }
  }
}
</script>
