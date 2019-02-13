<template>
  <div class="container">
    <div class="row justify-content-md-center">
      <div class="col-md-12 col-xl-9">
        <div class="card-header px-0 mt-2 bg-transparent clearfix">
          <h4 class="float-left pt-2"><a href="/companies" class="text-dark"><i class="fas fa-angle-left fa-lg"></i></a>&nbsp; Crear empresa</h4>
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
            <input type="text" class="form-control" :class="{'is-invalid': errors.name}" v-model="company.name" placeholder="Modulr Co.">
            <div class="invalid-feedback" v-if="errors.name">{{errors.name[0]}}</div>
          </div>
        </div>
        <div class="card-header px-0 bg-transparent">
          <strong>Usuarios</strong><br>
          <small class="text-muted">Contactos de la empresa con acceso al sistema.</small>
          <div class="card-header-actions">
            <div class="float-left mr-2 d-sm-down-none">
              <div class="progress" style="height: 4px;">
                <div class="progress-bar bg-info" role="progressbar" :style="`width: ${8*100/100}%`" :aria-valuenow="8*100/100" aria-valuemin="0" :aria-valuemax="100"></div>
              </div>
            </div>
            <a class="card-header-action btn-minimize" href="#" data-toggle="collapse" data-target="#collapseUsers" aria-expanded="true">
              <i class="icon-arrow-up"></i>
            </a>
          </div>
        </div>
        <div class="card-body text-center px-0 collapse show" id="collapseUsers">
          <p class="text-muted">Podras crear usuarios para comunicarte con ellos, una vez creada la empresa.</p>
          <a class="btn btn-success disabled mb-2" href="#" role="button">
            <i class="fa fa-plus"></i>&nbsp; Crear usuario
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
      company: {},
      errors: {},
      submiting: false
    }
  },
  methods: {
    create () {
      if (!this.submiting) {
        this.submiting = true
        axios.post(`/api/companies/store`, this.company)
        .then(response => {
          this.$toasted.global.error('Empresa creada!')
          location.href = `/companies/${response.data.id}/edit`
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
