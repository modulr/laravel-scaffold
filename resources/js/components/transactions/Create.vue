<template>
  <div class="container">
    <div class="row justify-content-md-center">
      <div class="col-md-12 col-xl-9">
        <div class="card-header px-0 mt-2 bg-transparent clearfix">
          <h4 class="float-left pt-2"><a href="/transactions" class="text-dark"><i class="fas fa-angle-left fa-lg"></i></a>&nbsp; Crear transaccion</h4>
          <div class="card-header-actions mr-1">
            <a class="btn btn-primary" href="#" :disabled="submiting" @click.prevent="create">
              <i class="fas fa-spinner fa-spin" v-if="submiting"></i>
              <i class="fas fa-check" v-else></i>
              <span class="ml-1">Guardar</span>
            </a>
          </div>
        </div>
        <div class="card-body px-0">
          <div class="form-group">
            <label>Nombre</label>
            <input type="text" class="form-control form-control-lg" :class="{'is-invalid': errors.name}" v-model="transaction.name" placeholder="Enero 2019">
            <div class="invalid-feedback" v-if="errors.name">{{errors.name[0]}}</div>
          </div>
        </div>
        <div class="card-header px-0 bg-transparent">
          <strong>Empresas</strong><br>
          <small class="text-muted">Empresas involucradas en la transaccion.</small>
          <div class="card-header-actions">
            <a class="card-header-action btn-minimize" href="#" data-toggle="collapse" data-target="#collapseCompanies" aria-expanded="true">
              <i class="icon-arrow-up"></i>
            </a>
          </div>
        </div>
        <div class="card-body px-0 collapse show" id="collapseCompanies">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Empresa Importadora</label>
                <multiselect
                  v-model="transaction.company_import"
                  :options="companies"
                  openDirection="bottom"
                  track-by="id"
                  label="name"
                  :class="{'border border-danger rounded': errors.company_import_id}">
                </multiselect>
                <small class="form-text text-danger" v-if="errors.company_import_id">{{errors.company_import_id[0]}}</small>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Aduana Importadora</label>
                <multiselect
                  v-model="transaction.customs_import"
                  :options="companies"
                  openDirection="bottom"
                  track-by="id"
                  label="name"
                  :class="{'border border-danger rounded': errors.customs_import_id}">
                </multiselect>
                <small class="form-text text-danger" v-if="errors.customs_import_id">{{errors.customs_import_id[0]}}</small>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Empresa Exportadora</label>
                <multiselect
                  v-model="transaction.company_export"
                  :options="companies"
                  openDirection="bottom"
                  track-by="id"
                  label="name"
                  :class="{'border border-danger rounded': errors.company_export_id}">
                </multiselect>
                <small class="form-text text-danger" v-if="errors.company_export_id">{{errors.company_export_id[0]}}</small>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Aduana Exportadora</label>
                <multiselect
                  v-model="transaction.customs_export"
                  :options="companies"
                  openDirection="bottom"
                  track-by="id"
                  label="name"
                  :class="{'border border-danger rounded': errors.customs_export_id}">
                </multiselect>
                <small class="form-text text-danger" v-if="errors.customs_export_id">{{errors.customs_export_id[0]}}</small>
              </div>
            </div>
          </div>
        </div>
        <div class="card-header px-0 bg-transparent">
          <strong>Usuarios</strong><br>
          <small class="text-muted">Usuarios participantes en la transaccion.</small>
          <div class="card-header-actions">
            <a class="card-header-action btn-minimize" href="#" data-toggle="collapse" data-target="#collapseUsers" aria-expanded="false">
              <i class="icon-arrow-up"></i>
            </a>
          </div>
        </div>
        <div class="card-body text-center px-0 collapse" id="collapseUsers">
          <p class="text-muted">Podras visualizar los usuarios participantes, una vez creada la transaccion.</p>
        </div>
        <div class="card-header px-0 bg-transparent">
          <strong>Etapas</strong><br>
          <small class="text-muted">Etapas de la transaccion.</small>
          <div class="card-header-actions">
            <div class="float-left mr-2 d-sm-down-none">
              <div class="progress" style="height: 4px;">
                <div class="progress-bar bg-info" role="progressbar" :style="`width: ${8*100/100}%`" :aria-valuenow="8*100/100" aria-valuemin="0" :aria-valuemax="100"></div>
              </div>
            </div>
            <a class="card-header-action btn-minimize" href="#" data-toggle="collapse" data-target="#collapseSteps" aria-expanded="false">
              <i class="icon-arrow-up"></i>
            </a>
          </div>
        </div>
        <div class="card-body text-center px-0 collapse" id="collapseSteps">
          <p class="text-muted">Podras crear etapas, una vez creada la transaccion.</p>
          <a class="btn btn-success disabled mb-2" href="#" role="button">
            <i class="fa fa-plus"></i>&nbsp; Crear etapa
          </a>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data () {
    return {
      companies: [],
      transaction: {},
      errors: {},
      submiting: false
    }
  },
  mounted () {
    this.getCompanies()
  },
  methods: {
    getCompanies () {
      axios.get(`/api/companies/all`)
      .then(response => {
        this.companies = response.data
      })
      .catch(error => {
        this.errors = error.response.data.errors
      })
    },
    create () {
      if (!this.submiting) {
        this.submiting = true
        this.transaction.company_import_id = this.transaction.company_import ? this.transaction.company_import.id : null;
        this.transaction.company_export_id = this.transaction.company_export ? this.transaction.company_export.id : null;
        this.transaction.customs_import_id = this.transaction.customs_import ? this.transaction.customs_import.id : null;
        this.transaction.customs_export_id = this.transaction.customs_export ? this.transaction.customs_export.id : null;
        axios.post(`/api/transactions/store`, this.transaction)
        .then(response => {
          this.$toasted.global.error('Transaccion creada!')
          location.href = `/transactions/${response.data.id}/edit`
        })
        .catch(error => {
          this.errors = error.response.data.errors
        })
        .then(() => {
          this.submiting = false
        })
      }
    }
  }
}
</script>
