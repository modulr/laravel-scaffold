<template lang="html">
  <div>
      <a :href="this.config.facebook" target="_blank" class="text-secondary mr-3">
        <i class="fab fa-facebook-square fa-2x"></i>
      </a>
      <a :href="this.config.instagram" target="_blank" class="text-secondary mr-3">
        <i class="fab fa-instagram fa-2x"></i>
      </a>
      <a :href="`https://wa.me/${this.config.phone}?text=¡Hola!%20quiero%20más%20información%20sobre%20...`" target="_blank" class="text-secondary">
        <i class="fab fa-whatsapp fa-2x"></i>
      </a>
      <!-- <div class="mt-3">
        <a class="btn btn-link btn-phone pl-0 text-secondary" :href="`tel:${this.config.phone}`">
            <small class="fa-stack mr-1">
                <i class="fas fa-circle fa-stack-2x"></i>
                <i class="fas fa-phone fa-stack-1x fa-inverse"></i>
            </small>
            {{this.config.phone}}
        </a>
      </div> -->
  </div>
</template>

<script>
export default {
  data () {
    return {
      config: {}
    }
  },
  mounted () {
    this.getConfig()
  },
  methods: {
    getConfig () {
      axios.get(`/api/configs/first`)
      .then(response => {
        this.config = response.data
      })
      .catch(error => {
        this.errors = error.response.data.errors
      })
    },
  }
}
</script>
