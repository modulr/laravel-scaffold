<template lang="html">
  <div>
    <content-placeholders class="mt-5" v-if="loading">
      <content-placeholders-text :lines="6"/>
    </content-placeholders>
    <div v-else>
      <div class="card-header px-0 mt-2 bg-transparent clearfix">
        <h4 class="float-left pt-2">Pedidos</h4>
        <div class="card-header-actions mr-1">
          <a class="btn btn-primary" href="#" @click.prevent="orderModal">
            <i class="fa fa-plus mr-1"></i>Crear
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
                <small class="text-muted">Tarifa: ${{item.rate}}</small>
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
                <p class="mb-0">{{item.order}}</p>
                <small class="text-muted mr-3">
                  <i class="icon-location-pin"></i>&nbsp; {{item.address}}
                </small>
                <small class="text-muted">
                  <i class="icon-calendar"></i>&nbsp; {{item.created_at | moment('LLL')}}
                </small>
              </div>
              <div class="col-12">
                <hr>
              </div>
              <div class="col">
                <div class="media">
                  <div class="avatar float-left mr-2">
                    <img class="img-avatar" :src="item.client.avatar_url">
                  </div>
                  <div class="media-body">
                    <div>{{item.client.name}}</div>
                    <small class="text-muted">Cliente</small>
                  </div>
                </div>
                <rate :length="5" v-model="item.score_client" :disabled="true"/>
              </div>
              <div class="col" v-if="item.dealer_id">
                <div class="media" v-if="item.dealer_id">
                  <div class="avatar float-left mr-2">
                    <img class="img-avatar" :src="item.dealer.avatar_url">
                  </div>
                  <div class="media-body">
                    <div>{{item.dealer.name}}</div>
                    <small class="text-muted">Repartidor</small>
                  </div>
                </div>
                <rate :length="5" v-model="item.score_dealer" :disabled="true"/>
              </div>
              <div class="col text-right" v-if="item.status_id == 1">
                <a href="#" class="btn btn-outline-info btn-sm" @click.prevent="assignModal(item, index)">
                  Asignar repartidor
                </a>
              </div>
            </div>
          </li>
        </ul>
      </div>
    </div>
    <div class="no-items-found text-center mt-5" v-if="!loading && !orders.length > 0">
      <i class="icon-magnifier fa-3x text-muted"></i>
      <p class="mb-0 mt-3"><strong>No existe ningun pedido</strong></p>
      <p class="text-muted">Crea una dando clic en el boton de abajo</p>
      <a class="btn btn-primary" href="#" data-toggle="modal" data-target="#addModal">
        <i class="fa fa-plus mr-1"></i>Crear
      </a>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="orderModal" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Crea un pedido</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label>Pedido</label>
              <textarea class="form-control" rows="3" placeholder="¡Traeme unos tacos!" v-model="newOrder.order" :class="{'is-invalid': errors.order}"></textarea>
              <div class="invalid-feedback" v-if="errors.order">{{errors.order[0]}}</div>
            </div>
            <div class="form-group">
              <label>Cliente</label>
              <multiselect
                v-model="newOrder.client"
                :options="clients"
                openDirection="bottom"
                track-by="id"
                label="name"
                @select="getAddress"
                :class="{'border border-danger rounded': errors.client}">
              </multiselect>
              <small class="form-text text-danger" v-if="errors.client">{{errors.client[0]}}</small>
            </div>
            <div class="form-group">
              <label>Dirección</label>
              <multiselect
                v-model="newOrder.address"
                :options="address"
                openDirection="bottom"
                label="address"
                track-by="id"
                :custom-label="customLabel"
                placeholder="Selecciona o agrega una dirección"
                tag-placeholder="Agregar esta dirección"
                :taggable="true"
                @tag="addTag"
                :class="{'border border-danger rounded': errors.address}">
                <template slot="singleLabel" slot-scope="props">
                  <span>
                    <strong class="mr-2">{{ props.option.alias }}</strong>
                    <span>{{ props.option.address }}</span>
                  </span>
                </template>
                <template slot="option" slot-scope="props">
                  <div v-if="props.option.isTag">
                    {{ props.search }}
                  </div>
                  <div v-else>
                    <strong class="mr-2">{{ props.option.alias }}</strong>
                    <span>{{ props.option.address }}</span>
                  </div>
                </template>
              </multiselect>
              <small class="form-text text-danger" v-if="errors.address">{{errors.address[0]}}</small>
            </div>
            <div class="form-group">
              <label>Repartidor</label>
              <multiselect
                v-model="newOrder.dealer"
                :options="dealers"
                openDirection="bottom"
                track-by="id"
                label="name"
                :class="{'border border-danger rounded': errors.dealer}">
              </multiselect>
              <small class="form-text text-danger" v-if="errors.dealer">{{errors.dealer[0]}}</small>
            </div>
          </div>
          <div class="modal-footer">
            <a class="btn btn-primary" href="#" :disabled="submiting" @click.prevent="createOrder">
              <i class="fas fa-spinner fa-spin" v-if="submiting"></i>
              <i class="fas fa-check" v-else></i>
              <span class="ml-1">Guardar</span>
            </a>
          </div>
        </div>
      </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="assingModal" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Asigna al repartidor</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <content-placeholders class="modal-body" v-if="loadingDealers">
            <content-placeholders-text :lines="3"/>
          </content-placeholders>
          <div v-else>
            <div class="modal-body">
              <div class="form-group">
                <label>Repartidor</label>
                <multiselect
                  v-model="editOrder.dealer"
                  :options="dealers"
                  openDirection="bottom"
                  track-by="id"
                  label="name"
                  :class="{'border border-danger rounded': errors.dealer}">
                </multiselect>
                <small class="form-text text-danger" v-if="errors.dealer">{{errors.dealer[0]}}</small>
              </div>
            </div>
            <div class="modal-footer">
              <a class="btn btn-primary" href="#" :disabled="submitingDealer" @click.prevent="assignDealer">
                <i class="fas fa-spinner fa-spin" v-if="submitingDealer"></i>
                <i class="fas fa-check" v-else></i>
                <span class="ml-1">Guardar</span>
              </a>
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
      orders: [],
      clients: [],
      dealers: [],
      address: [],
      newOrder: {},
      editOrder: {},
      loading: true,
      loadingDealers: true,
      loadingClients: true,
      submiting: false,
      submitingDealer: false,
      errors: {}
    }
  },
  mounted () {
    this.getOrders()
  },
  methods: {
    getOrders () {
      this.loading = true
      axios.get(`/api/orders/all`)
      .then(response => {
        this.orders = response.data
        this.loading = false
      })
    },
    getClients () {
      if (this.clients.length == 0) {
        this.loadingClients = true
        axios.get(`/api/users/getClients`)
        .then(response => {
          this.clients = response.data
          this.loadingClients = false
        })
      }
    },
    getDealers () {
      if (this.dealers.length == 0) {
        this.loadingDealers = true
        axios.get(`/api/users/getDealers`)
        .then(response => {
          this.dealers = response.data
          this.loadingDealers = false
        })
      }
    },
    getAddress (client) {
      this.loading = true
      axios.get(`/api/address/byClient/${client.id}`)
      .then(response => {
        this.address = response.data
        this.loading = false
      })
    },
    orderModal () {
      this.newOrder = {}
      this.errors = {}
      $('#orderModal').modal('show')
      this.getDealers()
      this.getClients()
    },
    createOrder () {
      if (!this.submiting) {
        this.submiting = true
        axios.post(`/api/orders/store`, this.newOrder)
        .then(response => {
          this.orders.unshift(response.data)
          this.submiting = false
          $('#orderModal').modal('hide')
          this.$toasted.global.error('¡Mandado creado!')
        })
        .catch(error => {
          this.errors = error.response.data.errors
          this.submiting = false
        })
      }
    },
    addTag (newTag) {
      const tag = {
        address: newTag
      }
      axios.post(`/api/address/store/${this.newOrder.client.id}`, tag)
      .then(response => {
        this.newOrder.address = tag
        this.address.unshift(response.data)
        this.$toasted.global.error('¡Direccion agregada!')
      })
      .catch(error => {
        this.errors = error.response.data.errors
      })
    },
    customLabel ({ address, alias }) {
      return `${alias} ${address}`
    },
    assignModal (order, index) {
      this.errors = {}
      this.editOrder = order
      this.editOrder.index = index
      $('#assingModal').modal('show')
      this.getDealers()
    },
    assignDealer () {
      if (!this.submitingDealer) {
        this.submitingDealer = true
        axios.put(`/api/orders/assignDealer/${this.editOrder.id}`, this.editOrder)
        .then(response => {
          this.orders[this.editOrder.index].status_id = response.data.status_id
          this.orders[this.editOrder.index].status = response.data.status
          this.orders[this.editOrder.index].dealer_id = response.data.dealer_id
          this.orders[this.editOrder.index].dealer = response.data.dealer
          this.submitingDealer = false
          $('#assingModal').modal('hide')
          this.$toasted.global.error('¡Repartidor Asignado!')
        })
        .catch(error => {
          this.errors = error.response.data.errors
          this.submitingDealer = false
        })
      }
    }
  }
}
</script>
