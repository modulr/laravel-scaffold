<template lang="html">
  <div>
    <div class="card-header px-0 mt-2 bg-transparent clearfix">
      <h4 class="float-left pt-2">Direcciones</h4>
      <div class="card-header-actions mr-1">
        <a class="btn btn-primary btn-block mb-2" href="#" @click.prevent="saveAddress">
          <i class="fas fa-check"></i>
          <span class="ml-1">Guardar</span>
        </a>
      </div>
    </div>
    <div class="card-body px-0">
      <div class="bg-danger"><small>{{errorAddress}}</small></div>
      <div class="row mt-2 mb-3">
        <div class="col-xs-12 col-md-8 mb-3">
          <input type="text" class="form-control" :class="{'is-invalid': errorAddress}" placeholder="Agrega una nueva direccion"
          v-model="newAddress.title" @keyup.enter="saveAddress">
        </div>
        <div class="col-xs-12 col-md-4 mb-3">
          <input type="text" class="form-control" placeholder="Alias: Oficina" v-model="newAddress.alias">
        </div>
      </div>
      <ul class="list-group mb-1" v-for="(item, index) in address">
        <li class="list-group-item">
          <div class="d-flex w-100 justify-content-between">
            <div>
              <i class="fas fa-map-marker-alt mr-3"></i>
              <strong>{{item.alias}}</strong> <span>{{item.title}}</span>
            </div>
            <a href="#" @click.prevent="deleteAddress(index)"><i class="far fa-trash-alt"></i></a>
          </div>
        </li>
      </ul>
    </div>
  </div>

</template>

<script>
export default {
  data () {
    return {
      address: [],
      newAddress: {},
      errorAddress: ''
    }
  },
  mounted () {
    if (localStorage.getItem("address")) {
      this.address = JSON.parse(localStorage.getItem("address"))
    } else {
      localStorage.setItem("address", this.address);
    }
  },
  methods: {
    saveAddress () {
      this.errorAddress = ''
      if (this.newAddress.title) {
        this.address.unshift(this.newAddress)
        localStorage.setItem("address", JSON.stringify(this.address))
        this.$toasted.global.error('¡Direccion agregada!')
        this.newAddress = {}
      } else {
        this.errorAddress = 'Escribe una direccion'
      }
    },
    deleteAddress (index) {
      this.address.splice(index, 1)
      localStorage.setItem("address", JSON.stringify(this.address))
      this.$toasted.global.error('¡Direccion borrada!')

    }
  }
}
</script>
