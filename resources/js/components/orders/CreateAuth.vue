<template>
  <div>
    <div class="form-group">
      <textarea class="form-control" rows="3" :placeholder="placeholder" v-model="order.order"></textarea>
    </div>
    <div class="form-group">
      <multiselect
        v-model="order.address"
        :options="address"
        openDirection="bottom"
        label="title"
        track-by="title"
        :custom-label="customLabel"
        selectLabel="Seleccionar"
        selectedLabel="Seleccionado"
        deselectLabel="deseleccionar"
        placeholder="Selecciona o agrega una dirección"
        tag-placeholder="Agregar esta dirección"
        :taggable="true"
        @tag="addTag">
        <template slot="singleLabel" slot-scope="props">
          <span>
            <strong class="mr-2">{{ props.option.alias }}</strong>
            <span>{{ props.option.title }}</span>
          </span>
        </template>
        <template slot="option" slot-scope="props">
          <div v-if="props.option.isTag">
            {{ props.search }}
          </div>
          <div v-else>
            <strong class="mr-2">{{ props.option.alias }}</strong>
            <span>{{ props.option.title }}</span>
          </div>
        </template>
      </multiselect>
      <!-- <div class="input-group border-right-0">
        <div class="input-group-prepend">
          <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
        </div>
        <input type="text" class="form-control" placeholder="¿A donde? Calle, numero y colonia" v-model="order.destination">
      </div> -->
    </div>
    <div class="bg-danger mt-3 mb-3"><small>{{error}}</small></div>
    <a class="btn btn-light btn-lg" href="#" @click.prevent="save">
      Ordenar
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
        address: ''
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
    if (localStorage.getItem("address")) {
      this.address = JSON.parse(localStorage.getItem("address"))
    }
    if (localStorage.getItem("currentAddress")) {
      this.order.address = JSON.parse(localStorage.getItem("currentAddress"))
    }
    this.randomPlaceholder()
  },
  methods: {
    save () {
      if (!this.submiting) {
        this.submiting = true
        axios.post(`/api/orders/store`, this.order)
        .then(response => {
          localStorage.setItem("currentAddress", JSON.stringify(this.order.address))
          this.$toasted.global.error('¡Mandado enviado!')
          location.href = `/orders`
          //location.href = `/orders/${response.data.id}`
        })
        .catch(error => {
          this.errors = error.response.data.errors
          this.submiting = false
        })
      }
    },
    addTag (newTag) {
      const tag = {
        title: newTag,
        alias: ''
      }
      this.address.unshift(tag)
      localStorage.setItem("address", JSON.stringify(this.address))
      this.order.address = tag
    },
    customLabel ({ title, alias }) {
      return `${alias} ${title}`
    },
    randomPlaceholder () {
      this.placeholder = this.placeholders[Math.floor(Math.random() * this.placeholders.length)]
    }
  }
}
</script>
