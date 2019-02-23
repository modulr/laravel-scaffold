<template>
  <div class="container">
    <div class="row justify-content-md-center">
      <div class="col-md-12 col-xl-9" v-if="!loading">
        <!-- button actions -->
        <div class="card-header px-0 mt-2 bg-transparent clearfix">
          <h4 class="float-left pt-2"><a href="/transactions" class="text-dark"><i class="fas fa-angle-left fa-lg px-2"></i></a> Transaccion</h4>
          <div class="card-header-actions mr-1" v-if="user.hasPermission['create-transactions']">
            <a class="btn btn-primary" href="#" :disabled="submiting" @click.prevent="update">
              <i class="fas fa-spinner fa-spin" v-if="submiting"></i>
              <i class="fas fa-check" v-else></i>
              <span class="ml-1">Guardar</span>
            </a>
            <a class="card-header-action ml-1" href="#" :disabled="submitingDestroy" @click.prevent="destroy" v-if="user.hasPermission['delete-transactions']">
              <i class="fas fa-spinner fa-spin" v-if="submitingDestroy"></i>
              <i class="far fa-trash-alt" v-else></i>
              <span class="d-md-down-none ml-1">Borrar</span>
            </a>
          </div>
        </div>
        <!-- form -->
        <div class="card-body px-0">
          <div class="form-group text-right clearfix mb-0">
            <small class="text-success" v-if="transaction.finished && transaction.finished_by_user">Finalizada por <i>{{transaction.finished_by_user.name}}. {{transaction.finished_at | moment('LL')}}</i></small>
            <small v-if="!transaction.finished && !transaction.finished_by_user && user.hasPermission['update-transactions']">Finalizar transaccion</small>
            <label class="switch switch-label switch-pill switch-success float-right mb-0 ml-3" v-if="user.hasPermission['update-transactions']">
              <input class="switch-input form-check-input" type="checkbox" v-model="transaction.finished" @change="toggleFinished">
              <span class="switch-slider" data-checked="✓" data-unchecked="✕"></span>
            </label>
          </div>
          <div class="form-group">
            <label>Nombre</label>
            <input type="text" class="form-control form-control-lg" :class="{'is-invalid': errors.name}" v-model="transaction.name" placeholder="Enero 2019">
            <div class="invalid-feedback" v-if="errors.name">{{errors.name[0]}}</div>
          </div>
        </div>
        <!-- sections -->
        <div class="card-header px-0 bg-transparent">
          <strong>Empresas y usuarios</strong><br>
          <small class="text-muted">Empresas y usuarios invitados a la transaccion.</small>
          <div class="card-header-actions">
            <a class="card-header-action btn-minimize" href="#" data-toggle="collapse" data-target="#collapseCompanies" aria-expanded="false">
              <i class="icon-arrow-up"></i>
            </a>
          </div>
        </div>
        <div class="card-body collapse show" id="collapseCompanies">
          <transactions-companies :transaction="transaction"></transactions-companies>
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
      user: Laravel.user,
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
        this.$toasted.global.error('La transaccion no existe')
        location.href = '/transactions'
      })
      .then(() => {
        this.loading = false
      })
    },
    update () {
      if (!this.submiting) {
        this.submiting = true
        axios.put(`/api/transactions/update/${this.transaction.id}`, this.transaction)
        .then(response => {
          this.$toasted.global.error('Transaccion actualizada!')
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
          title: "¿Estas seguro?",
          text: "Una vez borrada, ya no podras recuperar la transaccion!",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            axios.delete(`/api/transactions/${this.transaction.id}`)
            .then(response => {
              this.$toasted.global.error('Transaccion borrada!')
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
        this.transaction.finished_at = response.data.finished_at
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
