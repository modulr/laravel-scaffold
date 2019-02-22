<template>
  <div class="container">
    <div class="row justify-content-md-center">
      <div class="col-md-12 col-xl-9">
        <!-- button actions -->
        <div class="card-header px-0 mt-2 bg-transparent clearfix">
          <h4 class="float-left pt-2"><a href="/transactions" class="text-dark"><i class="fas fa-angle-left fa-lg px-2"></i></a> Crear transaccion</h4>
          <div class="card-header-actions mr-1">
            <a class="btn btn-primary" href="#" :disabled="submiting" @click.prevent="create">
              <i class="fas fa-spinner fa-spin" v-if="submiting"></i>
              <i class="fas fa-check" v-else></i>
              <span class="ml-1">Guardar</span>
            </a>
          </div>
        </div>
        <!-- form -->
        <div class="card-body px-0">
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
            <a class="card-header-action btn-minimize" href="#" data-toggle="collapse" data-target="#collapseCompanies" aria-expanded="true">
              <i class="icon-arrow-up"></i>
            </a>
          </div>
        </div>
        <div class="card-body text-center px-0 collapse show" id="collapseCompanies">
          <p class="alert alert-info">Podras invitar empresas y usuarios, una vez creada la transaccion.</p>
          <p class="text-muted"><small>Agrega empresas y usuarios para interactuar con ellos.</small></p>
          <a class="btn btn-success disabled mb-2" href="#" role="button">
            <i class="fa fa-plus mr-2"></i>Agregar empresa
          </a>
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
        <div class="card-body text-center px-0 collapse show" id="collapseSteps">
          <p class="alert alert-info">Podras crear etapas, una vez creada la transaccion.</p>
          <p class="text-muted"><small>Agrega etapas para cargar archivos validarlos y comentarlos.</small></p>
          <a class="btn btn-success disabled mb-2" href="#" role="button">
            <i class="fa fa-plus mr-2"></i>Crear etapa
          </a>
        </div>
        <br><br><br>
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
      submiting: false,
    }
  },
  methods: {
    create () {
      if (!this.submiting) {
        this.submiting = true
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
