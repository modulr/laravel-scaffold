<template>
  <div>
    <div class="form-group">
      <textarea class="form-control" rows="3" :placeholder="placeholder" v-model="order"></textarea>
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
        <input type="text" class="form-control" placeholder="¿A donde? Calle, numero y colonia" v-model="address">
      </div>
      <small class="form-text text-white" v-if="errors.address">¿A donde te lo llevamos?</small>
    </div>
    <div class="mb-1">
      <a class="btn btn-light btn-lg px-5" href="/login">Pedir</a>
      <!-- <a class="btn btn-brand btn-facebook" href="/auth/facebook">
        Pídelo por Facebook
      </a> -->
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
      order: '',
      address: '',
      placeholder: '',
      placeholders: [
        '¿Necesitas algo de la tienda?',
        'Traeme unos tacos',
        'Pagame la luz',
        'Me puedes pagar el Agua de la Dirección...',
        '¿Necesitas enviar un paquete?'
      ],
      loading: false,
      errors: {}
    }
  },
  mounted () {
    this.randomPlaceholder()
    if (localStorage.getItem("address")) {
      this.address = JSON.parse(localStorage.getItem("address"))
    }
    this.getPosition()
  },
  methods: {
    send () {
      this.errors = {}
      if (!this.order) {
        this.errors.order = true
      }
      if (!this.address) {
        this.errors.address = true
      }
      if (Object.entries(this.errors).length === 0 && this.errors.constructor === Object) {
        location.href = `https://api.whatsapp.com/send?phone=526271101145&text=Pedido:%20${this.order},%20%20Destino:%20%20${this.address}`
        localStorage.setItem("address", JSON.stringify(this.address))
      }
      // if (!this.submiting) {
      //   this.submiting = true
      //   axios.get(`https://api.whatsapp.com/send?phone=526271101145&text=${this.order.order}&source=&data=${this.order.address}`)
      //   .then(response => {
      //     this.$toasted.global.error('¡Orden enviada!')
      //   })
      //   .catch(error => {
      //     this.errors = error.response.data.errors
      //     this.submiting = false
      //   })
      // }
    },
    getPosition() {
      if (navigator.geolocation) {
        this.loading = true
        navigator.geolocation.getCurrentPosition(this.setPosition);
      } else {
        x.innerHTML = "Geolocation is not supported by this browser.";
      }
    },
    setPosition(position) {
      //console.log(position);
      axios.get(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${position.coords.latitude}&lon=${position.coords.longitude}`)
      .then(response => {
        //console.log(response.data);
        this.address = response.data.display_name
        localStorage.setItem("address", JSON.stringify(this.address))
        this.loading = false
      })
    },
    randomPlaceholder () {
      this.placeholder = this.placeholders[Math.floor(Math.random() * this.placeholders.length)]
    }
  }
}
</script>
