<template lang="html">
  <div>
    <div class="card-header px-0 mt-2 bg-transparent clearfix">
      <h4 class="float-left pt-2">Direcciones</h4>
      <div class="card-header-actions mr-1">
        <a class="btn btn-primary" href="#" data-toggle="modal" data-target="#addAddressModal">
          <i class="fa fa-plus mr-1"></i>Agregar
        </a>
      </div>
    </div>
    <div class="card-body px-0">
      <ul class="list-group mb-1" v-for="(item, index) in address">
        <li class="list-group-item">
          <div class="d-flex w-100 justify-content-between">
            <div>
              <i class="fas fa-map-marker-alt mr-3"></i>
              <strong class="mr-2">{{item.alias}}</strong>
              <span>{{item.address}}</span>
            </div>
            <a href="#" :disabled="submitingDestroy" @click.prevent="deleteAddress(item, index)">
              <i class="fas fa-spinner fa-spin" v-if="submitingDestroy"></i>
              <i class="far fa-trash-alt" v-else></i>
            </a>
          </div>
        </li>
      </ul>
    </div>
    <div class="no-items-found text-center mt-5" v-if="!address.length > 0">
      <i class="icon-magnifier fa-3x text-muted"></i>
      <p class="mb-0 mt-3"><strong>No tienes ningun dirección</strong></p>
      <p class="text-muted">Agrega tus direcciones dando clic en el boton de abajo</p>
      <a class="btn btn-primary" href="#" data-toggle="modal" data-target="#addAddressModal">
        <i class="fa fa-plus mr-1"></i>Agregar
      </a>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="addAddressModal" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Agrega una dirección</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label>Alias</label>
              <input type="text" class="form-control" placeholder="Casa"
              v-model="newAddress.alias">
            </div>
            <div class="form-group">
              <label>Direccion</label>
              <input type="text" class="form-control" :class="{'is-invalid': errors.address}" placeholder="Calle, numero y colonia"
              v-model="newAddress.address" @keyup.enter="saveAddress">
              <div class="invalid-feedback" v-if="errors.address">{{errors.address[0]}}</div>
            </div>
          </div>
          <div class="modal-footer">
            <a class="btn btn-primary" href="#" :disabled="submiting" @click.prevent="saveAddress">
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
      address: [],
      newAddress: {},
      loading: true,
      submiting: false,
      submitingDestroy: false,
      errors: {}
    }
  },
  mounted () {
    this.getAddress()
  },
  methods: {
    getAddress () {
      this.loading = true
      axios.get(`/api/address/byClient`)
      .then(response => {
        this.address = response.data
        this.loading = false
      })
    },
    saveAddress () {
      if (!this.submiting) {
        this.errors = {}
        this.submiting = true
        axios.post(`/api/address/store`, this.newAddress)
        .then(response => {
          this.newAddress = {}
          this.address.unshift(response.data)
          this.submiting = false
          $('#addAddressModal').modal('hide')
          this.$toasted.global.error('¡Direccion agregada!')
        })
        .catch(error => {
          this.errors = error.response.data.errors
          this.submiting = false
        })
      }
    },
    deleteAddress (address, index) {
      if (!this.submitingDestroy) {
        this.submitingDestroy = true
        swal({
          title: "¿Estas seguro?",
          text: "¿En verdad quieres borrar la dirección?",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            axios.delete(`/api/address/${address.id}`)
            .then(response => {
              this.address.splice(index, 1)
              this.$toasted.global.error('¡Direccion borrada!')
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
