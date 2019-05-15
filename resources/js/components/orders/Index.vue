<template lang="html">
  <div>
    <content-placeholders class="mt-5" v-if="loading">
      <content-placeholders-text :lines="6"/>
    </content-placeholders>
    <div v-else>
      <div class="card-header px-0 mt-2 bg-transparent clearfix">
        <h4 class="float-left pt-2">Mis mandados</h4>
        <div class="card-header-actions mr-1">
          <a class="btn btn-primary btn-block mb-2" href="/">
            <i class="fa fa-plus mr-2"></i>Pedir
          </a>
        </div>
      </div>
      <div class="card-body px-0">
        <ul class="list-group mb-1" v-for="(item, index) in orders">
          <li class="list-group-item">
            <div class="row">
              <div class="col">
                <small class="text-muted">Mandado: {{item.id}}</small>
              </div>
              <div class="col text-center">
                <small class="text-muted">Envio: <strong>${{item.delivery_costs}}</strong></small>
              </div>
              <div class="col text-right">
                <span class="badge badge-pill" :class="{ 'badge-primary': item.status_id == 1, 'badge-success': item.status_id == 2, 'badge-info': item.status_id == 3, 'badge-secondary': item.status_id == 4 }">
                  {{item.status.status}}
                </span>
              </div>
              <div class="col-12">
                <hr class="mt-1 mb-2">
              </div>
              <div class="col-12">
                <p class="mb-1">{{item.order}}</p>
                <small class="text-muted mr-3">
                  <i class="icon-location-pin"></i>&nbsp; {{item.address}}
                </small>
                <small class="text-muted">
                  <i class="icon-clock"></i>&nbsp; {{item.created_at | moment('LT')}}
                </small>
              </div>
              <div class="col-12">
                <hr>
              </div>
              <div class="col-12" v-if="item.status_id != 4">
                <vue-step class="mb-3" :now-step="item.status_id" :step-list="status" style-type="style2"></vue-step>
              </div>
              <div class="col-6">
                <users-view :user="item.dealer" role="Repartidor" @viewUser="userView = $event" v-if="item.dealer_id"></users-view>
              </div>
              <div class="col-6 text-right">
                <rate :length="5" v-model="item.score_client" @after-rate="scoreOrder(item, index)" v-if="item.status_id == 3"/>
                <a href="#" class="btn btn-outline-secondary btn-sm" @click.prevent="cancelOrder(item, index)" v-if="item.status_id == 1">
                  Cancelar
                </a>
              </div>
            </div>
          </li>
        </ul>
      </div>
    </div>
    <div class="no-items-found text-center mt-5" v-if="!loading && !orders.length > 0">
      <i class="icon-magnifier fa-3x text-muted"></i>
      <p class="mb-0 mt-3"><strong>No tienes ningun mandado</strong></p>
      <p class="text-muted">Haz tu primer pedido dando clic en el boton de abajo</p>
      <a class="btn btn-primary" href="/">
        <i class="fa fa-plus mr-1"></i>Pedir
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
      axios.get(`/api/orders/byClient/${this.user.id}`)
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
    cancelOrder (order, index) {
      swal({
        title: "¿Estas seguro?",
        text: "¿En verdad quieres cancelar el mandado?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          axios.put(`/api/orders/updateStatus/${order.id}`, {'statusId': 4})
          .then(response => {
            this.orders[index].status_id = response.data.status_id
            this.orders[index].status = response.data.status
            this.$toasted.global.error('¡Mandado cancelado!')
          })
        }
      })
    },
    scoreOrder (order, index) {
      axios.put(`/api/orders/updateScoreClient/${order.id}`, {'scoreClient': order.score_client})
      .then(response => {
        this.orders[index].score_client = response.data.score_client
        this.$toasted.global.error('¡Mandado calificado!')
      })
    }
  }
}
</script>
