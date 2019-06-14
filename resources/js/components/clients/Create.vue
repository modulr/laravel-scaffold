<template>
  <div class="container">
    <div class="row justify-content-md-center">
      <div class="col-md-9 col-xl-7">
        <div class="card-header px-0 mt-2 bg-transparent clearfix">
          <h4 class="float-left pt-2">Nuevo Cliente</h4>
          <div class="card-header-actions mr-1">
            <a class="btn btn-primary" href="#" :disabled="submiting" @click.prevent="create">
              <i class="fas fa-spinner fa-spin" v-if="submiting"></i>
              <i class="fas fa-check" v-else></i>
              <span class="ml-1">Guardar</span>
            </a>
          </div>
        </div>
        <div class="card-body px-0">
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
            <label>Cellphone</label>
            <input type="tel" class="form-control" :class="{'is-invalid': errors.cellphone}" v-model="user.cellphone" placeholder="6271012345">
            <div class="invalid-feedback" v-if="errors.cellphone">{{errors.cellphone[0]}}</div>
          </div>
          <div class="form-group">
            <label>Descripción</label>
            <textarea class="form-control" rows="3" placeholder="About" v-model="user.description"></textarea>
            <div class="invalid-feedback" v-if="errors.description">{{errors.description[0]}}</div>
          </div>
          <div class="form-group">
            <label>Contraseña</label>
            <input type="password" class="form-control" :class="{'is-invalid': errors.password}" v-model="user.password">
            <div class="invalid-feedback" v-if="errors.password">{{errors.password[0]}}</div>
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
      user: {
        roles: [{name: 'user', display_name: 'Cliente'}]
      },
      errors: {},
      submiting: false
    }
  },
  methods: {
    create () {
      if (!this.submiting) {
        this.submiting = true
        axios.post(`/api/clients/store`, this.user)
        .then(response => {
          this.$toasted.global.error('Cliente creado!')
          location.href = '/clients'
        })
        .catch(error => {
          this.errors = error.response.data.errors
          this.submiting = false
        })
      }
    }
  }
}
</script>
