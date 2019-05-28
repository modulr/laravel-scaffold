<template lang="html">
  <div>
    <content-placeholders class="mt-5" v-if="loading">
      <content-placeholders-text :lines="6"/>
    </content-placeholders>
    <div v-else>
      <div class="card-header px-0 mt-2 bg-transparent clearfix">
        <h4 class="float-left pt-2">Mis vueltas <small class="text-muted">({{orders.length}}/${{profit}})</small></h4>
      </div>
      <div class="card-body px-0">
        <ul class="list-group mb-1" v-for="(item, index) in orders">
          <li class="list-group-item">
            <div class="row">
              <div class="col">
                <small class="text-muted">
                  <i class="far fa-clock mr-1"></i>{{item.created_at | moment('LT')}} / {{item.updated_at | moment('LT')}}
                   = <strong>{{ item.created_at | moment("from", item.updated_at, true) }}</strong>
                </small>
              </div>
              <div class="col text-right">
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
                <a :href="`https://www.google.com/maps/search/Calle ${item.address}, Hidalgo delParral, Chih.`" target="_blank">
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
              <div class="col-6">
                <users-view :user="item.client" role="Cliente" @viewUser="userView = $event"></users-view>
              </div>
              <div class="col-6 text-right">
                <rate :length="5" v-model="item.score_dealer" @after-rate="scoreOrder(item, index)" v-if="item.status_id == 3"/>
                <a href="#" class="btn btn-outline-info btn-sm" @click.prevent="finalizeOrder(item, index)" v-if="item.status_id == 2">
                  Finalizar
                </a>
              </div>
            </div>
          </li>
        </ul>
      </div>
    </div>
    <div class="no-items-found text-center mt-5" v-if="!loading && !orders.length > 0">
      <i class="icon-magnifier fa-3x text-muted"></i>
      <p class="mb-0 mt-3"><strong>No tienes ningun pedido asignado</strong></p>
      <p class="text-muted">Toma un pedido en la seccion de Pedidos</p>
      <a class="btn btn-primary" href="/orders/availables">
        Ir a Pedidos
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
      user: Laravel.user,
      orders: [],
      profit: 0,
      status:[],
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
      axios.get(`/api/orders/byDealer/${this.user.id}`)
      .then(response => {
        this.orders = response.data.orders
        this.profit = response.data.profit
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
    finalizeOrder (order, index) {
      axios.put(`/api/orders/updateStatus/${order.id}`, {'statusId': 3})
      .then(response => {
        this.orders[index].status_id = response.data.status_id
        this.orders[index].status = response.data.status
        this.$toasted.global.error('¡Mandado finalizado!')
      })
    },
    scoreOrder (order, index) {
      axios.put(`/api/orders/updateScoreDealer/${order.id}`, {'scoreDealer': order.score_dealer})
      .then(response => {
        this.orders[index].score_dealer = response.data.score_dealer
        this.$toasted.global.error('¡Mandado calificado!')
      })
    }
  }
}
</script>
