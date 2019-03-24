<template>
  <div>
    <div class="form-group">
      <textarea class="form-control" rows="3" placeholder="¡Traeme unos tacos!" v-model="order.order"></textarea>
    </div>
    <div class="input-group mb-3 border-right-0">
      <div class="input-group-prepend">
        <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
      </div>
      <input type="text" class="form-control" placeholder="Calle #numero, colonia" v-model="order.destination">
    </div>
    <a class="btn btn-lg btn-light" href="#" @click.prevent="send">
      <i class="fab fa-whatsapp"></i> Ordenar
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
      errors: {},
      submiting: false
    }
  },
  mounted () {
    if (localStorage.getItem("destination")) {
      this.order.destination = localStorage.getItem("destination")
    }
  },
  methods: {
    send () {
      if (this.order.order && this.order.destination) {
        location.href = `https://api.whatsapp.com/send?phone=528118977886&text=Orden:%20${this.order.order},%20%20Destino:%20%20${this.order.destination}`
        localStorage.setItem("destination", this.order.destination)
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
    }
  }
}
</script>
