<template>
  <div>
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="/users">
          <i class="fa fa-chevron-left mr-1"></i>
          Users
        </a>
      </li>
      <li class="breadcrumb-item active">New</li>
      <li class="breadcrumb-menu">
        <a class="btn btn-outline-primary text-primary" href="#" :disabled="submiting" @click="create">
          <i class="fas fa-spinner fa-spin" v-if="submiting"></i>
          <i class="far fa-save d-lg-none"></i>
          <span class="d-md-down-none ml-1">Create user</span>
        </a>
      </li>
    </ol>
    <div class="container">
      <div class="card-body">
        <form class="form-horizontal">
          <div class="form-group row">
            <label class="col-md-3 text-md-right">Full Name</label>
            <div class="col-md-7">
              <input class="form-control" :class="{'is-invalid': errors.name}" type="text" v-model="user.name" placeholder="John Doe">
              <div class="invalid-feedback" v-if="errors.name">{{errors.name[0]}}</div>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-md-3 text-md-right">Email</label>
            <div class="col-md-7">
              <input class="form-control" :class="{'is-invalid': errors.email}" type="email" v-model="user.email" placeholder="john@modulr.io">
              <div class="invalid-feedback" v-if="errors.email">{{errors.email[0]}}</div>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-md-3 text-md-right">Password</label>
            <div class="col-md-7">
              <input class="form-control" :class="{'is-invalid': errors.password}" type="password" v-model="user.password">
              <div class="invalid-feedback" v-if="errors.password">{{errors.password[0]}}</div>
            </div>
          </div>
        </form>
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
      if (!this.submiting) {
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
}
</script>
