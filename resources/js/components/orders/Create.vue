<template>
  <div>
    <div class="form-group">
      <textarea class="form-control" rows="3" :placeholder="placeholder" v-model="order.order"></textarea>
    </div>
    <div class="form-group">
      <div class="input-group border-right-0">
        <div class="input-group-prepend">
          <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
        </div>
        <input type="text" class="form-control" placeholder="¿A donde? Calle, numero y colonia" v-model="order.destination">
      </div>
    </div>
    <div class="bg-danger mt-3 mb-3"><small>{{error}}</small></div>
    <a class="btn btn-spotify btn-lg" href="#" @click.prevent="send">
      <i class="fab fa-whatsapp mr-1"></i> Ordenar por WhatsApp
    </a>
  </div>
</template>

<script>
export default {
  data () {
    return {
      order: {
        order: '',
        destination: ''
      },
      error: '',
      placeholders: [
        '¿Necesitas algo de la tienda?',
        'Traeme unos tacos',
        'Pagame la luz',
        '¿Necesitas enviar un paquete?'
      ],
      placeholder: ''
    }
  },
  mounted () {
    if (localStorage.getItem("destination")) {
      this.order.destination = localStorage.getItem("destination")
    }
    this.randomPlaceholder()
  },
  methods: {
    send () {
      this.error = ''
      if (this.order.order && this.order.destination) {
        location.href = `https://api.whatsapp.com/send?phone=528118977886&text=Orden:%20${this.order.order},%20%20Destino:%20%20${this.order.destination}`
        localStorage.setItem("destination", this.order.destination)
      } else {
        this.error = 'Dinos que te llevamos y a donde'
      }
      // if (!this.submiting) {
      //   this.submiting = true
      //   axios.get(`https://api.whatsapp.com/send?phone=528130898642&text=${this.order.order}&source=&data=${this.order.destination}`)
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
