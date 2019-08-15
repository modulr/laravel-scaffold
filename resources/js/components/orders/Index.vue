<template lang="html">
  <div>
    <div>
      <div class="card-header px-0 mt-2 bg-transparent clearfix">
        <h4 class="float-left pt-2">Mis mandados</h4>
        <div class="card-header-actions mr-1">
          <a class="btn btn-primary btn-block mb-2" href="/">
            <i class="fa fa-plus mr-2"></i>Pedir
          </a>
        </div>
      </div>
      <div class="card-body px-0">
        <content-placeholders v-if="loading">
          <content-placeholders-text :lines="6"/>
        </content-placeholders>
        <div v-else>
          <ul class="list-group mb-1" v-for="(item, index) in orders">
            <li class="list-group-item">
              <div class="row">
                <div class="col-12">
                  <p class="pre-line mb-1">{{item.order}}</p>
                  <span class="text-muted">
                    <i class="icon-location-pin mr-1"></i>{{item.address}}
                  </span>
                </div>
                <div class="col-12">
                  <hr>
                </div>
                <div class="col-12">
                  <vue-step class="mb-0 pt-0" :now-step="item.status_id" :step-list="listStatus" style-type="style2" v-if="item.status_id!= 4"></vue-step>
                  <vue-step class="mb-0 pt-0" :now-step="0" :step-list="listStatus" style-type="style2" v-else></vue-step>
                  <small class="text-muted">
                    <i class="far fa-clock mr-1"></i>{{item.created_at | moment('LT')}} - {{item.updated_at | moment('LT')}}
                    <strong class="float-right">{{ item.created_at | moment("from", item.updated_at, true) }}</strong>
                  </small>
                </div>
                <div class="col-12">
                  <hr>
                </div>
                <div class="col-8">
                  <div v-if="item.status_id == 1">
                    <div class="media">
                      <div class="avatar float-left mr-2 text-muted">
                        <span class="fa-stack" style="font-size: 1.3em;">
                          <i class="fas fa-circle fa-stack-2x"></i>
                          <i class="fas fa-user fa-stack-1x fa-inverse"></i>
                        </span>
                      </div>
                      <div class="media-body">
                        <div class="text-body text-muted">
                          Buscando repartidor...
                        </div>
                        <div class="small text-muted">
                          30 minutos aproximadamente
                        </div>
                      </div>
                    </div>
                  </div>
                  <div v-else>
                    <users-view :user="item.dealer" role="Repartidor" @viewUser="userView = $event" v-if="item.dealer_id"></users-view>
                    <rate :length="5" v-model="item.score_client" @after-rate="scoreOrder(item, index)" v-if="item.status_id == 3"/>
                  </div>
                </div>
                <div class="col-4 text-right">
                  <div>
                    <small class="text-muted">
                      Envio: <strong>${{item.delivery_costs}}</strong>
                    </small>
                  </div>
                  <div>
                    <small class="text-muted">
                      Costo: <strong>${{item.order_cost}}</strong>
                    </small>
                  </div>
                  <div>
                    <span class="text-muted border-top">
                      Total: <strong>${{item.delivery_costs + item.order_cost}}</strong>
                    </span>
                  </div>
                </div>
              </div>
              <div class="row" v-if="item.status_id == 1">
                <div class="col-12">
                  <hr>
                </div>
                <div class="col-12 text-right">
                  <a href="#" class="btn btn-outline-secondary btn-sm" @click.prevent="cancelOrder(item, index)">
                    Cancelar
                  </a>
                </div>
              </div>
              <div class="row" v-if="item.status_id == 4">
                <div class="col-12">
                  <hr>
                </div>
                <div class="col">
                  <div class="alert alert-secondary text-center mb-0">
                    Cancelado
                  </div>
                </div>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <div class="no-items-found text-center mt-5" v-if="!loading && !orders.length > 0">
      <i class="fas fa-motorcycle fa-3x text-muted"></i>
      <p class="mb-0 mt-3"><strong>No tienes ningun mandado</strong></p>
      <p class="text-muted">Haz tu primer mandado dando clic en el boton de abajo</p>
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
      listStatus:[],
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
        this.listStatus = response.data.map(function(i, index) {
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
