<template lang="html">
  <div>
    <div>
      <div class="card-header px-0 mt-2 bg-transparent clearfix">
        <h4 class="float-left pt-2">Mandados</h4>
        <div class="card-header-actions mr-1">
          <a class="text-secondary" :class="{'text-success': statusShow}" href="#" @click.prevent="showFilters">
            <i class="fas fa-filter"></i>
          </a>
          <a class="btn btn-primary ml-4" href="#" @click.prevent="orderModal">
            <i class="fa fa-plus"></i>
            <span class="d-md-down-none ml-1">Crear</span>
          </a>
        </div>
      </div>
      <div class="card-body px-0">
        <div class="mb-4" v-if="statusShow">
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
        <content-placeholders v-if="loading">
          <content-placeholders-text :lines="6"/>
        </content-placeholders>
        <div v-else>
          <ul class="list-group mb-1" v-for="(item, index) in orders">
            <li class="list-group-item">
              <div class="row">
                <div class="col">
                  <small class="text-muted" @click.prevent="showOrderUpdateModal(item, index)">Mandado: {{item.id}}</small>
                </div>
                <div class="col text-center">
                  <small class="text-muted" @click.prevent="showOrderUpdateModal(item, index)">Envio: ${{item.delivery_costs}}</small>
                </div>
                <div class="col text-right">
                  <span class="badge badge-pill" @click.prevent="showOrderUpdateModal(item, index)" :class="{
                    'badge-primary': item.status_id == 1,
                    'badge-success': item.status_id == 2,
                    'badge-info': item.status_id == 3,
                    'badge-secondary': item.status_id == 4 }">
                    {{item.status.status}}
                  </span>
                </div>
                <div class="col-12">
                  <hr class="mt-1 mb-2">
                </div>
                <div class="col-12">
                  <p class="mb-1" @click.prevent="showOrderUpdateModal(item, index)">{{item.order}}</p>
                  <span class="text-muted mr-3" @click.prevent="showOrderUpdateModal(item, index)">
                    <i class="icon-location-pin mr-2"></i>{{item.address}}
                  </span>
                  <small class="text-muted" @click.prevent="showOrderUpdateModal(item, index)">
                    <i class="icon-calendar mr-2"></i>{{item.created_at | moment('LLL')}}
                  </small>
                </div>
                <div class="col-12">
                  <hr>
                </div>
                <div class="col">
                  <users-view :user="item.client" role="Cliente" @viewUser="userView = $event"></users-view>
                  <rate :length="5" v-model="item.score_client" :disabled="true"/>
                </div>
                <div class="col">
                  <div v-if="item.dealer_id">
                    <users-view :user="item.dealer" role="Repartidor" @viewUser="userView = $event"></users-view>
                    <rate :length="5" v-model="item.score_dealer" :disabled="true"/>
                  </div>
                </div>
              </div>
              <div class="row" v-if="item.status_id == 1 || item.status_id == 2">
                <div class="col-12">
                  <hr>
                </div>
                <div class="col">
                  <a href="#" class="btn btn-outline-secondary btn-sm" @click.prevent="cancelOrder(item, index)">
                    Cancelar
                  </a>
                </div>
                <div class="col text-right">
                  <a href="#" class="btn btn-outline-secondary btn-sm" @click.prevent="assignModal(item, index)">
                    <span v-if="!item.dealer_id">Asignar repartidor</span>
                    <span v-else>Cambiar repartidor</span>
                  </a>
                </div>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <div class="no-items-found text-center mt-5" v-if="!loading && !orders.length > 0">
      <i class="icon-magnifier fa-3x text-muted"></i>
      <p class="mb-0 mt-3"><strong>No existe ningun mandado</strong></p>
      <p class="text-muted">Crea uno dando clic en el boton de abajo</p>
      <a class="btn btn-primary" href="#" @click.prevent="orderModal">
        <i class="fa fa-plus mr-1"></i>Crear
      </a>
    </div>
    <!-- Modal create -->
    <div class="modal fade" id="orderModal" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Crear mandado</h5>
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
              <label>Cliente</label>
              <multiselect
                v-model="newOrder.client"
                :options="clients"
                track-by="id"
                label="name"
                :loading="isLoading"
                :internal-search="false"
                @search-change="searchClients"
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
                track-by="id"
                label="address"
                :custom-label="customLabel"
                placeholder="Selecciona o agrega una dirección"
                tag-placeholder="Agregar dirección"
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
              <label>Mandado</label>
              <textarea class="form-control" rows="3" placeholder="¡Traeme unos tacos!" v-model="editOrder.order" :class="{'is-invalid': errors.order}"></textarea>
              <div class="invalid-feedback" v-if="errors.order">{{errors.order[0]}}</div>
            </div>
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
            <!-- <div class="form-group">
              <label>Repartidor</label>
              <multiselect
                v-model="editOrder.dealer"
                :options="dealers"
                track-by="id"
                label="name"
                :class="{'border border-danger rounded': errors.dealer}">
              </multiselect>
              <small class="form-text text-danger" v-if="errors.dealer">{{errors.dealer[0]}}</small>
            </div>
            <div class="form-group">
              <label>Estatus</label>
              <multiselect
                v-model="editOrder.status"
                :options="status"
                track-by="id"
                label="status"
                :searchable="false"
                :class="{'border border-danger rounded': errors.status}">
              </multiselect>
              <small class="form-text text-danger" v-if="errors.status">{{errors.status[0]}}</small>
            </div> -->
          </div>
          <div class="modal-footer">
            <a class="btn btn-primary" href="#" :disabled="submiting" @click.prevent="updateOrder">
              <i class="fas fa-spinner fa-spin" v-if="submiting"></i>
              <i class="fas fa-check" v-else></i>
              <span class="ml-1">Guardar</span>
            </a>
          </div>
        </div>
      </div>
    </div>
    <!-- Modal assign -->
    <div class="modal fade" id="assingModal" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Asigna al repartidor</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label>Repartidor</label>
              <multiselect
                v-model="editOrder.dealer"
                :options="dealers"
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
    <!-- Modal -->
    <profile-view :user="userView"></profile-view>
  </div>
</template>

<script>
export default {
  data () {
    return {
      orders: [],
      status:[],
      statusShow: false,
      clients: [],
      dealers: [],
      address: [],
      newOrder: {},
      editOrder: {},
      userView: {},
      loading: true,
      isLoading: false,
      submiting: false,
      submitingUpdate: false,
      submitingDealer: false,
      errors: {},
      filters: {
        status: [
          {'id': 1, 'status': 'Abierto'},
          {'id': 2, 'status': 'En camino'}
        ]
      }
    }
  },
  mounted () {
    if (localStorage.getItem("filtersOrders")) {
      this.filters = JSON.parse(localStorage.getItem("filtersOrders"))
    } else {
      localStorage.setItem("filtersOrders", JSON.stringify(this.filters))
    }
    this.getOrders()
  },
  methods: {
    getOrders () {
      this.loading = true
      axios.post(`/api/orders/filters`, this.filters)
      .then(response => {
        this.orders = response.data
        this.loading = false
        localStorage.setItem("filtersOrders", JSON.stringify(this.filters))
      })
    },
    getStatus () {
      if (this.status.length <= 0) {
        axios.get(`/api/orders/status`)
        .then(response => {
          this.status = response.data
        })
      }
    },
    // getClients () {
    //   if (this.clients.length == 0) {
    //     axios.get(`/api/users/getClients`)
    //     .then(response => {
    //       this.clients = response.data
    //     })
    //   }
    // },
    getDealers () {
      if (this.dealers.length == 0) {
        axios.get(`/api/users/getDealers`)
        .then(response => {
          this.dealers = response.data
        })
      }
    },
    searchClients (query) {
      this.isLoading = true
      axios.get(`/api/users/searchClients/${query}`)
      .then(response => {
        this.clients = response.data
        this.isLoading = false
      })
    },
    getAddress (client) {
      axios.get(`/api/address/byClient/${client.id}`)
      .then(response => {
        this.address = response.data
      })
    },
    showFilters () {
      this.statusShow = !this.statusShow
      this.getStatus()
    },
    orderModal () {
      this.errors = {}
      this.newOrder = {}
      //this.getClients()
      this.getDealers()
      $('#orderModal').modal('show')
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
    showOrderUpdateModal (order, index) {
      this.errors = {}
      // this.getDealers()
      // this.getStatus()
      //this.editOrder = order
      this.editOrder = Object.assign({}, order)
      this.editOrder.index = index
      $('#orderUpdateModal').modal('show')
    },
    updateOrder () {
      if (!this.submitingUpdate) {
        this.submitingUpdate = true
        axios.put(`/api/orders/update/${this.editOrder.id}`, this.editOrder)
        .then(response => {
          this.orders[this.editOrder.index].order = response.data.order
          this.orders[this.editOrder.index].delivery_costs = response.data.delivery_costs
          this.submitingUpdate = false
          $('#orderUpdateModal').modal('hide')
          this.$toasted.global.error('Mandado actualizado!')
        })
        .catch(error => {
          this.errors = error.response.data.errors
          this.submitingUpdate = false
        })
      }
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
