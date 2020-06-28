<template lang="html">
  <div>
    <div>
      <div class="card-header px-0 mt-2 bg-transparent clearfix">
        <a href="/orders"><h4 class="float-left pt-2 text-body"><i class="fas fa-arrow-left mr-3"></i> Detalles del mandado</h4></a>
        <div class="card-header-actions mr-1">
          <a class="btn btn-outline-secondary" :href="`/orders/${order.id}`" @click.prevent="getOrder">
            <i class="fa fa-sync" :class="{'fa-spin': loading}"></i>
          </a>
        </div>
      </div>
      <div class="card-body px-0">
        <content-placeholders v-if="loading">
          <content-placeholders-text :lines="6"/>
        </content-placeholders>
        <ul class="list-group mb-1" v-else>
          <div class="alert alert-danger" role="alert" v-if="order.status_id == 4">
            Mandado cancelado
          </div>
          <li class="list-group-item mb-2">
            <div class="row">
              <div class="col-12">
                <p class="text-muted">Tiempo de entrega</p>
                <vue-step class="mb-0 pt-0" :now-step="order.status_id" :step-list="listStatus" style-type="style2" v-if="order.status_id!= 4"></vue-step>
                <vue-step class="mb-0 pt-0" :now-step="0" :step-list="listStatus" style-type="style2" v-else></vue-step>
                <small class="text-muted">
                  <i class="far fa-clock mr-1"></i>{{order.created_at | moment('LT')}}<span v-if="order.created_at != order.updated_at"> - {{order.updated_at | moment('LT')}}</span>
                  <strong class="float-right">{{ order.created_at | moment("from", order.updated_at, true) }}</strong>
                </small>
              </div>
            </div>
          </li>
          <li class="list-group-item mb-2">
            <p class="text-muted mb-0">Mandado</p>
            <p class="pre-line">{{order.order}}</p>
            <p class="text-muted mb-0">Dirección</p>
            <div class="mb-2">
              <i class="icon-location-pin mr-1"></i>{{order.address}}
            </div>
          </li>
          <li class="list-group-item mb-2">
            <div v-if="order.status_id == 1">
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
              <users-view :user="order.dealer" role="Repartidor" @viewUser="userView = $event" v-if="order.dealer_id"></users-view>
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
            </div>
          </li>
          <li class="list-group-item mb-2">
            <dl class="row mb-0">
              <dd class="col-6">Costo del paquete</dd>
              <dt class="col-6 text-right">${{order.order_cost}}</dt>
              <dd class="col-6">Costo envío</dd>
              <dt class="col-6 text-right">${{order.delivery_costs}}</dt>
              <dd class="col-6"><h4 class="mb-0">Total</h4></dd>
              <dt class="col-6 text-right"><h4 class="mb-0">${{order.delivery_costs + order.order_cost}}</h4></dt>
            </dl>
          </li>
          <li class="list-group-item mb-2">
            <p class="text-muted">Más información</p>
            <dl class="row mb-0">
              <dd class="col-5" v-if="order.status_id == 3">Calificar</dd>
              <dt class="col-7 text-right" v-if="order.status_id == 3"><rate :length="5" v-model="order.score_client" @after-rate="scoreOrder(order)"/></dt>
              <dd class="col-5">Fecha</dd>
              <dt class="col-7 text-right">{{order.created_at | moment('ll')}}</dt>
              <dd class="col-5">Nº de pedido</dd>
              <dt class="col-7 text-right">{{order.id}}</dt>
            </dl>
          </li>
          <div class="row mb-3">
            <div class="col-6">
              <a class="btn btn-block btn-outline-info" :href="`https://wa.me/52${this.config.phone}`" target="_blank">
                <i class="fab fa-whatsapp mr-2"></i> Mensaje
              </a>
            </div>
            <div class="col-6">
              <a class="btn btn-block btn-outline-info" :href="`tel:${this.config.phone}`">
                <i class="fas fa-phone mr-2"></i> Llamar
              </a>
            </div>
            <div class="col-12 mt-3">
              <a href="#" class="btn btn-block btn-lg btn-secondary" @click.prevent="cancelOrder(order)" v-if="order.status_id == 1">
                <i class="fas fa-spinner fa-spin" v-if="submiting"></i>
                Cancelar
              </a>
              <a href="#" class="btn btn-block btn-lg btn-primary" @click.prevent="showCreateOrderModal(order)" v-if="order.status_id == 3">
                Pedir de nuevo
              </a>
              <a href="#" class="btn btn-block btn-lg btn-primary" :disabled="submitingOpen" @click.prevent="openOrder(order)" v-if="order.status_id == 4">
                <i class="fas fa-spinner fa-spin" v-if="submitingOpen"></i>
                Abrir de nuevo
              </a>
            </div>
          </div>
        </ul>
      </div>
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
      order: {
        status_id: 0
      },
      listStatus:[
        'Abierto',
        'En camino',
        'Entregado'
      ],
      userView: {},
      newOrder: {},
      errors: {},
      loading: true,
      submiting: false,
      submitingOpen: false,
      submitingCreate: false,
      config: {}
    }
  },
  mounted () {
    this.getConfig()
    this.getOrder()
  },
  methods: {
    getConfig () {
      axios.get(`/api/configs/first`)
      .then(response => {
        this.config = response.data
      })
      .catch(error => {
        this.errors = error.response.data.errors
      })
    },
    getOrder () {
      this.loading = true
      let str = window.location.pathname
      let res = str.split("/")
      axios.get(`/api/orders/${res[2]}`)
      .then(response => {
        this.order = response.data
        this.loading = false
      })
      .catch(error => {
        this.$toasted.global.error('¡El mandado no existe!')
        location.href = '/orders'
      })
    },
    cancelOrder (order) {
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
              this.order.status_id = response.data.status_id
              this.order.status = response.data.status
              this.$toasted.global.error('¡Mandado cancelado!')
              this.submiting = false
            })
          } else {
            this.submiting = false
          }
        })
      }
    },
    openOrder (order) {
      if (!this.submitingOpen) {
        this.submitingOpen = true
        let status = 1
        let message = '¡Mandado abierto!'
        axios.put(`/api/orders/updateStatus/${order.id}`, {'statusId': status})
        .then(response => {
          this.order.status_id = response.data.status_id
          this.order.status = response.data.status
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
          this.submitingCreate = false
          $('#createOrderModal').modal('hide')
          this.$toasted.global.error('¡Mandado creado!')
          location.href = `/orders/${response.data.id}`
        })
        .catch(error => {
          this.errors = error.response.data.errors
          this.submitingCreate = false
        })
      }
    },
    scoreOrder (order) {
      axios.put(`/api/orders/updateScoreClient/${order.id}`, {'scoreClient': order.score_client})
      .then(response => {
        this.order.score_client = response.data.score_client
        this.$toasted.global.error('¡Mandado calificado!')
      })
    }
  }
}
</script>
