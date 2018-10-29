<template>
  <div class="card">
    <div class="card-header">
      <i class="fas fa-pencil-alt"></i> Edit Role
    </div>
    <div class="card-body">
      <form class="form-horizontal">
        <div class="form-group row">
          <label class="col-md-3">ID</label>
          <div class="col-md-9">
            <input class="form-control" type="text" v-model="role.id" readonly>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-md-3">Name</label>
          <div class="col-md-9">
            <input class="form-control" :class="{'is-invalid': errors.name}" type="text" v-model="role.name" placeholder="Admin" autofocus>
            <div class="invalid-feedback" v-if="errors.name">{{errors.name[0]}}</div>
          </div>
        </div>
        <div class="form-group row">
          <label for="staticEmail" class="col-md-3">Created</label>
          <div class="col-md-9">
            <p class="form-control-plaintext text-muted">{{role.created_at | moment("LLL")}}</p>
          </div>
        </div>
        <div class="form-group row mt-4">
          <div class="col-md-9 offset-md-3">
            <small class="form-text text-muted mb-2">Removing the role will delete all related resources. Removed role cannot be restored!</small>
            <button class="btn btn-danger" type="button" :disabled="submitingDestroy" @click="destroy">
              <i class="fas fa-spinner fa-spin" v-if="submitingDestroy"></i> Remove role
            </button>
          </div>
        </div>
      </form>
    </div>
    <div class="card-footer">
      <div class="form-group row">
        <div class="col-md-9 offset-md-3">
          <button class="btn btn-primary float-right" type="button" :disabled="submiting" @click="update" >
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
      })
      .catch(error => {
        this.$toasted.global.error('Role does not exist!')
        location.href = '/roles'
      })
    },
    update () {
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
    },
    destroy () {
      this.submitingDestroy = true
      axios.delete(`/api/roles/${this.role.id}`)
      .then(response => {
        this.$toasted.global.error('Deleted role!')
        location.href = '/roles'
      })
      .catch(error => {
        this.errors = error.response.data.errors
        this.submitingDestroy = false
      })
    }
  }
}
</script>
