<template>
  <div class="container">
    <div class="row justify-content-md-center">
      <div class="col-md-9 col-xl-7">
        <div class="card-header px-0 mt-2 bg-transparent clearfix">
          <h4 class="float-left pt-2">Edit Password</h4>
          <div class="card-header-actions mr-1">
            <a class="btn btn-primary" href="#" :disabled="submiting" @click.prevent="updatePasswordAuthUser">
              <i class="fas fa-spinner fa-spin" v-if="submiting"></i>
              <i class="fas fa-check" v-else></i>
              <span class="ml-1">Save</span>
            </a>
          </div>
        </div>
        <div class="card-body px-0">
          <form class="form-horizontal">
            <div class="form-group row justify-content-md-center">
              <label class="col-md-3">Current password</label>
              <div class="col-md-9">
                <input class="form-control" :class="{'is-invalid': errors.current}" type="password" v-model="password.current">
                <small class="form-text text-muted">You must provide your current password in order to change it.</small>
                <div class="invalid-feedback" v-if="errors.current">{{errors.current[0]}}</div>
              </div>
            </div>
            <div class="form-group row justify-content-md-center">
              <label class="col-md-3">New password</label>
              <div class="col-md-9">
                <input class="form-control" :class="{'is-invalid': errors.password}" type="password" v-model="password.password">
                <div class="invalid-feedback" v-if="errors.password">{{errors.password[0]}}</div>
              </div>
            </div>
            <div class="form-group row justify-content-md-center">
              <label class="col-md-3">Password confirmation</label>
              <div class="col-md-9">
                <input class="form-control" :class="{'is-invalid': errors.password_confirmation}" type="password" v-model="password.password_confirmation">
                <div class="invalid-feedback" v-if="errors.password_confirmation">{{errors.password_confirmation[0]}}</div>
              </div>
            </div>
          </form>
        </div>
      </div>
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
