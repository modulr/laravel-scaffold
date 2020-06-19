<template>
  <div class="container">
    <div class="row justify-content-md-center">
      <div class="col-md-9 col-xl-7">
        <div class="card-header px-0 mt-2 bg-transparent clearfix">
          <h4 class="float-left pt-2">Editar Tienda</h4>
          <div class="card-header-actions mr-1">
            <a class="card-header-action mr-2" href="#" :disabled="submitingDestroy" @click.prevent="destroy">
              <i class="fas fa-spinner fa-spin" v-if="submitingDestroy"></i>
              <i class="far fa-trash-alt" v-else></i>
              <span class="d-md-down-none ml-1">Borrar</span>
            </a>
            <a class="btn btn-primary" href="#" :disabled="submiting" @click.prevent="update">
              <i class="fas fa-spinner fa-spin" v-if="submiting"></i>
              <i class="fas fa-check" v-else></i>
              <span class="ml-1">Guardar</span>
            </a>
          </div>
        </div>
        <div class="card-body px-0">
          <div class="form-group row justify-content-md-center">
            <div class="col-md-9 text-center">
              <stores-banner :user="user"></stores-banner>
              <stores-avatar :user="user"></stores-avatar>
            </div>
          </div>
          <div class="row" v-if="!loading">
            <div class="col-md-12">
              <div class="form-group">
                <label>Tienda *</label>
                <input type="text" class="form-control" :class="{'is-invalid': errors.name}" v-model="user.name" placeholder="Pollo Feliz">
                <div class="invalid-feedback" v-if="errors.name">{{errors.name[0]}}</div>
              </div>
              <div class="form-group">
                <label>Correo electrónico *</label>
                <input type="email" class="form-control" :class="{'is-invalid': errors.email}" v-model="user.email" placeholder="john@modulr.io">
                <div class="invalid-feedback" v-if="errors.email">{{errors.email[0]}}</div>
              </div>
              <div class="form-group">
                <label>Cambiar contraseña</label>
                <input type="password" class="form-control" :class="{'is-invalid': errors.password}" v-model="user.password">
                <div class="invalid-feedback" v-if="errors.password">{{errors.password[0]}}</div>
              </div>
              <div class="form-group">
                <label>Dirección</label>
                <input type="text" class="form-control" :class="{'is-invalid': errors.address}" v-model="user.address" placeholder="Av. Boulevard #15, col. Centro">
                <div class="invalid-feedback" v-if="errors.address">{{errors.address[0]}}</div>
              </div>
              <div class="form-group">
                <label>Horario</label>
                <input type="text" class="form-control" :class="{'is-invalid': errors.schedule}" v-model="user.schedule" placeholder="8:00am - 10:00pm">
                <div class="invalid-feedback" v-if="errors.schedule">{{errors.schedule[0]}}</div>
              </div>
              <div class="form-group">
                <label>Descripción</label>
                <textarea class="form-control" rows="3" v-model="user.description" placeholder="Pollos y más"></textarea>
                <div class="invalid-feedback" v-if="errors.description">{{errors.description[0]}}</div>
              </div>
              <div class="form-group">
                <label>Teléfono</label>
                <input type="text" class="form-control" :class="{'is-invalid': errors.phone}" v-model="user.phone" placeholder="5230034">
                <div class="invalid-feedback" v-if="errors.phone">{{errors.phone[0]}}</div>
              </div>
              <div class="form-group">
                <label>Celular</label>
                <input type="text" class="form-control" :class="{'is-invalid': errors.cellphone}" v-model="user.cellphone" placeholder="6271012233">
                <div class="invalid-feedback" v-if="errors.cellphone">{{errors.cellphone[0]}}</div>
              </div>
              <div class="form-group">
                <label>Categorias</label>
                <multiselect
                  v-model="user.tags"
                  :options="categories"
                  :multiple="true"
                  openDirection="bottom"
                  :class="{'border border-danger rounded': errors.roles}">
                </multiselect>
                <div class="invalid-feedback" v-if="errors.tags">{{errors.tags[0]}}</div>
              </div>
              <div class="form-group">
                <label>Paquete Publicidad *</label>
                <input type="text" class="form-control" :class="{'is-invalid': errors.level}" v-model="user.level" placeholder="0, 1, 2, 3">
                <div class="invalid-feedback" v-if="errors.level">{{errors.level[0]}}</div>
              </div>
              <div class="form-group">
                <label>Pagina Web</label>
                <input type="text" class="form-control" :class="{'is-invalid': errors.web}" v-model="user.web" placeholder="http://www.tacos-chu.com">
                <div class="invalid-feedback" v-if="errors.web">{{errors.web[0]}}</div>
              </div>
              <div class="form-group">
                <label>Facebook</label>
                <input type="text" class="form-control" :class="{'is-invalid': errors.facebook}" v-model="user.facebook" placeholder="facebook.com/profile">
                <div class="invalid-feedback" v-if="errors.facebook">{{errors.link[0]}}</div>
              </div>
              <div class="form-group">
                <label>Instagram</label>
                <input type="text" class="form-control" :class="{'is-invalid': errors.instagram}" v-model="user.instagram" placeholder="instagram.com/profile">
                <div class="invalid-feedback" v-if="errors.instagram">{{errors.link[0]}}</div>
              </div>
              <div class="form-group">
                <label>Otro Link</label>
                <input type="text" class="form-control" :class="{'is-invalid': errors.link}" v-model="user.link" placeholder="www.otrolink.com">
                <div class="invalid-feedback" v-if="errors.link">{{errors.link[0]}}</div>
              </div>
              <div class="form-group">
                <label class="col-form-label">Registrado</label>
                <p class="form-control-plaintext text-muted">{{user.created_at | moment("LLL")}}</p>
              </div>
            </div>
          </div>
          <div class="row" v-else>
            <div class="col-md-12">
              <content-placeholders>
                <content-placeholders-text/>
              </content-placeholders>
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
      user: {},
      categories: [
        'Belleza',
        'Comida',
        'Postres',
        'Recibos',
        'Super',
        'Licores',
        'Paquetes',
        'Farmacia',
        'Tacos',
        'Hamburguesas',
        'Pizza',
        'Sushi',
        'Gorditas',
        'Tortas',
        'Lonches',
        'Flautas',
        'Quesadillas',
        'Tripitas',
        'Otro'
      ],
      errors: {},
      loading: true,
      submiting: false,
      submitingDestroy: false
    }
  },
  mounted () {
    this.getUser()
  },
  methods: {
    getUser() {
      this.loading = true
      let str = window.location.pathname
      let res = str.split("/")
      axios.get(`/api/stores/${res[2]}`)
      .then(response => {
        this.user = response.data
      })
      .catch(error => {
        this.$toasted.global.error('¡La tienda no existe!')
        location.href = '/stores'
      })
      .then(() => {
        this.loading = false
      })
    },
    update () {
      if (!this.submiting) {
        this.submiting = true
        axios.put(`/api/stores/update/${this.user.id}`, this.user)
        .then(response => {
          this.$toasted.global.error('¡Tienda actualizada!')
          location.href = '/stores'
        })
        .catch(error => {
          this.errors = error.response.data.errors
          this.submiting = false
        })
      }
    },
    destroy () {
      if (!this.submitingDestroy) {
        this.submitingDestroy = true
        swal({
          title: "¿Estas seguro?",
          text: "¡Se borrara como tienda y seguira como cliente!",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            axios.delete(`/api/stores/${this.user.id}`)
            .then(response => {
              this.$toasted.global.error('¡Tienda Borrada!')
              location.href = '/stores'
            })
            .catch(error => {
              this.errors = error.response.data.errors
            })
          }
          this.submitingDestroy = false
        })
      }
    }
  }
}
</script>
