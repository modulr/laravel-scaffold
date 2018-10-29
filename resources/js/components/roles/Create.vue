<template>
  <div class="card">
    <div class="card-header">
      <i class="fas fa-plus"></i> New Role
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
      role: {},
      errors: {},
      submiting: false
    }
  },
  methods: {
    create () {
      this.submiting = true
      axios.post(`/api/roles/store`, this.role)
      .then(response => {
        this.$toasted.global.error('Created role!')
        location.href = '/roles'
      })
      .catch(error => {
        this.errors = error.response.data.errors
        this.submiting = false
      })
    }
  }
}
</script>
