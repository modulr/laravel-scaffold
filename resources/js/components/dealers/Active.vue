<template lang="html">
  <div>
    <a class="nav-label" href="#" @click.prevent="activeToggle">
      <i class="fa fa-circle mr-2" :class="{'text-success': !currentUser.active, 'text-primary': currentUser.active}"></i> {{activeText}}
    </a>
  </div>
</template>

<script>
export default {
  data () {
    return {
      currentUser: {},
      user: Laravel.user,
      activeText: 'Desactivo',
    }
  },
  //props: ['user'],
  mounted () {
    this.currentUser = this.user
    if (this.currentUser.active) {
      this.activeText = 'Activo'
    } else {
      this.activeText = 'Desactivo'
    }
  },
  methods: {
    activeToggle () {
      if (this.activeText != 'Loading...') {
        this.activeText = 'Loading...'
        axios.post(`/api/dealers/activeToggle`, this.currentUser)
        .then(response => {
          this.currentUser = response.data
          if (this.currentUser.active) {
            this.user.active = true
            this.activeText = 'Activo'
            this.$toasted.global.error('Activado!')
          } else {
            this.user.active = false
            this.activeText = 'Desactivo'
            this.$toasted.global.error('Desactivado!')
          }
        })
      }
    }
  }
}
</script>
