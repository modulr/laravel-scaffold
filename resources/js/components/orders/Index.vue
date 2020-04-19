<template lang="html">
  <div>
    <div>
      <div class="card-header px-0 mt-2 bg-transparent clearfix">
        <h4 class="float-left pt-2">Mis mandados</h4>
        <div class="card-header-actions mr-1">
          <a class="btn btn-primary btn-block mb-2" href="#" @click.prevent="showCreateOrderModal">
            <i class="fa fa-plus mr-2"></i>Pedir
          </a>
        </div>
      </div>
      <div class="card-body px-0">
        <!-- <content-placeholders v-if="loading">
          <content-placeholders-text :lines="6"/>
        </content-placeholders> -->
        <div>
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
                    <div v-else>
                      <div class="media">
                        <div class="avatar float-left mr-2 text-muted">
                          <span class="fa-stack" style="font-size: 1.3em;">
                            <i class="fas fa-circle fa-stack-2x"></i>
                            <i class="fas fa-user fa-stack-1x fa-inverse"></i>
                          </span>
                        </div>
                        <div class="media-body">
                          <div class="text-body text-muted">
                            Sin repartidor
                          </div>
                          <div class="small text-muted">
                            Repartidor
                          </div>
                        </div>
                      </div>
                    </div>
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
              <div class="row" >
                <div class="col-12">
                  <hr>
                </div>
                <div class="col-12 text-right" v-if="item.status_id == 1">
                  <a href="#" class="btn btn-outline-secondary btn-sm" @click.prevent="cancelOrder(item, index)">
                    <i class="fas fa-spinner fa-spin" v-if="submiting"></i>
                    Cancelar
                  </a>
                </div>
                <div class="col-12 text-right" v-if="item.status_id == 4">
                  <a href="#" class="btn btn-outline-primary btn-sm" :disabled="submitingOpen" @click.prevent="openOrder(item, index)">
                    <i class="fas fa-spinner fa-spin" v-if="submitingOpen"></i>
                    Abrir de nuevo
                  </a>
                  <div class="btn btn-secondary btn-sm disabled">
                    Cancelado
                  </div>
                </div>
                <div class="col-12 text-right" v-if="item.status_id == 3">
                  <a href="#" class="btn btn-outline-info btn-sm" @click.prevent="showCreateOrderModal(item)">
                    Pedir de nuevo
                  </a>
                </div>
              </div>
            </li>
          </ul>
        </div>
        <!-- Loading -->
        <infinite-loading @infinite="loadOrders" ref="infiniteLoading">
          <span slot="no-results"></span>
          <span slot="no-more"></span>
        </infinite-loading>
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
    <!-- Modal create -->
    <div class="modal fade" id="createOrderModal" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Pedir mandado</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label>Mandado</label>
              <textarea class="form-control" rows="3" placeholder="¡Traeme unos tacos!" v-model="newOrder.order" :class="{'is-invalid': errors.order}"></textarea>
              <div class="invalid-feedback" v-if="errors.order">{{errors.order[0]}}</div>
            </div>
            <div class="form-group">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="icon-location-pin"></i></span>
                </div>
                <input type="text" class="form-control" :class="{'is-invalid': errors.address}" v-model="newOrder.address" placeholder="Destino">
                <div class="invalid-feedback" v-if="errors.address">{{errors.address[0]}}</div>
              </div>
            </div>
            <!-- <div class="form-group">
              <label>Costo del paquete</label>
              <div class="input-group border-right-0">
                <div class="input-group-prepend">
                  <span class="input-group-text">$</span>
                </div>
                <input type="text" class="form-control" :class="{'is-invalid': errors.order_cost}" v-model="newOrder.order_cost" placeholder="150">
              </div>
              <div class="invalid-feedback" v-if="errors.order_cost">{{errors.order_cost[0]}}</div>
            </div>
            <div class="form-group">
              <label>Agendar</label>
              <div class="input-group border-right-0">
                <div class="input-group-prepend">
                  <span class="input-group-text">📅</span>
                </div>
                <input type="datetime-local" class="form-control" :class="{'is-invalid': errors.created_at}" v-model="newOrder.created_at">
              </div>
              <div class="invalid-feedback" v-if="errors.created_at">{{errors.created_at[0]}}</div>
            </div> -->
          </div>
          <div class="modal-footer">
            <a class="btn btn-primary" href="#" :disabled="submitingCreate" @click.prevent="createOrder">
              <i class="fas fa-spinner fa-spin" v-if="submitingCreate"></i>
              <i class="fas fa-check" v-else></i>
              <span class="ml-1">Guardar</span>
            </a>
          </div>
        </div>
      </div>
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
      pagination: {
        current_page: 0
      },
      listStatus:[],
      userView: {},
      newOrder: {},
      errors: {},
      loading: true,
      submiting: false,
      submitingOpen: false,
      submitingCreate: false
    }
  },
  mounted () {
    //this.getOrders()
    this.getStatus()
  },
  methods: {
    // getOrders () {
    //   this.loading = true
    //   axios.get(`/api/orders/byClient/${this.user.id}`)
    //   .then(response => {
    //     this.orders = response.data
    //     this.loading = false
    //   })
    // },
    loadOrders ($state) {
        this.loading = true
        var page = Number(this.pagination.current_page) + 1;
        axios.get(`/api/orders/byClient/${this.user.id}?page=${page}`)
        .then(response => {
            this.orders = this.orders.concat(response.data.data);
            this.pagination = response.data
            $state.loaded();
            this.loading = false
            if (!this.pagination.next_page_url)
                $state.complete();
        });
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
      if (!this.submiting) {
        this.submiting = true
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
              this.submiting = false
            })
          } else {
            this.submiting = false
          }
        })
      }
    },
    openOrder (order, index) {
      if (!this.submitingOpen) {
        this.submitingOpen = true
        let status = 1
        let message = '¡Mandado abierto!'
        axios.put(`/api/orders/updateStatus/${order.id}`, {'statusId': status})
        .then(response => {
          this.orders[index].status_id = response.data.status_id
          this.orders[index].status = response.data.status
          this.$toasted.global.error(message)
          this.submitingOpen = false
        })
      }
    },
    showCreateOrderModal (order) {
      this.errors = {}
      if (order) {
        this.newOrder.order = order.order
        this.newOrder.address = order.address
        // this.newOrder.order_cost = order.order_cost
        // this.newOrder.created_at = Vue.moment().format('YYYY-MM-DDTHH:mm')
      }
      $('#createOrderModal').modal('show')
    },
    createOrder () {
      if (!this.submitingCreate) {
        this.submitingCreate = true
        axios.post(`/api/orders/storeAuth`, this.newOrder)
        .then(response => {
          this.orders.unshift(response.data)
          this.submitingCreate = false
          $('#createOrderModal').modal('hide')
          this.$toasted.global.error('¡Mandado creado!')
        })
        .catch(error => {
          this.errors = error.response.data.errors
          this.submitingCreate = false
        })
      }
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
