<template lang="html">
  <div>
    <div v-if="!loading">
      <div class="card-header px-0 mt-2 bg-transparent clearfix">
        <h4 class="float-left pt-2">Tarifas</h4>
        <div class="card-header-actions mr-1">
          <a class="btn btn-primary" href="#" data-toggle="modal" data-target="#addModal">
            <i class="fa fa-plus mr-1"></i>Agregar</span>
          </a>
        </div>
      </div>
      <div class="card-body px-0">
        <ul class="list-group mb-1" v-for="(item, index) in rates">
          <li class="list-group-item">
            <div class="d-flex w-100 justify-content-between">
              <div>
                <i class="fas fa-dollar-sign"></i>
                <strong class="mr-2">{{item.rate}}</strong>
                <span>{{item.created_at | moment('LLL')}}</span>
              </div>
              <small class="text-primary" v-if="index == 0">Tarifa del Día</small>
            </div>
          </li>
        </ul>
      </div>
    </div>
    <content-placeholders class="mt-5" v-else>
      <content-placeholders-text :lines="6"/>
    </content-placeholders>
    <div class="no-items-found text-center mt-5" v-if="!loading && !rates.length > 0">
      <i class="icon-magnifier fa-3x text-muted"></i>
      <p class="mb-0 mt-3"><strong>No existe ninguna tarifa</strong></p>
      <p class="text-muted">Crea una dando clic en el boton de abajo</p>
      <a class="btn btn-primary" href="#" data-toggle="modal" data-target="#addModal">
        <i class="fa fa-plus mr-1"></i>Agregar
      </a>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Agrega una tarifa</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label>Tarifa</label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text">$</span>
                </div>
                <input type="text" class="form-control" :class="{'is-invalid': errors.rate}" placeholder="20" v-model="newRate.rate" @keyup.enter="create">
                <div class="input-group-prepend">
                  <span class="input-group-text">pesos</span>
                </div>
                <div class="invalid-feedback" v-if="errors.rate">{{errors.rate[0]}}</div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <a class="btn btn-primary" href="#" :disabled="submiting" @click.prevent="create">
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
      rates: [],
      newRate: {},
      loading: true,
      submiting: false,
      errors: {}
    }
  },
  mounted () {
    this.getRates()
  },
  methods: {
    getRates () {
      axios.get(`/api/rates/all`)
      .then(response => {
        this.rates = response.data
        this.loading = false
      })
      .catch(error => {
        this.errors = error.response.data.errors
      })
    },
    create () {
      if (!this.submiting) {
        this.errors = {}
        this.submiting = true
        axios.post(`/api/rates/store`, this.newRate)
        .then(response => {
          this.rates.unshift(response.data)
          this.newRate = {}
          this.submiting = false
          $('#addModal').modal('hide')
          this.$toasted.global.error('¡Tarifa creada!')
        })
        .catch(error => {
          this.errors = error.response.data.errors
          this.submiting = false
        })
      }
    }
  }
}
</script>
