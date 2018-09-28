<template>
  <div class="card">
      <div class="card-header">
        <i class="fas fa-pencil-alt"></i> Edit Profile
      </div>
      <div class="card-body">
        <form class="form-horizontal">
          <div class="form-group row mb-4">
            <div class="col-md-3">Avatar</div>
            <div class="col-md-9">
              <small class="form-text text-muted mb-3">You can change your avatar here or remove the current avatar</small>
              <avatar :user="user"></avatar>
            </div>
          </div>
          <hr>
          <div class="form-group row">
            <label class="col-md-3">Full Name</label>
            <div class="col-md-9">
              <input class="form-control" :class="{'is-invalid': errors.name}" type="text" v-model="user.name">
              <small class="form-text text-muted">Enter your name, so people you know can recognize you.</small>
              <div class="invalid-feedback" v-if="errors.name">{{errors.name[0]}}</div>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-md-3">Email</label>
            <div class="col-md-9">
              <input class="form-control" :class="{'is-invalid': errors.email}" type="email" v-model="user.email">
              <small class="form-text text-muted">This email will be displayed on your public profile.</small>
              <div class="invalid-feedback" v-if="errors.email">{{errors.email[0]}}</div>
            </div>
          </div>
        </form>
      </div>
      <div class="card-footer">
        <div class="form-group row">
          <div class="col-md-9 offset-md-3">
            <button class="btn btn-primary" type="button" :disabled="submiting" @click="updateAuthUser" >
              <i class="fas fa-spinner fa-spin" v-if="submiting"></i> Save profile
            </button>
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
      submiting: false,
      submitingRemove: false,
      optionsAvatar: {
        headers: {'X-CSRF-TOKEN': Laravel.csrfToken},
        url: '/api/profile/uploadAvatarAuthUser',
        paramName: 'file',
        parallelUploads: 1,
        maxFilesize: {
          limit: 1,
          message: '{{filesize}} is greater than the {{maxFilesize}}MB'
        },
        acceptedFiles: {
          extensions: ['image/*'],
          message: 'You are uploading an invalid file'
        }
      }
    }
  },
  components: {
    avatar
  },
  mounted() {
    this.getAuthUser()
  },
  methods: {
    getAuthUser () {
      axios.get(`/api/profile/getAuthUser`)
      .then(response => {
        this.user = response.data
      })
    },
    updateAuthUser () {
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
</script>
