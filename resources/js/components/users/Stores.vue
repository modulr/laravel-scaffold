<template>
  <div class="row justify-content-center mt-5">
    <div class="col-12 text-center mb-3 pb-3 px-5">
      <a href="#" data-toggle="collapse" data-target="#collapseStores" aria-expanded="true" @click="getStores">
        <img src="/img/stores/tiendas_todas.svg" class="img-fluid w-25" alt="Traeme Tienda">
      </a>
    </div>
    <div class="col-12 collapse" id="collapseStores">
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
        <div class="col-12 col-md-4 px-5 py-3" v-for="store in stores">
          <div class="media border rounded p-4">
            <div class="avatar float-left mr-2">
              <img class="img-avatar" :src="store.avatar_url">
            </div>
            <div class="media-body">
              <div class="text-body">{{store.name}}</div>
              <div class="small text-muted"><a :href="`tel:${store.cellphone}`">{{store.cellphone}}</a></div>
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
  methods: {
    getStores () {
      if (this.stores.length == 0) {
        this.loading = true
        axios.get(`/api/users/getStores`)
        .then(response => {
          this.stores = response.data
          this.loading = false
        })
      }
    }
  }
}
</script>
