<template>
  <div class="container">
    <div class="row justify-content-md-center">
      <div class="col-md-9 col-xl-7">
        <div class="card-header px-0 mt-2 bg-transparent clearfix">
          <h4 class="float-left pt-2">Edit Profile</h4>
          <div class="card-header-actions mr-1">
            <a class="btn btn-primary" href="#" :disabled="submiting" @click.prevent="updateAuthUser">
              <i class="fas fa-spinner fa-spin" v-if="submiting"></i>
              <i class="fas fa-check" v-else></i>
              <span class="ml-1">Save</span>
            </a>
          </div>
        </div>
        <div class="card-body px-0">
          <form class="form-horizontal" v-if="!loading">
            <div class="form-group row justify-content-md-center">
              <div class="col-md-3">Avatar</div>
              <div class="col-md-9">
                <small class="form-text text-muted mb-3">You can change your avatar here or remove the current avatar</small>
                <avatar :user="user"></avatar>
              </div>
            </div>
            <hr class="my-3">
            <div class="form-group row justify-content-md-center">
              <label class="col-md-3">Full Name</label>
              <div class="col-md-9">
                <input class="form-control" :class="{'is-invalid': errors.name}" type="text" v-model="user.name">
                <small class="form-text text-muted">Enter your name, so people you know can recognize you.</small>
                <div class="invalid-feedback" v-if="errors.name">{{errors.name[0]}}</div>
              </div>
            </div>
            <div class="form-group row justify-content-md-center">
              <label class="col-md-3">Email</label>
              <div class="col-md-9">
                <input class="form-control" :class="{'is-invalid': errors.email}" type="email" v-model="user.email">
                <small class="form-text text-muted">This email will be displayed on your public profile.</small>
                <div class="invalid-feedback" v-if="errors.email">{{errors.email[0]}}</div>
              </div>
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
