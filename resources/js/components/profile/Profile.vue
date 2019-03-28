<template>
  <div class="container">
    <div class="row justify-content-md-center">
      <div class="col-md-9 col-xl-7">
        <div class="card-body px-0 pt-5">
          <form class="form-horizontal" v-if="!loading">
            <div class="form-group row justify-content-md-center">
              <div class="col-md-9 text-center">
                <avatar :user="user"></avatar>
                <ul class="list-inline text-success mt-3">
                  <li class="list-inline-item"><i class="fas fa-star"></i></li>
                  <li class="list-inline-item"><i class="fas fa-star"></i></li>
                  <li class="list-inline-item"><i class="fas fa-star"></i></li>
                  <li class="list-inline-item"><i class="fas fa-star"></i></li>
                  <li class="list-inline-item"><i class="fas fa-star"></i></li>
                </ul>
              </div>
            </div>
            <div class="form-group row justify-content-md-center">
              <label class="col-md-3">Nombre</label>
              <div class="col-md-9">
                <input class="form-control" :class="{'is-invalid': errors.name}" type="text" v-model="user.name">
                <div class="invalid-feedback" v-if="errors.name">{{errors.name[0]}}</div>
              </div>
            </div>
            <div class="form-group row justify-content-md-center">
              <label class="col-md-3">Correo electrónico</label>
              <div class="col-md-9">
                <input class="form-control" :class="{'is-invalid': errors.email}" type="email" v-model="user.email">
                <div class="invalid-feedback" v-if="errors.email">{{errors.email[0]}}</div>
              </div>
            </div>
            <div class="form-group">
              <label>Descripción</label>
              <textarea class="form-control" rows="3" placeholder="¡Cuentanos algo!"></textarea>
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
