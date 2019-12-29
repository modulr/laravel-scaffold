<template>
    <div class="row justify-content-center">
      <div class="col-10">
        <div class="row justify-content-center">
          <div class="col-12 col-md-4 px-2 pt-2" v-for="store in stores">
            <div class="card">
              <div class="row no-gutters">
                <div class="col-4">
                  <img :src="store.avatar_url" class="card-img" :alt="store.name">
                </div>
                <div class="col-8">
                  <div class="card-body">
                    <h5 class="card-title"><strong>{{store.name}}</strong></h5>
                    <p class="card-text">{{store.description}}</p>
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
      stores: []
    }
  },
  mounted () {
    this.getStores()
  },
  methods: {
    getStores () {
      if (this.stores.length == 0) {
        axios.get(`/api/stores/getStoresRandom`)
        .then(response => {
          this.stores = response.data
        })
      }
    }
  }
}
</script>
