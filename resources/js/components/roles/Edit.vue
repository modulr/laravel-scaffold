<template>
  <div>
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="/roles">Roles</a>
      </li>
      <li class="breadcrumb-item active">Edit Role</li>
      <li class="breadcrumb-menu">
        <a class="btn btn-outline-primary text-primary" href="#" :disabled="submiting" @click="update">
          <i class="fas fa-spinner fa-spin mr-1" v-if="submiting"></i>Save changes
        </a>
        <a class="btn" href="#" :disabled="submitingDestroy" @click="destroy">
          <i class="fas fa-spinner fa-spin" v-if="submitingDestroy"></i>
          <i class="far fa-trash-alt" v-if="!submitingDestroy"></i>
          <span class="d-md-down-none ml-1">Delete</span>
        </a>
      </li>
    </ol>
    <div class="container">
      <div class="card-header bg-transparent">
        <strong>General</strong>
        <small class="text-muted float-right" v-if="role.created_at">{{role.created_at | moment("LLL")}}</small>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="form-group col-sm-8">
            <label>Role name</label>
            <input class="form-control" :class="{'is-invalid': errors.display_name}" type="text" v-model="role.display_name" placeholder="Admin" autofocus>
            <div class="invalid-feedback" v-if="errors.display_name">{{errors.display_name[0]}}</div>
          </div>
          <div class="form-group col-sm-4">
            <label>Role ID</label>
            <input class="form-control" type="text" v-model="role.id" readonly>
          </div>
          <div class="form-group col-sm-8">
            <label>Role slug</label>
            <input class="form-control" :class="{'is-invalid': errors.name}" type="text" v-model="role.name" placeholder="admin" readonly>
            <div class="invalid-feedback" v-if="errors.name">{{errors.name[0]}}</div>
          </div>
        </div>
      </div>
      <div class="card-header bg-transparent">
        <strong>Permissions</strong><br>
        <small class="text-muted">Enable or disable certain permissions and choose access to modules.</small>
      </div>
      <div class="card-body">
        <form class="form-horizontal">
          <div class="form-group row" v-for="module in role.modules">
            <label class="col-md-3">{{module.display_name}}</label>
            <div class="col-md-9">
              <div class="clearfix" v-for="permission in module.permissions">
                <span>{{permission.display_name}}</span>
                <label class="switch switch-pill switch-outline-success-alt float-right">
                  <input class="switch-input" type="checkbox" v-model="permission.allow">
                  <span class="switch-slider"></span>
                </label>
                <hr>
              </div>
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
      role: {},
      errors: {},
      submiting: false,
      submitingDestroy: false
    }
  },
  mounted () {
    this.getRole()
  },
  methods: {
    getRole() {
      let str = window.location.pathname
      let res = str.split("/")
      axios.get(`/api/roles/${res[2]}`)
      .then(response => {
        this.role = response.data
        this.getModulesPermissions()
      })
      .catch(error => {
        this.$toasted.global.error('Role does not exist!')
        location.href = '/roles'
      })
    },
    getModulesPermissions () {
      axios.get('/api/modules/getModulesPermissions')
      .then(response => {
        this.$set(this.role, 'modules', response.data)
        console.log(this.role);
      })
    },
    update () {
      if (!this.submiting) {
        this.submiting = true
        axios.put(`/api/roles/update/${this.role.id}`, this.role)
        .then(response => {
          this.$toasted.global.error('Updated role!')
          location.href = '/roles'
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
          text: "Once deleted, you will not be able to recover this role!",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            axios.delete(`/api/roles/${this.role.id}`)
            .then(response => {
              this.$toasted.global.error('Deleted role!')
              location.href = '/roles'
            })
            .catch(error => {
              this.errors = error.response.data.errors
            })
          }
          this.submitingDestroy = false
        })
      }
    }
  },
  watch: {
    'role.display_name': function (val) {
      this.role.name = val.toString().toLowerCase()
        .replace(/\s+/g, '-')           // Replace spaces with -
        .replace(/[^\w\-]+/g, '')       // Remove all non-word chars
        .replace(/\-\-+/g, '-')         // Replace multiple - with single -
        .replace(/^-+/, '')             // Trim - from start of text
        .replace(/-+$/, '');
    }
  }
}
</script>
