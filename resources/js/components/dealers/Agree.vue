<template lang="html">
  <div class="text-center mt-5 mb-4">
    <a class="btn btn-primary py-2 px-5" href="#" :disabled="submiting" @click.prevent="agree" v-if="!user.agree">
      <i class="fas fa-spinner fa-spin mr-1" v-if="submiting"></i>
      <span>ACEPTAR</span>
    </a>
    <p class="lead text-primary" v-else>¡Haz aceptado el contrato!</p>
  </div>
</template>

<script>
export default {
  data () {
    return {
      user: Laravel.user,
      submiting: false
    }
  },
  methods: {
    agree () {
      if (!this.submiting) {
        this.submiting = true
        axios.put(`/api/dealers/agree/${this.user.id}`)
        .then(response => {
          this.user.agree = response.data.agree
        })
        .catch(error => {
          this.submiting = false
        })
      }
    },
  }
}
</script>
