<template lang="html">
  <div>
    <div>
      <div class="card-header px-0 mt-2 bg-transparent clearfix">
        <h4 class="float-left pt-2">Mandados</h4>
        <div class="card-header-actions mr-1">
          <a class="btn btn-primary" href="/orders/availables" @click.prevent="getOrders">
            <i class="fa fa-sync mr-1" :class="{'fa-spin': loading}"></i>Refrescar
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
                  <vue-step class="mb-0 pt-0" :now-step="item.status_id" :step-list="listStatus" style-type="style2" @selected="finalizeOrder(item, index)" v-if="item.status_id!= 4"></vue-step>
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
                  <rate :length="5" v-model="item.client.score" :disabled="true"/>
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
                <div class="col-12">
                  <hr>
                </div>
                <div class="col-12 text-right">
                  <a href="#" class="btn btn-outline-info btn-sm" @click.prevent="takeOrder(item, index)" v-if="item.status_id == 1">
                    Tomar mandado
                  </a>
                  <a href="#" class="btn btn-outline-info btn-sm" @click.prevent="finalizeOrder(item, index)" v-if="item.status_id == 2">
                    Finalizar
                  </a>
                </div>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <div class="no-items-found text-center mt-5" v-if="!loading && !orders.length > 0">
      <i class="fas fa-motorcycle fa-3x text-muted"></i>
      <p class="mb-0 mt-3"><strong>No existe ningun mandado nuevo</strong></p>
      <p class="text-muted">Revisa mas tarde o da clic en el boton de abajo para refrescar la pantalla</p>
      <a class="btn btn-primary" href="/orders/availables" @click.prevent="getOrders">
        <i class="fa fa-sync mr-1" :class="{'fa-spin': loading}"></i>Refrescar
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
      orders: [],
      listStatus: [],
      userView: {},
      loading: true
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
        return 'https://www.google.com/maps/search/Calle ' + url + ', Hidalgo del Parral, Chih.'
      });
    }
  },
  methods: {
    getOrders () {
      this.loading = true
      axios.get(`/api/orders/availables`)
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
    takeOrder (order, index) {
      axios.put(`/api/orders/takeOrder/${order.id}`)
      .then(response => {
        order.status_id = 2
        this.$toasted.global.error('¡Mandado tomado!')
        //location.href = `/orders/dealer`
      })
      .catch(error => {
        if (error.response.data.errors.finalize) {
          swal({
            title: "¡Finaliza tus mandados!",
            text: "¡Podras tomar mas de un mandado cuando subas de nivel!",
            icon: "warning"
          })
        }
        if (error.response.data.errors.taken) {
          swal({
            title: "¡El mandado ya fue tomado!",
            text: "¡Refresca la lista de mandados para ver lo nuevo!",
            icon: "warning",
            button: "Refrescar"
          })
          .then((value) => {
            if (value) {
              this.getOrders()
            }
          })
        }
      })
    },
    finalizeOrder (order, index) {
      axios.put(`/api/orders/updateStatus/${order.id}`, {'statusId': 3})
      .then(response => {
        this.$toasted.global.error('¡Mandado finalizado!')
        this.getOrders()
      })
    }
  }
}
</script>
