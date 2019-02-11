<template>
  <div class="container">
    <div class="row justify-content-md-center">
      <div class="col-md-12 col-xl-9" v-if="!loading">
        <!--button actions-->
        <div class="card-header px-0 mt-2 bg-transparent clearfix">
          <h4 class="float-left pt-2"><a href="/companies" class="text-dark"><i class="fas fa-angle-left fa-lg"></i></a>&nbsp; Editar Empresa</h4>
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
        <!--forms-->
        <div class="card-body px-0">
          <div class="form-group">
            <label>Nombre</label>
            <input type="text" class="form-control" :class="{'is-invalid': errors.name}" v-model="company.name" placeholder="Modulr Co.">
            <div class="invalid-feedback" v-if="errors.name">{{errors.name[0]}}</div>
          </div>
        </div>
        <div class="card-header px-0 bg-transparent">
          <strong>Usuarios</strong><br>
          <small class="text-muted">Contactos de la empresa con acceso al sistema.</small>
          <div class="card-header-actions">
            <div class="float-left mr-2">
              <small class="text-muted">{{company.users.length}} de 10</small>
              <div class="progress" style="height: 4px;">
                <div class="progress-bar bg-info" role="progressbar" :style="`width: ${company.users.length*100/10}%`" :aria-valuenow="company.users.length*100/10" aria-valuemin="0" :aria-valuemax="10"></div>
              </div>
            </div>
            <a class="card-header-action btn-minimize" href="#" data-toggle="collapse" data-target="#collapseUsers" aria-expanded="true">
              <i class="icon-arrow-up"></i>
            </a>
          </div>
        </div>
        <div class="card-body px-0 collapse show" id="collapseUsers">
          <companies-users :company="company"></companies-users>
        </div>
        <div class="card-header px-0 bg-transparent">
          <strong>Transacciones</strong><br>
          <small class="text-muted">Transacciones con otras empresas.</small>
          <div class="card-header-actions">
            <div class="card-header-actions">
              <div class="float-left mr-2">
                <small class="text-muted">0 de 10</small>
                <div class="progress" style="height: 4px;">
                  <div class="progress-bar bg-info" role="progressbar" :style="`width: ${0*100/10}%`" :aria-valuenow="0*100/10" aria-valuemin="0" :aria-valuemax="10"></div>
                </div>
              </div>
              <a class="card-header-action btn-minimize" href="#" data-toggle="collapse" data-target="#collapseTransactions" aria-expanded="false">
                <i class="icon-arrow-up"></i>
              </a>
            </div>
          </div>
        </div>
        <div class="card-body text-center px-0 collapse" id="collapseTransactions">
          <a class="btn btn-success mb-2" href="/transaction/create" role="button">
            <i class="fa fa-plus"></i>&nbsp; Crear transaccion
          </a>
          <p><small class="text-muted">Crea transacciones, para llebar el control de tus documentos y conversaciones.</small></p>
        </div>
        <div class="card-body text-right px-0">
          <small class="text-muted">Creada <i>{{company.created_at | moment("LLL")}}</i></small>
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
      company: {},
      errors: {},
      loading: true,
      submiting: false,
      submitingDestroy: false
    }
  },
  mounted () {
    this.getCompany()
  },
  methods: {
    getCompany() {
      this.loading = true
      let str = window.location.pathname
      let res = str.split("/")
      axios.get(`/api/companies/${res[2]}`)
      .then(response => {
        this.company = response.data
      })
      .catch(error => {
        this.$toasted.global.error('Company does not exist!')
        location.href = '/companies'
      })
      .then(() => {
        this.loading = false
      })
    },
    update () {
      if (!this.submiting) {
        this.submiting = true
        axios.put(`/api/companies/update/${this.company.id}`, this.company)
        .then(response => {
          this.$toasted.global.error('Updated company!')
          location.href = '/companies'
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
          text: "Once deleted, you will not be able to recover this company!",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            axios.delete(`/api/companies/${this.company.id}`)
            .then(response => {
              this.$toasted.global.error('Deleted company!')
              location.href = '/companies'
            })
            .catch(error => {
              this.errors = error.response.data.errors
            })
          }
          this.submitingDestroy = false
        })
      }
    }
  }
}
</script>
