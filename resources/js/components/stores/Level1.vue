<template>
  <div class="mb-5">
    <div class="row justify-content-center" v-if="loading">
      <div class="col-12 col-md-4 px-5 py-3">
        <content-placeholders>
          <content-placeholders-heading :img="true"/>
        </content-placeholders>
      </div>
      <div class="col-12 col-md-4 px-5 py-3">
        <content-placeholders>
          <content-placeholders-heading :img="true"/>
        </content-placeholders>
      </div>
      <div class="col-12 col-md-4 px-5 py-3">
        <content-placeholders>
          <content-placeholders-heading :img="true"/>
        </content-placeholders>
      </div>
    </div>
    <div class="row justify-content-center" v-else>
      <div class="col-12 col-md-4 px-5 pt-3" v-for="store in stores">
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
</template>

<script>
export default {
  data () {
    return {
      stores: [],
      loading: false
    }
  },
  mounted () {
    this.getStores()
  },
  methods: {
    getStores () {
      if (this.stores.length == 0) {
        this.loading = true
        axios.get(`/api/stores/getStoresLevel1`)
        .then(response => {
          this.stores = response.data
          this.loading = false
        })
      }
    }
  }
}
</script>
