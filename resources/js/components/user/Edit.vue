<template>
  <div class="card">
    <div class="card-header">
      <i class="fas fa-pencil-alt"></i> Edit User
      <button class="btn btn-primary float-right" type="button" :disabled="submiting" @click="update" >
        <i class="fas fa-spinner fa-spin" v-if="submiting"></i> Save
      </button>
    </div>
    <div class="card-body">
      <form class="form-horizontal">
        <div class="form-group row">
          <label class="col-md-3">ID</label>
          <div class="col-md-9">
            <input class="form-control" type="text" v-model="user.id" readonly>
          </div>
        </div>
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
        <div class="form-group row">
          <label for="staticEmail" class="col-md-3">Registered</label>
          <div class="col-md-9">
            <p class="form-control-plaintext text-muted">{{user.created_at | moment("LLL")}}</p>
          </div>
        </div>
        <div class="form-group row mt-4">
          <div class="col-md-9 offset-md-3">
            <small class="form-text text-muted mb-2">Removing the user will delete all related resources. Removed user cannot be restored!</small>
            <button class="btn btn-danger" type="button" :disabled="submitingDestroy" @click="destroy">
              <i class="fas fa-spinner fa-spin" v-if="submitingDestroy"></i> Remove user
            </button>
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
      user: {},
      errors: {},
      submiting: false,
      submitingDestroy: false
    }
  },
  mounted () {
    this.getUser()
  },
  methods: {
    getUser() {
      let str = window.location.pathname
      let res = str.split("/")
      axios.get(`/api/users/${res[2]}`)
      .then(response => {
        this.user = response.data
      })
      .catch(error => {
        this.$toasted.global.error('User does not exist!')
        location.href = '/users'
      })
    },
    update () {
      this.submiting = true
      axios.put(`/api/users/update/${this.user.id}`, this.user)
      .then(response => {
        this.$toasted.global.error('Updated user!')
        location.href = '/users'
      })
      .catch(error => {
        this.errors = error.response.data.errors
        this.submiting = false
      })
    },
    destroy () {
      this.submitingDestroy = true
      axios.delete(`/api/users/${this.user.id}`)
      .then(response => {
        this.$toasted.global.error('Deleted user!')
        location.href = '/users'
      })
      .catch(error => {
        this.errors = error.response.data.errors
        this.submitingDestroy = false
      })
    }
  }
}
</script>
