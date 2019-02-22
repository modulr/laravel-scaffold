<template>
  <div>
    <!-- List companies -->
    <div class="list-group list-group-flush">
      <li class="list-group-item list-group-item-action border-light py-3" v-for="company in transaction.companies">
        <div class="d-flex justify-content-between">
          <div>
            <strong>{{company.name}}</strong><br>
            <small class="text-muted">{{company.pivot.company_type}}</small>
          </div>
          <button type="button" class="close" aria-label="Close" @click="detachCompany(company)">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <ul class="list-group list-group-flush" v-if="company.users">
          <li v-for="(user, index) in company.users" track-by="id" class="list-group-item media border-light">
            <div class="avatar-sm float-left mr-3">
              <img class="img-avatar" :src="user.avatar_url">
            </div>
            <div class="media-body">
              <div class="d-flex justify-content-between">
                {{user.name}}
              </div>
              <div class="small text-muted">
                {{user.email}}
              </div>
            </div>
          </li>
        </ul>
      </li>
    </div>
    <div class="card-body text-center px-0">
      <p class="text-muted"><small>Agrega empresas y usuarios para interactuar con ellos.</small></p>
      <a class="btn btn-success" href="#" role="button" @click.prevent="addCompany">
        <i class="fa fa-plus mr-2"></i>Agregar empresa
      </a>
    </div>
    <!-- Add Company -->
    <div class="modal fade" id="addCompanyModal" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Agregar empresa</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label>Empresa</label>
              <multiselect
                v-model="company.company"
                :options="lists.companies"
                openDirection="bottom"
                track-by="id"
                label="name"
                placeholder="Seleccionar"
                :class="{'border border-danger rounded': errors.company}">
              </multiselect>
              <small class="form-text text-danger" v-if="errors.company">{{errors.company[0]}}</small>
            </div>
            <div class="form-group">
              <label>Rol de la empresa</label>
              <multiselect
                v-model="company.type"
                :options="lists.companyTypes"
                openDirection="bottom"
                track-by="id"
                label="type"
                placeholder="Seleccionar"
                :class="{'border border-danger rounded': errors.type}">
              </multiselect>
              <small class="form-text text-danger" v-if="errors.type">{{errors.type[0]}}</small>
            </div>
            <p v-if="company.company && company.company.users.length > 0">Estos usuarios pertenecen a la empresa seleccionada y tambien seran invitados a la transaccion</p>
            <ul class="list-group list-group-flush" v-if="company.company && company.company.users.length > 0">
              <li v-for="(user, index) in company.company.users" track-by="id" class="list-group-item media border-light">
                <div class="avatar-sm float-left mr-3">
                  <img class="img-avatar" :src="user.avatar_url">
                </div>
                <div class="media-body">
                  <div class="d-flex justify-content-between">
                    {{user.name}}
                  </div>
                  <div class="small text-muted">
                    {{user.email}}
                  </div>
                </div>
              </li>
            </ul>
          </div>
          <div class="modal-footer">
            <a class="btn btn-primary" href="#" :disabled="submiting" @click.prevent="attachCompany">
              <i class="fas fa-spinner fa-spin" v-if="submiting"></i>
              <i class="fas fa-check" v-else></i>
              <span class="ml-1">Guardar</span>
            </a>
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
      company: {
        company: null,
        type: null
      },
      lists: {
        companies: [],
        companyTypes: []
      },
      errors: {},
      submiting: false,
    }
  },
  props: ['transaction'],
  mounted () {
    this.getCompanies()
    this.getCompanyTypes()
  },
  methods: {
    getCompanies () {
      axios.get(`/api/companies/all`)
      .then(response => {
        this.lists.companies = response.data
      })
      .catch(error => {
        this.errors = error.response.data.errors
      })
    },
    getCompanyTypes () {
      axios.get(`/api/companies/companyType/all`)
      .then(response => {
        this.lists.companyTypes = response.data
      })
      .catch(error => {
        this.errors = error.response.data.errors
      })
    },
    addCompany () {
      $('#addCompanyModal').modal('show')
    },
    attachCompany() {
      if (!this.submiting) {
        this.submiting = true
        axios.put(`/api/transactions/attachCompany/${this.transaction.id}`, {company: this.company.company ? this.company.company.id : null, type: this.company.type ? this.company.type.type : null})
        .then(response => {
          this.transaction.companies = response.data.companies;
          this.$toasted.global.error('Empresa agregada!')
          this.company = {
            company: null,
            type: null
          },
          this.errors = {}
          this.submiting = false
          $('#addCompanyModal').modal('hide')
        })
        .catch(error => {
          if (error.response) {
            this.errors = error.response.data.errors
          }
          this.submiting = false
        })
      }
    },
    detachCompany(company) {
      if (!this.submiting) {
        this.submiting = true
        axios.put(`/api/transactions/detachCompany/${this.transaction.id}/${company.id}`)
        .then(response => {
          this.transaction.companies = response.data.companies;
          this.$toasted.global.error('Empresa eliminada!')
          this.submiting = false
          $('#addCompanyModal').modal('hide')
        })
        .catch(error => {
          if (error.response) {
            this.errors = error.response.data.errors
          }
          this.submiting = false
        })
      }
    }
  }
}
</script>
