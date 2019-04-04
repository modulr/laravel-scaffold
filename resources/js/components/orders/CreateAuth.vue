<template>
  <div>
    <div class="form-group">
      <textarea class="form-control" rows="3" :class="{'is-invalid': errors.order}" :placeholder="placeholder"
      v-model="newOrder.order"></textarea>
      <small class="form-text text-white" v-if="errors.order">Dinos que te llevamos</small>
    </div>
    <div class="form-group">
      <multiselect
        v-model="newOrder.address"
        :options="address"
        openDirection="bottom"
        label="address"
        track-by="id"
        :custom-label="customLabel"
        selectLabel="Seleccionar"
        selectedLabel="Seleccionado"
        deselectLabel="deseleccionar"
        placeholder="Selecciona o agrega una dirección"
        tag-placeholder="Agregar esta dirección"
        :taggable="true"
        @tag="addTag"
        :class="{'border border-danger rounded': errors.address}">
        <template slot="singleLabel" slot-scope="props">
          <span>
            <strong class="mr-2">{{ props.option.alias }}</strong>
            <span>{{ props.option.address }}</span>
          </span>
        </template>
        <template slot="option" slot-scope="props">
          <div v-if="props.option.isTag">
            {{ props.search }}
          </div>
          <div v-else>
            <strong class="mr-2">{{ props.option.alias }}</strong>
            <span>{{ props.option.address }}</span>
          </div>
        </template>
      </multiselect>
      <small class="form-text text-white" v-if="errors.address">¿A donde te lo llevamos?</small>
      <!-- <div class="input-group border-right-0">
        <div class="input-group-prepend">
          <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
        </div>
        <input type="text" class="form-control" placeholder="¿A donde? Calle, numero y colonia" v-model="order.address">
      </div> -->
    </div>
    <div class="form-group" v-if="!user.cellphone">
      <input type="tel" class="form-control" :class="{'is-invalid': errors.cellphone}" v-model="newOrder.cellphone" placeholder="Escribe tu numero de celular">
      <small class="form-text text-white" v-if="errors.cellphone">¿Cual es tu numero celular?</small>
    </div>
    <!-- <a class="btn btn-light btn-lg" href="#" @click.prevent="createOrder">Pedir</a> -->
    <a class="btn btn-light btn-lg" href="#" :disabled="submiting" @click.prevent="createOrder">
      <i class="fas fa-spinner fa-spin mr-2" v-if="submiting"></i>Pedir
    </a>
  </div>
</template>

<script>
export default {
  data () {
    return {
      user: Laravel.user,
      address: [],
      newOrder: {},
      placeholder: '',
      placeholders: [
        '¿Necesitas algo de la tienda?',
        'Traeme unos tacos',
        'Pagame la luz',
        'Me puedes pagar el Agua de la Dirección...',
        '¿Necesitas enviar un paquete?'
      ],
      loading: true,
      submiting: false,
      errors: ''
    }
  },
  mounted () {
    this.getAddress()
    this.randomPlaceholder()
    if (localStorage.getItem("currentAddress")) {
      //this.newOrder.address = JSON.parse(localStorage.getItem("currentAddress"))
      this.$set(this.newOrder, 'address', JSON.parse(localStorage.getItem("currentAddress")))

    }
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
    createOrder () {
      if (!this.submiting) {
        this.submiting = true
        axios.post(`/api/orders/storeAuth`, this.newOrder)
        .then(response => {
          localStorage.setItem("currentAddress", JSON.stringify(this.newOrder.address))
          this.$toasted.global.error('¡Mandado enviado!')
          location.href = `/orders`
        })
        .catch(error => {
          this.errors = error.response.data.errors
          this.submiting = false
        })
      }
    },
    addTag (newTag) {
      const tag = {
        address: newTag
      }
      axios.post(`/api/address/store`, tag)
      .then(response => {
        this.newOrder.address = tag
        this.address.unshift(response.data)
        this.$toasted.global.error('¡Direccion agregada!')
      })
      .catch(error => {
        this.errors = error.response.data.errors
      })
    },
    customLabel ({ address, alias }) {
      return `${alias} ${address}`
    },
    randomPlaceholder () {
      this.placeholder = this.placeholders[Math.floor(Math.random() * this.placeholders.length)]
    }
  }
}
</script>
