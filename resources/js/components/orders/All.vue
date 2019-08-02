<template lang="html">
  <div>
    <div>
      <div class="card-header px-0 mt-2 bg-transparent clearfix">
        <h4 class="float-left pt-2">Mandados <small class="text-muted">({{orders.length}}/${{profit}})</small></h4>
        <div class="card-header-actions mr-1">
          <a class="text-secondary" href="/orders/all" @click.prevent="getOrders">
            <i class="fa fa-sync mr-1" :class="{'fa-spin': loading}"></i>
          </a>
          <a class="text-secondary ml-3" :class="{'text-success': filtersShow}" href="#" @click.prevent="showFilters">
            <i class="fas fa-filter"></i>
          </a>
          <a class="text-success ml-3" href="#" @click.prevent="showUserCreateModal">
            <i class="fas fa-user-plus"></i>
            <span class="d-md-down-none ml-1">Crear cliente</span>
          </a>
          <a class="btn btn-primary ml-3" href="#" @click.prevent="orderModal">
            <i class="fa fa-plus"></i>
            <span class="d-md-down-none ml-1">Crear</span>
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
            <input class="form-control" type="date" v-model="filters.date" @change="getOrders" placeholder="Filtra por Fecha">
          </div>
          <div class="form-group">
            <multiselect
              v-model="filters.dealers"
              :options="dealers"
              track-by="id"
              label="name"
              :multiple="true"
              @select="getOrders"
              @remove="getOrders"
              placeholder="Filtra por Repartidor"
              :class="{'border border-danger rounded': errors.dealer}">
            </multiselect>
          </div>
        </div>
        <content-placeholders v-if="loading">
          <content-placeholders-text :lines="6"/>
        </content-placeholders>
        <div v-else>
          <ul class="list-group mb-1" v-for="(item, index) in orders">
            <li class="list-group-item">
              <div class="row">
                <!-- <div class="col text-right">
                  <span class="badge badge-pill" :class="{
                    'badge-primary': item.status_id == 1,
                    'badge-success': item.status_id == 2,
                    'badge-info': item.status_id == 3,
                    'badge-secondary': item.status_id == 4 }">
                    {{item.status.status}}
                  </span>
                </div> -->
                <div class="col-12">
                  <p class="pre-line mb-2" @click.prevent="showOrderUpdateModal(item, index)">{{item.order}}</p>
                  <!-- <div v-if="item.origin" class="mb-1">
                    <a :href="originGMap[index]" target="_blank">
                      <span class="text-muted">
                        <i class="far fa-dot-circle mr-1"></i>{{item.origin}}
                      </span>
                    </a>
                  </div> -->
                  <div>
                    <a class="text-muted" :href="addressGMap[index]" target="_blank">
                      <i class="icon-location-pin mr-1"></i>{{item.address}}
                    </a>
                  </div>
                </div>
                <div class="col-12">
                  <hr>
                </div>
                <div class="col-8">
                  <vue-step class="mb-0 pt-0" :now-step="item.status_id" :step-list="listStatus" style-type="style2" @selected="finalizeOrder(item, index)" v-if="item.status_id!= 4"></vue-step>
                  <vue-step class="mb-0 pt-0" :now-step="0" :step-list="listStatus" style-type="style2" v-else></vue-step>
                  <small class="text-muted">
                    <i class="far fa-clock mr-1"></i>{{item.created_at | moment('LT')}} - {{item.updated_at | moment('LT')}}
                    <strong class="float-right">{{ item.created_at | moment("from", item.updated_at, true) }}</strong>
                  </small>
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
                <div class="col text-right">
                  <a href="#" class="btn btn-outline-secondary btn-sm" @click.prevent="cancelOrder(item, index)">
                    Cancelar
                  </a>
                  <a href="#" class="btn btn-outline-info btn-sm" @click.prevent="assignModal(item, index)">
                    <span v-if="!item.dealer_id">Asignar repartidor</span>
                    <span v-else>Cambiar repartidor</span>
                  </a>
                </div>
              </div>
              <div class="row" v-if="item.status_id == 4">
                <div class="col-12">
                  <hr>
                </div>
                <div class="col">
                  <div class="alert alert-secondary text-center mb-0" @click="finalizeOrder(item, index)">
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
      <p class="mb-0 mt-3"><strong>No existe ningun mandado</strong></p>
      <p class="text-muted">Crea uno dando clic en el boton de abajo</p>
      <a class="btn btn-primary" href="#" @click.prevent="orderModal">
        <i class="fa fa-plus mr-1"></i>Crear
      </a>
    </div>
    <!-- Modal create -->
    <div class="modal fade" id="orderModal" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Crear mandado</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
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
              <label>Mandado</label>
              <textarea class="form-control" rows="3" placeholder="¡Traeme unos tacos!" v-model="newOrder.order" :class="{'is-invalid': errors.order}"></textarea>
              <div class="invalid-feedback" v-if="errors.order">{{errors.order[0]}}</div>
            </div>
            <div class="form-group">
              <label>Costo de envio</label>
              <div class="input-group border-right-0">
                <div class="input-group-prepend">
                  <span class="input-group-text">$</span>
                </div>
                <input type="text" class="form-control" :class="{'is-invalid': errors.delivery_costs}" v-model="newOrder.delivery_costs" placeholder="20">
                <div class="invalid-feedback" v-if="errors.delivery_costs">{{errors.delivery_costs[0]}}</div>
              </div>
            </div>
            <div class="form-group">
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
            <a class="text-success mr-3" href="#" @click.prevent="showUserCreateModal">
              <i class="fas fa-user-plus"></i>
              <span class="d-md-down-none ml-1">Crear cliente</span>
            </a>
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
            <!-- <div class="form-group">
              <div class="input-group">
                <div class="input-group-prepend border-right-0">
                  <span class="input-group-text"><i class="far fa-dot-circle"></i></span>
                </div>
                <input type="text" class="form-control" :class="{'is-invalid': errors.origin}" v-model="editOrder.origin" placeholder="Origen">
              </div>
              <div class="invalid-feedback" v-if="errors.origin">{{errors.origin[0]}}</div>
            </div> -->
            <div class="form-group">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="icon-location-pin"></i></span>
                </div>
                <input type="text" class="form-control" :class="{'is-invalid': errors.address}" v-model="editOrder.address" placeholder="Destino">
              </div>
              <div class="invalid-feedback" v-if="errors.address">{{errors.address[0]}}</div>
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
    <!-- Modal create user -->
    <div class="modal fade" id="userCreateModal" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Crear cliente</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label>Nombre</label>
              <input type="text" class="form-control" :class="{'is-invalid': errors.name}" v-model="newUser.name" placeholder="John Doe">
              <div class="invalid-feedback" v-if="errors.name">{{errors.name[0]}}</div>
            </div>
            <div class="form-group">
              <label>Correo electrónico</label>
              <input type="email" class="form-control" :class="{'is-invalid': errors.email}" v-model="email" placeholder="john@modulr.io">
              <div class="invalid-feedback" v-if="errors.email">{{errors.email[0]}}</div>
            </div>
            <div class="form-group">
              <label>Teléfono celular</label>
              <input type="tel" class="form-control" :class="{'is-invalid': errors.cellphone}" v-model="newUser.cellphone" placeholder="6271012345">
              <div class="invalid-feedback" v-if="errors.cellphone">{{errors.cellphone[0]}}</div>
            </div>
            <div class="form-group">
              <label>Contraseña</label>
              <input type="text" class="form-control" :class="{'is-invalid': errors.password}" v-model="newUser.password" placeholder="123456">
              <div class="invalid-feedback" v-if="errors.password">{{errors.password[0]}}</div>
            </div>
          </div>
          <div class="modal-footer">
            <a class="btn btn-primary" href="#" :disabled="submitingUser" @click.prevent="createUser">
              <i class="fas fa-spinner fa-spin" v-if="submitingUser"></i>
              <i class="fas fa-check" v-else></i>
              <span class="ml-1">Guardar</span>
            </a>
          </div>
        </div>
      </div>
    </div>
    <!-- Modal view user-->
    <profile-view :user="userView"></profile-view>
  </div>
</template>

<script>
export default {
  data () {
    return {
      orders: [],
      profit: 0,
      status: [],
      listStatus: [],
      rate: null,
      clients: [],
      dealers: [],
      address: [],
      newOrder: {},
      editOrder: {},
      newUser: {
        name: ''
      },
      userView: {},
      loading: true,
      isLoading: false,
      submiting: false,
      submitingUpdate: false,
      submitingDealer: false,
      submitingUser: false,
      errors: {},
      filtersShow: false,
      filters: {
        status: [
          {'id': 1, 'status': 'Abierto'},
          {'id': 2, 'status': 'En camino'}
        ],
        dealers: [],
        date: ''
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
    this.getStatus()
  },
  methods: {
    getOrders () {
      this.loading = true
      axios.post(`/api/orders/filters`, this.filters)
      .then(response => {
        this.orders = response.data.orders
        this.profit = response.data.profit
        this.loading = false
        localStorage.setItem("filtersOrders", JSON.stringify(this.filters))
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
    getRate () {
      if (this.rate == null) {
        axios.get(`/api/rates/day`)
        .then(response => {
          this.rate = response.data
          this.newOrder.delivery_costs = this.rate.rate + 5
        })
      } else {
        this.newOrder.delivery_costs = this.rate.rate
      }
    },
    getDealers () {
      if (this.dealers.length == 0) {
        axios.get(`/api/users/getDealers`)
        .then(response => {
          this.dealers = response.data
        })
      }
    },
    searchClients (query) {
      if (query.length > 2) {
        this.isLoading = true
        axios.post(`/api/users/searchClients`, {name: query})
        .then(response => {
          this.clients = response.data
          this.isLoading = false
        })
      }
    },
    getAddress (client) {
      axios.get(`/api/address/byClient/${client.id}`)
      .then(response => {
        this.address = response.data
      })
    },
    showFilters () {
      this.filtersShow = !this.filtersShow
      this.getStatus()
      this.getDealers()
    },
    orderModal () {
      this.errors = {}
      this.newOrder = {}
      //this.getClients()
      this.getDealers()
      this.getRate()
      this.newOrder.order_cost = 0
      $('#orderModal').modal('show')
      $('#userCreateModal').modal('hide')
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
      // this.editOrder = order
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
          this.orders[this.editOrder.index].address = response.data.address
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
    },
    finalizeOrder (order, index) {
      let status = 3
      let message = '¡Mandado finalizado!'

      if (order.status_id == 1 || order.status_id == 3 || order.status_id == 4) {
        message = '¡Mandado En Camino!'
        status = 2
      }

      axios.put(`/api/orders/updateStatus/${order.id}`, {'statusId': status})
      .then(response => {
        this.orders[index].status_id = response.data.status_id
        this.orders[index].status = response.data.status
        this.$toasted.global.error(message)
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
    showUserCreateModal () {
      this.errors = {}
      this.newUser = {
        name: '',
        password: '123456'
      }
      $('#userCreateModal').modal('show')
      $('#orderModal').modal('hide')
    },
    createUser () {
      if (!this.submitingUser) {
        this.submitingUser = true
        this.newUser.email = this.email
        this.newUser.roles = [{name: 'user', display_name: 'Cliente'}]
        axios.post(`/api/clients/store`, this.newUser)
        .then(response => {
          this.newUser = {
            name: ''
          }
          this.submitingUser = false
          $('#userCreateModal').modal('hide')
          this.$toasted.global.error('Cliente creado!')
          //this.orderModal()
        })
        .catch(error => {
          this.errors = error.response.data.errors
          this.submitingUser = false
        })
      }
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
    }
  },
  computed: {
    email: function () {
      const a = 'àáäâãåăæçèéëêǵḧìíïîḿńǹñòóöôœøṕŕßśșțùúüûǘẃẍÿź·/_,:;'
      const b = 'aaaaaaaaceeeeghiiiimnnnooooooprssstuuuuuwxyz------'
      const p = new RegExp(a.split('').join('|'), 'g')

      return this.newUser.name.toString().toLowerCase()
      .replace(/\s+/g, '-') // Replace spaces with -
      .replace(p, c => b.charAt(a.indexOf(c))) // Replace special characters
      .replace(/&/g, '-and-') // Replace & with 'and'
      .replace(/[^\w\-]+/g, '') // Remove all non-word characters
      .replace(/\-\-+/g, '-') // Replace multiple - with single -
      .replace(/^-+/, '') // Trim - from start of text
      .replace(/-+$/, '') // Trim - from end of text
      .concat('@traeme.app')
    },
    originGMap: function () {
      return this.orders.map(function(item) {
        if (item.origin != null) {
          let url = item.origin.replace(/#/g, ' ')
          return 'https://www.google.com/maps/search/Calle ' + url + ', Hidalgo del Parral, Chih.'
        }
      });
    },
    addressGMap: function () {
      return this.orders.map(function(item) {
        let url = item.address.replace(/#/g, '')
        return 'https://www.google.com/maps/search/Calle ' + url + ', Hidalgo del Parral, Chih.'
      });
    }
  }
}
</script>
