<template lang="html">
  <div>
    <div>
      <div class="card-header px-0 mt-2 bg-transparent clearfix">
        <h4 class="float-left pt-2">Mis mandados</h4>
        <div class="card-header-actions mr-1">
          <a class="btn btn-primary btn-block mb-2" href="#" @click.prevent="showCreateOrderModal">Pedir</a>
        </div>
      </div>
      <div class="card-body px-0">
        <!-- <content-placeholders v-if="loading">
          <content-placeholders-text :lines="6"/>
        </content-placeholders> -->
        <ul class="list-group mb-1" v-for="(item, index) in orders">
          <li class="list-group-item">
            <div class="row">
              <div class="col-12" @click="viewOrder(item)">
                <small class="text-muted">
                  <i class="far fa-clock mr-1"></i>{{item.created_at | moment('LT')}}<span v-if="item.created_at != item.updated_at"> - {{item.updated_at | moment('LT')}}</span>
                  <strong class="float-right">{{ item.created_at | moment("from", item.updated_at, true) }}</strong>
                </small>
                <vue-step class="mb-0 pt-0" :now-step="item.status_id" :step-list="listStatus" style-type="style2" v-if="item.status_id!= 4"></vue-step>
                <vue-step class="mb-0 pt-0" :now-step="0" :step-list="listStatus" style-type="style2" v-else></vue-step>
              </div>
              <div class="col-12" @click="viewOrder(item)">
                <p class="pre-line mb-2">{{item.order}}</p>
                <p class="mb-3 text-muted">
                  <i class="icon-location-pin mr-1"></i>{{item.address}}
                </p>
              </div>
              <div class="col-9">
                <div v-if="item.status_id == 1" @click="viewOrder(item)">
                  <div class="media">
                    <div class="avatar float-left mr-2 text-muted">
                      <span class="fa-stack" style="font-size: 1.3em;">
                        <i class="fas fa-circle fa-stack-2x"></i>
                        <i class="fas fa-user fa-stack-1x fa-inverse"></i>
                      </span>
                    </div>
                    <div class="media-body">
                      <div class="text-body text-muted">
                       <i class="fas fa-spinner fa-spin"></i> Buscando repartidor
                      </div>
                      <div class="small text-muted">
                        20 minutos aproximadamente
                      </div>
                    </div>
                  </div>
                </div>
                <div v-else>
                  <users-view :user="item.dealer" role="Repartidor" @viewUser="userView = $event" v-if="item.dealer_id"></users-view>
                  <div v-else @click="viewOrder(item)">
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
                </div>
              </div>
              <div class="col-3 text-right" @click="viewOrder(item)">
                <h3 class="mt-2 mb-0">${{item.delivery_costs}}</h3>
              </div>
            </div>
            <div class="row">
              <div class="col-12">
                <hr>
              </div>
              <div class="col-6" @click="viewOrder(item)">
                <h5>{{item.created_at | moment('D MMM')}}</h5>
              </div>
              <div class="col-6 text-right">
                <div class="text-danger mb-0" v-if="item.status_id == 4">
                  Cancelado
                </div>
                <rate :length="5" v-model="item.score_client" @after-rate="scoreOrder(item, index)" v-if="item.status_id == 3"/>
              </div>
            </div>
          </li>
        </ul>
        <!-- Loading -->
        <infinite-loading slot="append" @infinite="loadOrders" force-use-infinite-wrapper=".card-body">
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
      <div class="modal-dialog modal-dialog-centered" role="document">
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
                <input type="text" class="form-control" :class="{'is-invalid': errors.address}" v-model="newOrder.address" placeholder="Dirección">
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
            <a class="btn btn-block btn-primary" href="#" :disabled="submitingCreate" @click.prevent="createOrder">
              <i class="fas fa-spinner fa-spin" v-if="submitingCreate"></i>
              <i class="fas fa-check" v-else></i>
              <span class="ml-1">Pedir</span>
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
      listStatus:['','',''],
      userView: {},
      newOrder: {},
      errors: {},
      loading: true,
      submitingCreate: false
    }
  },
  methods: {
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
    viewOrder (order) {
      location.href = `/orders/${order.id}`
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
