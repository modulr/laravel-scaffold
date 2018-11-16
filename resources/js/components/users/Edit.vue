<template>
  <div>
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="/users">
          <i class="fa fa-chevron-left mr-1"></i>
          Users
        </a>
      </li>
      <li class="breadcrumb-item active">Edit</li>
      <li class="breadcrumb-menu">
        <a class="btn btn-primary" href="#" :disabled="submiting" @click.prevent="update" >
          <i class="fas fa-spinner fa-spin" v-if="submiting"></i>
          <i class="far fa-save" v-else></i>
          <span class="d-md-down-none ml-1">Save changes</span>
        </a>
        <a class="btn btn-link" href="#" :disabled="submitingDestroy" @click.prevent="destroy">
          <i class="fas fa-spinner fa-spin" v-if="submitingDestroy"></i>
          <i class="far fa-trash-alt" v-else></i>
          <span class="d-md-down-none ml-1"> Delete</span>
        </a>
      </li>
    </ol>
    <div class="container">
      <div class="card-body px-0">
        <div class="row justify-content-md-center" v-if="!loading">
          <div class="form-group col-md-9 col-xl-5">
            <label>Full Name</label>
            <input type="text" class="form-control" :class="{'is-invalid': errors.name}" v-model="user.name" placeholder="John Doe">
            <div class="invalid-feedback" v-if="errors.name">{{errors.name[0]}}</div>
          </div>
          <div class="form-group col-md-3 col-xl-2">
            <label>ID</label>
            <input class="form-control" type="text" v-model="user.id" readonly>
          </div>
          <div class="col-md-12 col-xl-7">
            <div class="form-group">
              <label>Email</label>
              <input type="email" class="form-control" :class="{'is-invalid': errors.email}" v-model="user.email" placeholder="john@modulr.io">
              <div class="invalid-feedback" v-if="errors.email">{{errors.email[0]}}</div>
            </div>
            <div class="form-group">
              <label>Password</label>
              <input type="password" class="form-control" :class="{'is-invalid': errors.password}" v-model="user.password">
              <div class="invalid-feedback" v-if="errors.password">{{errors.password[0]}}</div>
            </div>
            <div class="form-group">
              <label>Roles</label>
              <multiselect
                v-model="user.roles"
                :options="roles"
                :multiple="true"
                openDirection="bottom"
                track-by="id"
                label="display_name"
                :class="{'border border-danger rounded': errors.roles}">
              </multiselect>
              <small class="form-text text-danger" v-if="errors.roles">{{errors.roles[0]}}</small>
            </div>
            <div class="form-group">
              <label class="col-form-label">Registered</label>
              <p class="form-control-plaintext text-muted">{{user.created_at | moment("LLL")}}</p>
            </div>
          </div>
        </div>
        <div class="row justify-content-md-center" v-else>
          <div class="col-md-12 col-xl-7">
            <content-placeholders>
              <content-placeholders-text/>
            </content-placeholders>
          </div>
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
      roles: [],
      errors: {},
      loading: true,
      submiting: false,
      submitingDestroy: false
    }
  },
  mounted () {
    this.getRoles()
    this.getUser()
  },
  methods: {
    getUser() {
      this.loading = true
      let str = window.location.pathname
      let res = str.split("/")
      axios.get(`/api/users/getUserRoles/${res[2]}`)
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
    getRoles () {
      axios.get(`/api/roles/all`)
      .then(response => {
        this.roles = response.data
      })
      .catch(error => {
        this.errors = error.response.data.errors
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
          if (error.response.status == 403) {
            swal("It's a Demo", "You don't have permission for this action in demo.")
            this.submiting = false
            return false
          }
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
              if (error.response.status == 403) {
                swal("It's a Demo", "You don't have permission for this action in demo.")
                this.submitingDestroy = false
                return false
              }
              this.errors = error.response.data.errors
              this.submitingDestroy = false
            })
          }
          this.submitingDestroy = false
        })
      }
    }
  }
}
</script>
