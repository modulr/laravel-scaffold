<template lang="html">
  <div>
    <div>
      <div class="card-header px-0 mt-2 bg-transparent clearfix">
        <div class="row">
          <div class="col">
            <h4 class="pt-2">Tiendas</h4>
          </div>
          <div class="col text-right">
            <input type="text" class="form-control" placeholder="Buscar" v-model.trim="filters.search" @keyup="getStores">
          </div>
          <div class="col text-right">
            <a class="btn btn-primary" href="#" @click.prevent="create">
              <i class="fa fa-plus"></i>
              <span class="d-md-down-none ml-1">Crear</span>
            </a>
          </div>
        </div>
      </div>
      <div class="card-body px-0">
        <content-placeholders v-if="loading">
          <content-placeholders-text :lines="6"/>
        </content-placeholders>
        <ul class="list-group mb-1" v-for="(item, index) in stores" v-else>
          <li class="list-group-item">
            <div class="row">
              <div class="col">
                <small class="text-muted">Tienda: {{item.id}}</small>
              </div>
              <div class="col text-right">
                <rate :length="5" v-model="item.score" @after-rate="updateScore(item, index)"/>
              </div>
              <div class="col-12">
                <hr class="mt-1 mb-2">
              </div>
              <div class="col-12">
                <h5 class="mb-1" @click.prevent="edit(item, index)">{{item.store}}</h5>
                <div class="mb-2" @click.prevent="edit(item, index)">
                  <small class="description" v-if="item.description">{{item.description}}</small>
                </div>
                <div>
                  <span class="small mr-3" v-if="item.address">
                    <i class="icon-location-pin mr-2"></i>{{item.address}}
                  </span>
                </div>
                <a :href="item.web" target="_blank" class="small text-muted mr-3" v-if="item.web">
                  <i class="icon-link mr-2"></i>{{item.web}}
                </a>
                <a :href="item.link" target="_blank" class="small text-muted mr-3" v-if="item.link">
                  <i class="icon-link mr-2"></i>{{item.link}}
                </a>
              </div>
              <div class="col-12">
                <hr>
              </div>
              <div class="col" v-if="item.cellphone">
                <small class="text-muted">Celular</small>
                <br>
                <a class="text-info" :href="`tel:+52${item.cellphone}`">
                  <i class="fas fa-mobile-alt mr-1"></i>{{item.cellphone}}
                </a>
                <br>
                <a class="btn btn-outline-primary btn-sm mt-2" :href="`https://api.whatsapp.com/send?phone=52${item.cellphone}`" target="_blank">
                  <i class="fab fa-whatsapp mr-1"></i>WhatsApp
                </a>
              </div>
              <div class="col text-right">
                <small class="text-muted">Teléfono</small>
                <br>
                <a class="text-info" :href="`tel:+52${item.phone}`">
                  {{item.phone}}
                </a>
                <div class="mt-2">
                  <a class="text-muted" href="#" @click.prevent="edit(item, index)">
                    <i class="fas fa-pencil-alt"></i>
                  </a>
                </div>
              </div>
            </div>
          </li>
        </ul>
      </div>
    </div>
    <div class="no-items-found text-center mt-5" v-if="!loading && !stores.length > 0">
      <i class="icon-magnifier fa-3x text-muted"></i>
      <p class="mb-0 mt-3"><strong>No existe ninguna tienda</strong></p>
      <p class="text-muted">Crea una dando clic en el boton de abajo</p>
      <a class="btn btn-primary" href="#" @click.prevent="create">
        <i class="fa fa-plus mr-1"></i>Crear
      </a>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="storeModal" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Crear tienda</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label>Nombre *</label>
              <input type="text" class="form-control" :class="{'is-invalid': errors.store}" placeholder="Tacos de Chu" v-model="store.store" @keyup.enter="save">
              <div class="invalid-feedback" v-if="errors.store">{{errors.store[0]}}</div>
            </div>
            <div class="form-group">
              <label>Teléfono *</label>
              <input type="text" class="form-control" :class="{'is-invalid': errors.phone}" placeholder="5230034" v-model="store.phone" @keyup.enter="save">
              <div class="invalid-feedback" v-if="errors.phone">{{errors.phone[0]}}</div>
            </div>
            <div class="form-group">
              <label>Celular</label>
              <input type="text" class="form-control" :class="{'is-invalid': errors.cellphone}" placeholder="6271012233" v-model="store.cellphone" @keyup.enter="save">
              <div class="invalid-feedback" v-if="errors.cellphone">{{errors.cellphone[0]}}</div>
            </div>
            <div class="form-group">
              <label>Dirección</label>
              <input type="text" class="form-control" :class="{'is-invalid': errors.address}" placeholder="Av. Boulevard #15, col. Centro" v-model="store.address" @keyup.enter="save">
              <div class="invalid-feedback" v-if="errors.address">{{errors.address[0]}}</div>
            </div>
            <div class="form-group">
              <label>Descripción</label>
              <textarea class="form-control" rows="3" placeholder="Descripción de la tienda" v-model="store.description" :class="{'is-invalid': errors.description}"></textarea>
              <div class="invalid-feedback" v-if="errors.description">{{errors.description[0]}}</div>
            </div>
            <div class="form-group">
              <label>Pagina Web</label>
              <input type="text" class="form-control" :class="{'is-invalid': errors.web}" placeholder="http://www.tacos-chu.com" v-model="store.web" @keyup.enter="save">
              <div class="invalid-feedback" v-if="errors.web">{{errors.web[0]}}</div>
            </div>
            <div class="form-group">
              <label>Otro Link</label>
              <input type="text" class="form-control" :class="{'is-invalid': errors.link}" placeholder="Facebook" v-model="store.link" @keyup.enter="save">
              <div class="invalid-feedback" v-if="errors.link">{{errors.link[0]}}</div>
            </div>
          </div>
          <div class="modal-footer">
            <a class="btn btn-primary" href="#"
              :disabled="submiting"
              @click.prevent="save">
              <i class="fas fa-spinner fa-spin" v-if="submiting"></i>
              <i class="fas fa-check" v-else></i>
              <span class="ml-1">Guardar</span>
            </a>
            <a class="card-header-action ml-1" href="#"
              :disabled="submitingDestroy"
              v-if="store.id"
              @click.prevent="destroy">
              <i class="fas fa-spinner fa-spin" v-if="submitingDestroy"></i>
              <i class="far fa-trash-alt" v-else></i>
              <span class="d-md-down-none ml-1">Borrar</span>
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
      stores: [],
      store: {},
      loading: true,
      submiting: false,
      submitingDestroy: false,
      errors: {},
      filters: {
        search: ''
      }
    }
  },
  mounted () {
    this.getStores()
  },
  methods: {
    getStores () {
      this.loading = true
      this.stores = []
      axios.post(`/api/stores/filter`, this.filters)
      .then(response => {
        this.stores = response.data
        this.loading = false
      })
    },
    create () {
      this.store = {}
      this.errors = {}
      $('#storeModal').modal('show')
    },
    edit (item, index) {
      this.store = item
      this.store.index = index
      this.errors = {}
      $('#storeModal').modal('show')
    },
    save () {
      if (!this.submiting) {
        this.submiting = true
        if (this.store.id) {
          axios.put(`/api/stores/update/${this.store.id}`, this.store)
          .then(response => {
            this.stores[this.store.index] = response.data
            this.submiting = false
            $('#storeModal').modal('hide')
            this.$toasted.global.error('¡Tienda actualizada!')
          })
          .catch(error => {
            this.errors = error.response.data.errors
            this.submiting = false
          })
        } else {
          axios.post(`/api/stores/store`, this.store)
          .then(response => {
            this.stores.unshift(response.data)
            this.submiting = false
            $('#storeModal').modal('hide')
            this.$toasted.global.error('¡Tienda creada!')
          })
          .catch(error => {
            this.errors = error.response.data.errors
            this.submiting = false
          })
        }
      }
    },
    destroy () {
      if (!this.submitingDestroy) {
        this.submitingDestroy = true
        swal({
          title: "¿Estas seguro?",
          text: "Una vez borrada la tienda ya no podras consultarla",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            axios.delete(`/api/stores/${this.store.id}`)
            .then(response => {
              this.stores.splice(this.store.index, 1);
              $('#storeModal').modal('hide')
              this.$toasted.global.error('¡Tienda borrada!')
            })
            .catch(error => {
              this.errors = error.response.data.errors
            })
          }
          this.submitingDestroy = false
        })
      }
    },
    updateScore (item, index) {
      axios.put(`/api/stores/updateScore/${item.id}`, {'score': item.score})
      .then(response => {
        this.stores[index].score = response.data.score
        this.$toasted.global.error('¡Tienda calificada!')
      })
    }
  }
}
</script>
