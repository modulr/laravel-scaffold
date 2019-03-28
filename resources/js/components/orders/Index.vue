<template lang="html">
  <div>
    <content-placeholders class="mt-5" v-if="loading">
      <content-placeholders-text :lines="6"/>
    </content-placeholders>
    <div v-else>
      <div class="card-header px-0 mt-2 bg-transparent clearfix">
        <h4 class="float-left pt-2">Mandados</h4>
        <div class="card-header-actions mr-1">
          <a class="btn btn-success btn-block mb-2" href="/">
            <span class="ml-1">Ordenar</span>
          </a>
        </div>
      </div>
      <div class="card-body px-0">
        <ul class="list-group mb-1" v-for="(item, index) in orders">
          <li class="list-group-item">
            <span class="badge badge-pill float-right" :class="{ 'badge-warning': item.status_id == 1, 'badge-primary': item.status_id == 2, 'badge-success': item.status_id == 3, 'badge-danger': item.status_id == 4 }">{{item.status.status}}</span>
            <div class="mb-1">
              {{item.order}}
            </div>
            <small class="text-muted mr-3">
              <i class="icon-location-pin"></i>&nbsp; {{item.address}}
            </small>
            <small class="text-muted">
              <i class="icon-calendar"></i>&nbsp; {{item.created_at | moment('LLL')}}
            </small>
            <div v-if="item.status_id == 2">
              <div v-if="user.hasRole['admin'] || user.hasRole['user']">
                <div class="media mt-3" v-if="item.status_id == 2">
                  <div class="avatar avatar-xs float-left mr-2">
                    <img class="img-avatar" :src="item.dealer.avatar_url">
                  </div>
                  <div class="media-body">
                    <div>
                      {{item.dealer.name}}
                      <small class="text-muted"> - repartidor</small>
                    </div>
                  </div>
                </div>
              </div>
              <div v-if="user.hasRole['dealer']">
                <div class="media mt-3">
                  <div class="avatar avatar-xs float-left mr-2">
                    <img class="img-avatar" :src="item.creator.avatar_url">
                  </div>
                  <div class="media-body">
                    <div>
                      {{item.creator.name}}
                      <small class="text-muted"> - cliente</small>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data () {
    return {
      user: Laravel.user,
      orders: [],
      loading: true
    }
  },
  mounted () {
    this.getOrders()
    console.log(this.user);
  },
  methods: {
    getOrders () {
      this.loading = true
      axios.get(`/api/orders/byUser/${this.user.id}`)
      .then(response => {
        this.orders = response.data
        this.loading = false
      })
    }
  }
}
</script>
