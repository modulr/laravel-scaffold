<template>
  <div>
    <div class="form-group">
      <textarea class="form-control" rows="3" :placeholder="placeholder" v-model="order.order"></textarea>
      <small class="form-text text-white" v-if="errors.order">Dinos que te llevamos</small>
    </div>
    <div class="form-group">
      <div class="input-group border-right-0">
        <div class="input-group-prepend">
          <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
        </div>
        <input type="text" class="form-control" placeholder="¿A donde? Calle, numero y colonia" v-model="order.address.title">
      </div>
      <small class="form-text text-white" v-if="errors.address">¿A donde te lo llevamos?</small>
    </div>
    <a class="btn btn-light btn-lg" href="#" @click.prevent="send">
      <i class="fab fa-whatsapp mr-1"></i> Pedir por WhatsApp
    </a>
  </div>
</template>

<script>
export default {
  data () {
    return {
      address: [],
      order: {
        order: '',
        address: {
          title: '',
          alias: ''
        }
      },
      errors: {},
      placeholders: [
        '¿Necesitas algo de la tienda?',
        'Traeme unos tacos',
        'Pagame la luz',
        'Me puedes pagar el Agua de la Dirección...',
        '¿Necesitas enviar un paquete?'
      ],
      placeholder: ''
    }
  },
  mounted () {
    if (localStorage.getItem("address")) {
      this.address = JSON.parse(localStorage.getItem("address"))
    }
    if (localStorage.getItem("currentAddress")) {
      this.order.address = JSON.parse(localStorage.getItem("currentAddress"))
    }
    this.randomPlaceholder()
  },
  methods: {
    send () {
      this.errors = {}
      if (!this.order.order) {
        this.errors.order = true
      } else if (!this.order.address.title) {
        this.errors.address = true
      } else {
        location.href = `https://api.whatsapp.com/send?phone=528130898642&text=Pedido:%20${this.order.order},%20%20Dirección:%20%20${this.order.address.title}`
        this.address.unshift(this.order.address)
        localStorage.setItem("address", JSON.stringify(this.address))
        localStorage.setItem("currentAddress", JSON.stringify(this.order.address))
      }
      // if (!this.submiting) {
      //   this.submiting = true
      //   axios.get(`https://api.whatsapp.com/send?phone=528130898642&text=${this.order.order}&source=&data=${this.order.address}`)
      //   .then(response => {
      //     this.$toasted.global.error('¡Orden enviada!')
      //   })
      //   .catch(error => {
      //     this.errors = error.response.data.errors
      //     this.submiting = false
      //   })
      // }
    },
    randomPlaceholder () {
      this.placeholder = this.placeholders[Math.floor(Math.random() * this.placeholders.length)]
    }
  }
}
</script>
