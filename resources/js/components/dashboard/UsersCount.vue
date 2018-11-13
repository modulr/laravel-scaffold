<template>
  <div class="card text-white bg-info">
    <div class="card-body">
      <div class="h1 text-muted text-right mb-4">
        <i class="icon-people"></i>
      </div>
      <div class="text-value">{{users}}</div>
      <small class="text-muted text-uppercase font-weight-bold">Users registered</small>
    </div>
  </div>
</template>

<script>
export default {
  data () {
    return {
      users: 0
    }
  },
  mounted () {
    this.getUsersCount()
  },
  methods: {
    getUsersCount () {
      axios.get(`/api/users/count`)
      .then(response => {
        this.users = response.data
      })
    },
  }
}
</script>
