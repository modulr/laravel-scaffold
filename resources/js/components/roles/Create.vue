<template>
  <div>
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="/roles">Roles</a>
      </li>
      <li class="breadcrumb-item active">New Role</li>
      <li class="breadcrumb-menu">
        <a class="btn btn-outline-success text-success" href="#" :disabled="submiting" @click="create">
          <i class="fas fa-spinner fa-spin mr-1" v-if="submiting"></i>
          <span>Create role</span>
        </a>
      </li>
    </ol>
    <div class="container">
      <div class="card-header bg-transparent">
        <strong>General</strong>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="form-group col-sm-6">
            <label for="name">Role name</label>
            <input class="form-control" :class="{'is-invalid': errors.display_name}" type="text" v-model="role.display_name" placeholder="Admin" autofocus>
            <div class="invalid-feedback" v-if="errors.display_name">{{errors.display_name[0]}}</div>
          </div>
          <div class="form-group col-sm-6">
            <label for="name">Role slug</label>
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
          <div class="form-group row" v-for="module in modules">
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
        <content-placeholders v-if="loadingModules">
          <content-placeholders-heading :img="true"/>
          <content-placeholders-heading :img="true"/>
        </content-placeholders>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data () {
    return {
      role: {},
      modules: [],
      loadingModules: true,
      errors: {},
      submiting: false
    }
  },
  mounted() {
    this.getModulesPermissions()
  },
  methods: {
    create () {
      if (!this.submiting) {
        this.submiting = true
        axios.post('/api/roles/store', this.role)
        .then(response => {
          this.$toasted.global.error('Created role!')
          location.href = '/roles'
        })
        .catch(error => {
          this.errors = error.response.data.errors
          this.submiting = false
        })
      }
    },
    getModulesPermissions () {
      this.loadingModules = true
      axios.get('/api/modules/getModulesPermissions')
      .then(response => {
        this.modules = response.data
        this.loadingModules = false
        //this.$set(this.role, 'modules', response.data)
        //console.log(this.role);
      })
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
