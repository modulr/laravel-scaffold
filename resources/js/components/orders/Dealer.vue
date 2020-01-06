<template lang="html">
  <div>
    <div>
      <div class="card-header px-0 mt-2 bg-transparent clearfix">
        <h4 class="float-left pt-2">Mis vueltas <small class="text-muted">${{profit}}|{{orders.length}}</small></h4>
        <div class="card-header-actions mr-1">
          <a class="text-secondary" :class="{'text-success': filtersShow}" href="#" @click.prevent="showFilters">
            <i class="fas fa-filter"></i>
          </a>
          <a class="btn btn-primary ml-3" href="/orders/dealer" @click.prevent="getOrders">
            <i class="fa fa-sync mr-1" :class="{'fa-spin': loading}"></i>Refrescar
          </a>
        </div>
      </div>
      <div class="card-body px-0">
        <div class="mb-4" v-show="filtersShow">
          <div class="form-group">
            <multiselect
              v-model="filters.status"
              :options="status"
              track-by="id"
              label="status"
              :multiple="true"
              :searchable="false"
              @select="getOrders"
              @remove="getOrders"
              placeholder="Filtra por Estatus"
              :class="{'border border-danger rounded': errors.status}">
            </multiselect>
          </div>
          <div class="form-group">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">📅</span>
              </div>
              <input class="form-control" type="date" v-model="filters.date" @change="getOrders" placeholder="Filtra por Fecha">
            </div>
          </div>
        </div>
        <content-placeholders v-if="loading">
          <content-placeholders-text :lines="6"/>
        </content-placeholders>
        <div v-else>
          <ul class="list-group mb-1" v-for="(item, index) in orders">
            <li class="list-group-item">
              <div class="row">
                <div class="col-12">
                  <p class="pre-line mb-1">{{item.order}}</p>
                  <div>
                    <a class="text-muted" :href="addressGMap[index]" target="_blank">
                      <i class="icon-location-pin mr-1"></i>{{item.address}}
                    </a>
                  </div>
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
                  <users-view :user="item.client" role="Cliente" @viewUser="userView = $event"></users-view>
                  <rate :length="5" v-model="item.client.score" :disabled="true" v-if="item.status_id != 3"/>
                  <rate :length="5" v-model="item.score_dealer" @after-rate="scoreOrder(item, index)" v-if="item.status_id == 3"/>
                </div>
                <div class="col-4 text-right">
                  <div>
                    <small class="text-muted" @click.prevent="showOrderUpdateModal(item, index)">
                      Envio: <strong>${{item.delivery_costs}}</strong>
                    </small>
                  </div>
                  <div>
                    <small class="text-muted" @click.prevent="showOrderUpdateModal(item, index)">
                      Costo: <strong>${{item.order_cost}}</strong>
                    </small>
                  </div>
                  <div>
                    <span class="text-muted border-top" @click.prevent="showOrderUpdateModal(item, index)">
                      Total: <strong>${{item.delivery_costs + item.order_cost}}</strong>
                    </span>
                  </div>
                </div>
              </div>
              <div class="row" v-if="item.status_id == 2">
                <div class="col-12">
                  <hr>
                </div>
                <div class="col-12 text-right">
                  <a href="#" class="btn btn-outline-info btn-sm" :disabled="submiting" @click.prevent="finalizeOrder(item, index)">
                    <i class="fas fa-spinner fa-spin" v-if="submiting"></i>
                    Finalizar
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
      <p class="mb-0 mt-3"><strong>No tienes ningun mandado asignado</strong></p>
      <p class="text-muted">Toma un mandado en la seccion de Mandados</p>
      <a class="btn btn-primary" href="/orders/availables">
        Ir a Mandados
      </a>
    </div>
    <!-- Modal -->
    <profile-view :user="userView"></profile-view>
    <!-- Modal update -->
    <div class="modal fade" id="orderUpdateModal" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Editar mandado</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label>Costo de envio</label>
              <div class="input-group border-right-0">
                <div class="input-group-prepend">
                  <span class="input-group-text">$</span>
                </div>
                <input type="text" class="form-control" :class="{'is-invalid': errors.delivery_costs}" v-model="editOrder.delivery_costs" placeholder="20">
              </div>
              <div class="invalid-feedback" v-if="errors.delivery_costs">{{errors.delivery_costs[0]}}</div>
            </div>
            <div class="form-group">
              <label>Costo del paquete</label>
              <div class="input-group border-right-0">
                <div class="input-group-prepend">
                  <span class="input-group-text">$</span>
                </div>
                <input type="text" class="form-control" :class="{'is-invalid': errors.order_cost}" v-model="editOrder.order_cost" placeholder="150">
              </div>
              <div class="invalid-feedback" v-if="errors.order_cost">{{errors.order_cost[0]}}</div>
            </div>
          </div>
          <div class="modal-footer">
            <a class="btn btn-primary" href="#" :disabled="submitingUpdate" @click.prevent="updateOrder">
              <i class="fas fa-spinner fa-spin" v-if="submitingUpdate"></i>
              <i class="fas fa-check" v-else></i>
              <span class="ml-1">Guardar</span>
            </a>
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
      user: Laravel.user,
      orders: [],
      editOrder: {},
      profit: 0,
      status: [],
      listStatus:[],
      userView: {},
      filtersShow: false,
      filters: {
        userId: Laravel.user.id,
        date: '',
        status: [
          {'id': 1, 'status': 'Abierto'},
          {'id': 2, 'status': 'En camino'},
          {'id': 3, 'status': 'Entregado'}
        ]
      },
      loading: true,
      submiting: false,
      submitingUpdate: false,
      errors: {}
    }
  },
  mounted () {
    this.getOrders()
    this.getStatus()
  },
  computed: {
    addressGMap: function () {
      return this.orders.map(function(item) {
        let url = item.address.replace(/#/g, '')
        return 'https://www.google.com/maps/search/' + url + ', Hidalgo del Parral, Chih.'
      });
    }
  },
  methods: {
    getOrders () {
      this.loading = true
      axios.post(`/api/orders/byDealer/filters`, this.filters)
      //axios.get(`/api/orders/byDealer/${this.user.id}`)
      .then(response => {
        this.orders = response.data.orders
        this.profit = response.data.profit
        this.loading = false
      })
    },
    getStatus () {
      if (this.status.length <= 0) {
        axios.get(`/api/orders/status`)
        .then(response => {
          this.status = response.data
          let status = response.data.slice(0)
          status.pop()
          this.listStatus = status.map(function(i, index) {
            return i.status
          })
        })
      }
    },
    showFilters () {
      this.filtersShow = !this.filtersShow
      this.getStatus()
    },
    finalizeOrder (order, index) {
      if (!this.submiting) {
        this.submiting = true
        axios.put(`/api/orders/updateStatus/${order.id}`, {'statusId': 3})
        .then(response => {
          this.orders[index].status_id = response.data.status_id
          this.orders[index].status = response.data.status
          this.$toasted.global.error('¡Mandado finalizado!')
          this.submiting = false
        })
      }
    },
    scoreOrder (order, index) {
      axios.put(`/api/orders/updateScoreDealer/${order.id}`, {'scoreDealer': order.score_dealer})
      .then(response => {
        this.orders[index].score_dealer = response.data.score_dealer
        this.$toasted.global.error('¡Mandado calificado!')
      })
    },
    showOrderUpdateModal (order, index) {
      //if (order.status_id == 2 && this.user.hasRole['dealer-level-2']) {
      if (order.status_id == 2) {
        this.errors = {}
        this.editOrder = Object.assign({}, order)
        this.editOrder.index = index
        $('#orderUpdateModal').modal('show')
      }
    },
    updateOrder () {
      if (!this.submitingUpdate) {
        this.submitingUpdate = true
        axios.put(`/api/orders/update/${this.editOrder.id}`, this.editOrder)
        .then(response => {
          this.orders[this.editOrder.index].delivery_costs = response.data.delivery_costs
          this.orders[this.editOrder.index].order_cost = response.data.order_cost
          this.submitingUpdate = false
          $('#orderUpdateModal').modal('hide')
          this.$toasted.global.error('Mandado actualizado!')
        })
        .catch(error => {
          this.errors = error.response.data.errors
          this.submitingUpdate = false
        })
      }
    }
  }
}
</script>
