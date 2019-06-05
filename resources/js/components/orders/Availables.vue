<template lang="html">
  <div>
    <content-placeholders class="mt-5" v-if="loading">
      <content-placeholders-text :lines="6"/>
    </content-placeholders>
    <div v-else>
      <div class="card-header px-0 mt-2 bg-transparent clearfix">
        <h4 class="float-left pt-2">Mandados</h4>
        <div class="card-header-actions mr-1">
          <a class="btn btn-primary" href="/orders/availables">
            <i class="fa fa-sync mr-1"></i>Refrescar
          </a>
        </div>
      </div>
      <div class="card-body px-0">
        <ul class="list-group mb-1" v-for="(item, index) in orders">
          <li class="list-group-item">
            <div class="row">
              <div class="col-8">
                <small class="text-muted">
                  <i class="far fa-clock mr-1"></i>{{item.created_at | moment('LT')}} / {{item.updated_at | moment('LT')}}
                   = <strong>{{ item.created_at | moment("from", item.updated_at, true) }}</strong>
                </small>
              </div>
              <div class="col-4 text-right">
                <!-- <span class="badge badge-pill" :class="{
                  'badge-primary': item.status_id == 1,
                  'badge-success': item.status_id == 2,
                  'badge-info': item.status_id == 3,
                  'badge-secondary': item.status_id == 4 }">
                  {{item.status.status}}
                </span> -->
                <small class="text-muted">
                  Envio: <strong>${{item.delivery_costs}}</strong>
                </small>
              </div>
              <div class="col-12">
                <hr class="mt-1 mb-2">
              </div>
              <div class="col-12">
                <p class="mb-1">{{item.order}}</p>
                <a :href="`https://www.google.com/maps/search/Calle ${item.address}, Hidalgo del Parral, Chih.`" target="_blank">
                  <span class="text-muted">
                    <i class="icon-location-pin mr-1"></i>{{item.address}}
                  </span>
                </a>
              </div>
              <div class="col-12">
                <hr>
              </div>
              <div class="col-12" v-if="item.status_id != 4">
                <vue-step class="mb-3" :now-step="item.status_id" :step-list="status" style-type="style2"></vue-step>
              </div>
              <div class="col-12 alert alert-secondary text-center" v-else>
                Cancelado
              </div>
              <div class="col-6">
                <users-view :user="item.client" role="Cliente" @viewUser="userView = $event"></users-view>
              </div>
              <div class="col-6 text-right">
                <a href="#" class="btn btn-outline-info btn-sm" @click.prevent="takeOrder(item, index)" v-if="item.status_id == 1">
                  Tomar mandado
                </a>
                <a href="#" class="btn btn-outline-info btn-sm" @click.prevent="finalizeOrder(item, index)" v-if="item.status_id == 2">
                  Finalizar
                </a>
              </div>
              <div class="col-12">
                <p class="text-primary text-center mt-5" v-if="item.status_id == 2">
                  Finaliza este mandado para poder tomar mas
                </p>
              </div>
            </div>
          </li>
        </ul>
      </div>
    </div>
    <div class="no-items-found text-center mt-5" v-if="!loading && !orders.length > 0">
      <i class="fas fa-motorcycle fa-3x text-muted"></i>
      <p class="mb-0 mt-3"><strong>No existe ningun mandado nuevo</strong></p>
      <p class="text-muted">Revisa mas tarde o da clic en el boton de abajo para refrescar la pantalla</p>
      <a class="btn btn-primary" href="/orders/availables">
        <i class="fa fa-sync mr-1"></i>Refrescar
      </a>
    </div>
    <!-- Modal -->
    <profile-view :user="userView"></profile-view>
  </div>
</template>

<script>
export default {
  data () {
    return {
      orders: [],
      status: [],
      userView: {},
      loading: true
    }
  },
  mounted () {
    this.getOrders()
    this.getStatus()
  },
  methods: {
    getOrders () {
      this.loading = true
      axios.get(`/api/orders/availables`)
      .then(response => {
        this.orders = response.data
        this.loading = false
      })
    },
    getStatus () {
      axios.get(`/api/orders/status`)
      .then(response => {
        response.data.pop()
        this.status = response.data.map(function(i, index) {
          return i.status
        })
      })
    },
    takeOrder (order, index) {
      axios.put(`/api/orders/takeOrder/${order.id}`)
      .then(response => {
        this.$toasted.global.error('¡Mandado tomado!')
        location.href = `/orders/dealer`
      })
    },
    finalizeOrder (order, index) {
      axios.put(`/api/orders/updateStatus/${order.id}`, {'statusId': 3})
      .then(response => {
        this.$toasted.global.error('¡Mandado finalizado!')
        this.getOrders()
      })
    }
  }
}
</script>
