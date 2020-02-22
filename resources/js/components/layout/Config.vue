<template lang="html">
  <div>
    <div class="text-center mb-2">
        <a :href="this.config.facebook" target="_blank" class="text-success mr-3">
          <i class="fab fa-facebook-square fa-3x"></i>
          <!-- <img src="/img/facebook.png" class="img-fluid" alt="Facebook"> -->
        </a>
        <a :href="this.config.instagram" target="_blank" class="text-success">
          <i class="fab fa-instagram fa-3x"></i>
          <!-- <img src="/img/instagram.png" class="img-fluid" alt="Instagram"> -->
        </a>
    </div>
    <div class="m-5">
        <a class="btn btn-link btn-lg btn-phone" :href="`tel:${this.config.phone}`">
            <small class="fa-stack mr-1">
                <i class="fas fa-circle fa-stack-2x"></i>
                <i class="fas fa-phone fa-stack-1x fa-inverse"></i>
            </small>
            {{this.config.phone}}
        </a>
    </div>
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
