<template>
  <div>
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="/users">Users</a>
      </li>
      <li class="breadcrumb-item active">Edit User</li>
      <li class="breadcrumb-menu">
        <a class="btn btn-outline-primary text-primary" href="#" :disabled="submiting" @click="update" >
          <i class="fas fa-spinner fa-spin mr-1" v-if="submiting"></i>Save changes
        </a>
        <a class="btn" href="#" :disabled="submitingDestroy" @click="destroy">
          <i class="fas fa-spinner fa-spin" v-if="submitingDestroy"></i>
          <i class="far fa-trash-alt" v-if="!submitingDestroy"></i>
          <span class="d-md-down-none ml-1"> Delete</span>
        </a>
      </li>
    </ol>
    <div class="container">
      <div class="card-body">
        <form class="form-horizontal" v-if="!loading">
          <div class="form-group row">
            <label class="col-md-3 text-md-right">ID</label>
            <div class="col-md-9 col-xl-7">
              <input class="form-control" type="text" v-model="user.id" readonly>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-md-3 text-md-right">Full Name</label>
            <div class="col-md-9 col-xl-7">
              <input class="form-control" :class="{'is-invalid': errors.name}" type="text" v-model="user.name" placeholder="John Doe">
              <div class="invalid-feedback" v-if="errors.name">{{errors.name[0]}}</div>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-md-3 text-md-right">Email</label>
            <div class="col-md-9 col-xl-7">
              <input class="form-control" :class="{'is-invalid': errors.email}" type="email" v-model="user.email" placeholder="john@modulr.io">
              <div class="invalid-feedback" v-if="errors.email">{{errors.email[0]}}</div>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-md-3 text-md-right">Password</label>
            <div class="col-md-9 col-xl-7">
              <input class="form-control" :class="{'is-invalid': errors.password}" type="password" v-model="user.password">
              <div class="invalid-feedback" v-if="errors.password">{{errors.password[0]}}</div>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">Registered</label>
            <div class="col-md-9 col-xl-7">
              <p class="form-control-plaintext text-muted">{{user.created_at | moment("LLL")}}</p>
            </div>
          </div>
        </form>
        <content-placeholders v-else>
          <content-placeholders-text/>
        </content-placeholders>
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
      loading: true,
      submiting: false,
      submitingDestroy: false
    }
  },
  mounted () {
    this.getUser()
  },
  methods: {
    getUser() {
      this.loading = true
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
      .then(() => {
        this.loading = false
      })
    },
    update () {
      if (!this.submiting) {
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
      }
    },
    destroy () {
      if (!this.submitingDestroy) {
        this.submitingDestroy = true
        swal({
          title: "Are you sure?",
          text: "Once deleted, you will not be able to recover this user!",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            axios.delete(`/api/users/${this.user.id}`)
            .then(response => {
              this.$toasted.global.error('Deleted user!')
              location.href = '/users'
            })
            .catch(error => {
              this.errors = error.response.data.errors
            })
          }
          this.submitingDestroy = false
        })
      }
    }
  }
}
</script>
