<template>
  <div class="container">
    <div class="row justify-content-md-center">
      <div class="col-md-12 col-xl-9" v-if="!loading">
        <!-- button actions -->
        <div class="card-header px-0 mt-2 bg-transparent clearfix">
          <h4 class="float-left pt-2"><a href="/transactions" class="text-dark"><i class="fas fa-angle-left fa-lg px-2"></i></a> Editar Transaccion</h4>
          <div class="card-header-actions mr-1">
            <a class="btn btn-primary" href="#" :disabled="submiting" @click.prevent="update">
              <i class="fas fa-spinner fa-spin" v-if="submiting"></i>
              <i class="fas fa-check" v-else></i>
              <span class="ml-1">Guardar</span>
            </a>
            <a class="card-header-action ml-1" href="#" :disabled="submitingDestroy" @click.prevent="destroy">
              <i class="fas fa-spinner fa-spin" v-if="submitingDestroy"></i>
              <i class="far fa-trash-alt" v-else></i>
              <span class="d-md-down-none ml-1">Borrar</span>
            </a>
          </div>
        </div>
        <!-- form -->
        <div class="card-body px-0">
          <div class="form-group text-right">
            <small class=" text-success mr-3" v-if="transaction.finished && transaction.finished_by_user">-- Finalizada por <i>{{transaction.finished_by_user.name}}</i> -- </small>
            <label>Finalizar transaccion</label>
            <div class="float-right ml-2">
              <label class="switch switch-label switch-pill switch-success">
                <input class="switch-input form-check-input" type="checkbox" v-model="transaction.finished" @change="toggleFinished">
                <span class="switch-slider" data-checked="✓" data-unchecked="✕"></span>
              </label>
            </div>
          </div>
          <div class="form-group">
            <label>Nombre</label>
            <input type="text" class="form-control form-control-lg" :class="{'is-invalid': errors.name}" v-model="transaction.name" placeholder="Enero 2019">
            <div class="invalid-feedback" v-if="errors.name">{{errors.name[0]}}</div>
          </div>
        </div>
        <!-- sections -->
        <div class="card-header px-0 bg-transparent">
          <strong>Empresas</strong><br>
          <small class="text-muted">Empresas invitadas a la transaccion.</small>
          <div class="card-header-actions">
            <a class="card-header-action btn-minimize" href="#" data-toggle="collapse" data-target="#collapseCompanies" aria-expanded="false">
              <i class="icon-arrow-up"></i>
            </a>
          </div>
        </div>
        <div class="card-body collapse show" id="collapseCompanies">
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
              <div class="mb-4" v-if="transaction.company_import">
                <div class="media mb-2" v-if="transaction.company_import.users && transaction.company_import.users.length > 0" v-for="user in transaction.company_import.users">
                  <div class="float-left">
                    <img class="img-avatar avatar-sm mr-2" :src="user.avatar_url">
                  </div>
                  <div class="media-body">
                    {{user.name}}
                    <div class="small text-muted">
                      {{user.email}}
                    </div>
                  </div>
                </div>
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
              <div class="mb-4" v-if="transaction.company_export">
                <div class="media mb-2" v-if="transaction.company_export.users && transaction.company_export.users.length > 0" v-for="user in transaction.company_export.users">
                  <div class="float-left">
                    <img class="img-avatar avatar-sm mr-2" :src="user.avatar_url">
                  </div>
                  <div class="media-body">
                    {{user.name}}
                    <div class="small text-muted">
                      {{user.email}}
                    </div>
                  </div>
                </div>
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
              <div class="mb-4" v-if="transaction.customs_import">
                <div class="media mb-2" v-if="transaction.customs_import.users && transaction.customs_import.users.length > 0" v-for="user in transaction.customs_import.users">
                  <div class="float-left">
                    <img class="img-avatar avatar-sm mr-2" :src="user.avatar_url">
                  </div>
                  <div class="media-body">
                    {{user.name}}
                    <div class="small text-muted">
                      {{user.email}}
                    </div>
                  </div>
                </div>
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
              <div class="mb-4" v-if="transaction.customs_export">
                <div class="media mb-2" v-if="transaction.customs_export.users && transaction.customs_export.users.length > 0" v-for="user in transaction.customs_export.users">
                  <div class="float-left">
                    <img class="img-avatar avatar-sm mr-2" :src="user.avatar_url">
                  </div>
                  <div class="media-body">
                    {{user.name}}
                    <div class="small text-muted">
                      {{user.email}}
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="card-header px-0 bg-transparent">
          <strong>Etapas</strong><br>
          <small class="text-muted">Etapas de la transaccion.</small>
          <div class="card-header-actions">
            <div class="float-left mr-2">
              <small class="text-muted">{{transaction.stages.length}} de 10</small>
              <div class="progress" style="height: 4px;">
                <div class="progress-bar bg-info" role="progressbar" :style="`width: ${transaction.stages.length*100/10}%`" :aria-valuenow="transaction.stages.length*100/10" aria-valuemin="0" :aria-valuemax="10"></div>
              </div>
            </div>
            <a class="card-header-action btn-minimize" href="#" data-toggle="collapse" data-target="#collapseStages" aria-expanded="true">
              <i class="icon-arrow-up"></i>
            </a>
          </div>
        </div>
        <div class="card-body collapse show" id="collapseStages">
          <transactions-stages :transaction="transaction"></transactions-stages>
        </div>
        <div class="card-body text-right px-0">
          <small class="text-muted">Creada <i>{{transaction.created_at | moment("LLL")}}</i></small>
        </div>
      </div>
      <div class="col-md-12 col-xl-9 mt-5" v-else>
          <content-placeholders>
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
      transaction: {},
      errors: {},
      loading: true,
      submiting: false,
      submitingDestroy: false
    }
  },
  mounted () {
    this.getCompanies()
  },
  methods: {
    getCompanies () {
      this.loading = true
      axios.get(`/api/companies/all`)
      .then(response => {
        this.companies = response.data
        this.getTransaction()
      })
      .catch(error => {
        this.errors = error.response.data.errors
      })
    },
    getTransaction() {
      let str = window.location.pathname
      let res = str.split("/")
      axios.get(`/api/transactions/${res[2]}`)
      .then(response => {
        this.transaction = response.data
      })
      .catch(error => {
        this.$toasted.global.error('Transaction does not exist!')
        location.href = '/transactions'
      })
      .then(() => {
        this.loading = false
      })
    },
    update () {
      if (!this.submiting) {
        this.submiting = true
        this.transaction.company_import_id = this.transaction.company_import ? this.transaction.company_import.id : null;
        this.transaction.company_export_id = this.transaction.company_export ? this.transaction.company_export.id : null;
        this.transaction.customs_import_id = this.transaction.customs_import ? this.transaction.customs_import.id : null;
        this.transaction.customs_export_id = this.transaction.customs_export ? this.transaction.customs_export.id : null;
        axios.put(`/api/transactions/update/${this.transaction.id}`, this.transaction)
        .then(response => {
          this.$toasted.global.error('Updated transaction!')
          location.href = '/transactions'
        })
        .catch(error => {
          this.errors = error.response.data.errors
          this.submiting = false
        })
      }
    },
    destroy () {
      if (!this.submitingDestroy) {
        this.submitingDestroy = true
        swal({
          title: "Are you sure?",
          text: "Once deleted, you will not be able to recover this transaction!",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            axios.delete(`/api/transactions/${this.transaction.id}`)
            .then(response => {
              this.$toasted.global.error('Deleted transaction!')
              location.href = '/transactions'
            })
            .catch(error => {
              this.errors = error.response.data.errors
            })
          }
          this.submitingDestroy = false
        })
      }
    },
    toggleFinished () {
      axios.put(`/api/transactions/toggleFinished/${this.transaction.id}`, this.transaction)
      .then(response => {
        this.transaction.finished_by = response.data.finished_by
        this.transaction.finished_by_user = response.data.finished_by_user
        if (response.data.finished) {
          this.$toasted.global.error('Transaccion Finalizada!')
        } else {
          this.$toasted.global.error('Transaccion Abierta!')
        }
      })
      .catch(error => {
        if (error.response) {
          this.errors = error.response.data.errors
        }
      })
    }
  }
}
</script>
