<template lang="html">
  <span class="badge badge-primary">{{ordersCount}}</span>
</template>

<script>
export default {
  data () {
    return {
      ordersCount: 0
    }
  },
  mounted () {
    this.getOrders()
  },
  methods: {
    getOrders () {
      axios.get(`/api/orders/availablesCount`)
      .then(response => {
        this.ordersCount = response.data
      })
    }
  }
}
</script>
