<template>
  <div>
    <div class="form-group">
      <textarea class="form-control" rows="3" :class="{'is-invalid': errors.order}" :placeholder="placeholder"
      v-model="newOrder.order"></textarea>
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
        <input type="text" class="form-control" placeholder="¿A donde? Calle, numero y colonia" v-model="newOrder.address">
      </div>
      <small class="form-text text-white" v-if="errors.address">¿A donde te lo llevamos?</small>
    </div>
    <div class="form-group" v-if="!user.cellphone">
      <input type="tel" class="form-control" :class="{'is-invalid': errors.cellphone}" v-model="newOrder.cellphone" placeholder="Escribe tu numero de celular">
      <small class="form-text text-white" v-if="errors.cellphone">{{errors.cellphone[1]}}</small>
    </div>
    <a class="btn btn-light btn-lg px-5" href="#" :disabled="submiting" @click.prevent="createOrder">
      <i class="fas fa-spinner fa-spin mr-2" v-if="submiting"></i>Pedir
    </a>
  </div>
</template>

<script>
export default {
  data () {
    return {
      user: Laravel.user,
      newOrder: {},
      address: [],
      placeholder: '',
      placeholders: [
        '¿Necesitas algo de la tienda?',
        'Traeme unos tacos',
        'Pagame la luz',
        'Me puedes pagar el Agua de la Dirección...',
        '¿Necesitas enviar un paquete?'
      ],
      loading: false,
      loadingAddress: false,
      submiting: false,
      errors: ''
    }
  },
  mounted () {
    this.randomPlaceholder()
    if (localStorage.getItem("order")) {
      this.newOrder = JSON.parse(localStorage.getItem("order"))
      //this.$set(this.newOrder, 'address', JSON.parse(localStorage.getItem("address")))
    }
  },
  methods: {
    getAddress () {
      this.loadingAddress = true
      axios.get(`/api/address/byClient`)
      .then(response => {
        this.address = response.data
        this.loadingAddress = false
      })
    },
    createOrder () {
      if (!this.submiting) {
        this.submiting = true
        this.errors = {}
        axios.post(`/api/orders/storeAuth`, this.newOrder)
        .then(response => {
          //this.$toasted.global.error('¡Mandado creado!')
          this.newOrder.order = ''
          localStorage.setItem("order", JSON.stringify(this.newOrder))
          this.submiting = false
          const wrapper = document.createElement('div');
          wrapper.innerHTML = `<div data-v-3500aeb9 class="mb-3 v-step-warp-horizontal style2"><div data-v-3500aeb9 class="v-step-progress-bg"><div data-v-3500aeb9 class="v-step-progress-value" style="background-color: rgb(31, 177, 29); width: 33.3333%;"></div></div> <ul data-v-3500aeb9 class="v-step-list"><li data-v-3500aeb9 class="v-step-item" style="width: 33.3333%;"><label data-v-3500aeb9 class="v-step-item-label"> Abierto </label> <div data-v-3500aeb9 class="v-step-item-number" style="background-color: rgb(31, 177, 29); color: rgb(255, 255, 255);">  </div></li><li data-v-3500aeb9 class="v-step-item" style="width: 33.3333%;"><label data-v-3500aeb9 class="v-step-item-label"> En camino </label> <div data-v-3500aeb9 class="v-step-item-number">  </div></li><li data-v-3500aeb9 class="v-step-item" style="width: 33.3333%;"><label data-v-3500aeb9 class="v-step-item-label"> Entregado </label> <div data-v-3500aeb9 class="v-step-item-number">  </div></li></ul></div>`;
          swal({
            title: "¡Mandado creado!",
            text: "¡Un repartidor pronto llevara tu mandado!",
            icon: "success",
            button: "Ver mandado",
            content: wrapper
          })
          .then((value) => {
            if (value) {
              location.href = `/orders`
            }
          })
        })
        .catch(error => {
          this.errors = error.response.data.errors
          if (this.errors.cellphone) {
            if (this.errors.cellphone[0] == 'The cellphone field is required.') {
              this.errors.cellphone[1] = '¿Cual es tu numero celular?'
            } else {
              this.errors.cellphone[1] = 'El numero de celular ya esta registrado'
            }
          }
          this.submiting = false
        })
      }
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
        this.newOrder.address = response.data.display_name
        localStorage.setItem("order", JSON.stringify(this.newOrder))
        this.loading = false
      })
    },
    randomPlaceholder () {
      this.placeholder = this.placeholders[Math.floor(Math.random() * this.placeholders.length)]
    }
  }
}
</script>
