<template>
  <div class="card">
    <div class="card-header">
      <i class="fas fa-plus"></i> New User
    </div>
    <div class="card-body">
      <form class="form-horizontal">
        <div class="form-group row">
          <label class="col-md-3">Full Name</label>
          <div class="col-md-9">
            <input class="form-control" :class="{'is-invalid': errors.name}" type="text" v-model="user.name" placeholder="John Doe">
            <div class="invalid-feedback" v-if="errors.name">{{errors.name[0]}}</div>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-md-3">Email</label>
          <div class="col-md-9">
            <input class="form-control" :class="{'is-invalid': errors.email}" type="email" v-model="user.email" placeholder="john@modulr.io">
            <div class="invalid-feedback" v-if="errors.email">{{errors.email[0]}}</div>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-md-3">Password</label>
          <div class="col-md-9">
            <input class="form-control" :class="{'is-invalid': errors.password}" type="password" v-model="user.password">
            <div class="invalid-feedback" v-if="errors.password">{{errors.password[0]}}</div>
          </div>
        </div>
      </form>
    </div>
    <div class="card-footer">
      <div class="form-group row">
        <div class="col-md-9 offset-md-3">
          <button class="btn btn-primary float-right" type="button" :disabled="submiting" @click="create" >
            <i class="fas fa-spinner fa-spin" v-if="submiting"></i> Save
          </button>
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
      errors: {},
      submiting: false
    }
  },
  methods: {
    create () {
      this.submiting = true
      axios.post(`/api/users/store`, this.user)
      .then(response => {
        this.$toasted.global.error('Created user!')
        location.href = '/users'
      })
      .catch(error => {
        this.errors = error.response.data.errors
        this.submiting = false
      })
    }
  }
}
</script>
