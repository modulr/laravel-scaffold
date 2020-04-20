<template>
    <div class="row justify-content-center">
      <div class="col-10 pb-3 text-center mt-5 mb-4">
        <h2 class="font-weight-bold">Destacados</h2>
      </div>
      <div class="col-10 col-lg-8">
        <div class="row justify-content-center">
          <div class="col-12 col-md-4 px-2" v-for="store in stores">
            <div class="card shadow-sm">
              <div class="row no-gutters">
                <div class="col-4">
                  <a href="" @click.prevent="create(store)">
                    <img :src="store.avatar_url" class="card-img" :alt="store.name">
                  </a>
                </div>
                <div class="col-8">
                  <div class="card-body">
                    <h5 class="card-title text-dark mb-0"><strong>{{store.name}}</strong></h5>
                    <p class="card-text text-muted mb-2">{{store.description}}</p>
                    <!-- <a class="btn btn-secondary btn-sm float-right" href="" @click.prevent="create(store)">
                      Pedir
                    </a> -->
                  </div>
                </div>
              </div>
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
      stores: [],
      order: {}
    }
  },
  mounted () {
    this.getStores()
  },
  methods: {
    getStores () {
      if (this.stores.length == 0) {
        axios.get(`/api/stores/getStoresLevel1`)
        .then(response => {
          this.stores = response.data
        })
      }
    },
    create (store) {
      this.order.order = `Traeme de ${store.name}`
      localStorage.setItem("order", JSON.stringify(this.order))
      location.href = `/`
    }
  }
}
</script>
