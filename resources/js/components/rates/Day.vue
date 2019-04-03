<template lang="html">
  <b>${{rate.rate}}</b>
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
