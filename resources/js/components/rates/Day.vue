<template lang="html">
  <p class="mb-0">Tarifa del dia desde <b>${{rate.rate}}</b> pesos</p>
</template>

<script>
export default {
  data () {
    return {
      rate: {}
    }
  },
  mounted () {
    this.getRate()
  },
  methods: {
    getRate () {
      axios.get(`/api/rates/day`)
      .then(response => {
        this.rate = response.data
      })
      .catch(error => {
        this.errors = error.response.data.errors
      })
    }
  }
}
</script>
