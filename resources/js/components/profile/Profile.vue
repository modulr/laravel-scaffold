<template>
  <div>
    <ol class="breadcrumb">
      <li class="breadcrumb-item">Profile</li>
      <li class="breadcrumb-item active">Edit</li>
      <li class="breadcrumb-menu">
        <a class="btn btn-outline-primary text-primary" href="#" :disabled="submiting" @click="updateAuthUser">
          <i class="fas fa-spinner fa-spin" v-if="submiting"></i>
          <i class="far fa-save d-lg-none"></i>
          <span class="d-md-down-none ml-1">Save profile</span>
        </a>
      </li>
    </ol>
    <div class="card-body">
      <form class="form-horizontal" v-if="!loading">
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
      <content-placeholders v-else>
        <content-placeholders-heading :img="true"/>
        <content-placeholders-text/>
      </content-placeholders>
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
