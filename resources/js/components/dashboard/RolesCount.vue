<template>
  <div class="card text-white bg-success">
    <div class="card-body">
      <div class="h1 text-muted text-right mb-4">
        <i class="icon-key"></i>
      </div>
      <div class="text-value">{{roles}}</div>
      <small class="text-muted text-uppercase font-weight-bold">Roles created</small>
    </div>
  </div>
</template>

<script>
export default {
  data () {
    return {
      roles: 0
    }
  },
  mounted () {
    this.getRolesCount()
  },
  methods: {
    getRolesCount () {
      axios.get(`/api/roles/count`)
      .then(response => {
        this.roles = response.data
      })
    },
  }
}
</script>
