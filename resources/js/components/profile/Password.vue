<template>
  <div>
    <ol class="breadcrumb">
      <li class="breadcrumb-item">Profile</li>
      <li class="breadcrumb-item active">Edit Password</li>
      <li class="breadcrumb-menu">
        <a class="btn btn-outline-primary text-primary" href="#" :disabled="submiting" @click="updatePasswordAuthUser">
          <i class="fas fa-spinner fa-spin" v-if="submiting"></i>
          <i class="far fa-save d-lg-none"></i>
          <span class="d-md-down-none ml-1">Change password</span>
        </a>
      </li>
    </ol>
    <div class="card-body">
      <form class="form-horizontal">
        <div class="form-group row">
          <label class="col-md-3">Current password</label>
          <div class="col-md-9">
            <input class="form-control" :class="{'is-invalid': errors.current}" type="password" v-model="password.current">
            <small class="form-text text-muted">You must provide your current password in order to change it.</small>
            <div class="invalid-feedback" v-if="errors.current">{{errors.current[0]}}</div>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-md-3">New password</label>
          <div class="col-md-9">
            <input class="form-control" :class="{'is-invalid': errors.password}" type="password" v-model="password.password">
            <div class="invalid-feedback" v-if="errors.password">{{errors.password[0]}}</div>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-md-3">Password confirmation</label>
          <div class="col-md-9">
            <input class="form-control" :class="{'is-invalid': errors.password_confirmation}" type="password" v-model="password.password_confirmation">
            <div class="invalid-feedback" v-if="errors.password_confirmation">{{errors.password_confirmation[0]}}</div>
          </div>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
export default {
  data () {
    return {
      password: {},
      errors: {},
      submiting: false
    }
  },
  methods: {
    updatePasswordAuthUser () {
      if (!this.submiting) {
        this.submiting = true
        axios.put(`/api/profile/updatePasswordAuthUser`, this.password)
        .then(response => {
          this.password = {}
          this.errors = {}
          this.submiting = false
          this.$toasted.global.error('Password changed!');
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
