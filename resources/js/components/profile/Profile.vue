<template>
  <div class="container">
    <div class="row justify-content-md-center">
      <div class="col-md-9 col-xl-7">
        <div class="card-body px-0 pt-5">
          <form class="form-horizontal" v-if="!loading">
            <div class="form-group row justify-content-md-center">
              <div class="col-md-9 text-center">
                <profile-avatar :user="user"></profile-avatar>
              </div>
            </div>
            <div class="form-group row justify-content-md-center">
              <label class="col-md-3">Nombre</label>
              <div class="col-md-9">
                <input type="text" class="form-control" :class="{'is-invalid': errors.name}" v-model="user.name" placeholder="Juan Perez">
                <div class="invalid-feedback" v-if="errors.name">{{errors.name[0]}}</div>
              </div>
            </div>
            <div class="form-group row justify-content-md-center">
              <label class="col-md-3">Correo electrónico</label>
              <div class="col-md-9">
                <input type="email" class="form-control" :class="{'is-invalid': errors.email}" v-model="user.email" placeholder="juan@traeme.app">
                <div class="invalid-feedback" v-if="errors.email">{{errors.email[0]}}</div>
              </div>
            </div>
            <div class="form-group row justify-content-md-center">
              <label class="col-md-3">Teléfono celular</label>
              <div class="col-md-9">
                <input type="tel" class="form-control" :class="{'is-invalid': errors.cellphone}" v-model="user.cellphone" placeholder="6271012345">
                <div class="invalid-feedback" v-if="errors.cellphone">{{errors.cellphone[0]}}</div>
              </div>
            </div>
            <div class="form-group row justify-content-md-center">
              <label class="col-md-3">Descripción</label>
              <div class="col-md-9">
                <textarea class="form-control" rows="3" placeholder="¡Cuentanos algo sobre ti!" v-model="user.description"></textarea>
              </div>
            </div>
            <div class="text-center">
              <a class="btn btn-primary mt-2" href="#" :disabled="submiting" @click.prevent="updateAuthUser">
                <i class="fas fa-spinner fa-spin" v-if="submiting"></i>
                <i class="fas fa-check" v-else></i>
                <span class="ml-1">Guardar</span>
              </a>
            </div>
          </form>
          <div class="row justify-content-md-center" v-else>
            <div class="col-md-12">
              <content-placeholders>
                <content-placeholders-heading :img="true"/>
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
import avatar from './Avatar.vue'

export default {
  data () {
    return {
      user: {},
      errors: {},
      loading: true,
      submiting: false
    }
  },
  components: {
    avatar
  },
  mounted () {
    this.getAuthUser()
  },
  methods: {
    getAuthUser () {
      this.loading = true
      axios.get(`/api/profile/getAuthUser`)
      .then(response => {
        this.user = response.data
        this.loading = false
      })
    },
    updateAuthUser () {
      if (!this.submiting) {
        this.submiting = true
        axios.put(`/api/profile/updateAuthUser`, this.user)
        .then(response => {
          this.errors = {}
          this.submiting = false
          this.$toasted.global.error('Profile updated!');
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
