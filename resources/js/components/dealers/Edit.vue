<template>
  <div class="container">
    <div class="row justify-content-md-center">
      <div class="col-md-9 col-xl-7">
        <div class="card-header px-0 mt-2 bg-transparent clearfix">
          <h4 class="float-left pt-2">Editar Repartidor</h4>
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
              <dealers-avatar :user="user"></dealers-avatar>
            </div>
          </div>
          <div class="row" v-if="!loading">
            <div class="col-md-12">
              <div class="form-group">
                <form class="form-horizontal" @click="activeToggle">
                  <div class="form-group row">
                    <label class="col-3">{{activeText}}</label>
                    <div class="col-9">
                      <label class="switch switch-3d switch-primary float-right mb-0">
                        <input class="switch-input" type="checkbox" v-model="user.active">
                        <span class="switch-slider"></span>
                      </label>
                    </div>
                  </div>
                </form>
              </div>
              <div class="form-group">
                <label>Nombre</label>
                <input type="text" class="form-control" :class="{'is-invalid': errors.name}" v-model="user.name" placeholder="John Doe">
                <div class="invalid-feedback" v-if="errors.name">{{errors.name[0]}}</div>
              </div>
              <div class="form-group">
                <label>Correo electrónico</label>
                <input type="email" class="form-control" :class="{'is-invalid': errors.email}" v-model="user.email" placeholder="john@modulr.io">
                <div class="invalid-feedback" v-if="errors.email">{{errors.email[0]}}</div>
              </div>
              <div class="form-group">
                <label>Celular</label>
                <input type="tel" class="form-control" :class="{'is-invalid': errors.cellphone}" v-model="user.cellphone" placeholder="6271012345">
                <div class="invalid-feedback" v-if="errors.cellphone">{{errors.cellphone[0]}}</div>
              </div>
              <div class="form-group">
                <label>Ganancia %</label>
                <input type="text" class="form-control" :class="{'is-invalid': errors.profit}" v-model="user.profit" placeholder="70">
                <div class="invalid-feedback" v-if="errors.profit">{{errors.profit[0]}}</div>
              </div>
              <div class="form-group">
                <label>Cambiar contraseña</label>
                <input type="password" class="form-control" :class="{'is-invalid': errors.password}" v-model="user.password">
                <div class="invalid-feedback" v-if="errors.password">{{errors.password[0]}}</div>
              </div>
              <div class="form-group">
                <label>Descripción</label>
                <textarea class="form-control" rows="3" placeholder="About" v-model="user.description"></textarea>
                <div class="invalid-feedback" v-if="errors.description">{{errors.description[0]}}</div>
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
      activeText: 'Desactivo',
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
      axios.get(`/api/dealers/${res[2]}`)
      .then(response => {
        this.user = response.data
        if (this.user.active) {
          this.activeText = 'Activo'
        } else {
          this.activeText = 'Desactivo'
        }
      })
      .catch(error => {
        this.$toasted.global.error('¡La tienda no existe!')
        location.href = '/dealers'
      })
      .then(() => {
        this.loading = false
      })
    },
    update () {
      if (!this.submiting) {
        this.submiting = true
        axios.put(`/api/dealers/update/${this.user.id}`, this.user)
        .then(response => {
          this.$toasted.global.error('Repartidor actualizado!')
          location.href = '/dealers'
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
          text: "¡Se borrara como repartidor y seguira como cliente!",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            axios.delete(`/api/dealers/${this.user.id}`)
            .then(response => {
              this.$toasted.global.error('¡Repartidor Borrado!')
              location.href = '/dealers'
            })
            .catch(error => {
              this.errors = error.response.data.errors
            })
          }
          this.submitingDestroy = false
        })
      }
    },
    activeToggle () {
      if (this.activeText != 'Loading...') {
        this.activeText = 'Loading...'
        axios.post(`/api/dealers/activeToggle`, this.user)
        .then(response => {
          this.currentUser = response.data
          if (this.currentUser.active) {
            this.activeText = 'Activo'
            this.$toasted.global.error('Activado!')
          } else {
            this.activeText = 'Desactivo'
            this.$toasted.global.error('Desactivado!')
          }
        })
      }
    }
  }
}
</script>
