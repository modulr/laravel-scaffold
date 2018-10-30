<template>
  <div>
    <div class="card-header">
      <i class="fas fa-plus"></i> New Role
      <button class="btn btn-primary float-right" type="button" :disabled="submiting" @click="create" >
        <i class="fas fa-spinner fa-spin" v-if="submiting"></i> Save
      </button>
    </div>
    <div class="card-body">
      <form class="form-horizontal" @submit.prevent>
        <div class="form-group row">
          <label class="col-md-3">Name</label>
          <div class="col-md-9">
            <input class="form-control" :class="{'is-invalid': errors.name}" type="text" v-model="role.name" placeholder="Admin" autofocus>
            <div class="invalid-feedback" v-if="errors.name">{{errors.name[0]}}</div>
          </div>
        </div>
        <div class="form-group row">
          <div class="col-md-12 text-info mt-3">Permissions</div>
        </div>
        <hr>
        <div class="form-group row" v-for="role in role.modules">
          <label class="col-md-3">{{role.display_name}}</label>
          <div class="col-md-9">
            <div class="form-check checkbox" v-for="permission in role.permissions">
              <input class="form-check-input" :id="`check${permission.id}`" type="checkbox" v-model="permission.allow">
              <label class="form-check-label" :for="`check${permission.id}`">{{permission.name}}</label>
            </div>
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
      role: {
        modules: []
      },
      errors: {},
      submiting: false
    }
  },
  mounted() {
    this.getModules()
  },
  methods: {
    create () {
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
    },
    getModules () {
      axios.get('/api/modules/getModules')
      .then(response => {
        this.role.modules = response.data
        console.log(this.role.modules);
      });
    }
  }
}
</script>
