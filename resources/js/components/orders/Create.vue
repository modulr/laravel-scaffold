<template>
  <div>
    <div class="form-group">
      <textarea class="form-control" rows="3" :placeholder="placeholder" v-model="order.order"></textarea>
      <small class="form-text text-white" v-if="errors.order">Dinos que te llevamos</small>
    </div>
    <div class="form-group">
      <div class="input-group border-right-0">
        <div class="input-group-prepend" @click="getPosition">
          <span class="input-group-text">
            <i class="fas fa-spinner fa-spin" v-if="loading"></i>
            <i class="fas fa-map-marker-alt" v-else></i>
          </span>
        </div>
        <input type="text" class="form-control" placeholder="Dirección (calle, numero y colonia)" v-model="order.address">
      </div>
      <small class="form-text text-white" v-if="errors.address">¿A donde te lo llevamos?</small>
    </div>
    <div class="mb-4">
      <a class="btn btn-light btn-lg px-5" href="" @click.prevent="create">Pedir</a>
      <!-- <a class="btn btn-brand btn-facebook" href="/auth/facebook">
        Pídelo por Facebook
      </a> -->
    </div>
    <rates-day></rates-day>
    <p class="mb-1"><small>{{config.schedule}}</small></p>
    <a class="text-white" href="#modalCity" data-toggle="modal" data-target="#modalCity">{{config.city}}</a>
    <!-- Modal -->
    <div class="modal" id="modalCity" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Selecciona tu ciudad</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body text-left">
            <div class="list-group list-group-flush">
              <a href="https://traeme.app" class="list-group-item list-group-item-action">Hidalgo del Parral</a>
              <a href="https://delicias.traeme.app" class="list-group-item list-group-item-action">Delicias</a>
              <!-- <a class="list-group-item list-group-item-action disabled" tabindex="-1" aria-disabled="true">Chihuahua <small class="text-muted"> - Próximamente</small></a>
              <a class="list-group-item list-group-item-action disabled" tabindex="-1" aria-disabled="true">Juárez <small class="text-muted"> - Próximamente</small></a> -->
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- <p class="mb-1">ó</p>
    <a class="btn btn-light" href="#" @click.prevent="send">
      por WhatsApp
    </a> -->
    <!-- <a class="btn btn-lg btn-light" href="https://m.me/traeme">
        <i class="fab fa-lg fa-facebook-messenger"></i> Messenger
    </a> -->
  </div>
</template>

<script>
export default {
  data () {
    return {
      config: {},
      order: {},
      //address: '',
      placeholder: '',
      placeholders: [
        '¿Necesitas algo de la tienda?',
        'Tráeme unos tacos',
        'Pagame la luz de la dirección...',
        '¿Necesitas enviar un paquete?'
      ],
      loading: false,
      errors: {}
    }
  },
  mounted () {
    this.randomPlaceholder()
    this.getConfig()
    if (localStorage.getItem("order")) {
      this.order = JSON.parse(localStorage.getItem("order"))
    }
    this.getPosition()
  },
  methods: {
    getConfig () {
      axios.get(`/api/configs/first`)
      .then(response => {
        this.config = response.data
        if (this.order.city != this.config.city) {
          $('#modalCity').modal('show')
        }
      })
      .catch(error => {
        this.errors = error.response.data.errors
      })
    },
    create () {
      localStorage.setItem("order", JSON.stringify(this.order))
      location.href = `/login`
    },
    // send () {
    //   this.errors = {}
    //   if (!this.order) {
    //     this.errors.order = true
    //   }
    //   if (!this.address) {
    //     this.errors.address = true
    //   }
    //   if (Object.entries(this.errors).length === 0 && this.errors.constructor === Object) {
    //     location.href = `https://api.whatsapp.com/send?phone=526271101145&text=Pedido:%20${this.order},%20%20Destino:%20%20${this.address}`
    //     localStorage.setItem("address", JSON.stringify(this.address))
    //   }
    //   // if (!this.submiting) {
    //   //   this.submiting = true
    //   //   axios.get(`https://api.whatsapp.com/send?phone=526271101145&text=${this.order.order}&source=&data=${this.order.address}`)
    //   //   .then(response => {
    //   //     this.$toasted.global.error('¡Orden enviada!')
    //   //   })
    //   //   .catch(error => {
    //   //     this.errors = error.response.data.errors
    //   //     this.submiting = false
    //   //   })
    //   // }
    // },
    getPosition() {
      if (navigator.geolocation) {
        this.loading = true
        navigator.geolocation.getCurrentPosition(this.setPosition, this.showError);
      } else {
        this.loading = false
        console.log("Geolocation is not supported by this browser.")
      }
    },
    setPosition(position) {
      //console.log(position);
      axios.get(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${position.coords.latitude}&lon=${position.coords.longitude}`)
      .then(response => {
        //console.log(response.data);
        this.order.address = response.data.name
        this.order.city = response.data.address.city
        localStorage.setItem("order", JSON.stringify(this.order))
        this.loading = false
      })
    },
    showError(error) {
      switch(error.code) {
        case error.PERMISSION_DENIED:
          console.log("User denied the request for Geolocation.")
          this.loading = false
          $('#modalCity').modal('show')
          break;
        case error.POSITION_UNAVAILABLE:
          console.log("Location information is unavailable.")
          this.loading = false
          $('#modalCity').modal('show')
          break;
        case error.TIMEOUT:
          console.log("The request to get user location timed out.")
          this.loading = false
          $('#modalCity').modal('show')
          break;
        case error.UNKNOWN_ERROR:
          console.log("An unknown error occurred.")
          this.loading = false
          $('#modalCity').modal('show')
          break;
      }
    },
    randomPlaceholder () {
      this.placeholder = this.placeholders[Math.floor(Math.random() * this.placeholders.length)]
    }
  }
}
</script>
